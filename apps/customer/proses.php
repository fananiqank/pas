<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
if($_GET[act]=='post'){
	$db->query("
		insert into m_customer (
			cust_id,
			cust_name,
			cust_address,
			cust_npwp,
			cust_desc,
			cust_status
		) 
		values (
			'$_POST[cust_id]',
			'$_POST[cust_name]',
			'$_POST[cust_address]',
			'$_POST[cust_npwp]',
			'$_POST[cust_desc]',
			'1'
		) ON DUPLICATE KEY UPDATE 
			cust_name='$_POST[cust_name]',
			cust_address='$_POST[cust_address]',
			cust_npwp='$_POST[cust_npwp]',
			cust_desc='$_POST[cust_desc]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_customer","*","cust_id='$_GET[id]'");
	echo json_encode($dt);

}