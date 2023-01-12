<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	foreach ($db->select("(select count(codename) jumcode from (
select SUBSTR(driver_name,1,3) codename from m_driver where SUBSTR(driver_name,1,3) = substr('$_POST[driver_name]',1,3)) a ) a","*") as $coli){}

$urut = $coli[jumcode]+1;
$sbname = strtoupper(substr($_POST['driver_name'], 0,3));
$codebrg = $sbname.sprintf('%03s', $urut);
	
	$db->query("
		insert into m_driver (
			driver_id,
			driver_code,
			driver_name,
			driver_address,
			driver_telp,
			driver_armada,
			id_site,
			status_driver,
			driver_bank,
			driver_rekening
		) 
		values (
			'$_POST[driver_id]',
			'$codebrg',
			'$_POST[driver_name]',
			'$_POST[driver_address]',
			'$_POST[driver_telp]',
			'$_POST[driver_armada]',
			'$_POST[id_site]',
			'$_POST[status_driver]',
			'".strtoupper($_POST['driver_bank'])."',
			'$_POST[driver_rekening]'
		) ON DUPLICATE KEY UPDATE 
			driver_name='$_POST[driver_name]',
			driver_address='$_POST[driver_address]',
			driver_telp='$_POST[driver_telp]',
			driver_armada='$_POST[driver_armada]',
			id_site='$_POST[id_site]',
			status_driver='$_POST[status_driver]',
			driver_bank='".strtoupper($_POST['driver_bank'])."',
			driver_rekening='$_POST[driver_rekening]'
		");
	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_driver","*","driver_id='$_GET[id]'");
	echo json_encode($dt);

}