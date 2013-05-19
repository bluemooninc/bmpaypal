<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
/*
 * {Dirname}_{Filename} : Naming convention for Model
 */
class bmpaypal_paymentObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('id', XOBJ_DTYPE_INT, 0);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('order_id', XOBJ_DTYPE_STRING, '', true, 27);
        $this->initVar('amount', XOBJ_DTYPE_FLOAT, 0, true);
	    $this->initVar('currency', XOBJ_DTYPE_STRING, '', true, 8);
        $this->initVar('paypal_id', XOBJ_DTYPE_STRING, '', true, 32);
	    $this->initVar('state', XOBJ_DTYPE_STRING, '', true, 32);
	    $this->initVar('payer_id', XOBJ_DTYPE_STRING, '', true, 16);
        $this->initVar('utime', XOBJ_DTYPE_INT, time(), true);
    }
}

class bmpaypal_paymentHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'bmpaypal_payment';
    public $mPrimary = 'id';
    public $mClass = 'bmpaypal_paymentObject';
    public $id;

    public function __construct(&$db)
    {
        parent::XoopsObjectGenericHandler($db);
    }
	public function AddNew($uid,$order_id,$amount,$currency,$paypal_id,$state){
		$object = $this->create();
		$object->set('uid', $uid );
		$object->set('order_id', $order_id);
		$object->set('amount', $amount);
		$object->set('currency', $currency);
		$object->set('paypal_id', $paypal_id);
		$object->set('state', $state);
		$this->insert($object,true);
	}

    public function getDefaultList($uid = 0, $id = NULL)
    {
        $ret = array();
        $sql = "SELECT u.`uname`, i.* FROM `" . $this->db->prefix('users') . "` u LEFT JOIN ";
        $sql .= $this->mTable . " i ON i.`uid` =  u.`uid` ";
        $sql .= "WHERE i.`uid` = " . $uid;
        if ($id) {
            $sql .= " AND id=" . $id;
        }
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchArray($result)) {
            $ret[] = $row;
        }
        return $ret;
    }
	public function getByOrderId($uid, $order_id,$status=0){
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', $uid));
		$criteria->add(new Criteria('order_id', $order_id));
		$criteria->add(new Criteria('status', $status));
		$this->myObjects = parent::getObjects($criteria);
		return $this->myObjects;
	}
    public function getDataById($uid = 0, $id = NULL)
    {
        $ret = array();
        $sql = "SELECT i.* FROM `" . $this->db->prefix('users') . "` u LEFT JOIN ";
        $sql .= $this->mTable . " i ON i.`uid` =  u.`uid` ";
        $sql .= "WHERE i.`uid` = " . $uid;
        if ($id) {
            $sql .= " AND id=" . $id;
        }
        $result = $this->db->query($sql);
        return $this->db->fetchArray($result);
    }



    public function delete($id, $uid)
    {
        $sql = "DELETE FROM " . $this->db->prefix('bmpaypal_payment');
        $sql .= sprintf(" WHERE id=%d AND uid=%d", $id, $uid);
        $result = $this->db->queryF($sql);
    }
}
