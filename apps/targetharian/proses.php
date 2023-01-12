<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	
	$db->query("
		insert into m_targetharian (
			target_tglmulai,
			target_tonase,
			target_input,
			target_shift,
			target_ritase,
			target_type
		) 
		values (
			'$_POST[target_tglmulai]',
			'$_POST[target_tonase]',
			NOW(),
			'$_POST[target_shift]',
			'$_POST[target_ritase]',
			'$_POST[target_type]'
		)
		");
	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_tarif","*","tarif_id='$_GET[id]'");
	echo json_encode($dt);

}