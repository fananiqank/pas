<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_deduction (
			id_ddc,
			nama_ddc,
			status_ddc,
			createdate_ddc
		) 
		values (
			'$_POST[id_ddc]',
			'$_POST[nama_ddc]',
			'$_POST[status_ddc]',
			'$date'
		) ON DUPLICATE KEY UPDATE 
			nama_ddc='$_POST[nama_ddc]',
			status_ddc='$_POST[status_ddc]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_deduction","*","id_ddc='$_GET[id]'");
	echo json_encode($dt);

}