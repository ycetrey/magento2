<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_SocialLogin
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\SocialLogin\Model;

use Exception;
use Hybrid_Auth;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\EmailNotificationInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\Math\Random;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Social
 *
 * @package Mageplaza\SocialLogin\Model
 */
class Social extends AbstractModel
{
    /**
     * @type StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @type CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerInterfaceFactory
     */
    protected $customerDataFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @type \Mageplaza\SocialLogin\Helper\Social
     */
    protected $apiHelper;

    /**
     * @type
     */
    protected $apiName;

    /**
     * Social constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param CustomerFactory $customerFactory
     * @param CustomerInterfaceFactory $customerDataFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param StoreManagerInterface $storeManager
     * @param \Mageplaza\SocialLogin\Helper\Social $apiHelper
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CustomerFactory $customerFactory,
        CustomerInterfaceFactory $customerDataFactory,
        CustomerRepositoryInterface $customerRepository,
        StoreManagerInterface $storeManager,
        \Mageplaza\SocialLogin\Helper\Social $apiHelper,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->customerDataFactory = $customerDataFactory;
        $this->storeManager = $storeManager;
        $this->apiHelper = $apiHelper;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Social::class);
    }

    /**
     * @param $identify
     * @param $type
     *
     * @return Customer
     */
    public function getCustomerBySocial($identify, $type)
    {
        $customer = $this->customerFactory->create();

        $socialCustomer = $this->getCollection()
            ->addFieldToFilter('social_id', $identify)
            ->addFieldToFilter('type', $type)
            ->getFirstItem();
        if ($socialCustomer && $socialCustomer->getId()) {
            $customer->load($socialCustomer->getCustomerId());
        }

        return $customer;
    }

    /**
     * @param $email
     * @param null $websiteId
     *
     * @return Customer
     * @throws LocalizedException
     */
    public function getCustomerByEmail($email, $websiteId = null)
    {
        /** @var Customer $customer */
        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId ?: $this->storeManager->getWebsite()->getId());
        $customer->loadByEmail($email);

        return $customer;
    }

    /**
     * @param $data
     * @param $store
     *
     * @return mixed
     * @throws Exception
     */
    public function createCustomerSocial($data, $store)
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerDataFactory->create();
        $customer->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setEmail($data['email'])
            ->setStoreId($store->getId())
            ->setWebsiteId($store->getWebsiteId())
            ->setCreatedIn($store->getName());

        try {
            // If customer exists existing hash will be used by Repository
            $customer = $this->customerRepository->save($customer);

            $objectManager = ObjectManager::getInstance();
            $mathRandom = $objectManager->get(Random::class);
            $newPasswordToken = $mathRandom->getUniqueHash();
            $accountManagement = $objectManager->get(AccountManagementInterface::class);
            $accountManagement->changeResetPasswordLinkToken($customer, $newPasswordToken);

            if ($this->apiHelper->canSendPassword($store)) {
                $this->getEmailNotification()->newAccount(
                    $customer,
                    EmailNotificationInterface::NEW_ACCOUNT_EMAIL_REGISTERED_NO_PASSWORD
                );
            }

            $this->setAuthorCustomer($data['identifier'], $customer->getId(), $data['type']);
        } catch (AlreadyExistsException $e) {
            throw new InputMismatchException(
                __('A customer with the same email already exists in an associated website.')
            );
        } catch (Exception $e) {
            if ($customer->getId()) {
                $this->_registry->register('isSecureArea', true, true);
                $this->customerRepository->deleteById($customer->getId());
            }
            throw $e;
        }

        /** @var Customer $customer */
        $customer = $this->customerFactory->create()->load($customer->getId());

        return $customer;
    }

    /**
     * Get email notification
     *
     * @return EmailNotificationInterface
     */
    private function getEmailNotification()
    {
        return ObjectManager::getInstance()->get(EmailNotificationInterface::class);
    }

    /**
     * @param $identifier
     * @param $customerId
     * @param $type
     *
     * @return $this
     * @throws Exception
     */
    public function setAuthorCustomer($identifier, $customerId, $type)
    {
        $this->setData([
            'social_id'              => $identifier,
            'customer_id'            => $customerId,
            'type'                   => $type,
            'is_send_password_email' => $this->apiHelper->canSendPassword()
        ])
            ->setId(null)
            ->save();

        return $this;
    }

    /**
     * @param $apiName
     *
     * @return mixed
     * @throws LocalizedException
     */
    public function getUserProfile($apiName)
    {
        $config = [
            'base_url'   => $this->apiHelper->getBaseAuthUrl(),
            'providers'  => [
                $apiName => $this->getProviderData($apiName)
            ],
            'debug_mode' => false
        ];

        $auth = new Hybrid_Auth($config);
        $adapter = $auth->authenticate($apiName, $this->apiHelper->getAuthenticateParams($apiName));

        return $adapter->getUserProfile();
    }

    /**
     * @return array
     */
    public function getProviderData($apiName)
    {
        $data = [
            'enabled' => $this->apiHelper->isEnabled(),
            'keys'    => [
                'id'     => $this->apiHelper->getAppId(),
                'key'    => $this->apiHelper->getAppId(),
                'secret' => $this->apiHelper->getAppSecret()
            ]
        ];

        return array_merge($data, $this->apiHelper->getSocialConfig($apiName));
    }
}
