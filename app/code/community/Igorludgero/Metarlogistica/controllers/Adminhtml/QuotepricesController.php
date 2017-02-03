<?php

/**
 * @package     Igorludgero_Metarlogistica
 * @author      Igor Ludgero Miura
 * @copyright   Igor Ludgero Miura - https://www.igorludgero.com/ - igor@igorludgero.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Igorludgero_Metarlogistica_Adminhtml_QuotepricesController extends Mage_Adminhtml_Controller_Action
{

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('metarlogistica/quoteprices');
    }

    public function indexAction()
    {
        $this->_title($this->__('Metar Logistic'))->_title($this->__('Quote Prices'));
        $this->loadLayout();
        $this->_setActiveMenu('metarlogistica/quoteprices');
        $this->_addContent($this->getLayout()->createBlock('metarlogistica/adminhtml_quoteprices'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('metarlogistica/adminhtml_quoteprices_grid')->toHtml()
        );
    }

    public function newAction(){
        $this->_forward('edit');
    }

    public function editAction(){
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('metarlogistica/cotacaoprice')->load($id);
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('quoteprices_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('metarlogistica/quoteprices');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('metarlogistica/adminhtml_quoteprices_edit'));
            $this->getLayout()->getBlock('head')->setTitle($this->__('Metar Logistic - Quote Price'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('metarlogistica')->__("Quote Price not found.")
            );
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        if(isset($id)){
            $model = Mage::getModel('metarlogistica/cotacaoprice')->load($id);
            if($model->getId()>0){
                if($model->delete()){
                    Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('metarlogistica')->__("Quote Price removed.")
                    );
                    $this->_redirect('*/*/');
                }
                else{
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('metarlogistica')->__("Error trying to delete this quote price.")
                    );
                    $this->_redirect('*/*/new');
                }
            }
            else{
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('metarlogistica')->__("Invalid data, please re-input the quote price values.")
                );
                $this->_redirect('*/*/edit');
            }
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('metarlogistica')->__("Invalid data, please re-input the quote price values.")
            );
            $this->_redirect('*/*/edit');
        }
    }

    public function massDeleteAction(){
        $ids = $this->getRequest()->getParam('quoteprices_id');
        if(!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('metarlogistica')->__('Please select the quote price.'));
        } else {
            try {
                $quotePriceModel = Mage::getModel('metarlogistica/cotacaoprice');
                foreach ($ids as $id) {
                    $quotePriceModel->load($id)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('tax')->__(
                        'Total of %d record(s) were deleted.', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel("metarlogistica/cotacaoprice");

            if($data["id"] != ""){
                $model->load($data["id"]);
            }

            if($data['excedente'] != '')
                $model->setExcedente($data['excedente']);
            else
                $model->setExcedente(null);

            if($model->setUf($data['uf'])->setTipo($data['tipo'])->setPesoMin($data['peso_min'])->setPesoMax($data['peso_max'])->setValor($data['valor'])->save()){
                if($data["id"] != "")
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('metarlogistica')->__("Quote Price Updated."));
                else
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('metarlogistica')->__("Quote Price Saved."));
                $this->_redirect('adminhtml/quoteprices/index/');
            }
            else{
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('metarlogistica')->__("Error saving quote price. Check again the fields."));
                $this->_redirect('*/*/new');
            }

        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('metarlogistica')->__("Invalid Data."));
            $this->_redirect('*/*/new');
        }
    }

}