<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='save'){
	if($_GET[idmtc] != ''){
	$db->query("insert into tx_mekanik (
				id_mekanik,
				pekerjaan,
				biaya,
				tgltransinput,
				userinput,
				stinput,
				id_mtc
			) 
			values (
				'$_POST[mekanik]',
				'$_POST[pekerjaan]',
				'$_POST[biayamekanik]',
				'$date',
				'$_SESSION[ID_PEG]',
				'1',
				'$_GET[idmtc]'
				
			)");
	} else {
		$db->query("insert into tx_mekanik (
				id_mtc,
				id_mekanik,
				pekerjaan,
				biaya,
				tgltransinput,
				userinput
			) 
			values (
				'$_POST[idmtc]',
				'$_POST[mekanik]',
				'$_POST[pekerjaan]',
				'$_POST[biayamekanik]',
				'$date',
				'$_SESSION[ID_PEG]'
			)");
	} 
	// echo "insert into tx_mekanik (
	// 			nama_mekanik,
	// 			pekerjaan,
	// 			biaya,
	// 			tgltransinput,
	// 			userinput
	// 		) 
	// 		values (
	// 			'$_POST[mekanik]',
	// 			'$_POST[pekerjaan]',
	// 			'$_POST[biayamekanik]',
	// 			'$date',
	// 			'$_SESSION[ID_PEG]'
				
	// 		)";
	
} else if($_GET[act]=='get'){
	

}