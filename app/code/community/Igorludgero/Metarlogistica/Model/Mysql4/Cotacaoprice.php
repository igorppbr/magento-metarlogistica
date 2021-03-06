<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Model_Mysql4_Cotacaoprice extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('metarlogistica/cotacaoprice', 'id');
    }
}