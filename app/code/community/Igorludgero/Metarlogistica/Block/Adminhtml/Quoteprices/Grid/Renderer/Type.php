<?php

/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices_Grid_Renderer_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if($value == 1){
            return Mage::helper("metarlogistica")->__("Capital");
        }
        else{
            return Mage::helper("metarlogistica")->__("Interior");
        }
    }
}