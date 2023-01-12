<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

$nolamb=explode("_", $_POST[cust_id])[1]."".$_POST[arm_nolambungx];
$armada=$db->select("m_armada","*","arm_id='$_POST[arm_id]'");
$armada2=$db->select("m_armada","*","arm_nolambung='$nolamb'");

// echo count($armada2);
if(count($armada2)==0){
$tgl=date("Y-m-d H:i:s");
$datadtl=array(
				"arm_nopol"=>$armada[0][arm_nopol],
				"arm_norangka"=>$armada[0][arm_norangka],
				"arm_nomesin"=>$armada[0][arm_nomesin],
				"arm_merk"=>$armada[0][arm_merk],
				"arm_type"=>$armada[0][arm_type],
				"cust_id"=>explode("_", $_POST[cust_id])[0],
				"arm_nolambung"=>explode("_", $_POST[cust_id])[1]."".$_POST[arm_nolambungx],
				"arm_status"=>$armada[0][arm_status],
				"arm_tahun"=>$armada[0][arm_tahun],
				"arm_createdby"=>$_SESSION[ID_PEG],
				"arm_createddate"=>$tgl,
				"arm_status_milik"=>$armada[0][arm_status_milik],
				"arm_type_armada"=>$armada[0][arm_type_armada],
				"arm_target_rit"=>$armada[0][arm_target_rit]

			);
$ins=$db->insert("m_armada",$datadtl);

if($ins){
	echo "Berhasil Simpan Data!!";
} else {
	echo "Gagal Simpan Data!!";
}

} else {
	echo "No Lambung Telah Terdaftar";
}
?>