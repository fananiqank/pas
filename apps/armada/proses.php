<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$cust=explode("_",$_POST[cust_id]);
	$db->query("
		insert into m_armada (
			arm_id,
			arm_nopol,
			arm_nolambung,
			arm_norangka,
			arm_nomesin,
			arm_tahun,
			arm_status_milik,
			arm_merk,
			arm_type,
			cust_id,
			arm_status,
			arm_createdby,
			arm_createddate,
			arm_type_armada
		) 
		values (
			'$_POST[arm_id]',
			'$_POST[arm_nopol]',
			'$_POST[arm_nolambung]',
			'$_POST[arm_norangka]',
			'$_POST[arm_nomesin]',
			'$_POST[arm_tahun]',
			'$_POST[arm_status_milik]',
			'$_POST[arm_merk]',
			'$_POST[arm_type]',
			'$cust[0]',
			'$_POST[arm_status]',
			'$_SESSION[ID_PEG]',
			'$date',
			'$_POST[arm_type_armada]'
		) ON DUPLICATE KEY UPDATE 
			arm_nopol='$_POST[arm_nopol]',
			arm_nolambung='$_POST[arm_nolambung]',
			arm_nomesin='$_POST[arm_nomesin]',
			arm_tahun='$_POST[arm_tahun]',
			arm_status_milik='$_POST[arm_status_milik]',
			arm_merk='$_POST[arm_merk]',
			arm_type='$_POST[arm_type]',
			cust_id='$cust[0]',
			arm_status='$_POST[arm_status]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_armada","*","arm_id='$_GET[id]'");
	echo json_encode($dt);

}