<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	if($_POST[premidriver_type] == 1){$armtype = 2;}else{$armtype = 1;}
	$db->query("
		insert into m_premidriver (
			premidriver_jumlah,
			premidriver_tglmulai,
			premidriver_userinput,
			premidriver_tglinput,
			premidriver_type,
			arm_type_armada,
			rom_id
		) 
		values (
			'$_POST[premidriver_jumlah]',
			'$_POST[premidriver_tglmulai]',
			'$_SESSION[ID_PEG]',
			NOW(),
			'$_POST[premidriver_type]',
			'$armtype',
			'$_POST[rom_id]'
		)
		");
	


} else if($_GET[act]=='get'){
	$dt=$db->select("m_premidriver","*","premidriver_id='$_GET[id]'");
	echo json_encode($dt);

} else if($_GET[act]=='del'){
	$db->query("delete from m_premidriver where premidriver_id='$_GET[id]'");
	
}