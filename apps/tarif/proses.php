<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='post'){

	
	$db->query("
		insert into m_tarif (
			tarif_id,
			cust_id,
			rutejarak_id,
			tarif_tglmulai,
			tarif_userinput,
			tarif_harga,
			tarif_tglinput,
			type_armada

		) 
		values (
			'$_POST[tarif_id]',
			'$_POST[cust_id]',
			'$_POST[rutejarak_id]',
			'$_POST[tarif_tglmulai]',
			'$_SESSION[ID_PEG]',
			'$_POST[tarif_harga]',
			NOW(),
			'$_POST[type_armada]'

			
		)
		");
	
	echo "";

} else if($_GET[act]=='get'){
	$dt=$db->select("m_tarif","*","tarif_id='$_GET[id]'");
	echo json_encode($dt);

}