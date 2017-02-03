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

namespace Sulaeman\CheckoutUniqueGrandTotal\Block\Sales\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\DataObject;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber as UniqueNumberModel;

class UniqueNumber extends Template
{
    /**
     * @var Order|null
     */
    protected $_order = null;

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
     * Get order object
     *
     * @return Order
     */
    public function getOrder()
    {
        if ($this->_order === null) {
            if ($this->hasData('order')) {
                $this->_order = $this->_getData('order');
            } elseif ($this->_coreRegistry->registry('current_order')) {
                $this->_order = $this->_coreRegistry->registry('current_order');
            } elseif ($this->getParentBlock()->getOrder()) {
                $this->_order = $this->getParentBlock()->getOrder();
            }
        }
        return $this->_order;
    }

    /**
     * Get totals source object
     *
     * @return Order
     */
    public function getSource()
    {
        return $this->getOrder();
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
        }

        return $this;
    }
}
