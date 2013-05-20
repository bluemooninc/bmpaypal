<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class Model_Mail
{
	protected $mXoopsUser;
	protected $mXoopsConfig;
	protected $mMailer;
	protected $root;

	public function __construct()
	{
		$this->root = XCube_Root::getSingleton();
		$this->mXoopsConfig = $this->root->mContext->mXoopsConfig;
		$this->mXoopsUser = $this->root->mContext->mXoopsUser;
		$this->mMailer =& getMailer();
		$this->mMailer->usePM();            // send private message
		$this->mMailer->useMail();          // send email
		$language = $this->root->mContext->getXoopsConfig('language');
		$this->mMailer->setTemplateDir(
			XOOPS_ROOT_PATH . '/modules/bmpaypal/language/' . $language . '/mail_template/'
		);
	}

	private function _setBody($paymentObject)
	{
		$this->mMailer->assign("SITENAME", $this->mXoopsConfig['sitename']);
		$this->mMailer->assign("ADMINMAIL", $this->mXoopsConfig['adminmail']);
		foreach($paymentObject->mVars as $key => $val){
			if ($val['data_type']==3){
				$this->mMailer->assign(strtoupper($key), number_format($val['value']));
			}else{
				$this->mMailer->assign(strtoupper($key), $val['value']);
			}
		}
		$this->mMailer->assign("SITEURL", XOOPS_URL . "/");
		$this->mMailer->assign("URL_BILL", XOOPS_URL . "/modules/bmpaypal/bmpaypal/PaymentHistory/" . $paymentObject->getVar('uid'));
		$this->mMailer->assign("PAYMENT_DESC", _MD_PAYPAL_PAY_BY_PAYPAL);
		$this->mMailer->assign('PAYMENT_DATE',date("Y-m-d",$paymentObject->getVar('utime')));
	}

	/**
	 * @param $tpl_name
	 * @param $paymentInfo
	 * @param $listData
	 */
	public function sendMail($tpl_name,$paymentObject,$subject,$userObject=null){
		$this->mMailer->setTemplate($tpl_name);
		if (is_null($userObject)){
			$userObject = $this->root->mContext->mXoopsUser;
		}
		$this->mMailer->setToUsers($userObject);
		$this->mMailer->setFromEmail($this->mXoopsConfig['adminmail']);
		$this->mMailer->setFromName($this->mXoopsConfig['sitename']);
		$this->mMailer->setSubject($subject);
		$this->_setBody($paymentObject);
		if ($this->mMailer->send(true)) {   // Debug on: $this->mMailer->send(true)
			//echo $this->mMailer->getSuccess();
			return true;
		} else {
			echo '<h1>SendMail Error</h1>';
			echo 'Message could not be sent.';
			echo '<br />Mailer Error: ' . $this->mMailer->getErrors();
			echo '<br />Tpl :' . $tpl_name;
			echo '<br />Subject :' . $subject;
			echo '<br />Send from:' . $this->mXoopsConfig['adminmail'];
			echo '<br />Send to:' . $userObject->getVar('email');
			exit;
		}
	}
}
