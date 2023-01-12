<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
if($_GET[act]=='post'){
	$db->query("
		insert into m_cabang (
			id_cabang,
			nama_cabang,
			alamat
		) 
		values (
			'$_POST[id_cabang]',
			'$_POST[nama_cabang]',
			'$_POST[alamat]'
		) ON DUPLICATE KEY UPDATE 
			nama_cabang='$_POST[nama_cabang]',
			alamat='$_POST[alamat]'
		");

} else if($_GET[act]=='get'){
	$dt=$db->select("m_cabang","*","id_cabang='$_GET[id]'");
	echo json_encode($dt);

}