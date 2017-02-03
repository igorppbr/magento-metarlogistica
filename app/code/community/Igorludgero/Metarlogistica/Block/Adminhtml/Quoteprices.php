<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'metarlogistica';
        $this->_controller = 'adminhtml_quoteprices';
        $this->_headerText = Mage::helper('metarlogistica')->__('Metar Logistic - Manage Quote Prices');

        parent::__construct();
        $this->_removeButton('add');
        $this->_addButton('add_new', array(
            'label'   => Mage::helper('metarlogistica')->__('Add New Quote Price'),
            'onclick' => "setLocation('{$this->getUrl('*/*/new')}')",
            'class'   => 'add'
        ));
    }
}