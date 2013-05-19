<?php
/*
* GMO-PG - Payment Module as XOOPS Cube Module
* Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
* GPL V3 licence
 */
require_once _MY_MODULE_PATH.'app/Model/bmpaypal.class.php';

class Controller_CardPayment extends AbstractAction{
	private $params;
	var $viewFullPath;
	var $viewTemplate;
	protected $Model_PayPal;

	public function setParams($params){
		$this->params=$params;
		$this->Model_PayPal = new bmpaypal();
	}
	public function setTemplate($controllerName){
		if (is_null($this->viewTemplate)) $this->viewTemplate = $controllerName . ".html";
	}
	public function setView($viewFullPath){
		$this->viewFullPath = $viewFullPath;
	}
	public function template(){
		return $this->viewTemplate;
	}
	public function executeView(&$render){
		$render->setTemplateName($this->viewTemplate);
		$render->setAttribute('message', $this->Model_PayPal->get_message());
	}
	/*
	 * Method Section
	*/
	public function index(){
	}
	public function submit(){
		$CardNo = $this->root->mContext->mRequest->getRequest('CardNo');
		$CardName = $this->root->mContext->mRequest->getRequest('CardName');
		$ExpireMonth = intval($this->root->mContext->mRequest->getRequest('ExpireMonth'));
		$ExpireYear = intval($this->root->mContext->mRequest->getRequest('ExpireYear'));
		$cvv2 = intval($this->root->mContext->mRequest->getRequest('cvv2'));
		$FirstName = $this->root->mContext->mRequest->getRequest('FirstName');
		$LastName = $this->root->mContext->mRequest->getRequest('LastName');
		$this->Model_PayPal->setAmount(1,1.99);  // TODO: test
		$this->Model_PayPal->CreateCardPayment($CardNo,$CardName,$ExpireMonth,$ExpireYear,$cvv2,$FirstName,$LastName);
		$this->Model_PayPal->SavePaymentInfo();
		echo "Done!";die;
	}
}