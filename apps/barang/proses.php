<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){
	$db->query("
		insert into m_barang (
			id_barang,
			kode_barang,
			id_dep,
			id_sub,
			id_kat,
			nama_barang,
			id_satuan,
			status,
			min_stock,
			partnumber_barang
		) 
		values (
			'$_POST[id_barang]',
			'$_POST[kode_barang]',
			'$_POST[id_dep]',
			'$_POST[id_sub]',
			'$_POST[id_kat]',
			'$_POST[nama_barang]',
			'$_POST[id_satuan]',
			'$_POST[status]',
			'$_POST[min_stock]',
			'$_POST[partnumber_barang]'
		) ON DUPLICATE KEY UPDATE 
			nama_barang='$_POST[nama_barang]',
			id_satuan='$_POST[id_satuan]',
			status='$_POST[status]',
			min_stock= '$_POST[min_stock]',
			partnumber_barang='$_POST[partnumber_barang]'
		");
} else if($_GET[act]=='get'){
	$dt=$db->select("m_barang","*","id_barang='$_GET[id]'");
	echo json_encode($dt);

}