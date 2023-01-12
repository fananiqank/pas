<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$cust=explode("_",$_POST[cust_id]);
	$jar=explode("_",$_POST[rutejarak_id]);
    $dayinv=(int) date("m",strtotime($_POST[tglinvoice]));
    $yearinv=(int) date("Y",strtotime($_POST[tglinvoice]));
	foreach($db->select("tx_invoice a JOIN (select max(inv_id) inv_id from tx_invoice ) b ON a.inv_id=b.inv_id","LEFT(inv_no,3)+1 as urut") as $no){}

	$no=sprintf("%03s", $no[urut])."/INV ".$cust[1]."/".$db->bulanrom($dayinv)."/".$yearinv;


	$data=array(
					"inv_no"=>$no,
					"cust_id"=>$cust[0],
					"inv_tgl"=>$_POST[tglinvoice],
					"inv_subtotal"=>$_POST[st],
					"inv_ppn"=>$_POST[ppn],
					"inv_pph"=>$_POST[pph],
					"inv_grandtotal"=>$_POST[gt],
					"user_id"=>$_SESSION[ID_PEG],
					"inv_stamp"=>$date,
					"inv_periode1"=>$_POST[tglmulai],
					"inv_periode2"=>$_POST[tglakhir],
					"arm_type_armada"=>$_POST[arm_type_armada]

				);
	$in=$db->insertID("tx_invoice",$data);

	$db->query("
		insert into tx_invoice_dtl (
			inv_id,
			rutejarak_id,
			invdtl_uraian,
			invdtl_ritase,
			invdtl_tonase,
			invdtl_jarak,
			invdtl_harga,
			invdtl_jumlah,
			invdtl_stamp,
			invdtl_ritdtl,
			invdtl_periode
		) 
		 select * from (SELECT $in,a.rutejarak_id, concat(rom_name,' - ',tujuan_name) as uraian, sum(txangkut_ritase) ritase, sum(txangkut_tonase) ton ,max(txangkut_jarak) jarak, tarif,  sum(txangkut_tonase) * max(txangkut_jarak) * tarif as jumlah, NOW(), group_concat(trxangkutdtl_id) as idtxangkut_dtl,periode FROM (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where cust_id=c.cust_id and type_armada=c.arm_type_armada and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) 
		JOIN m_armada c ON c.arm_nolambung=b.txangkut_nolambung
		where txangkut_tgl between '$_POST[tglmulai]' and '$_POST[tglakhir]' and left(b.txangkut_nolambung,3)='$cust[1]' and arm_type_armada='$_POST[arm_type_armada]') a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_runofmine c ON c.rom_id=b.rom_id JOIN m_tujuan d ON d.tujuan_id=b.tujuan_id group by rutejarak_id, tarif, periode) a
		");

	// echo "SELECT $in,a.rutejarak_id, concat(rom_name,' - ',tujuan_name) as uraian, sum(txangkut_ritase) ritase, sum(txangkut_tonase) ton ,max(txangkut_jarak) jarak, tarif,  sum(txangkut_tonase) * max(txangkut_jarak) * tarif as jumlah, NOW(), group_concat(trxangkutdtl_id) as idtxangkut_dtl,periode FROM (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where cust_id=c.cust_id and type_armada=c.arm_type_armada and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) 
	// 	JOIN m_armada c ON c.arm_nolambung=b.txangkut_nolambung
	// 	where txangkut_tgl between '$_POST[tglmulai]' and '$_POST[tglakhir]' and left(b.txangkut_nolambung,3)='$cust[1]' and arm_type_armada='$_POST[arm_type_armada]') a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_runofmine c ON c.rom_id=b.rom_id JOIN m_tujuan d ON d.tujuan_id=b.tujuan_id group by rutejarak_id, tarif, periode";
	


} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_ritase_dtltmp",array("trxangkutdtl_id"=> $_GET[id]));
	// echo json_encode($dt);

}