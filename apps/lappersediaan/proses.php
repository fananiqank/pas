<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='save'){

	$idmtc = $db->idurut("tx_maintenance","id_mtc");
 	$selno = $db->selectcount("tx_maintenance","id_mtc","");
 	$nopart = $selno+1;
 	$nomasuk = 'MTC' . sprintf('%05s', $nopart);

	$db->query("
		insert into tx_maintenance (
			id_mtc,
			no_mtc,
			tgl_mtc,
			status_mtc,
			keterangan_mtc,
			arm_id
		) VALUES (
			'$idmtc',
			'$nomasuk',
			'$_POST[tgl_mtc]',
			1,
			'$_POST[keterangan_mtc]',
			'$_POST[arm_id]'
		)
		");
	
	$db->query("
			update tx_maintenancedtl set
				id_mtc = $idmtc,
				status_mtcdtl='1'
			where status_mtcdtl = 0 and created_by = '$_SESSION[ID_PEG]'
 			");


} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_maintenancedtl",array("id_mtcdtl"=> $_GET[id]));
	// echo json_encode($dt);

}