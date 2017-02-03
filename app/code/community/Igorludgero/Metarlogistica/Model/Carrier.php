<?php

/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code = 'metarlogistica';
    protected $_title;
    protected $_estimatedDeadline;
    protected $_addDays;
    protected $_addPrice;
    protected $_customMessage;
    protected $_enabled;

    public function __construct()
    {

        $this->_estimatedDeadline = $this->getConfigValue('estimated_deadline');
        $this->_addDays = $this->getConfigValue('add_days');
        $this->_addPrice = $this->getConfigValue('add_price');
        $this->_customMessage = $this->getConfigValue('custom_message');
        $this->_enabled = $this->getConfigValue('active');
    }

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {

        $result = Mage::getModel('shipping/rate_result');

        if($this->_enabled) {

            try {

                $weight = $request->getPackageWeight();
                $postCode = str_replace("-", "", $request->getDestPostcode());

                $metarlogisticaQuote = Mage::getModel("metarlogistica/cotacao")->getCollection()->addFieldToFilter("cep_inicio", array('lteq' => $postCode))->addFieldToFilter("cep_fim", array('gteq' => $postCode))->getFirstItem();

                $metarlogisticaQuotePriceCollection = Mage::getModel("metarlogistica/cotacaoprice")->getCollection()->addFieldToFilter("tipo", $metarlogisticaQuote->getTipo())->addFieldToFilter("uf", $metarlogisticaQuote->getUf())->addFieldToFilter("peso_min", array('lteq' => $weight))->addFieldToFilter("peso_max", array('gteq' => $weight));
                $metarlogisticaQuotePrice = null;
                if ($metarlogisticaQuotePriceCollection->count() > 1) {
                    $metarlogisticaQuotePrice = $metarlogisticaQuotePriceCollection->getFirstItem();
                } else {
                    $metarlogisticaQuotePrice = Mage::getModel("metarlogistica/cotacaoprice")->getCollection()->addFieldToFilter("uf", $metarlogisticaQuote->getUf())->setOrder('peso_max', 'DESC')->getFirstItem();
                }

                if ($metarlogisticaQuotePrice != null && $metarlogisticaQuotePrice->getValor() > 0)
                    $result->append($this->_getStandardRate($weight, $metarlogisticaQuotePrice, $metarlogisticaQuote));

            } catch (Exception $ex) {
                Mage::log("Error in Metarlogistica collectRates: " . $ex->getMessage(), null, "metarlogistica.log");
            }

        }

        return $result;
    }

    public function getAllowedMethods()
    {
        return array(
            'metarlogistica' => 'Metar Logistica Transportadora'
        );
    }

    protected function _getStandardRate($weight,$metarlogisticaQuotePrice,$metarlogisticaQuote)
    {
        $rate = Mage::getModel('shipping/rate_result_method');
        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->_title);
        $rate->setMethod('metarlogistica');
        $rate->setMethodTitle($this->generateMethodTitle($metarlogisticaQuote->getPrazo(), $metarlogisticaQuote->getCidade()));
        $rate->setPrice($this->calculateFinalPrice($weight,$metarlogisticaQuotePrice));
        if($this->_addPrice != "")
            $rate->setCost($this->_addPrice);
        else
            $rate->setCost(0);
        return $rate;
    }

    private function getConfigValue($path){
        return Mage::getStoreConfig(
            'carriers/metar_logistica/'.$path,
            Mage::app()->getStore()
        );
    }

    private function generateMethodTitle($days,$city){

        if($this->_estimatedDeadline){
            if($this->_addDays != ""){
                $days = $days + $this->_addDays;
            }
            if($this->_customMessage!=""){
                return sprintf($this->_customMessage,$city,$days);
            }
            else{
                return sprintf('Entrega em %s. Prazo de %d dia(s) útil(eis).',$city,$days);
            }
        }
        else{
            if($this->_customMessage!=""){
                return sprintf($this->_customMessage,$city);
            }
            else{
                return sprintf('Entrega em %s',$city);
            }
        }

    }

    private function calculateFinalPrice($weight,$quotePrice){
        $finalValue = 0;
        $difference = $weight - $quotePrice->getPesoMax();
        if($difference <= 0){
            $finalValue = $quotePrice->getValor();
        }
        else{
            if($quotePrice->getExcedente())
                $finalValue = $quotePrice->getValor() + ($quotePrice->getExcedente() * $difference);
            else
                $finalValue = $quotePrice->getValor();
        }
        if($this->_addPrice)
            $finalValue = $finalValue + $this->_addPrice;
        return $finalValue;
    }

}