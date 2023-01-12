<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
if($_GET[act]=='post'){
	$db->query("
		insert into m_tujuan (
			tujuan_id,
			tujuan_name,
			tujuan_desc,
			tujuan_status,
			tujuan_dtinput,
			tujuan_userinput
		) 
		values (
			'$_POST[tujuan_id]',
			'$_POST[tujuan_name]',
			'$_POST[tujuan_desc]',
			'1',
			NOW(),
			'$_SESSION[ID_PEG]'
		) ON DUPLICATE KEY UPDATE 
			tujuan_name='$_POST[tujuan_name]',
			tujuan_desc='$_POST[tujuan_desc]',
			tujuan_dtinput=NOW(),
			tujuan_userinput='$_SESSION[ID_PEG]'
		");

	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_tujuan","*","tujuan_id='$_GET[id]'");
	echo json_encode($dt);

}