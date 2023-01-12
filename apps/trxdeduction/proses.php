<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$date=date("Y-m-d H:i:S");
	
	foreach($_POST[driver_id] as $key => $value){
		//echo $value."_".$_POST[ddcjumlah][$key];
		if($_POST[ddcjumlah][$key]>0){
			$query.="insert into txdeduction(ddcdriver_bulan,ddcdriver_tahun,driver_id,id_ddc,ddcdriver_jumlah, ddcdriver_tgl,id_site,arm_id) 
										value ('$_POST[bpbulan]','$_POST[bptahun]','$value','$_POST[id_ddc]','{$_POST[ddcjumlah][$key]}','$date','$_POST[id_site]','{$_POST[armada][$key]}');";
		
		}
		
	}

	$sk=$db->query($query);		


} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_ritase_dtltmp",array("trxangkutdtl_id"=> $_GET[id]));
	// echo json_encode($dt);

}