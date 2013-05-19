<?php
/* $Id: $ */

if (!defined('XOOPS_ROOT_PATH')) exit();

/**
 * AbstractAction
 */
abstract class AbstractAction {
	// object
	protected $root = null;
	protected $mHandler = null;
	protected $mPagenavi = null;
	protected $mUtility = null;
	// Model
	protected $mModel = null;

	// set variable
	protected $mUrl = 'bmpaypal';
	protected $method_params = null;
	protected $mDirname;
	protected $mControllerName;
	protected $mTemplate;
	protected $mViewFullPath;

	// variable
	protected $mListData;
	protected $select;
	protected $isError = false;
	protected $mErrMsg = "";
	protected $mTicketHidden = '';
	protected $mModuleId;
	protected $mModuleAdmin = false;

	// constant
	protected $PAGENUM = 20;
	protected $TIMUOUT_SUCCESS = 2;
	protected $TIMUOUT_ERROR   = 5;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->root = XCube_Root::getSingleton();
		$this->mModuleId = $this->root->mContext->mXoopsModule->get('mid');
		if ($this->root->mContext->mXoopsUser){
			$this->mModuleAdmin = $this->root->mContext->mXoopsUser->isadmin($this->mModuleId);
		}
	}

//---------------------------------------------------------
// call from main controller
//---------------------------------------------------------


	/**
	 * set Params
	 *
	 * @param array $params
	 * @return none
	 */
	public function setParams($params){
		$this->mParams = $params;
	}

	/**
	 * set ViewFullPath
	 *
	 * @param string $viewFullPath
	 * @return none
	 */
	public function setView( $viewFullPath ){
		$this->mViewFullPath = $viewFullPath;
	}

	/**
	 * set Dirname
	 *
	 * @param string $dirname
	 * @return none
	 */
	public function setDirname($dirname){
		$this->mDirname = $dirname;
	}

	/**
	 * set ControllerName
	 *
	 * @param string $controller_name
	 * @return none
	 */
	public function setControllerName($controllerName){
		$this->mControllerName = $controllerName;
	}

	/**
	 * set DefaultTemplate
	 *
	 * @param string $template
	 * @return none
	 */
	public function setDefaultTemplate($template){
		$this->mTemplate = $template;
	}

	/**
	 * get template
	 *
	 * @param none
	 * @return string template
	 */
	public function getTemplate(){
		return $this->mTemplate;
	}

//-----------------
// public
//-----------------
	/**
	 * get Url(
	 *
	 * @param none
	 * @return string url
	 */
	public function getUrl() {
		return $this->mUrl;
	}

	/**
	 * isError
	 *
	 * @param none
	 * @return boolean isError
	 */
	public function isError() {
		return $this->isError;
	}

	/**
	 * get ErrMsg
	 *
	 * @param none
	 * @return stirng ErrMsg(
	 */
	public function getErrMsg() {
		return $this->mErrMsg;
	}

	public function is_admin() {
		return $this->mModuleAdmin;
	}
//-----------------
// protected
//-----------------

	/**
	 * index
	 *
	 * @param none
	 * @return none
	 */
	protected function indexDefault($primaryKey='id') {
//		$this->setPageNavi($primaryKey, 'ASC');
	}
	/**
	 * edit
	 *
	 * @param none
	 * @return none
	 */
	protected function editDefault($primaryKey='id') {
		$this->id = intval( $this->mParams[0] );
/*
 		if ( $this->id > 0 ){
			$this->setPageNavi($primaryKey, 'ASC');
			$this->mPagenavi->addCriteria(new Criteria($primaryKey, $this->id));
		}
*/
	}
	/**
	 * delete
	 *
	 * @param none
	 * @return none
	 */
	protected function deleteDefault($id=null) {
		$this->id = is_null($id) ? intval( $this->getRequest('id') ) : intval($id);
		if ( $this->id > 0 ){
			$this->mHandler->delete($this->id);
			$this->executeRedirect($this->mUrl, $this->TIMUOUT_SUCCESS, 'DELETED');
		}
	}
	/**
	 * set PageNavi
	 *
	 * @param string $sortName
	 * @param string $sortIndex
	 * @return none
	 */
	/*
	protected function setPageNaviDefault($sortName, $sortIndex){
		$class = $this->getPagenaviClass();
		$this->mPagenavi = new $class($this->mHandler);
		$this->mPagenavi->setPagenum($this->PAGENUM);
		$this->mPagenavi->setUrl($this->mUrl);
		$this->mPagenavi->addSort($sortName,$sortIndex);
		$this->mPagenavi->fetch();
	}
	protected function getPagenaviClass(){
		return ucwords($this->mDirname).'_PageNavi';
	}
	*/

	protected function setModel($modelName){
		$this->mHandler = xoops_getmodulehandler($modelName);
	}
	/*protected function setTemplate($controllerName){
		$this->mTemplate = $this->mDirname.'_'.$this->mControllerName.'_'.$controllerName . '.html';
	}*/
	protected function setUrl($url) {
		$this->mUrl = $url;
	}
	protected function getRequest( $key ) {
		return $this->root->mContext->mRequest->getRequest( $key );
	}

	protected function executeRedirect( $url, $timeout, $msg ) {
		$this->root->mController->executeRedirect( $url, $timeout, $msg );
	}
	protected function setErr($msg) {
		$this->isError = true;
		$this->mErrMsg = $msg;
	}

/**********************************
 * For This Application's Cntroller
 **********************************/

	protected function _getPaymentId(){
		$id = 0;
		if (xoops_getrequest('id')){
			$id = intval(xoops_getrequest('id'));
		}elseif (isset($this->mParams[0])){
			$id = intval($this->mParams[0]);
		}
		return $id;
	}
	protected function _getImageId(){
		$image_id = null;
		if (xoops_getrequest('image_id')){
			$image_id = intval(xoops_getrequest('image_id'));
		}elseif (isset($this->mParams[1])){
			$image_id = intval($this->mParams[1]);
		}
		return $image_id;
	}
	protected function _getCategoryId(){
		$category_id=0;
		if (xoops_getrequest('category_id')){
			$category_id = intval(xoops_getrequest('category_id'));
		}elseif (isset($this->mParams[2])){
			$category_id = intval($this->mParams[2]);
		}elseif ($_SESSION['bmpaypal']['category_id']){
			$category_id = $_SESSION['bmpaypal']['category_id'];
		}
		return $category_id;
	}

	protected function _getFieldId(){
		if (xoops_getrequest('field_id')){
			$field_id = intval(xoops_getrequest('field_id'));
		}elseif (isset($this->mParams[2])){
			$field_id = intval($this->mParams[2]);
		}
		return $field_id;
	}
	protected function _setSessionCategory($category_id,$force=false){
		$category_id = intval($category_id);
		$_SESSION['bmpaypal']['category_id'] = $category_id;
		if ($category_id>0){
			if ($force) $_SESSION['bmpaypal']['category_ids'] = array();
			$_SESSION['bmpaypal']['category_ids'][intval($category_id)] = $category_id;
		}
	}
	protected function _removeSessionCategory($category_id){
		$category_id = intval($category_id);
		if ($category_id>0){
			unset($_SESSION['bmpaypal']['category_ids'][intval($category_id)]);
		}
	}
	protected function _setSessionParentCategory($category_id){
		$category_id = intval($category_id);
		$_SESSION['bmpaypal']['parent_id'] = $category_id;
	}
	protected function _getSessionParentCategory(){
		return isset($_SESSION['bmpaypal']['parent_id']) ? $_SESSION['bmpaypal']['parent_id'] : 0;
	}
	protected function _getSessionCategory(){
		return isset($_SESSION['bmpaypal']['category_id']) ? $_SESSION['bmpaypal']['category_id'] : NULL;
	}
	static function _getSessionCategories(){
		return isset($_SESSION['bmpaypal']['category_ids']) ? $_SESSION['bmpaypal']['category_ids'] : NULL;
	}
	protected function _clearSessionCategories(){
		$_SESSION['bmpaypal']['category_ids'] = null;
	}
	protected function _getPerPage(){
		$perpage = $this->root->mContext->mRequest->getRequest('perpage');
		if ($perpage==0) $perpage = 20;
		return $perpage;
	}
}
