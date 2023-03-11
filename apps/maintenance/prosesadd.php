<?php

session_start();
 error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	if($_POST[idmtc] != ''){
		$arm=explode(";",$_POST[arm_id]);
		
		$db->query("insert into tx_maintenancedtl (
				id_mtc,
				id_barang,
				qty_mtcdtl,
				status_mtcdtl,
				created_by,
				jenis
			) 
			values (
				'$_POST[idmtc]',
				'$_POST[id_barang]',
				'$_POST[qty]',
				'1',
				'$_SESSION[ID_PEG]',
				'$_POST[jenis]'
			)");

//keluar barang baru/bekas
		$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual,nolambung,arm_id)
				select '$_POST[idmtc]','$_POST[nomtc]',no_transmutasi,id_mutasi, id_barang,'0', case when cumulative_sum>0 then stok-cumulative_sum else stok end as k, 2, '$_POST[id_gudang]',NOW(),'$_SESSION[ID_PEG]', '$_POST[jenis]',harga, hargajual,'$arm[1]','$arm[0]' from (select a.*,
@running_total:=stok - abs(@running_total) AS cumulative_sum
 from (select * from (select a.id_barang, b.no_transmutasi, a.idmutasli as id_mutasi, sum(stok) stok, a.harga, a.hargajual from (select id_barang, no_transmutasi,min(id_mutasi) as idmutasli,  case when masukmutasi>0 then id_mutasi else id_refmutasi1 end as id_mutasi, sum(masukmutasi)-sum(keluarmutasi) as stok,harga,hargajual from tx_mutasi where id_barang='$_POST[id_barang]' and jenisbrg='$_POST[jenis]' and id_gudang='$_POST[id_gudang]' group by id_mutasi order by id_mutasi) a join tx_mutasi b on b.id_mutasi=a.idmutasli group by a.id_mutasi) a where stok>0) a JOIN (SELECT @running_total:=$_POST[qty], @s:=0) b)a 
				");

//masuk barang bekas
		$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual,nolambung,arm_id)
				select '$_POST[idmtc]','$_POST[nomtc]','',NULL, $_POST[id_barang],'$_POST[qty]', 0, 1, '$_POST[id_gudang]',NOW(),'$_SESSION[ID_PEG]', '2',0, 0,'$_POST[arm_nolambug]','$_POST[arm_id]' 
				");
		
	} else {
		$db->query("insert into tx_maintenancedtl (
				id_mtc,
				id_barang,
				qty_mtcdtl,
				status_mtcdtl,
				created_by,
				jenis
			) 
			values (
				'0',
				'$_POST[id_barang]',
				'$_POST[qty]',
				'0',
				'$_SESSION[ID_PEG]',
				'$_POST[jenis]'
			)");
	
	}
} else if($_GET[act]=='get'){
	$dt=$db->select("m_tarif","*","tarif_id='$_GET[id]'");
	echo json_encode($dt);

}