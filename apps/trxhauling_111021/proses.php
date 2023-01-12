<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='save'){

	$arm=explode("_",$_POST[arm_id]);
	$jar=explode("_",$_POST[rutejarak_id]);
	$data=array(
					"arm_id"=>$arm[0],
					"arm_nolambung"=>$arm[1],
					"id_site"=>$_POST[id_site],
					"driver_id"=>$_POST[driver_id],
					"txangkut_tgl"=>$_POST[txangkut_tgl],
					"txangkut_shift"=>$_POST[txangkut_shift],
					"txangkut_input"=>'NOW()',
					"txangkut_user"=>$_SESSION[ID_PEG]
				);
	$in=$db->insertID("tx_ritase",$data);

	$db->query("
		insert into tx_ritase_dtl (
			txangkut_id,
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
		select '$in',
			'$arm[0]',
			id_site,
			'$_POST[driver_id]',
			rutejarak_id,
			txangkut_sk,
			txangkut_ritase,
			txangkut_tonase,
			txangkut_jam,
			txangkut_solar,
			userid,
			'$arm[1]', txangkut_jarak from tx_ritase_dtltmp where userid='$_SESSION[ID_PEG]';
		delete FROM tx_ritase_dtltmp where userid='$_SESSION[ID_PEG]';
		");
	


} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_ritase_dtltmp",array("trxangkutdtl_id"=> $_GET[id]));
	// echo json_encode($dt);

}