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

namespace Sulaeman\CheckoutUniqueGrandTotal\Block\Sales\Order\Invoice;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\DataObject;
use Magento\Sales\Model\Order\Invoice;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber as UniqueNumberModel;

class UniqueNumber extends Template
{
    /**
     * @var Order|null
     */
    protected $_invoice = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        if ($this->_invoice === null) {
            if ($this->hasData('invoice')) {
                $this->_invoice = $this->_getData('invoice');
            } elseif ($this->_coreRegistry->registry('current_invoice')) {
                $this->_invoice = $this->_coreRegistry->registry('current_invoice');
            } elseif ($this->getParentBlock()->getInvoice()) {
                $this->_invoice = $this->getParentBlock()->getInvoice();
            }
        }
        return $this->_invoice;
    }

    /**
     * Get totals source object
     *
     * @return Order
     */
    public function getSource()
    {
        return $this->getInvoice();
    }

    /**
     * Initialize all order totals relates with unique number
     *
     * @return self
     */
    public function initTotals()
    {
        $number = $this->getSource()->getUniqueNumber();
        if ( ! empty($number)) {
            $uniqueNumber = new DataObject([
                'code'       => UniqueNumberModel::CODE,
                'field'      => UniqueNumberModel::FIELD,
                'value'      => $number,
                'base_value' => $number,
                'label'      => __('Unique Number')
            ]);

            $this->getParentBlock()->addTotal($uniqueNumber, UniqueNumberModel::CODE);

            // Update grand total
            $grandTotal = $this->getParentBlock()->getTotal('grand_total');
            $grandTotal->setValue($grandTotal->getValue() + $number);
            $grandTotal->setBaseValue($grandTotal->getBaseValue() + $number);
        }

        return $this;
    }
}
