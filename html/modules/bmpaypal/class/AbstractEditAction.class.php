<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class bmpaypal_AbstractEditAction extends bmpaypal_Action
{
	var $mObject = null;
	var $mObjectHandler = null;
	var $mActionForm = null;
	var $mConfig;

	/**
	 * @access protected
	 */
	function _setupObject()
	{
		$id = $this->_getId();
		
		$this->mObjectHandler = $this->_getHandler();
		
		$this->mObject =& $this->mObjectHandler->get($id);
		
		if ($this->mObject == null && $this->isEnableCreate()) {
			$this->mObject =& $this->mObjectHandler->create();
		}
	}

	/**
	 * _getPageAction
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	protected function _getPageAction()
	{
		return _EDIT;
	}

	/**
	 * @access protected
	 */
	function isEnableCreate()
	{
		return true;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;

		$this->_setupActionForm();
		$this->_setupObject();
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return BMPAYPAL_FRAME_VIEW_ERROR;
		}
	
		$this->mActionForm->load($this->mObject);
		
		return BMPAYPAL_FRAME_VIEW_INPUT;
	}

	function execute(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return BMPAYPAL_FRAME_VIEW_ERROR;
		}
		if (xoops_getrequest('_form_control_cancel') != null) {
			return BMPAYPAL_FRAME_VIEW_CANCEL;
		}
		$this->mActionForm->load($this->mObject);
		$this->mActionForm->fetch();
		$this->mActionForm->validate();             //  /html/core/XCube_ActionForm.class.php line(370)
		if($this->mActionForm->hasError()) {
			var_dump($this->mActionForm->mErrorMessages);
			die("validate error");
			return BMPAYPAL_FRAME_VIEW_INPUT;
		}
		$this->mActionForm->update($this->mObject);
		return $this->_doExecute($this->mObject) ? BMPAYPAL_FRAME_VIEW_SUCCESS
		                                         : BMPAYPAL_FRAME_VIEW_ERROR;
	}

	/**
	 * @access protected
	 */
	function _doExecute()
	{
		return $this->mObjectHandler->insert($this->mObject);
	}
}

?>
