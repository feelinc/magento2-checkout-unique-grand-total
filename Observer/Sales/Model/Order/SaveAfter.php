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

namespace Sulaeman\CheckoutUniqueGrandTotal\Observer\Sales\Model\Order;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;

use Sulaeman\CheckoutUniqueGrandTotal\Model\UniqueNumber;

class SaveAfter implements ObserverInterface
{
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    public function __construct(CartRepositoryInterface $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getDataObject();

        $number = $order->getData(UniqueNumber::FIELD);
        if (empty($number)) {
            $quoteId = $order->getQuoteId();
            if ( ! empty($quoteId)) {
                $quote = $this->quoteRepository->get($quoteId);
                if ($quote instanceOf Quote) {
                    $number = $quote->getData(UniqueNumber::FIELD);
                }
            }

            if (empty($number)) {
                $number = (string) $order->getId();
                if (strlen($number) > 3) {
                    $number = substr($number, strlen($number) - 3);
                }
                $number = (int) $number;
            }

            $order->setData(UniqueNumber::FIELD, $number);
            $order->save();
        }

        return $this;
    }
}
