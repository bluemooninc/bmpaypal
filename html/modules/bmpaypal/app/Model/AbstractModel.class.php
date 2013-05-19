<?php
/**
 * Created by JetBrains PhpStorm.
 * Copyright(c): bluemooninc
 * Date: 2013/01/08
 * Time: 15:55
 * To change this template use File | Settings | File Templates.
 */
abstract class AbstractModel {
	// object
	protected $root = null;
	protected $myHandler;
	protected $myObject;
	/**
	 * constructor
	 */
	public function __construct() {
		$this->root = XCube_Root::getSingleton();
	}
	protected function getModuleNames($isactive = FALSE)
	{
		$criteria = new CriteriaCompo();
		if ($isactive) {
			$criteria->add(new Criteria('isactive', '1', '='));
		}
		$module_handler =& xoops_gethandler('module');
		$objs = $module_handler->getObjects($criteria);
		$ret = array();
		foreach ($objs as $obj) {
			$ret[$obj->getVar('mid')] = $obj->getVar('name');
		}
		return $ret;
	}

	public function setMyObject(&$object){
		$this->myObject = $object;
	}

	public function &getMyObject(){
		return $this->myObject;
	}

	public function setterInjection(&$object){
		$this->myObject->mVars = array_merge($this->myObject->mVars,$object->mVars);
		//foreach($object->mVars as $key=>$val){
		//	if (isset($this->myObject->mVars[$key])){
		//		$this->myObject->set($key,$val['value']);
		//	}
		//}
	}
	/**
	 * @param $array
	 * @return array
	 */
	function array_flatten($array){
		$result = array();
		array_walk_recursive($array, function($v) use (&$result){
			$result[] = $v;
		});
		return $result;
	}

}