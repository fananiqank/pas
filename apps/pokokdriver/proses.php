<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	
	$db->query("
		insert into m_basicdriver (
			basicdriver_id,
			basicdriver_jumlah,
			basicdriver_tglmulai,
			basicdriver_userinput,
			basicdriver_tglinput

		) 
		values (
			'$_POST[basicdriver_id]',
			'$_POST[basicdriver_jumlah]',
			'$_POST[basicdriver_tglmulai]',
			'$_SESSION[ID_PEG]',
			NOW()
		)
		");
	
	echo "";

} else if($_GET[act]=='get'){
	$dt=$db->select("m_basicdriver","*","basicdriver_id='$_GET[id]'");
	echo json_encode($dt);

}