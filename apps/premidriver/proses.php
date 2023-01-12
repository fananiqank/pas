<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	
	$db->query("
		insert into m_premidriver (
			premidriver_id,
			premidriver_jumlah,
			premidriver_tglmulai,
			premidriver_userinput,
			premidriver_tglinput,
			premidriver_type
		) 
		values (
			'$_POST[premidriver_id]',
			'$_POST[premidriver_jumlah]',
			'$_POST[premidriver_tglmulai]',
			'$_SESSION[ID_PEG]',
			NOW(),
			'$_POST[premidriver_type]'
		)
		");
	
	echo "";

} else if($_GET[act]=='get'){
	$dt=$db->select("m_premidriver","*","premidriver_id='$_GET[id]'");
	echo json_encode($dt);

}