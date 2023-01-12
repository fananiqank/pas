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
				jenisbrg,
				status_pakai,
				supp_id
			) 
			values (
				'$_POST[id_brgkeluardtl]',
				'$_POST[id_brgkeluar]',
				'$_POST[id_barang]',
				'$_POST[qty]',
				'$_SESSION[ID_PEG]',
				'$_POST[jenisbrg]',
				'$_POST[typepakai]',
				'$_POST[supp_id]'
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

	 	$idbrgmasuk = $db->idurut("tx_barangmasuk","id_brgmasuk");
	 	$selno2 = $db->selectcount("tx_barangmasuk","id_brgmasuk","");
	 	$nopart2 = $selno2+1;
	 	$nomasuk = 'BM' . sprintf('%05s', $nopart2);
	 	
	//barang keluar
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
			
				$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual)
					select '$idbrgkeluar','$nokeluar',no_transmutasi,id_mutasi, id_barang,'0', case when cumulative_sum>0 then stok-cumulative_sum else stok end as k, 2, '$_POST[id_gudang]',NOW(),'$_SESSION[ID_PEG]', '$bk[jenisbrg]',harga, hargajual from (select a.*,
	@running_total:=stok - abs(@running_total) AS cumulative_sum
	 from (select * from (select id_barang, no_transmutasi, id_mutasi, sum(stok) stok, harga, hargajual from (select id_barang, no_transmutasi, case when masukmutasi>0 then id_mutasi else id_refmutasi1 end as id_mutasi, sum(masukmutasi)-sum(keluarmutasi) as stok,harga,hargajual from tx_mutasi where id_barang='$bk[id_barang]' and jenisbrg='$bk[jenisbrg]' group by id_mutasi order by id_mutasi) a group by id_mutasi) a where stok>0) a JOIN (SELECT @running_total:=$bk[qty], @s:=0) b)a 
				");

		}
		$db->query("
			insert into tx_barangmasuk (
				id_brgmasuk,
				no_brgmasuk,
				date_brgmasuk,
				status_brgmasuk,
				createdby_brgmasuk,
				id_gudang,
				harga_total
			) 
			values (
				'$idbrgmasuk',
				'$nomasuk',
				'$_POST[date_brgkeluar]',
				'1',
				'$_SESSION[ID_PEG]',
				'$_POST[id_gudang2]',
				'$hgjual[totalharga]'
			) 
			");

	//barang masuk
		foreach($db->select("(select * from tx_mutasi where id_transmutasi='$idbrgkeluar') a","*") as $hgjual){


		}
			
		$db->query("
				insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual)
					select '$idbrgmasuk','$nomasuk',no_transmutasi,id_mutasi, id_barang,keluarmutasi,'0', 1, '$_POST[id_gudang2]',NOW(),'$_SESSION[ID_PEG]', '$bk[jenisbrg]',harga, hargajual from (select * from tx_mutasi where id_transmutasi='$idbrgkeluar')a 
				");
		// echo "insert into tx_mutasi (id_transmutasi,no_transmutasi,no_refmutasi1,id_refmutasi1,id_barang,masukmutasi,keluarmutasi,jenismutasi,id_gudang,tgl_mutasi,created_by,jenisbrg,harga,hargajual)
		// 			select '$idbrgmasuk','$nomasuk',no_transmutasi,id_mutasi, id_barang,keluar,'0', 1, '$_POST[id_gudang2]',NOW(),'$_SESSION[ID_PEG]', '$bk[jenisbrg]',harga, hargajual from (select * from tx_mutasi where id_transmutasi='$idbrgkeluar')a ";
		$db->query("
				insert into tx_barangmasukdtl (id_brgmasuk,id_barang,qty,status_brgmasukdtl,harga,hargajual,created_by,jenisbrg)
					select '$idbrgmasuk', id_barang, keluarmutasi, 1, harga, hargajual, '$_SESSION[ID_PEG]',jenisbrg from (select * from tx_mutasi where id_transmutasi='$idbrgkeluar')a 
				");
		
		// echo "insert into tx_barangmasukdtl (id_brgmasuk,id_barang,qty,status_brgmasukdtl,harga,hargajual,created_by,jenisbrg)
		// 			select '$idbrgmasuk', id_barang, keluar, 1, harga, hargajual, '$_SESSION[ID_PEG]',jenisbrg from (select * from tx_mutasi where id_transmutasi='$idbrgkeluar')a";
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