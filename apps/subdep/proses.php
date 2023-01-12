<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_dep (
			id_dep,
			kd_dep,
			nama_dep
		) 
		values (
			'$_POST[id_dep]',
			'$_POST[kd_dep]',
			'$_POST[nama_dep]'
		) ON DUPLICATE KEY UPDATE 
			nama_dep='$_POST[nama_dep]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_dep","*","id_dep='$_GET[id]'");
	echo json_encode($dt);

}