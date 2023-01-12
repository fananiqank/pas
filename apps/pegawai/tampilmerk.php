
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Merk</option>";
 foreach($db->select("m_armada_merk","*","arm_merk_status='1'") as $val){
	if($_GET['merk'] == $val['arm_merk_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[arm_merk_id]' $s>$val[arm_merk_name]</option>"; 

}
?>