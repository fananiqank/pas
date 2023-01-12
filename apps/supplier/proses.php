<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
if($_GET[act]=='post'){
	$db->query("
		insert into m_supplier (
			supp_id,
			supp_nama,
			supp_alamat,
			supp_notelp,
			supp_status,
			supp_type
		) 
		values (
			'$_POST[supp_id]',
			'$_POST[supp_nama]',
			'$_POST[supp_alamat]',
			'$_POST[supp_notelp]',
			1,
			'$_POST[supp_type]'
		) ON DUPLICATE KEY UPDATE 
			supp_nama='$_POST[supp_nama]',
			supp_alamat='$_POST[supp_alamat]',
			supp_notelp='$_POST[supp_notelp]',
			supp_status='$_POST[supp_status]',
			supp_type='$_POST[supp_type]'
		");

foreach($db->select("m_supplier","max(supp_id) maxsupid") as $spi){}

	$db->query("
		insert into m_mekanik (
			name_mekanik,
			alamat_mekanik,
			telp_mekanik,
			supp_id
		) VALUES (
			'$_POST[supp_nama]',
			'$_POST[supp_alamat]',
			'$_POST[supp_notelp]',
			'$spi[maxsupid]'
		) ON DUPLICATE KEY UPDATE 
			name_mekanik='$_POST[supp_nama]',
			alamat_mekanik='$_POST[supp_alamat]',
			telp_mekanik='$_POST[supp_notelp]',
			
		");
		
	
	

} else if($_GET[act]=='get'){
	$dt=$db->select("m_supplier","*","supp_id='$_GET[id]'");
	echo json_encode($dt);

}