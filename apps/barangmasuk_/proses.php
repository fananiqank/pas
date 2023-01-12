<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	if($_POST['typeform'] == 1){
		$db->query("
			insert into tx_barangmasukdtl (
				id_brgmasukdtl,
				id_brgmasuk,
				id_barang,
				qty,
				harga,
				hargajual,
				created_by,
				jenisbrg
			) 
			values (
				'$_POST[id_brgmasukdtl]',
				'$_POST[id_brgmasuk]',
				'$_POST[id_barang]',
				'$_POST[qty]',
				'$_POST[harga]',
				'$_POST[hargajual]',
				'$_SESSION[ID_PEG]',
				'$_POST[jenisbrg]'
			)");
	} else if($_POST['typeform'] == 3) {
		$db->query("
				delete from tx_barangmasukdtl where id_brgmasukdtl = '$_POST[iddtl]'
			");
	 } 
	 else {
	 	$idbrgmasuk = $db->idurut("tx_barangmasuk","id_brgmasuk");
	 	$selno = $db->selectcount("tx_barangmasuk","id_brgmasuk","");
	 	$nopart = $selno+1;
	 	$nomasuk = 'BM' . sprintf('%05s', $nopart);
	 	
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
				'$_POST[nama_supp]',
				'$_POST[no_sj]',
				'$_POST[date_brgmasuk]',
				'1',
				'$_SESSION[ID_PEG]',
				'$_POST[harga_total]',
				'$_POST[id_gudang]'
			) 
			");

		$idtransmutasi = $db->idurut("(select id_transmutasi from tx_mutasi GROUP BY id_transmutasi) as asi","id_transmutasi");
		//no transmutasi masuk
	 	$notransmutasi = 'MB' . sprintf('%09s', $idtransmutasi);
	 	// echo $idtransmutasi."<br>";
	 	// echo $cmutasi['id_transmutasi']."<br>";
	 	// echo $notr."<br>";
	 	foreach($db->select("tx_barangmasukdtl","*","status_brgmasukdtl = 0 and created_by = '$_SESSION[ID_PEG]'") as $bm){
			$db->query("
				insert into tx_mutasi (
					id_transmutasi,
					no_transmutasi,
					id_barang,
					masukmutasi,
					keluarmutasi,
					jenismutasi,
					id_gudang,
					tgl_mutasi,
					created_by,
					no_refmutasi1,
					jenisbrg,
					harga,
					hargajual
				) 
				values (
					'$idtransmutasi',
					'$notransmutasi',
					'$bm[id_barang]',
					'$bm[qty]',
					'0',
					'1',
					'$_POST[id_gudang]',
					'$_POST[date_brgmasuk]',
					'$_SESSION[ID_PEG]',
					'0',
					'1',
					'$bm[harga]',
					'$bm[hargajual]'
				) 
				");
		}

		 $db->query("
			update tx_barangmasukdtl set
				id_brgmasuk = $idbrgmasuk,
				status_brgmasukdtl='1'
			where status_brgmasukdtl = 0 and created_by = '$_SESSION[ID_PEG]'
			");

		

	}
	
} else if($_GET[act]=='get'){
	$dt=$db->select("tx_barangmasuk","*","id_brgmasuk='$_GET[id]'");
	echo json_encode($dt);

}