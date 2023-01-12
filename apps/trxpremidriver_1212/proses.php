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

	foreach($db->select("trx_basicpremi_driver a JOIN (select max(txbaspre_id) txbaspre_id from trx_basicpremi_driver ) b ON a.txbaspre_id=b.txbaspre_id","LEFT(txbaspre_no,3)+1 as urut") as $no){}
	// echo "select LEFT(txbaspre_no,3)+1 as urut from trx_basicpremi_driver a JOIN (select max(txbaspre_id) txbaspre_id from trx_basicpremi_driver ) b ON a.txbaspre_id=b.txbaspre_id<br>";
	
	$no=sprintf("%03s", $no[urut] ? $no[urut] : 1) ."/TBP/".$db->bulanrom($dayinv)."/".$yearinv;
	// echo "$dayinv".$no;
	$date=date("Y-m-d H:i:S");
	
	$data=array(
					"txbaspre_no"=>$no,
					"id_site"=>$_POST['id_site'],
					"txbaspre_bulan"=>$dayinv,
					"txbaspre_tahun"=>$yearinv,
					"txbaspre_tbas"=>$_POST[tbas],
					"txbaspre_tpre"=>$_POST[tpre],
					"txbaspre_gttl"=>$_POST[subt],
					"txbaspre_user"=>$_SESSION[ID_PEG],
					"txbaspre_tglinput"=>$date,
					"txbaspre_tgl1"=>$_POST[txangkut_tgl1],
					"txbaspre_tgl2"=>$_POST[txangkut_tgl2],
				);
	$in=$db->insertID("trx_basicpremi_driver",$data);
	// $db->query("
	// 	insert into trx_basicpremi_driver_dtl (
	// 	txbaspre_id,
	// 	txbaspredtl_uraian,
	// 	driver_id,
	// 	txbaspredtl_jenis,
	// 	txbaspredtl_jumlah,
	// 	txbaspredtl_satuan,
	// 	txbaspredtl_ttl,
	// 	txbaspredtl_nolambung
	// 	) 
	// 	select $in p, case when arm_type_armada='1' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x2,sum(case when arm_type_armada='1' then ritase else tonase end) as x,case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x3,sum(tpremi) tpremi,txangkut_nolambung from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 1 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.premidriver_type=c.arm_type_armada order by premidriver_id desc limit 1) premi, b.txangkut_nolambung from tx_ritase a 
	// 						JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id
	// 						JOIN m_armada c ON c.arm_id=b.arm_id where month(a.txangkut_tgl)='$_POST[bpbulan]' and year(a.txangkut_tgl)='$_POST[bptahun]') a) a group by arm_type_armada,txangkut_nolambung UNION ALL
	// 	select $in as p, 'Basic' tipegaji, driver_id,'Hari',sum(harikerja) harikerja,'Hari', sum(basic) tbasic,' - ' from (select driver_id, count(driver_id) harikerja, (case when bhari>=30 then (basic/30)*count(driver_id) else (basic/bhari)*count(driver_id) end) as basic from (
	// 	select *, DAY(LAST_DAY(NOW())) bhari, (select basicdriver_jumlah from m_basicdriver x where a.txangkut_tgl>=x.basicdriver_tglmulai order by basicdriver_id desc limit 1) basic from tx_ritase a where month(a.txangkut_tgl)='$_POST[bpbulan]' and year(a.txangkut_tgl)='$_POST[bptahun]') a group by driver_id, basic) a group by driver_id

	// 	");



	$db->query("
		insert into trx_basicpremi_driver_dtl (
		txbaspre_id,
		txbaspredtl_uraian,
		driver_id,
		txbaspredtl_jenis,
		txbaspredtl_jumlah,
		txbaspredtl_satuan,
		txbaspredtl_ttl,
		txbaspredtl_nolambung
		) 
		select $in p, case when arm_type_armada='1' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x2,sum(case when arm_type_armada='1' then ritase else tonase end) as x,case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x3,sum(tpremi) tpremi,txangkut_nolambung from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 1 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.premidriver_type=c.arm_type_armada order by premidriver_id desc limit 1) premi, b.txangkut_nolambung from tx_ritase a 
							JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id
							JOIN m_armada c ON c.arm_id=b.arm_id where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]') a) a group by arm_type_armada,txangkut_nolambung UNION ALL
		select $in as p, 'Basic' tipegaji, driver_id,'Hari',sum(harikerja) harikerja,'Hari', sum(basic) tbasic,' - ' from (select driver_id, count(driver_id) harikerja, (case when bhari>=30 then (basic/30)*count(driver_id) else (basic/bhari)*count(driver_id) end) as basic from (
		select *, DAY(LAST_DAY(NOW())) bhari, (select basicdriver_jumlah from m_basicdriver x where a.txangkut_tgl>=x.basicdriver_tglmulai order by basicdriver_id desc limit 1) basic from tx_ritase a where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]') a group by driver_id, basic) a group by driver_id

		");
	

} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_ritase_dtltmp",array("trxangkutdtl_id"=> $_GET[id]));
	// echo json_encode($dt);

}