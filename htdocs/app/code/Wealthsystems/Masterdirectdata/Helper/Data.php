<?php

namespace Wealthsystems\Masterdirectdata\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const DIRECT_DATA_FAILED = -1;
    const DIRECT_DATA_SUCCESS = 0;
    const DIRECT_DATA_ENTITY_DOCUMENT_NOT_FOUND = 1;
    const DIRECT_DATA_CUSTOMER_INACTIVATE = 2;

    const SINTEGRA = "SINTEGRA";
    const SEFAZ = "SEFAZ";
    const REVENUE = "REVENUE";

    public function validateCustomer($_customer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($_customer->getId());       

        $sintegraResponse = false;
        $sefazResponse = false;               
        $revenueResponse = false;   
        
        if ($this->SintegraIsEnabled() && $customer->getSintegraCheck() == 0) {            
            if ($customer->getSintegraAttempts() < $this->AttemptLimit() || $this->AttemptLimit() < 1) {
                $sintegraResponse = $this->_validateSintegra($customer);
            }
        }            
        
        if ($this->SefazIsEnabled() && $customer->getSefazCheck() == 0) {
            if ($customer->getSefazAttempts() < $this->AttemptLimit() || $this->AttemptLimit() < 1) {
                $sefazResponse = $this->_validateSefaz($customer);
            }
        } 

        if ($this->RevenueIsEnabled() && $customer->getRevenueCheck() == 0) {
            if ($customer->getRevenueAttempts() < $this->AttemptLimit() || $this->AttemptLimit() < 1) {
                $revenueResponse = $this->_validateRevenue($customer);
            }
        } 
    }

    protected function _validateRevenue($customer)
    {
        $shippingAddress = $customer->getDefaultShippingAddress();
        if ($shippingAddress) {
            $region_id = $shippingAddress->getRegionId();            
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $region = $objectManager->create('Magento\Directory\Model\Region')->load($region_id);
        $uf = $region->getCode();

        $cnpj = $customer->getCountyInscription();                
        $customer->setRevenueAttempts(intval($customer->getRevenueAttempts()) + 1);

        $customer->save();

        $revenueResponse = $this->requestRevenueData($cnpj);
        $data = json_encode($revenueResponse->data, JSON_UNESCAPED_UNICODE);

        if (!$revenueResponse->isSuccess) {
            if ($revenueResponse->type == self::DIRECT_DATA_ENTITY_DOCUMENT_NOT_FOUND) {
                $customer->setVerifiedRevenue(1);
                $this->_reproveCustomer($customer, $revenueResponse);
            }

            $customer->setDirectdataProblem(1);
            $customer->setRevenueReturn(print_r($revenueResponse->data->Mensagem, true));
            $customer->save();

            return false;
        }

        $customer->setRevenueCheck(1);
        $customer->setRevenueReturn(print_r($revenueResponse->data->Mensagem, true));
        $customer->save();

        if (!$revenueResponse->isActivatedCustomer) {
            $this->_reproveCustomer($customer, $revenueResponse);

            return false;
        } else {
            $customer->setRevenueApproved(1);
            $customer->save();
        }

        return $revenueResponse;
    }

    protected function _validateSintegra($customer)
    {
        $shippingAddress = $customer->getDefaultShippingAddress();
        if ($shippingAddress) {
            $region_id = $shippingAddress->getRegionId();            
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $region = $objectManager->create('Magento\Directory\Model\Region')->load($region_id);
        $uf = $region->getCode();

        $cnpj = $customer->getCountyInscription();                
        $customer->setSintegraAttempts(intval($customer->getSintegraAttempts()) + 1);
        $customer->save();

        $sintegraResponse = $this->requestSintegraData($cnpj, $uf);
        $data = json_encode($sintegraResponse->data, JSON_UNESCAPED_UNICODE);

        if (!$sintegraResponse->isSuccess) { 
            if ($sintegraResponse->type == self::DIRECT_DATA_ENTITY_DOCUMENT_NOT_FOUND) {
                $customer->setSintegraCheck(1);
                $this->reproveCustomer($customer);
            }

            $customer->setDirectdataProblem(1);
            $customer->setSintegraReturn(print_r($sintegraResponse->data->Mensagem, true));
            $customer->save();

            return false;
        }

        $customer->setSintegraCheck(1);        
        $customer->setSintegraReturn(print_r($sintegraResponse->data->Mensagem, true));

        $customer->save();

        if (!$sintegraResponse->isActivatedCustomer) {
            $this->reproveCustomer($customer);

            return false;
        } else {
            $customer->setSintegraApproved(1);
            $customer->save();
        }

        return $sintegraResponse;
    }

    protected function _validateSefaz($customer)
    {
        $shippingAddress = $customer->getDefaultShippingAddress();
        if ($shippingAddress) {
            $region_id = $shippingAddress->getRegionId();            
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $region = $objectManager->create('Magento\Directory\Model\Region')->load($region_id);
        $uf = $region->getCode();

        $cnpj = $customer->getCountyInscription();   
        $customer->setSefazAttempts(intval($customer->getSefazAttempts()) + 1);
        $customer->save();
       
        $sefazResponse = $this->requestSefazData($cnpj, $uf);
        $data = json_encode($sefazResponse->data, JSON_UNESCAPED_UNICODE);

        if (!$sefazResponse->isSuccess) {
            if ($sefazResponse->type == self::DIRECT_DATA_ENTITY_DOCUMENT_NOT_FOUND) {
                $customer->setVerifiedSefaz(1);
                $this->_reproveCustomer($customer, $sefazResponse);
            }

            $customer->setDirectdataProblem(1);
            $customer->setSefazReturn(print_r($sefazResponse->data->Mensagem, true));
            $customer->save();

            return false;
        }

        $customer->setVerifiedSefaz(1);
        $customer->setSefazReturn(print_r($sefazResponse->data->Mensagem, true));
        $customer->save();

        if (!$sefazResponse->isActivatedCustomer) {
            $this->reproveCustomer($customer, $sefazResponse);
            return false;
        } else {
            $customer->setSefazApproved(1);
            $customer->save();
        }

        return $sefazResponse;
    }
    
    protected function serializeDirectdataResponse($data)
    {
        $data = json_decode($data);
        $response = new \stdClass();
        $response->data = $data;
        $response->isSuccess = false;
        $response->type = self::DIRECT_DATA_FAILED;
        $response->isActivatedCustomer = false;

        if ($data) {
            $type = $data->Tipo;
            $response->isSuccess = preg_match("/sucesso/i", $type) == 1;

            if ($response->isSuccess) {
                $situation = $data->Retorno->SituacaoCadastral;

                if (empty($situation)) {
                    $situation = $data->Retorno->SituacaoCadastralAtual;
                }

                $response->isActivatedCustomer = !(preg_match("/(\b(nao.*)\b)|(\b(não.*)\b)/i", $situation)) == 1;
                if ($response->isActivatedCustomer)
                    $response->isActivatedCustomer = preg_match("/(\b(ativ.*)\b)|(\b(habilitad.*)\b)/i", $situation) == 1;

                if (!$response->isActivatedCustomer) {
                    $response->type = self::DIRECT_DATA_CUSTOMER_INACTIVATE;
                }
            } else {
                if (preg_match("/DocumentoEntidadeNaoEncontrada/i", $type) == 1) {
                    $response->type = self::DIRECT_DATA_ENTITY_DOCUMENT_NOT_FOUND;
                }
            }
        }

        return $response;
    }

    protected function reproveCustomer($customer)
    {
        $customer->setDirectdataProblem(1);
        $customer->setDirectdataChecked(1);
        $customer->setDirectdataApproves(0);
        $customer->save();
    }

    protected function approveCustomer($customer)
    {
        $customer->setVerifiedRegistration(1);
        $customer->setRegisterApproved(1);
        $customer->save();
    }

    protected function _requestData($url, $timeout = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (!is_null($timeout)) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        }

        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

    public function requestSintegraData($cnpj, $uf)
    {
        $url = "https://api.directd.com.br/consultas/sintegra/v1/consulta-pj?token=" . $this->getToken() . "&uf=" . $uf . "&cnpj=" . $cnpj;
        return $this->serializeDirectdataResponse($this->_requestData($url, 250));
    }

    public function requestSefazData($cnpj, $uf)
    {
        $url = "https://api.directd.com.br/consultas/sefaz/v1/consulta-uf?token=" . $this->getToken() . "&uf=" . $uf . "&cnpj=" . $cnpj;
        return $this->serializeDirectdataResponse($this->_requestData($url, 250));
    }

    public function requestRevenueData($cnpj)
    {
        $url = "https://api.directd.com.br/consultas/receita/v1/consulta-pj?token=" . $this->getToken() . "&cnpj=" . $cnpj;
        return $this->serializeDirectdataResponse($this->_requestData($url, 250));
    }

    public function SintegraIsEnabled()
    {
        return boolval($this->scopeConfig->getValue('wsdirectdata/general/enable_sintegra', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function RevenueIsEnabled()
    {
        return boolval($this->scopeConfig->getValue('wsdirectdata/general/enable_revenue', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function SefazIsEnabled()
    {
        return boolval($this->scopeConfig->getValue('wsdirectdata/general/enable_sefaz', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    public function AttemptLimit()
    {
        return $this->scopeConfig->getValue('wsdirectdata/general/attempt_limit', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getToken()
    {
        return $this->scopeConfig->getValue('wsdirectdata/general/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
