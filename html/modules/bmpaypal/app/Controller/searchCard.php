<?php
/*
* GMO-PG - Payment Module as XOOPS Cube Module
* Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
* GPL V3 licence
 */
require_once _MY_MODULE_PATH.'app/Model/bmpaypal.class.php';

class Controller_searchCard extends AbstractAction{
	private $listdata;
	private $params;
	var $viewFullPath;
	var $viewTemplate;
	protected $_bmpaypal;
	
	public function setParams($params){
		$this->params=$params;
		$this->_bmpaypal = new bmpaypal();
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
		$render->setAttribute('ListData', $this->listdata);
		$render->setAttribute('message', $this->_bmpaypal->get_message());
	}
	/*
	 * Method Section
	*/

	public function index(){

        $this->listdata = $this->_bmpaypal->getCardList();
    }
	public function submit(){

        if( isset( $_POST['submit'] ) ){
            $this->listdata = $this->_bmpaypal->getCardList();
		}
	}
}