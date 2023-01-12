<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_site (
			id_site,
			nama_site,
			status_site
		) 
		values (
			'$_POST[id_site]',
			'$_POST[nama_site]',
			'$_POST[status_site]'
		) ON DUPLICATE KEY UPDATE 
			nama_site='$_POST[nama_site]',
			status_site='$_POST[status_site]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_site","*","id_site='$_GET[id]'");
	echo json_encode($dt);

}