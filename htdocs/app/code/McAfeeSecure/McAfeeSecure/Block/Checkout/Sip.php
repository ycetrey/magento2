<?php

namespace McAfeeSecure\McAfeeSecure\Block\Checkout;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderAddressInterface;

class Sip extends Template
{

    protected $checkoutSession;
    protected $orderRepository;
    protected $order;
    protected $address;

    public function __construct(
        Context $context,
        Session $checkoutSession,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    protected function getOrder()
    {
        if (!$this->order) {
            $this->order = $this->orderRepository->get($this->checkoutSession->getLastOrderId());
        }

        return $this->order;
    }

    protected function getAddress()
    {

        $order = $this->getOrder();

        if (!$this->address) {
            $this->address = $order->getBillingAddress();
        }

        return $this->address;
    }

    public function getCheckoutData()
    {

        $checkoutData = [];

        $order = $this->getOrder();
        $address = $this->getAddress();

        $checkoutData['email'] =        $order->getCustomerEmail();
        $checkoutData['firstname'] =    $address->getFirstname();
        $checkoutData['lastname'] =     $address->getLastname();
        $checkoutData['region'] =       $address->getRegionCode();
        $checkoutData['country'] =      $address->getCountryId();
        $checkoutData['orderid'] =      $order->getIncrementId();

        return $checkoutData;
    }
}
