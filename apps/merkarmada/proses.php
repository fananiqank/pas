<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_armada_merk (
			arm_merk_id,
			arm_merk_name,
			arm_merk_status
		) 
		values (
			'$_POST[arm_merk_id]',
			'$_POST[arm_merk_name]',
			'$_POST[arm_merk_status]'
		) ON DUPLICATE KEY UPDATE 
			arm_merk_name='$_POST[arm_merk_name]',
			arm_merk_status='$_POST[arm_merk_status]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_armada_merk","*","arm_merk_id='$_GET[id]'");
	echo json_encode($dt);

}