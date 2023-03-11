
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Driver</option>";
 foreach($db->select("m_driver","*","") as $val){
	if($_GET['driver_id'] == $val['driver_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[driver_id]' $s>$val[driver_name]</option>"; 

}
?>