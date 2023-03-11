<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$arm=explode("_",$_POST[arm_id]);
	$jar=explode("_",$_POST[rutejarak_id]);
	$db->query("insert into tx_ritase_dtltmp (
			arm_id,
			id_site,
			driver_id,
			rutejarak_id,
			txangkut_sk,
			txangkut_ritase,
			txangkut_tonase,
			txangkut_jam,
			txangkut_solar,
			userid,
			txangkut_nolambung,
			txangkut_jarak
		) 
		values (
			'$arm[0]',
			'$_POST[id_site]',
			'$_POST[driver_id]',
			'$jar[0]',
			'$_POST[txangkut_sk]',
			'1',
			'$_POST[txangkut_tonase]',
			'$_POST[txangkut_jam]',
			'$_POST[txangkut_solar]',
			'$_SESSION[ID_PEG]',
			'$arm[1]',
			'$jar[1]'
		)");
	
	

} else if($_GET[act]=='get'){
	$dt=$db->select("m_tarif","*","tarif_id='$_GET[id]'");
	echo json_encode($dt);

}