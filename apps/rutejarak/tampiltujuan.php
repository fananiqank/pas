<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Tujuan</option>";
 foreach($db->select("m_tujuan","*","tujuan_status='1'") as $val){
	if($_GET['tujuan_id'] == $val['tujuan_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[tujuan_id]' $s>$val[tujuan_name]</option>"; 

}
?>