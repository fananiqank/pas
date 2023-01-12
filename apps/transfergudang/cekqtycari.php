<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();


// foreach($db->select("(SELECT masuk.id_barang, CASE WHEN qtykeluar != '' THEN IFNULL(( qtymasuk - qtykeluar ),
// 							0 
// 							) ELSE IFNULL( qtymasuk, 0 ) 
// 						END AS stok 
// 					FROM
// 						( SELECT sum( qty ) AS qtymasuk, id_barang FROM tx_barangmasukdtl GROUP BY id_barang ) AS masuk
// 						LEFT JOIN ( SELECT sum( qty ) AS qtykeluar, id_barang FROM tx_barangkeluardtl GROUP BY id_barang ) AS keluar ON masuk.id_barang = keluar.id_barang 
// 					) as asi","*","id_barang = $_POST[idbarang]")as $val){}

foreach($db->select("(select id_barang, sum(masukmutasi)-sum(keluarmutasi)-(select IFNULL(sum(qty),0) as qty from tx_barangkeluardtl where id_barang = '$_POST[idbarang]' and status_brgkeluardtl = 0) as stok from tx_mutasi where id_barang='$_POST[idbarang]' and id_gudang = $_POST[idgudang]) as asi","*","")as $val){}

if($val[stok] == ''){
	echo "0";
} else {
	echo $val[stok];
}
?>