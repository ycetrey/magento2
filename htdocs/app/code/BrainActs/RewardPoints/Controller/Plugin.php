<?php
/**
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace BrainActs\RewardPoints\Controller;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;

class Plugin
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $config;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    private $redirector;

    /**
     * @param CustomerSession      $customerSession
     * @param ScopeConfigInterface $config
     * @param RedirectInterface    $redirector
     */
    public function __construct(
        CustomerSession $customerSession,
        ScopeConfigInterface $config,
        RedirectInterface $redirector
    ) {
        $this->customerSession = $customerSession;
        $this->config = $config;
        $this->redirector = $redirector;
    }

    /**
     * Perform customer authentication
     *
     * @param  \Magento\Framework\App\ActionInterface $subject
     * @param  RequestInterface                       $request
     * @return void
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function beforeDispatch(\Magento\Framework\App\ActionInterface $subject, RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $subject->getActionFlag()->set('', 'no-dispatch', true);
        }
        if (!$this->config->isSetFlag('brainacts_reward_points/general/enabled')) {
            throw new NotFoundException(__('Page not found.'));
        }
    }
}
