<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	
	$db->query("
		insert into m_gudang (
			id_gudang,
			nama_gudang,
			id_site
		) 
		values (
			'$_POST[id_gudang]',
			'$_POST[nama_gudang]',
			'$_POST[id_site]'
		) ON DUPLICATE KEY UPDATE 
			nama_gudang='$_POST[driver_name]',
			id_site='$_POST[id_site]'
		");
	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_gudang","*","id_gudang='$_GET[id]'");
	echo json_encode($dt);

}