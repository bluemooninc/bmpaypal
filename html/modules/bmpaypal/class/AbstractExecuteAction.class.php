<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/bmpaypal/class/AbstractEditAction.class.php";

class bmpaypal_AbstractExecuteAction extends bmpaypal_AbstractEditAction
{
	function isEnableCreate()
	{
		return false;
	}

	function _doExecute()
	{
		die("hoge");
		return $this->mObjectHandler->insert($this->mObject);
	}
}

?>
