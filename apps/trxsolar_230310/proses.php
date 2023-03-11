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
	


} else if($_GET[act]=='hapussolar'){
	$selhps = $db->select("tx_solar_dtl","*","txsolardtl_tgltrans = '$_GET[tgl]' and txsolardtl_shift = '$_GET[shift]'");
	foreach($selhps as $hps){
		$db->query("insert into tx_solar_dtl_rem (txsolardtl_id,txsolar_id,arm_id,driver_id,txsolardtl_liter,txsolardtl_harga,txsolardtl_total,
txsolardtl_tgl,txsolardtl_petugas,supp_id,txsolardtl_shift,txsolardtl_tgltrans) values ('$hps[txsolardtl_id]','$hps[txsolar_id]','$hps[arm_id]','$hps[driver_id]','$hps[txsolardtl_liter]','$hps[txsolardtl_harga]','$hps[txsolardtl_total]','$hps[txsolardtl_tgl]','$hps[txsolardtl_petugas]','$hps[supp_id]','$hps[txsolardtl_shift]','$hps[txsolardtl_tgltrans]')");	
	}
	$dt=$db->query("delete from tx_solar_dtl where txsolardtl_tgltrans = '$_GET[tgl]' and txsolardtl_shift = '$_GET[shift]'");
	
	//$dt=$db->delete("tx_solar",array("txsolar_id"=> $_GET[id]));
	//$dt2=$db->delete("tx_solar_dtl",array("txsolar_id"=> $_GET[id]));
	if($dt){
		echo "Telah Dihapus";
	} else {
		echo "Gagal";
	}
	// echo json_encode($dt);

}