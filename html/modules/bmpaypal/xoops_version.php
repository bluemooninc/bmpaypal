<?php
/*
* GMO-PG - Payment Module as XOOPS Cube Module
* Copyright (c) Yoshi Sakai at Bluemoon inc. (http://bluemooninc.jp)
* GPL V3 licence
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
if ( !isset($root) ) {
	$root = XCube_Root::getSingleton();
}
//$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;
$modversion["name"] =  _MI_PAYPAL_TITLE;
$modversion["dirname"] = basename(dirname(__FILE__));
$modversion['hasMain'] = 1;
$modversion['version'] = 0.06;
$modversion['hasAdmin'] = 1;
$modversion['image'] = "bmpaypal.png";
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modDir = $modversion["dirname"];
$modversion['sub'][] = array('name' => _MI_PAYPAL_PAY_BY_PAYPAL, 'url' => 'BmPayPal');
$modversion['sub'][] = array('name' => _MI_PAYPAL_PAYMENT_HISTORY, 'url' => 'BmPayPal/PaymentHistory');
$modversion['sub'][] = array('name' => _MI_PAYPAL_CARD_PAYMENT, 'url' => 'CardPayment');
$modversion['sub'][] = array('name' => _MI_PAYPAL_SAVE_CARD  , 'url' => 'saveCard');
$modversion['sub'][] = array('name' => _MI_PAYPAL_SEARCH_CARD, 'url' => 'searchCard');
/*
$modversion['sub'][] = array('name' => _MI_PAYPAL_ENTRY_TRAN , 'url' => 'entryTran');
$modversion['sub'][] = array('name' => _MI_PAYPAL_EXEC_TRAN  , 'url' => 'execTran');
*/
/*
 * View
 */
// for payment controller
$modversion['templates'][] = array( 'file' => "hoge.html" );
$modversion['templates'][] = array( 'file' => "AcceptPayment.html" );
$modversion['templates'][] = array( 'file' => "ExecutePayment.html" );
$modversion['templates'][] = array( 'file' => "BmPayPal.html" );
$modversion['templates'][] = array( 'file' => "payment_history.html" );
$modversion['templates'][] = array( 'file' => "payment_detail.html" );
$modversion['templates'][] = array( 'file' => "payment_edit.html" );
// for memberSave controller
$modversion['templates'][] = array( 'file' => "CardPayment_index.html" );
$modversion['templates'][] = array( 'file' => "CardPayment_submit.html" );
// for saveCard controller
$modversion['templates'][] = array( 'file' => "saveCard_index.html" );
$modversion['templates'][] = array( 'file' => "saveCard_submit.html" );
// for entryTran controller
$modversion['templates'][] = array( 'file' => "entryTran_index.html" );
$modversion['templates'][] = array( 'file' => "entryTran_submit.html" );
// for execTran controller
$modversion['templates'][] = array( 'file' => "execTran_index.html" );
$modversion['templates'][] = array( 'file' => "execTran_submit.html" );
// for searchCard controller
$modversion['templates'][] = array( 'file' => "searchCard_index.html" );
$modversion['templates'][] = array( 'file' => "searchCard_submit.html" );
/*
 * Model
 */
$modversion['cube_style'] = true;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_payment';
/*
 * Config
 */
// Config Settings
$modversion['config'][1] = array(
	'name' => 'PAYPAL_ENDPOINT',
	'title' => _MI_PAYPAL_ENDPOINT,
	'description' => 'PAYPAL_ENDPOINT',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => 'api.sandbox.paypal.com'
);
$modversion['config'][2] = array(
    'name' => 'PAYPAL_CLIENT_ID',
    'title' => _MI_PAYPAL_CLIENT_ID,
    'description' => 'PAYPAL_CLIENT_ID',
    'formtype' => 'text',
    'valuetype' => 'text',
    'default' => ''
);
$modversion['config'][3] = array(
    'name' => 'PAYPAL_SECRET',
    'title' => _MI_PAYPAL_SECRET,
    'description' => 'PAYPAL_SECRET',
    'formtype' => 'text',
    'valuetype' => 'text',
    'default' => ''
);


