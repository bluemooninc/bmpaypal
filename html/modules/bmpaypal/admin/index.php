<?php
require_once "../../../mainfile.php";
require_once XOOPS_ROOT_PATH . "/header.php";
require_once XOOPS_MODULE_PATH . "/bmpaypal/class/ActionFrame.class.php";

$root = XCube_Root::getSingleton();

$actionName = xoops_getrequest('action') ? xoops_getrequest('action') : "PaymentList";

$moduleRunner = new bmpaypal_ActionFrame(TRUE);
$moduleRunner->setActionName($actionName);

$root->mController->mExecute->add(array(&$moduleRunner, 'execute'));

$root->mController->execute();
require_once XOOPS_ROOT_PATH . "/footer.php";