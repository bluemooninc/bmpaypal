<?php
if (!defined('XOOPS_ROOT_PATH')) die();

class Bmpaypal_Preload extends XCube_ActionFilter
{
    public function postFilter()
    {
        require_once XOOPS_MODULE_PATH . '/bmpaypal/service/Service.class.php';
        $service = new Bmpaypal_Service();
        $service->prepare();
        $this->mRoot->mServiceManager->addService('gmoPayment', $service);
    }
}
