<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("m_armada_type","*","arm_type_status='1' and arm_merk_id = $_GET[merk]") as $val){ 
	if($_GET['type'] == $val['arm_type_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[arm_type_id]' $s>$val[arm_type_name]</option>"; 

}
?>