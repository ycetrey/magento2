<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Plugin;

/**
 * Class UpdateFeeForOrder
 * @author BrainActs Commerce OÜ Core Team <support@brainacts.com>
 */
class SetupRewardDiscount
{

    const AMOUNT_Payment = 'payment_fee';

    const AMOUNT_SUBTOTAL = 'subtotal';

    const REWARD_PRODUCT_NAME = 'Reward Points(discount)';

    /**
     * @var \Magento\Quote\Model\Quote
     */
    private $quote;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;


    /**
     * @var array
     */
    private $paypalMehodList = [
        'payflowpro',
        'payflow_link',
        'payflow_advanced',
        'braintree_paypal',
        'paypal_express_bml',
        'payflow_express_bml',
        'payflow_express',
        'paypal_express'
    ];

    /**
     * SetupRewardDiscount constructor.
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Quote\Model\Quote $quote,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->quote = $quote;
        $this->logger = $logger;
        $this->checkoutSession = $checkoutSession;
        $this->registry = $registry;
        $this->request = $request;
    }

    /**
     * @param $cart
     * @param $result
     * @return mixed
     */
    public function afterGetAmounts($cart, $result)
    {

        $total = $result;
        $quote = $this->checkoutSession->getQuote();
        $rewardAmount = $quote->getRewardPointsAmount();

        $paymentMethod = $quote->getPayment()->getMethod();
        if ((in_array($paymentMethod, $this->paypalMehodList) || $this->isPayPalExpress()) && $rewardAmount > 0) {
            $total[self::AMOUNT_SUBTOTAL] = $total[self::AMOUNT_SUBTOTAL] - $rewardAmount;
        }

        return $total;
    }

    /**
     * @param $cart
     */
    public function beforeGetAllItems($cart)
    {

        $rewardExist = $this->registry->registry('reward_exist') ? $this->registry->registry('reward_exist') : false;

        if ($rewardExist) {
            return;
        }

        $quote = $this->checkoutSession->getQuote();
        $paymentMethod = $quote->getPayment()->getMethod();

        if (in_array($paymentMethod, $this->paypalMehodList) ||
            $this->isPayPalExpress()   //fix for PayPal Express checkout started by button
        ) {

            /** @var \Magento\Sales\Model\Order $cart */
            /** @var \Magento\Paypal\Model\Cart $cart */

            if (method_exists($cart, 'addCustomItem')) {
                $this->registry->register('reward_exist', 1);
                $isRewardProductExist = $this->isExistRewardItem($cart);
                $this->registry->unregister('reward_exist');

                if (!$isRewardProductExist) {
                    $rewardAmount = $quote->getRewardPointsAmount();


                    if ($rewardAmount > 0) {

                        $rewardAmount = $rewardAmount * -1;

                        $cart->addCustomItem(__(self::REWARD_PRODUCT_NAME), 1, $rewardAmount);

                        $quote->collectTotals();
                    }
                }

            }
        }
    }

    /**
     * Check if PayPal Express
     * Fix for paypal express checkout started by button
     * @return bool
     */
    private function isPayPalExpress()
    {
        $moduleName = $this->request->getModuleName();
        $controller = $this->request->getControllerName();

        return $moduleName == 'paypal' && $controller == 'express';
    }

    /**
     * Check if reward item is in list of paypal products
     * @param $cart
     * @return bool
     */
    private function isExistRewardItem($cart)
    {

        /** @var \Magento\Paypal\Model\Cart $cart */
        $items = $cart->getAllItems();

        foreach ($items as $item) {
            if ($item->getName() == self::REWARD_PRODUCT_NAME) {
                return true;
            }
        }

        return false;
    }
}
