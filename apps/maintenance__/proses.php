<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='save'){

	$idmtc = $db->idurut("tx_maintenance","id_mtc");
 	$selno = $db->selectcount("tx_maintenance","id_mtc","");
 	$idbrgkeluar = $db->idurut("tx_barangkeluar","id_brgkeluar");
 	$idbrgmasuk = $db->idurut("tx_barangmasuk","id_brgmasuk");

 	$nopart = $selno+1;
 	$nomasuk = 'MTC' . sprintf('%05s', $nopart);
 	$arm=explode(";",$_POST[arm_id]);
	$db->query("
		insert into tx_maintenance (
			id_mtc,
			no_mtc,
			tgl_mtc,
			status_mtc,
			keterangan_mtc,
			arm_id,
			supp_mtc,
			harga_mtc
		) VALUES (
			'$idmtc',
			'$nomasuk',
			'$_POST[tgl_mtc]',
			1,
			'$_POST[keterangan_mtc]',
			'$arm[0]',
			'$_POST[supp_mtc]',
			'$_POST[harga_mtc]'
		)
		");

	$db->query("
			insert into tx_barangkeluar (
				id_brgkeluar,
				no_brgkeluar,
				date_brgkeluar,
				status_brgkeluar,
				createdby_brgkeluar,
				id_gudang
			) 
			values (
				'$idbrgkeluar',
				'$nomasuk',
				'$_POST[tgl_mtc]',
				'1',
				'$_SESSION[ID_PEG]',
				'$_POST[id_gudang]'
			) 
			");

	$db->query("
			insert into tx_barangmasuk (
				id_brgmasuk,
				no_brgmasuk,
				nama_supp,
				no_sj,
				date_brgmasuk,
				status_brgmasuk,
				createdby_brgmasuk,
				harga_total,
				id_gudang
			) 
			values (
				'$idbrgmasuk',
				'$nomasuk',
				'Lepas dari Armada',
				'',
				'$_POST[tgl_mtc]',
				'1',
				'$_SESSION[ID_PEG]',
				'0',
				'$_POST[id_gudang]'
			) 
			");

		// echo "select * from tx_barangkeluarkdtl where status_brgkeluardtl = 0 and created_by = '$_SESSION[ID_PEG]'";
		foreach($db->select("tx_maintenancedtl","*","status_mtcdtl = 0 and created_by = '$_SESSION[ID_PEG]'") as $bk){
			
				$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual,nolambung,arm_id)
				select '$idbrgkeluar','$nomasuk',no_transmutasi,id_mutasi, id_barang,'0', case when cumulative_sum>0 then stok-cumulative_sum else stok end as k, 2, '$_POST[id_gudang]',NOW(),'$_SESSION[ID_PEG]', '$bk[jenis]',harga, hargajual,'$arm[1]','$arm[0]' from (select a.*,
@running_total:=stok - abs(@running_total) AS cumulative_sum
 from (select * from (select a.id_barang, b.no_transmutasi, a.idmutasli as id_mutasi, sum(stok) stok, a.harga, a.hargajual from (select id_barang, no_transmutasi,min(id_mutasi) as idmutasli,  case when masukmutasi>0 then id_mutasi else id_refmutasi1 end as id_mutasi, sum(masukmutasi)-sum(keluarmutasi) as stok,harga,hargajual from tx_mutasi where id_barang='$bk[id_barang]' and jenisbrg='$bk[jenis]' group by id_mutasi order by id_mutasi) a join tx_mutasi b on b.id_mutasi=a.idmutasli group by a.id_mutasi) a where stok>0) a JOIN (SELECT @running_total:=$bk[qty_mtcdtl], @s:=0) b)a 
				");


				$db->query("
							insert into tx_barangkeluardtl (
								id_brgkeluar,
								id_barang,
								qty,
								created_by,
								jenisbrg,
								status_brgkeluardtl
							) 
							values (
								'$idbrgkeluar',						
								'$bk[id_barang]',
								'$bk[qty_mtcdtl]',
								'$_SESSION[ID_PEG]',
								'$bk[jenis]',
								'1'
							)");


				$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual,nolambung,arm_id)
				select '$idbrgkeluar','$nomasuk','','', $bk[id_barang],'$bk[qty_mtcdtl]', 0, 1, '$_POST[id_gudang]',NOW(),'$_SESSION[ID_PEG]', '$bk[jenis]',0, 0,'$arm[1]','$arm[0]' 
				");
				
				$db->query("
						insert into tx_barangmasukdtl (
							id_brgmasuk,
							id_barang,
							qty,
							harga,
							hargajual,
							created_by,
							jenisbrg,
							status_brgmasukdtl
						) 
						values (
							'$idbrgmasuk',
							'$bk[id_barang]',
							'$bk[qty_mtcdtl]',
							'0',
							'0',
							'$_SESSION[ID_PEG]',
							'2',
							'1'
						)");

				
		}



	$db->query("
			update tx_maintenancedtl set
				id_mtc = $idmtc,
				status_mtcdtl='1'
			where status_mtcdtl = 0 and created_by = '$_SESSION[ID_PEG]'
 			");


} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_maintenancedtl",array("id_mtcdtl"=> $_GET[id]));
	// echo json_encode($dt);

}