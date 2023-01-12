<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	$ck=$db->select("m_rutejarak","count(*) c","rom_id='$_POST[rutejarak_rom]' AND tujuan_id='$_POST[rutejarak_tujuan]'");
	foreach($ck as $cc){}
	if($cc[c]>0 AND $_POST[rutejarak_id]==""){
		echo "Rute Telah Ada.";
	} else {
	$db->query("
		insert into m_rutejarak (
			rutejarak_id,
			rom_id,
			tujuan_id,
			rutejarak_jarak,
			rutejarak_update,
			rutejarak_user
		) 
		values (
			'$_POST[rutejarak_id]',
			'$_POST[rutejarak_rom]',
			'$_POST[rutejarak_tujuan]',
			'$_POST[rutejarak_jarak]',
			NOW(),
			'$_SESSION[ID_PEG]'
			
		) ON DUPLICATE KEY UPDATE 
			rutejarak_jarak='$_POST[rutejarak_jarak]',
			rutejarak_update=NOW(),
			rutejarak_user='$_SESSION[ID_PEG]'
		");
	}
	

} else if($_GET[act]=='get'){
	$dt=$db->select("(select a.*, rom_name, tujuan_name from m_rutejarak a JOIN m_runofmine b USING (rom_id)
						JOIN m_tujuan c USING (tujuan_id)) a","*","a.rutejarak_id='$_GET[id]'");
	echo json_encode($dt);

}