<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$db->query("insert into tx_maintenancedtl (
				id_mtcdtl,
				id_mtc,
				id_barang,
				qty_mtcdtl,
				status_mtcdtl,
				created_by,
				jenis
			) 
			values (
				'$_POST[id_mtcdtl]',
				'',
				'$_POST[id_barang]',
				'$_POST[qty]',
				'0',
				'$_SESSION[ID_PEG]',
				'$_POST[jenis]'
			)");
	
	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_tarif","*","tarif_id='$_GET[id]'");
	echo json_encode($dt);

}