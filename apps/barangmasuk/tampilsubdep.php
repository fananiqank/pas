<?php 

	session_start();
	require_once "../../webclass.php";
	$db = new kelas();


echo "<option value=''>Pilih Sub</option>";
foreach($db->select("m_subdep","*","id_dep = '$_GET[dep]' and status = 1") as $val){ 
	if($_GET['sub'] == $val['id_sub']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_sub]' $s>$val[nama_sub]</option>"; 

}
?>