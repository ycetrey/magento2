<?php

/**
 * Correios
 *
 * Correios Shipping Method for Magento 2.
 *
 * @package ImaginationMedia\Correios
 * @author Igor Ludgero Miura <igor@imaginemage.com>
 * @copyright Copyright (c) 2017 Imagination Media (http://imaginemage.com/)
 * @license https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

namespace ImaginationMedia\Correios\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use ImaginationMedia\Correios\Model\CotacoesFactory;
use ImaginationMedia\Correios\Model\ResourceModel\Cotacoes as ResourceModel;

class Data extends AbstractHelper
{
    /**
     * @var string
     */
    protected $storeScope;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var array
     */
    protected $obligatoryLogin = array(40096,40436,40444,81019,41068);

    /**
     * @var CotacoesFactory
     */
    protected $cotacoesFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    /**
     * Data constructor.
     * @param ProductRepository $productRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param CotacoesFactory $cotacoesFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        ProductRepository $productRepository,
        ScopeConfigInterface $scopeConfig,
        CotacoesFactory $cotacoesFactory,
        ResourceModel $resourceModel
    ) {
        $this->storeScope = ScopeInterface::SCOPE_STORE;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->cotacoesFactory = $cotacoesFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * @param $codigo
     * @return string
     */
    public function getMethodName($codigo)
    {
        $codigo = (int)$codigo;
        if ($codigo == 40010 || $codigo == $this->scopeConfig->getValue(
            'correios_postingmethods_config/settings/sedex',
            $this->storeScope
        )) {
            return "Sedex";
        } elseif ($codigo == 81019 || $codigo == $this->scopeConfig->getValue(
            'correios_postingmethods_config/settings/esedex',
            $this->storeScope
        )) {
            return "E-Sedex";
        } elseif ($codigo == 41106 || $codigo == 41068 || $this->scopeConfig->getValue(
            'correios_postingmethods_config/settings/pac',
            $this->storeScope
        )) {
            return "PAC ";
        } elseif ($codigo == 40215 || $this->scopeConfig->getValue(
            'correios_postingmethods_config/settings/sedex10',
            $this->storeScope
        )) {
            return "Sedex 10";
        } elseif ($codigo == 40290 || $this->scopeConfig->getValue(
            'correios_postingmethods_config/settings/sedex_hoje',
            $this->storeScope
        )) {
            return "Sedex HOJE";
        } elseif ($codigo == 40045 || $this->scopeConfig->getValue(
            'correios_postingmethods_config/settings/sedex_cobrar',
            $this->storeScope
        )) {
            return "Sedex a cobrar";
        } else {
            return "Undefined";
        }
    }

    /**
     * @param $service
     * @param $weight
     * @param $finalPostcode
     * @return bool|mixed
     */
    public function getServiceToPopulate($service, $weight, $finalPostcode)
    {
        $webserviceUrl = $this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/webservice_url',
            $this->storeScope
        );
        if ($webserviceUrl != "") {
            $url = $this->scopeConfig->getValue(
                'carriers/imaginationmedia_correios/webservice_url',
                $this->storeScope
            );
        } else {
            $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?StrRetorno=xml";
        }
        $login = $this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/login',
            $this->storeScope
        );
        $password = $this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/password',
            $this->storeScope
        );

        if ((int)$this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/default_height',
            $this->storeScope
        ) > 0) {
            $defHeight = (int)$this->scopeConfig->getValue(
                'carriers/imaginationmedia_correios/default_height',
                $this->storeScope
            );
        } else {
            $defHeight = 2;
        }

        if ((int)$this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/default_width',
            $this->storeScope
        ) > 0) {
            $defWidth = (int)$this->scopeConfig->getValue(
                'carriers/imaginationmedia_correios/default_width',
                $this->storeScope
            );
        } else {
            $defWidth = 16;
        }

        if ($this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/owner_hands',
            $this->storeScope
        ) == 0) {
            $ownerHands = 'N';
        } else {
            $ownerHands = 'S';
        }

        if ($this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/received_warning',
            $this->storeScope
        ) == 0) {
            $receivedWarning = 'N';
        } else {
            $receivedWarning = 'S';
        }

        $origPostcode = $this->scopeConfig->getValue("shipping/origin/postcode", $this->storeScope);
        $declaredValue = $this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/declared_value',
            $this->storeScope
        );

        //Check if the service needs the login and password
        if (in_array($service, $this->obligatoryLogin) == true && ($login=="" || $password=="")) {
            $this->logMessage("Impossible to calculate the service ".$service.
                " because the login/password isn't filled.");
            return false;
        }

        if ($login!="") {
            $url_d = $url . "&nCdEmpresa=" . $login . "&sDsSenha=" . $password . "&nCdFormato=1&nCdServico=" .
                $service . "&nVlComprimento=" . $defWidth . "&nVlAltura=" . $defHeight . "&nVlLargura=" .
                $defWidth . "&sCepOrigem=" . $origPostcode . "&sCdMaoPropria=" . $ownerHands . "&sCdAvisoRecebimento=" .
                $receivedWarning . "&nVlPeso=" . $weight . "&sCepDestino=" . $finalPostcode;
        } else {
            $url_d = $url . "&nCdFormato=1&nCdServico=" . $service . "&nVlComprimento=" . $defWidth . "&nVlAltura=" .
                $defHeight . "&nVlLargura=" . $defWidth . "&sCepOrigem=" . $origPostcode . "&sCdMaoPropria=" .
                $ownerHands . "&sCdAvisoRecebimento=" . $receivedWarning . "&nVlPeso=" .
                $weight . "&sCepDestino=" . $finalPostcode;
        }
        //Check "valor declarado"
        if ($declaredValue) {
            $url_d = $url_d . "&nVlValorDeclarado=18";
        }

        $this->logMessage($url_d);
        $urls = array($url_d);
        $shippingQuotes = $this->getOnlineShippingQuotes($urls);
        if (count($shippingQuotes) > 0) {
            return $shippingQuotes[0];
        } else {
            return false;
        }
    }

    /**
     * @param $urlsArray
     * @param bool $isOffline
     * @return array
     */
    public function getOnlineShippingQuotes($urlsArray, $isOffline = false)
    {
        $deliveryMessage = $this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/deliverydays_message",
            $this->storeScope
        );
        if ($deliveryMessage=="") {
            $deliveryMessage = "%s - Em média %d dia(s)";
        }
        $showDeliveryDays = $this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/show_deliverydays",
            $this->storeScope
        );
        $addDeliveryDays = (int)$this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/add_deliverydays",
            $this->storeScope
        );

        $handlingFee = 0;
        if ($this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/handling_fee",
            $this->storeScope
        ) != "") {
            if (is_numeric($this->scopeConfig->getValue(
                "carriers/imaginationmedia_correios/handling_fee",
                $this->storeScope
            ))) {
                $handlingFee = $this->scopeConfig->getValue(
                    "carriers/imaginationmedia_correios/handling_fee",
                    $this->storeScope
                );
            }
        }

        //Don't add more days if is a offline result
        if ($isOffline==true) {
            $addDeliveryDays = 0;
        }

        $ratingsCollection = array();
        foreach ($urlsArray as $url_d) {
            $xml=null;
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url_d);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                ob_start();
                curl_exec($ch);
                curl_close($ch);
                $content = ob_get_contents();
                ob_end_clean();
                if ($content) {
                    $xml = new \SimpleXMLElement($content);
                }
            } catch (\Exception $e) {
                $this->logMessage("Error in consult XML: ".$e->getMessage());
                continue;
            }

            if ($xml!=null) {
                foreach ($xml->cServico as $servico) {
                    if ((float)$servico->Valor > 0) {
                        try {
                            $data = array();
                            if ($showDeliveryDays==0) {
                                $data['servico'] = $this->getMethodName($servico->Codigo);
                            } else {
                                $data['servico'] = sprintf(
                                    $deliveryMessage,
                                    $this->getMethodName($servico->Codigo),
                                    intval($servico->PrazoEntrega + $addDeliveryDays)
                                );
                            }
                            $data['valor'] = str_replace(",", ".", $servico->Valor) + $handlingFee;
                            $data['prazo'] = $servico->PrazoEntrega + $addDeliveryDays;
                            $data['servico_codigo'] = $servico->Codigo;
                            array_push($ratingsCollection, $data);
                            if ($servico->MsgErro != "") {
                                $this->logMessage("Error on helper line165: " . $servico->MsgErro);
                            }
                        } catch (\Exception $ex) {
                            $this->logMessage("Error in consult XML2: ".$ex->getMessage());
                        }
                    } else {
                        $this->logMessage("Error in consult XML3: ");
                    }
                }
            }
        }
        return $ratingsCollection;
    }

    /**
     * @param $request
     * @param $fromCountryId
     * @return bool
     */
    public function checkCountry($request, $fromCountryId)
    {
        $from = $fromCountryId;
        $to = $request->getDestCountryId();
        if ($from != "BR" || $to != "BR") {
            return false;
        }
        return true;
    }

    /**
     * @param $zipcode
     * @return bool|null|string|string[]
     */
    public function formatZip($zipcode)
    {
        $new = trim($zipcode);
        $new = preg_replace('/[^0-9\s]/', '', $new);

        if (!preg_match("/^[0-9]{7,8}$/", $new)) {
            return false;
        } elseif (preg_match("/^[0-9]{7}$/", $new)) {
            $new = "0" . $new;
        }
        return $new;
    }

    /**
     * @param $service
     * @param $firstPostcode
     * @param $lastPostcode
     * @return bool
     */
    public function canCreateOfflineTrack($service, $firstPostcode, $lastPostcode)
    {
        $collection = $this->cotacoesFactory->create()
            ->getCollection()
            ->addFieldToFilter('cep_inicio', ["lteq" => $firstPostcode])
            ->addFieldToFilter('cep_fim', ["gteq" => $lastPostcode])
            ->addFilter("servico", $service);
        if ($collection->count()>0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $originalPrice
     * @return mixed
     */
    public function formatPrice($originalPrice)
    {
        $finalPrice = str_replace(" ", "", $originalPrice);
        $finalPrice = str_replace("R$", "", $finalPrice);
        return $finalPrice;
    }

    /**
     * @param $weight
     * @return string
     */
    public function fixWeight($weight)
    {
        $result = $weight;
        if (($this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/weight_type",
            $this->storeScope
        ) == 'gr')) {
            $result = number_format($weight/1000, 2, '.', '');
        }
        return $result;
    }

    /**
     * @param $request
     * @return bool
     */
    public function checkWeightRange($request)
    {
        $weight = $this->fixWeight($request->getPackageWeight());
        $maxWeight = (double)($this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/max_weight",
            $this->storeScope
        ));
        if ($weight > $maxWeight || $weight <= 0) {
            return false;
        }
        return true;
    }

    /**
     * @param $quote
     * @return int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCubicWeight($quote)
    {
        $cubicWeight = 0;
        $items = $quote->getAllVisibleItems();
        $maxH = 90;
        $minH = 2;
        $maxW = 90;
        $minW = 16;
        $maxD = 90;
        $minD = 11;
        $sumMax = 160;
        $coefficient = 6000;
        $validate = $this->scopeConfig->getValue(
            'carriers/imaginationmedia_correios/validate_dimensions',
            $this->storeScope
        );
        foreach ($items as $item) {
            $productItem = $item->getProduct();
            $product = $this->productRepository->getById($productItem->getId());
            $width = (!$product->getData('correios_width')) ? (int)$this->scopeConfig->getValue(
                "carriers/imaginationmedia_correios/default_width",
                $this->storeScope
            ) : $product->getData('correios_width');
            $height = (!$product->getData('correios_height')) ? (int)$this->scopeConfig->getValue(
                "carriers/imaginationmedia_correios/default_height",
                $this->storeScope
            ) : $product->getData('correios_height');
            $depth = (!$product->getData('correios_depth')) ? (int)$this->scopeConfig->getValue(
                "carriers/imaginationmedia_correios/default_depth",
                $this->storeScope
            ) : $product->getData('correios_depth');
            if ($validate && ($height > $maxH || $height < $minH || $depth > $maxD ||
                    $depth < $minD || $width > $maxW || $width < $minW ||
                    ($height+$depth+$width) > $sumMax)) {
                $this->logMessage("Invalid Product Dimensions");
                return 0;
            }
            $cubicWeight += (($width * $depth * $height) / $coefficient) * $item->getQty();
        }
        return $this->fixWeight($cubicWeight);
    }

    /**
     * @param $message
     */
    public function logMessage($message)
    {
        if (($this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/enabled_log",
            $this->storeScope
        ) == 1)) {
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/imaginationmedia_correios.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info($message);
        }
    }

    /**
     * @return bool
     */
    public function updateOfflineTracks()
    {
        $lastItem = $this->cotacoesFactory->create()
            ->getCollection()
            ->setOrder("ultimo_update", "desc")
            ->getFirstItem();
        $this->logMessage("Last Update: ".$lastItem->getUltimoUpdate());

        $daysUpdate = $this->scopeConfig->getValue(
            "carriers/imaginationmedia_correios/maxdays_update",
            $this->storeScope
        );
        if (!is_numeric($daysUpdate)) {
            $daysUpdate = 15;
        }
        if ($daysUpdate <= 0) {
            $daysUpdate = 15;
        }

        $lastUpdateDatetime = $lastItem->getUltimoUpdate();
        $nowDate = date('Y-m-d H:i:s');

        $diff = abs(strtotime($nowDate) - strtotime($lastUpdateDatetime));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $this->logMessage("Days: ".$days." daysUpdate: ".$daysUpdate);

        if ($days < $daysUpdate) {
            return false;
        }

        $collectionToUpdate = $this->cotacoesFactory->create()->getCollection();
        $this->updateTrackCollection($collectionToUpdate);
        $this->logMessage("Offline Postcode Tracks updated");
    }

    /**
     * @param $collection
     * @return array
     */
    private function updateTrackCollection($collection)
    {
        $updated = 0;
        $errors = 0;
        if ($collection->count()>0) {
            foreach ($collection as $cotacao) {
                $cotacaoObj = $this->cotacoesFactory->create()->load($cotacao->getId());
                $cotacaoValues = $this->getServiceToPopulate(
                    $cotacaoObj->getServico(),
                    $cotacaoObj->getPeso(),
                    $cotacaoObj->getCepFim()
                );
                if ($cotacaoValues != false) {
                    $now = new \DateTime();
                    $cotacaoObj->setPrazo($cotacaoValues["prazo"])
                        ->setValor($cotacaoValues["valor"])
                        ->setUltimoUpdate($now->format('Y-m-d H:i:s'));
                    if ($cotacaoObj->save()) {
                        $updated++;
                    } else {
                        $errors++;
                    }
                } else {
                    //Try to get with the half postcode in the current postcode track
                    $halfPostcode = ($cotacaoObj->getCepFim() -
                        ($cotacaoObj->getCepFim() - $cotacaoObj->getCepInicio()) / 2);
                    $cotacaoValues = $this->getServiceToPopulate(
                        $cotacaoObj->getServico(),
                        $cotacaoObj->getPeso(),
                        $halfPostcode
                    );
                    if ($cotacaoValues != false) {
                        $now = new \DateTime();
                        $cotacaoObj->setPrazo($cotacaoValues["prazo"])
                            ->setValor($cotacaoValues["valor"])
                            ->setUltimoUpdate($now->format('Y-m-d H:i:s'));
                        if ($cotacaoObj->save()) {
                            $updated++;
                        } else {
                            $errors++;
                        }
                    } else {
                        $errors++;
                    }
                }
            }
        }
        return array($updated,$errors);
    }

    /**
     * @param $methods
     * @return array
     */
    public function getPostMethodCodes($methods)
    {
        $arrayMethods = array();
        foreach ($methods as $codigo) {
            if ($codigo==40096) {
                if ($this->scopeConfig->getValue(
                    'correios_postingmethods_config/settings/sedex',
                    $this->storeScope
                ) != "") {
                    $arrayMethods[] = (string)$this->scopeConfig->getValue(
                        'correios_postingmethods_config/settings/sedex',
                        $this->storeScope
                    );
                } else {
                    $arrayMethods[] = $codigo;
                }
            } elseif ($codigo==81019) {
                if ($this->scopeConfig->getValue(
                    'correios_postingmethods_config/settings/esedex',
                    $this->storeScope
                ) != "") {
                    $arrayMethods[] = (string)$this->scopeConfig->getValue(
                        'correios_postingmethods_config/settings/esedex',
                        $this->storeScope
                    );
                } else {
                    $arrayMethods[] = $codigo;
                }
            } elseif ($codigo==41106 || $codigo==41068) {
                if ($this->scopeConfig->getValue(
                    'correios_postingmethods_config/settings/pac',
                    $this->storeScope
                ) != "") {
                    $arrayMethods[] = (string)$this->scopeConfig->getValue(
                        'correios_postingmethods_config/settings/pac',
                        $this->storeScope
                    );
                } else {
                    $arrayMethods[] = $codigo;
                }
            } elseif ($codigo==40215) {
                if ($this->scopeConfig->getValue(
                    'correios_postingmethods_config/settings/sedex10',
                    $this->storeScope
                ) != "") {
                    $arrayMethods[] = (string)$this->scopeConfig->getValue(
                        'correios_postingmethods_config/settings/sedex10',
                        $this->storeScope
                    );
                } else {
                    $arrayMethods[] = $codigo;
                }
            } elseif ($codigo==40290) {
                if ($this->scopeConfig->getValue(
                    'correios_postingmethods_config/settings/sedex_hoje',
                    $this->storeScope
                ) != "") {
                    $arrayMethods[] = (string)$this->scopeConfig->getValue(
                        'correios_postingmethods_config/settings/sedex_hoje',
                        $this->storeScope
                    );
                } else {
                    $arrayMethods[] = $codigo;
                }
            } elseif ($codigo==40045) {
                if ($this->scopeConfig->getValue(
                    'correios_postingmethods_config/settings/sedex_cobrar',
                    $this->storeScope
                ) != "") {
                    $arrayMethods[] = (string)$this->scopeConfig->getValue(
                        'correios_postingmethods_config/settings/sedex_cobrar',
                        $this->storeScope
                    );
                } else {
                    $arrayMethods[] = $codigo;
                }
            }
        }
        return $arrayMethods;
    }

    /**
     * Truncate collection data table
     * @throws \Exception
     */
    public function truncateCotacoes()
    {
        /**
         * @var $collection \ImaginationMedia\Correios\Model\ResourceModel\Cotacoes\Collection
         */
        $collection = $this->cotacoesFactory->create()->getCollection();
        foreach ($collection as $item) {
            $cotacao = $this->cotacoesFactory->create()->load($item->getId());
            $this->resourceModel->delete($cotacao);
        }
    }
}
