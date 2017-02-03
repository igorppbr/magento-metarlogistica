<?php

/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Model_System_Config_Backend_Shipping_Quotes extends Mage_Core_Model_Config_Data
{
    public function _afterSave()
    {
        Mage::getResourceModel('metarlogistica/cotacao')->uploadAndImport($this);
    }
}