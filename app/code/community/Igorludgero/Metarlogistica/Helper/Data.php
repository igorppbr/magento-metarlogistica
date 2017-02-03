<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Helper_Data extends Mage_Core_Helper_Abstract{


    /**
     * @description Insert the registry in the database.
     * @param $row - The current shipping quote to be added in database.
     * @return boolean - Return a boolean if was saved or not.
     */
    public function importCotacaoToDatabase($row){
        $rowArray = explode(";",$row[0]);

        //Check if can send to this current address.
        if(strtolower($rowArray[5]) == "s") {

            $cityType = 1;
            if (strtolower($rowArray[2]) == "interior")
                $cityType = 2;

            $cepFim = str_replace("-", "", $rowArray[4]);
            $cepInicio = str_replace("-", "", $rowArray[3]);

            $newModel = Mage::getModel("metarlogistica/cotacao")
                ->setCidade($rowArray[0])
                ->setUf($rowArray[1])
                ->setTipoCidade($cityType)
                ->setCepInicio($cepInicio)
                ->setCepFim($cepFim)
                ->setPrazo($rowArray[6]);
            return $newModel->save();
        }
        return false;
    }

    /**
     * @description Remove all registries from the cotacoes table to import new quotes.
     * @return bool
     */
    public function clearCotacoesDatabase(){
        $collection = Mage::getModel("metarlogistica/cotacao")->getCollection();
        foreach ($collection as $cotacao){
            $cotacao->delete();
        }
        return true;
    }

    /**
     * @description - Return the Quote Price of MetarLogistica database.
     * @return mixed - The Quote Price Collection
     */
    public function getAllQuotePrices(){
        return Mage::getModel("metarlogistica/cotacaoprice")->getCollection();
    }

    /**
     * @description - Return all brazilian states.
     * @return array - Array of all brazilian states.
     */
    public function getBrazilianStates(){
        return array(
            array('value' =>'AC', 'label' =>'Acre'),
            array('value' =>'AL', 'label' =>'Alagoas'),
            array('value' =>'AP', 'label' =>'Amapá'),
            array('value' =>'AM', 'label' =>'Amazonas'),
            array('value' =>'BA', 'label' =>'Bahia'),
            array('value' =>'CE', 'label' =>'Ceará'),
            array('value' =>'DF', 'label' =>'Distrito Federal'),
            array('value' =>'ES', 'label' =>'Espírito Santo'),
            array('value' =>'GO', 'label' =>'Goiás'),
            array('value' =>'MA', 'label' =>'Maranhão'),
            array('value' =>'MT', 'label' =>'Mato Grosso'),
            array('value' =>'MS', 'label' =>'Mato Grosso do Sul'),
            array('value' =>'MG', 'label' =>'Minas Gerais'),
            array('value' =>'PA', 'label' =>'Pará'),
            array('value' =>'PB', 'label' =>'Paraíba'),
            array('value' =>'PR', 'label' =>'Paraná'),
            array('value' =>'PE', 'label' =>'Pernambuco'),
            array('value' =>'PI', 'label' =>'Piauí'),
            array('value' =>'RJ', 'label' =>'Rio de Janeiro'),
            array('value' =>'RN', 'label' =>'Rio Grande do Norte'),
            array('value' =>'RS', 'label' =>'Rio Grande do Sul'),
            array('value' =>'RO', 'label' =>'Rondônia'),
            array('value' =>'RR', 'label' =>'Roraima'),
            array('value' =>'SC', 'label' =>'Santa Catarina'),
            array('value' =>'SP', 'label' =>'São Paulo'),
            array('value' =>'SE', 'label' =>'Sergipe'),
            array('value' =>'TO', 'label' =>'Tocantins')
        );
    }

}