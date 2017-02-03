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

namespace Sulaeman\CheckoutUniqueGrandTotal\Observer\Quote\Model\Quote;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber;

class SaveAfter implements ObserverInterface
{
    /**
     * @var \Magento\Sales\Api\Data\OrderInterface
     */
    protected $order;

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Observer $observer)
    {
        $quote = $observer->getEvent()->getDataObject();

        $number = $quote->getData(UniqueNumber::FIELD);
        if (empty($number)) {
            $reservedOrderId = $quote->getReservedOrderId();
            if ( ! empty($reservedOrderId)) {
                $order = $this->order->loadByIncrementId($reservedOrderId);
                if ($order instanceOf Order) {
                    $number = $order->getData(UniqueNumber::FIELD);
                }
            }

            if (empty($number)) {
                $number = (string) $quote->getId();
                if (strlen($number) > 3) {
                    $number = substr($number, strlen($number) - 3);
                }
                $number = (int) $number;
            }

            $quote->setData(UniqueNumber::FIELD, $number);
            $quote->save();
        }

        return $this;
    }
}
