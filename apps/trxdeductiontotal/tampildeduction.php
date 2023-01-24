
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Deduction</option>";
 foreach($db->select("m_deduction","*","") as $val){
	if($_GET['id_ddc'] == $val['id_ddc']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_ddc]' $s>$val[nama_ddc]</option>"; 

}
?>