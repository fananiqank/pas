<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
if($_GET[act]=='post'){
	$db->query("
		insert into m_runofmine (
			rom_id,
			rom_name,
			rom_desc,
			rom_status,
			rom_dtinput,
			rom_userinput
		) 
		values (
			'$_POST[rom_id]',
			'$_POST[rom_name]',
			'$_POST[rom_desc]',
			'1',
			NOW(),
			'$_SESSION[ID_PEG]'
		) ON DUPLICATE KEY UPDATE 
			rom_name='$_POST[rom_name]',
			rom_desc='$_POST[rom_desc]',
			rom_dtinput=NOW(),
			rom_userinput='$_SESSION[ID_PEG]'
		");

	
} else if($_GET[act]=='get'){
	$dt=$db->select("m_runofmine","*","rom_id='$_GET[id]'");
	echo json_encode($dt);

}