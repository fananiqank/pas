<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	if($_POST['typeform'] == 1){
		$db->query("
			insert into m_subdep (
				id_sub,
				kd_sub,
				nama_sub,
				id_dep
			) 
			values (
				'$_POST[id_sub]',
				'$_POST[kd_sub]',
				'$_POST[nama_sub]',
				'$_POST[iddep]'
			) ON DUPLICATE KEY UPDATE 
				nama_sub='$_POST[nama_sub]',
				status='$_POST[status]'
			");
	} else if($_POST['typeform'] == 2){
		$db->query("
			insert into m_kat (
				id_kat,
				kd_kat,
				nama_kat,
				id_sub
			) 
			values (
				'$_POST[id_kat]',
				'$_POST[kd_kat]',
				'$_POST[nama_kat]',
				'$_POST[idsub]'
			) ON DUPLICATE KEY UPDATE 
				nama_kat='$_POST[nama_kat]',
				status='$_POST[status]'
			");
	} else {
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
	}
} else if($_GET[act]=='get'){
	if($_GET['typeform'] == '1'){
		$dt=$db->select("m_subdep","*","id_sub='$_GET[id]'");
	} else if($_GET['typeform'] == '2'){
		$dt=$db->select("m_kat","*","id_kat='$_GET[id]'");
	} else {
		$dt=$db->select("m_dep","*","id_dep='$_GET[id]'");
	}
	echo json_encode($dt);

}