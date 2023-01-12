
<?php 
if($_GET['idsatuan']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Satuan</option>";
 foreach($db->select("m_satuan","*","") as $val){
	if($_GET['idsatuan'] == $val['id_satuan']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_satuan]' $s>$val[nama_satuan]</option>"; 

}
?>