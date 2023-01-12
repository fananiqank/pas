
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Armada</option>";
 foreach($db->select("m_armada","*","") as $val){
	if($_GET['arm_id'] == $val['arm_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[arm_id]' $s>$val[arm_nolambung]</option>"; 

}
?>