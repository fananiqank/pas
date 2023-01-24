<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$date=date("Y-m-d H:i:S");
	
		//echo $value."_".$_POST[ddcjumlah][$key];
		$query.="insert into txdeductiontotal(driver_id,id_ddc,tddc_jumlah) 
				 value ('$_POST[driver_id]','$_POST[id_ddc]','$_POST[tddc_jumlah]');";
	
	$sk=$db->query($query);		


} else if($_GET[act]=='get'){
	$dt=$db->select("txdeductiontotal","*","tddc_id='$_GET[id]'");
	echo json_encode($dt);

}