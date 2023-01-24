<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_mekanik",array("idtransmekanik"=> $_GET[id]));
	// echo json_encode($dt);

}