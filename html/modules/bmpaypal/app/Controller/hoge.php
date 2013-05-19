<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/05/18
 * Time: 9:12
 * To change this template use File | Settings | File Templates.
 */
require_once _MY_MODULE_PATH . 'app/View/view.php';

class Controller_Hoge extends AbstractAction {
	public function __construct()
	{
		parent::__construct();
	}
	public function action_index(){
		$this->template = 'hoge.html';
	}
	public function action_view(){
		/**
		 * make view
		 */
		$view = new View( $this->root );
		$view->setTemplate( $this->template );
	}
}