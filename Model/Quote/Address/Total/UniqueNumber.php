<?php

/**
 * This file is part of the Sulaeman Checkout Unique Grand Total package.
 *
 * @author Sulaeman <me@sulaeman.com>
 * @package Sulaeman_CheckoutUniqueGrandTotal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sulaeman\CheckoutUniqueGrandTotal\Model\Quote\Address\Total;

use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber as UniqueNumberModel;

class UniqueNumber extends AbstractTotal
{
    /**
     * Total amount
     *
     * @var int
     */
    protected $_amount;

    public function __construct()
    {
        $this->setCode(UniqueNumberModel::CODE);
    }

    /**
     * Collect address unique number amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $amount = $quote->getData(UniqueNumberModel::FIELD);
        
        $total->setUniqueNumberAmount($amount);
        $total->setBaseUniqueNumberAmount($amount);

        $total->setTotalAmount($this->getCode(), $amount);
        $total->setBaseTotalAmount($this->getCode(), $amount);

        $total->setGrandTotal($total->getGrandTotal() + $amount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $amount);
        
        return $this;
    }

    /**
     * Add unique number information to address
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array|null
     */
    public function fetch(Quote $quote, Total $total)
    {
        $result = null;
        $amount = $quote->getData(UniqueNumberModel::FIELD);
        
        if ($amount > 0) { 
            $result = [
                'code'  => $this->getCode(),
                'title' => $this->getLabel(),
                'value' => $amount
            ];
        }

        return $result;
    }

    /**
     * Get label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Unique Number');
    }

    /**
     * Get area
     *
     * @return null
     */
    public function getArea()
    {
        return null;
    }
}