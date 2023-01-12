<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_satuan (
			id_satuan,
			nama_satuan,
			status_satuan
		) 
		values (
			'$_POST[id_satuan]',
			'$_POST[nama_satuan]',
			'$_POST[status_satuan]'
		) ON DUPLICATE KEY UPDATE 
			nama_satuan='$_POST[nama_satuan]',
			status_satuan='$_POST[status_satuan]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_satuan","*","id_satuan='$_GET[id]'");
	echo json_encode($dt);

}