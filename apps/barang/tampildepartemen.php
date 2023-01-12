
<?php 
if($_GET['dep']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Departemen</option>";
 foreach($db->select("m_dep","*","") as $val){
	if($_GET['dep'] == $val['id_dep']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_dep]' $s>$val[nama_dep]</option>"; 

}
?>