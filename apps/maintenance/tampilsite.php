
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Site</option>";
 foreach($db->select("m_site","*","") as $val){
	if($_GET['id_site'] == $val['id_site']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_site]' $s>$val[nama_site]</option>"; 

}
?>