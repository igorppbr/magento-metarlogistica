<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'metarlogistica';
        $this->_controller = 'adminhtml_quoteprices';
        $this->_headerText = Mage::helper('metarlogistica')->__('Metar Logistic - Quote Price');
        $this->_updateButton('save', 'label', Mage::helper('metarlogistica')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('metarlogistica')->__('Delete'));
    }
}