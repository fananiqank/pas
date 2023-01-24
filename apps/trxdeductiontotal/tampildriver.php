
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

//if($val['hadirdriver_jenis'] != ""){$valarmada = $val['arm_id'];}else{$valarmada = $val['driver_armada'];}
echo "<option value=''>Pilih Driver</option>";
 foreach($db->select("m_driver","*","status_driver = 1") as $val22){
	if($val['driverid'] == $val22['driver_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val22[driver_id]' $s>$val22[driver_name]</option>"; 

}
?>