<?php
require_once 'Mage/Widget/controllers/Adminhtml/WidgetController.php';

class Codazon_Filterproducts_Adminhtml_WidgetController extends Mage_Widget_Adminhtml_WidgetController
{
    public function buildWidgetAction()
    {
        $type = $this->getRequest()->getPost('widget_type');
        $params = $this->getRequest()->getPost('parameters', array());

        if ('module/widget_html' == $type) {
            $params['text'] = base64_encode($params['text']);
        }

        $asIs = $this->getRequest()->getPost('as_is');
        $html = Mage::getSingleton('widget/widget')->getWidgetDeclaration($type, $params, $asIs);
        $this->getResponse()->setBody($html);
    }
}