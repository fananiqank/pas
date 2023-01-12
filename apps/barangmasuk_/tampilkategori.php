<?php 

	session_start();
	require_once "../../webclass.php";
	$db = new kelas();


echo "<option value=''>Pilih Kategori</option>";
 foreach($db->select("m_kat","*","id_sub='$_GET[sub]' and status='1'") as $val){
	if($_GET['kat'] == $val['id_kat']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_kat]' $s>$val[nama_kat]</option>"; 

}
?>