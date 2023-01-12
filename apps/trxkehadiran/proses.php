<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$cust=explode("_",$_POST[cust_id]);
	$jar=explode("_",$_POST[rutejarak_id]);
    // $dayinv=$_POST[bpbulan];
    // $yearinv=$_POST[bptahun];

    $dayinv=(int) date("m",strtotime($_POST[txangkut_tgl1]));
    $yearinv=date("Y",strtotime($_POST[txangkut_tgl1]));

	// foreach($db->select("trx_basicpremi_driver a JOIN (select max(txbaspre_id) txbaspre_id from trx_basicpremi_driver ) b ON a.txbaspre_id=b.txbaspre_id","LEFT(txbaspre_no,3)+1 as urut") as $no){}
	// echo "select LEFT(txbaspre_no,3)+1 as urut from trx_basicpremi_driver a JOIN (select max(txbaspre_id) txbaspre_id from trx_basicpremi_driver ) b ON a.txbaspre_id=b.txbaspre_id<br>";

	// $no=sprintf("%03s", $no[urut] ? $no[urut] : 1)."/TBP/".$db->bulanrom($dayinv)."/".$yearinv;
	// echo "$dayinv".$no;
	$date=date("Y-m-d H:i:S");
	
	$db->query("delete from txkehadiran where DATE(hadirdriver_tgl) = '$_POST[tglhadir]' and shift = '$_POST[bpshift]' and id_site='$_POST[id_site]'");

	foreach($_POST[driver_id] as $key => $value){
		$remarkhadir = "remarkhadir_".$value;
		if($_POST[harimasuk][$key]>0){
			//echo $key;
			$query.="insert into txkehadiran(hadirdriver_bulan,hadirdriver_tahun,driver_id,hadirdriver_jumlah, hadirdriver_tgl,hadirdriver_type,id_site,shift,hadirdriver_jenis,arm_id,hadirdriver_remark) 
										value ('$_POST[bpbulan]','$_POST[bptahun]','$value',1,'$_POST[tglhadir]','1','$_POST[id_site]','$_POST[bpshift]','{$_POST[harimasuk][$key]}','{$_POST[armada][$key]}','$_POST[$remarkhadir]') ;";
			// echo "insert into txkehadiran(hadirdriver_bulan,hadirdriver_tahun,driver_id,hadirdriver_jumlah, hadirdriver_tgl,hadirdriver_type,id_site,shift,hadirdriver_jenis,arm_id,hadirdriver_remark) 
			// 							value ('$_POST[bpbulan]','$_POST[bptahun]','$value',1,'$_POST[tglhadir]','1','$_POST[id_site]','$_POST[bpshift]','{$_POST[harimasuk][$key]}','{$_POST[armada][$key]}','$_POST[$remarkhadir]') ;";
		}
		if($_POST[rawatunit][$key]>0){
			$query.="insert into txkehadiran(hadirdriver_bulan,hadirdriver_tahun,driver_id,hadirdriver_jumlah, hadirdriver_tgl,hadirdriver_type,id_site,shift,arm_id,hadirdriver_remark) 
										value ('$_POST[bpbulan]','$_POST[bptahun]','$value','{$_POST[rawatunit][$key]}','$_POST[tglhadir]','2','$_POST[id_site]','$_POST[bpshift]','{$_POST[armada][$key]}','$_POST[$remarkhadir]');";
		}
	}
	// echo $query;
	$sk=$db->query($query);		
	// die();

} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_ritase_dtltmp",array("trxangkutdtl_id"=> $_GET[id]));
	// echo json_encode($dt);

}