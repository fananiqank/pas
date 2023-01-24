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

	$no=sprintf("%03s", $no[urut] ? $no[urut] : 1)."/TBP/".$db->bulanrom($dayinv)."/".$yearinv;
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



	// $db->query("
	// 	insert into trx_basicpremi_driver_dtl (
	// 	txbaspre_id,
	// 	txbaspredtl_uraian,
	// 	driver_id,
	// 	txbaspredtl_jenis,
	// 	txbaspredtl_jumlah,
	// 	txbaspredtl_satuan,
	// 	txbaspredtl_ttl,
	// 	txbaspredtl_nolambung,
	// 	rutejarak_id,
	// 	id_site

	// 	) 
	// 	select $in p, case when arm_type_armada='1' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x2,sum(case when arm_type_armada='1' then ritase else tonase end) as x,case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x3,sum(tpremi) tpremi,txangkut_nolambung, rutejarak_id,id_site from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 1 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung,rutejarak_id,id_site from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.premidriver_type=c.arm_type_armada order by premidriver_id desc limit 1) premi, b.txangkut_nolambung, b.rutejarak_id,b.id_site from tx_ritase a 
	// 						JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id
	// 						JOIN m_armada c ON c.arm_id=b.arm_id where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]') a) a group by arm_type_armada,txangkut_nolambung, rutejarak_id, id_site UNION ALL
	// 	select $in as p, 'Basic' tipegaji, driverid,'Hari',sum(harikerja) harikerja,'Hari', sum(basic) tbasic,' - ','','' from (select driverid, count(driverid) harikerja, (case when bhari>=30 then (basic/30)*count(driverid) else (basic/bhari)*count(driverid) end) as basic from (
	// 	select a.*, b.driver_id as driverid, DAY(LAST_DAY(NOW())) bhari, (select basicdriver_jumlah from m_basicdriver x where a.txangkut_tgl>=x.basicdriver_tglmulai order by basicdriver_id desc limit 1) basic from tx_ritase a join (select * from tx_ritase_dtl group by txangkut_id) b ON a.txangkut_id=b.txangkut_id where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]') a group by driverid, basic) a group by driverid

	// 	");

	// $db->query("
	// 	insert into trx_basicpremi_driver_dtl (
	// 	txbaspre_id,
	// 	txbaspredtl_uraian,
	// 	driver_id,
	// 	txbaspredtl_jenis,
	// 	txbaspredtl_jumlah,
	// 	txbaspredtl_satuan,
	// 	txbaspredtl_ttl,
	// 	txbaspredtl_nolambung,
	// 	rutejarak_id,
	// 	id_site

	// 	) 
	// 	select $in p, case when arm_type_armada='1' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x2,sum(case when arm_type_armada='1' then ritase else tonase end) as x,case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x3,sum(tpremi) tpremi,txangkut_nolambung, rutejarak_id,id_site from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 1 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung,rutejarak_id,id_site from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.premidriver_type=c.arm_type_armada and premidriver_rute=rutejarak_id order by premidriver_id desc limit 1) premi, b.txangkut_nolambung, b.rutejarak_id,b.id_site from tx_ritase a 
	// 						JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id
	// 						JOIN m_armada c ON c.arm_id=b.arm_id where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]' and a.id_site='$_POST[id_site]') a) a group by arm_type_armada,txangkut_nolambung, rutejarak_id, id_site

	// 	");


	// $db->query("
	// 	insert into trx_basicpremi_driver_dtl (
	// 	txbaspre_id,
	// 	txbaspredtl_uraian,
	// 	driver_id,
	// 	txbaspredtl_jenis,
	// 	txbaspredtl_jumlah,
	// 	txbaspredtl_satuan,
	// 	txbaspredtl_ttl,
	// 	txbaspredtl_nolambung,
	// 	rutejarak_id,
	// 	id_site

	// 	) 
	// 	select $in p, case when arm_type_armada='2' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, case when arm_type_armada='2' then 'Ritase' else 'Tonase' end as x2,sum(case when arm_type_armada='2' then ritase else tonase end) as x,case when arm_type_armada='2' then 'Ritase' else 'Tonase' end as x3,sum(tpremi) tpremi,txangkut_nolambung, rutejarak_id,id_site from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 2 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung,rutejarak_id, id_site from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.arm_type_armada=c.arm_type_armada order by premidriver_id desc limit 1) premi, b.txangkut_nolambung,rutejarak_id, b.id_site from tx_ritase a JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id JOIN m_armada c ON c.arm_id=b.arm_id where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]' and a.id_site='$_POST[id_site]') a) a group by arm_type_armada,txangkut_nolambung,rutejarak_id, id_site
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
		txbaspredtl_nolambung,
		rutejarak_id,
		id_site

		) 
		select $in p, case when arm_type_armada='2' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, case when arm_type_armada='2' then 'Ritase' else 'Tonase' end as x2,sum(case when arm_type_armada='2' then ritase else tonase end) as x,case when arm_type_armada='2' then 'Ritase' else 'Tonase' end as x3,sum(tpremi) tpremi,txangkut_nolambung, rutejarak_id,id_site from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 2 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung,rutejarak_id, id_site from 
(select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, COALESCE((select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.arm_type_armada=c.arm_type_armada and x.rom_id=d.rom_id order by premidriver_id desc limit 1),0) premi, b.txangkut_nolambung,b.rutejarak_id, b.id_site 
from tx_ritase a JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id 
JOIN m_armada c ON c.arm_id=b.arm_id
JOIN m_rutejarak d ON d.rutejarak_id=b.rutejarak_id
where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]' and a.id_site='$_POST[id_site]') a) a group by arm_type_armada,txangkut_nolambung,rutejarak_id, id_site
		");
	
		

} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_ritase_dtltmp",array("trxangkutdtl_id"=> $_GET[id]));
	// echo json_encode($dt);

} else if($_GET[act]=='hapuspremi'){
	$db->query("insert into trx_basicpremi_driver_rem (txbaspre_id,id_site,txbaspre_no,txbaspre_bulan,txbaspre_tahun,txbaspre_tbas,txbaspre_tpre,txbaspre_gttl,txbaspre_user,txbaspre_tglinput,txbaspre_tgl1,txbaspre_tgl2) select txbaspre_id,id_site,txbaspre_no,txbaspre_bulan,txbaspre_tahun,txbaspre_tbas,txbaspre_tpre,txbaspre_gttl,txbaspre_user,txbaspre_tglinput,txbaspre_tgl1,txbaspre_tgl2 from trx_basicpremi_driver where txbaspre_id = $_GET[id]");


	foreach($db->select("trx_basicpremi_driver_dtl","*","txbaspre_id = $_GET[id]") as $predtl){
		$db->query("insert into trx_basicpremi_driver_dtl_rem (txbaspredtl_id,
txbaspre_id,txbaspredtl_uraian,driver_id,txbaspredtl_jenis,txbaspredtl_jumlah,txbaspredtl_satuan,txbaspredtl_ttl,txbaspredtl_nolambung,id_site,rutejarak_id) 
values ('".$predtl['txbaspredtl_id']."','".$predtl['txbaspre_id']."','".$predtl['txbaspredtl_uraian']."','".$predtl['driver_id']."','".$predtl['txbaspredtl_jenis']."','".$predtl['txbaspredtl_jumlah']."','".$predtl['txbaspredtl_satuan']."','".$predtl['txbaspredtl_ttl']."','".$predtl['txbaspredtl_nolambung']."','".$predtl['id_site']."','".$predtl['rutejarak_id']."')");

		
	}

	 $dt=$db->delete("trx_basicpremi_driver_dtl",array("txbaspre_id"=> $_GET[id]));
	 $dt2=$db->delete("trx_basicpremi_driver",array("txbaspre_id"=> $_GET[id]));
	// echo json_encode($dt);

}