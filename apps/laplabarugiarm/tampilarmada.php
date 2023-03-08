
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>All Armada</option>";
 foreach($db->select("m_armada","*,SUBSTR(arm_norangka,-5) norangka","") as $val){
	if($_GET['armid'] == $val['arm_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[arm_id]' $s>$val[norangka] -  $val[arm_nolambung]</option>"; 

}
?>