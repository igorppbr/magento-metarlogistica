<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('igorludgero_metarlogistica_quoteprices');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('quoteprices_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('metarlogistica')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
            'confirm' => Mage::helper('metarlogistica')->__('Are you sure to delete these quote prices?')
        ));

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::helper("metarlogistica")->getAllQuotePrices();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('metarlogistica');

        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'type'   => 'text',
            'index'  => 'id'
        ));

        $this->addColumn('uf', array(
            'header' => $helper->__('State'),
            'type'   => 'text',
            'index'  => 'uf',
            'renderer' => 'Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices_Grid_Renderer_State'
        ));

        $this->addColumn('tipo', array(
            'header' => $helper->__('City Type'),
            'type'   => 'text',
            'index'  => 'tipo',
            'renderer' => 'Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices_Grid_Renderer_Type'
        ));

        $this->addColumn('peso_min', array(
            'header' => $helper->__('Min Weight'),
            'type'   => 'number',
            'index'  => 'peso_min'
        ));

        $this->addColumn('peso_max', array(
            'header' => $helper->__('Min Max'),
            'type'   => 'number',
            'index'  => 'peso_max'
        ));

        $this->addColumn('valor', array(
            'header' => $helper->__('Price'),
            'type'   => 'number',
            'index'  => 'valor'
        ));

        $this->addColumn('excedente', array(
            'header' => $helper->__('Price per KG surplus'),
            'type'   => 'number',
            'index'  => 'excedente'
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
                'store'=>$this->getRequest()->getParam('store'),
                'id'=>$row->getId())
        );
    }

}