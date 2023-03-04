
<?php 
if($_GET['reload']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Mekanik</option>";
 foreach($db->select("m_mekanik","*","status_mekanik=1") as $val){
	if($_GET['id'] == $val['id_mekanik']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_mekanik]' $s>$val[name_mekanik]</option>"; 

}
?>