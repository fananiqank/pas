<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

// foreach($db->select("(SELECT a.id_barang,
// 						CASE WHEN qtyker != '' THEN IFNULL(( stok - qtyker ),
// 						0 
// 						) ELSE IFNULL( stok, 0 ) 
// 						END AS stok FROM ( SELECT masuk.id_barang, CASE WHEN qtykeluar != '' THEN IFNULL(( qtymasuk - qtykeluar ),
// 							0 
// 							) ELSE IFNULL( qtymasuk, 0 ) 
// 						END AS stok 
// 					FROM
// 						( SELECT sum( qty ) AS qtymasuk, id_barang FROM tx_barangmasukdtl where jenisbrg = $_POST[jenis] GROUP BY id_barang ) AS masuk
// 						LEFT JOIN ( SELECT sum( qty ) AS qtykeluar, id_barang FROM tx_barangkeluardtl where jenisbrg = $_POST[jenis] GROUP BY id_barang ) AS keluar ON masuk.id_barang = keluar.id_barang 
// 					) a
// 					LEFT JOIN ( SELECT sum( qty_mtcdtl ) AS qtyker, id_barang FROM tx_maintenancedtl WHERE status_mtcdtl = 0 AND jenis = $_POST[jenis] GROUP BY id_barang ) AS b ON a.id_barang = b.id_barang) as asi","*","id_barang = $_POST[idbarang]")as $val){}
foreach($db->select("(select id_barang, sum(masukmutasi)-sum(keluarmutasi) as stok from tx_mutasi where id_barang='$_POST[idbarang]') as asi","*","")as $val){}
if($val[stok] == ''){
	echo "0";
} else {
	echo $val[stok];
}
?>