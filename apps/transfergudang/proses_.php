<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	if($_POST['typeform'] == 1){
		
		$db->query("
			insert into tx_barangkeluardtl (
				id_brgkeluardtl,
				id_brgkeluar,
				id_barang,
				qty,
				created_by,
				jenisbrg
			) 
			values (
				'$_POST[id_brgkeluardtl]',
				'$_POST[id_brgkeluar]',
				'$_POST[id_barang]',
				'$_POST[qty]',
				'$_SESSION[ID_PEG]',
				'$_POST[jenisbrg]'
			)");
	} else if($_POST['typeform'] == 3) {
		$db->query("
				delete from tx_barangkeluardtl where id_brgkeluardtl = '$_POST[iddtl]'
			");
	 } 
	 else {
	 	$idbrgkeluar = $db->idurut("tx_barangkeluar","id_brgkeluar");
	 	$selno = $db->selectcount("tx_barangkeluar","id_brgkeluar","");
	 	$nopart = $selno+1;
	 	$nokeluar = 'BK' . sprintf('%05s', $nopart);
	 	
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
				'$nokeluar',
				'$_POST[date_brgkeluar]',
				'1',
				'$_SESSION[ID_PEG]',
				'$_POST[id_gudang]'
			) 
			");

		// echo "select * from tx_barangkeluarkdtl where status_brgkeluardtl = 0 and created_by = '$_SESSION[ID_PEG]'";
		foreach($db->select("tx_barangkeluardtl","*","status_brgkeluardtl = 0 and created_by = '$_SESSION[ID_PEG]'") as $bk){
			echo "as";
				$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual)
				select '$idbrgkeluar','$nokeluar',no_transmutasi,id_mutasi, id_barang,'0', case when cumulative_sum>0 then stok-cumulative_sum else stok end as k, 2, '$_POST[id_gudang]',NOW(),'$_SESSION[ID_PEG]', '$bk[jenisbrg]',harga, hargajual from (select a.*,
@running_total:=stok - abs(@running_total) AS cumulative_sum
 from (select * from (select id_barang, no_transmutasi, id_mutasi, sum(stok) stok, harga, hargajual from (select id_barang, no_transmutasi, case when masukmutasi>0 then id_mutasi else id_refmutasi1 end as id_mutasi, sum(masukmutasi)-sum(keluarmutasi) as stok,harga,hargajual from tx_mutasi where id_barang='$bk[id_barang]' and jenisbrg='$bk[jenisbrg]' group by id_mutasi order by id_mutasi) a group by id_mutasi) a where stok>0) a JOIN (SELECT @running_total:=$bk[qty], @s:=0) b)a 
				");

		}

		// $selFIFO = $db->select("
		// 	SELECT * FROM
		// 	(SELECT	row_number() OVER ( PARTITION BY id_barang ORDER BY id_barang, id_transmutasi ) AS serial,id_barang,
		// 			id_transmutasi,no_transmutasi,id_barang,masukmutasi, tgl_mutasi,harga
		// 		FROM tx_mutasi aa WHERE	jenismutasi = 1	AND jenisbrg = 1) as a

		// 	");

		// $idtransmutasi = $db->idurut("(select id_transmutasi from tx_mutasi GROUP BY id_transmutasi) as asi","id_transmutasi");
		// //no transmutasi masuk
	 // 	$notransmutasi = 'MB' . sprintf('%09s', $idtransmutasi);
	 	
	 // 	foreach($db->select("tx_barangkeluardtl","*","status_brgmasukdtl = 0 and created_by = '$_SESSION[ID_PEG]'") as $bm){
		// 	$db->query("
		// 		insert into tx_mutasi (
		// 			id_transmutasi,
		// 			no_transmutasi,
		// 			id_barang,
		// 			masukmutasi,
		// 			keluarmutasi,
		// 			jenismutasi,
		// 			id_gudang,
		// 			tgl_mutasi,
		// 			created_by,
		// 			no_refmutasi1,
		// 			jenisbrg,
		// 			harga
		// 		) 
		// 		values (
		// 			'$idtransmutasi',
		// 			'$notransmutasi',
		// 			'$bm[id_barang]',
		// 			'0',
		// 			'$bm[qty]',
		// 			'1',
		// 			'$_POST[id_gudang]',
		// 			'$_POST[date_brgmasuk]',
		// 			'$_SESSION[ID_PEG]',
		// 			'0',
		// 			'$bm[jenisbrg]',
		// 			'$bm[harga]'
		// 		) 
		// 		");
		//	}

		//update status dtls
			$db->query("
			update tx_barangkeluardtl set
				id_brgkeluar = $idbrgkeluar,
				status_brgkeluardtl='1'
			where status_brgkeluardtl = 0 and created_by = '$_SESSION[ID_PEG]'
			");
	}
	
} else if($_GET[act]=='get'){
	$dt=$db->select("tx_barangkeluar","*","id_brgkeluar='$_GET[id]'");
	echo json_encode($dt);

}