<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_armada_type (
			arm_type_id,
			arm_type_name,
			arm_merk_id,
			arm_type_status
		) 
		values (
			'$_POST[arm_type_id]',
			'$_POST[arm_type_name]',
			'$_POST[idsub]',
			'$_POST[arm_type_status]'
		) ON DUPLICATE KEY UPDATE 
			arm_type_name='$_POST[arm_type_name]',
			arm_type_status='$_POST[arm_type_status]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_armada_type","*","arm_type_id='$_GET[id]'");
	echo json_encode($dt);

}