<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	
	$db->query("
		insert into m_mekanik (
			name_mekanik,
			alamat_mekanik,
			telp_mekanik,
			supp_id
		) 
		values (
			'$_POST[name_mekanik]',
			'$_POST[alamat_mekanik]',
			'$_POST[telp_mekanik]',
			'$_POST[supp_id]'
		) ON DUPLICATE KEY UPDATE 
			name_mekanik='$_POST[name_mekanik]',
			alamat_mekanik='$_POST[alamat_mekanik]',
			telp_mekanik='$_POST[telp_mekanik]',
			supp_id='$_POST[supp_id]'
		");
	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_mekanik","*","id_mekanik='$_GET[id]'");
	echo json_encode($dt);

}