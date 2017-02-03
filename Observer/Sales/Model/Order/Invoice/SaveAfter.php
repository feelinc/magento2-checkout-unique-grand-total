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

namespace Sulaeman\CheckoutUniqueGrandTotal\Observer\Sales\Model\Order\Invoice;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber;

class SaveAfter implements ObserverInterface
{
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Observer $observer)
    {
        $invoice = $observer->getEvent()->getDataObject();

        $number = $invoice->getData(UniqueNumber::FIELD);
        if (empty($number)) {
            $quoteId = $invoice->getQuoteId();
            if ( ! empty($quoteId)) {
                $order = $this->orderRepository->get($quoteId);
                if ($order instanceOf Quote) {
                    $number = $order->getData(UniqueNumber::FIELD);
                }
            }

            $invoice->setData(UniqueNumber::FIELD, $number);

            $invoice->save();
        }

        return $this;
    }
}
