<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Model_Mysql4_Cotacao extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('metarlogistica/cotacao', 'id');
    }

    public function uploadAndImport(Varien_Object $object)
    {
        $csvFile = $_FILES['groups']['tmp_name']['metarlogistica']['fields']['import']['value'];

        try {

            $dataObject = $object->getData();
            $name = $dataObject['groups']['metarlogistica']['fields']['import']['value'];

            if(is_numeric($name) == false) {

                $extensionAndName = explode(".", $name);

                if ($extensionAndName[1] == "csv") {

                    $csvObject = new Varien_File_Csv();
                    $csvData = $csvObject->getData($csvFile);

                    if (count($csvData) > 1) {

                        Mage::helper("metarlogistica")->clearCotacoesDatabase();

                        for ($i = 1; $i < count($csvData); $i++) {
                            Mage::helper("metarlogistica")->importCotacaoToDatabase($csvData[$i]);
                        }
                        Mage::getSingleton('core/session')->addSuccess(Mage::helper("metarlogistica")->__('MetarLogistica Database Updated successfully!'));

                    } else {
                        Mage::getSingleton('core/session')->addError(Mage::helper("metarlogistica")->__("Your CSV file is empty."));
                    }
                } else {
                    Mage::getSingleton('core/session')->addError(Mage::helper("metarlogistica")->__("Invalid file. Only CSV files are allowed."));
                }

            }

        }
        catch(Exception $ex){
            Mage::getSingleton('core/session')->addError(Mage::helper("metarlogistica")->__("An error occurred. Please check your csv file."));
        }
    }

}