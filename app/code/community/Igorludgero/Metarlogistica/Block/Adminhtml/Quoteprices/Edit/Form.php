<?php
/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Block_Adminhtml_Quoteprices_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post')
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        $data = array();
        if (Mage::getSingleton('adminhtml/session')->getQuotepricesData()) {
            $data = Mage::getSingleton('adminhtml/session')->getQuotepricesData();
            Mage::getSingleton('adminhtml/session')->setQuotepricesData(null);
        } elseif (Mage::registry('quoteprices_data')) {
            $data = Mage::registry('quoteprices_data')->getData();
        }

        $fieldset = $form->addFieldset('quoteprices_form', array(
            'legend'=>Mage::helper('metarlogistica')->__('Quote Price Information')
        ));

        $fieldset->addField('id', 'hidden', array(
            'label' => Mage::helper('metarlogistica')->__('ID'),
            'required' => false,
            'name' => 'id',
            'value' => ($data['id']) ? $data['id'] : ''
        ));

        $brazilianStates = Mage::helper("metarlogistica")->getBrazilianStates();

        $fieldset->addField('uf', 'select', array(
            'label' => Mage::helper('metarlogistica')->__('State'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'uf',
            'values' => $brazilianStates,
            'value' => ($data['uf']) ? $data['uf'] : ''
        ));

        $fieldset->addField('tipo', 'select', array(
            'label' => Mage::helper('metarlogistica')->__('City Type'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'tipo',
            'values' => array(array('label' => Mage::helper("metarlogistica")->__('Capital'), 'value' => 1), array('label' => Mage::helper("metarlogistica")->__('Interior'), 'value' => 2)),
            'value' => ($data['tipo']) ? $data['tipo'] : ''
        ));

        $fieldset->addField('peso_min', 'text', array(
            'label' => Mage::helper('metarlogistica')->__('Min Weight'),
            'required' => true,
            'name' => 'peso_min',
            'class' => 'required-entry validate-number',
            'value' => ($data['peso_min']) ? $data['peso_min'] : ''
        ));

        $fieldset->addField('peso_max', 'text', array(
            'label' => Mage::helper('metarlogistica')->__('Max Weight'),
            'required' => true,
            'name' => 'peso_max',
            'class' => 'required-entry validate-number',
            'value' => ($data['peso_max']) ? $data['peso_max'] : ''
        ));

        $fieldset->addField('valor', 'text', array(
            'label' => Mage::helper('metarlogistica')->__('Price'),
            'required' => true,
            'name' => 'valor',
            'class' => 'required-entry validate-number',
            'value' => ($data['valor']) ? $data['valor'] : ''
        ));

        $fieldset->addField('excedente', 'text', array(
            'label' => Mage::helper('metarlogistica')->__('Price per KG surplus'),
            'comment' => Mage::helper('metarlogistica')->__('If this Price Quote is the last one please add the surplus price per KG.'),
            'required' => false,
            'name' => 'excedente',
            'class' => 'validate-number',
            'value' => ($data['excedente']) ? $data['excedente'] : ''
        ));

        return parent::_prepareForm();

    }
}