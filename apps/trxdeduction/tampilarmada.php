
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

//if($val['hadirdriver_jenis'] != ""){$valarmada = $val['arm_id'];}else{$valarmada = $val['driver_armada'];}
echo "<option value=''>Pilih Armada</option>";
 foreach($db->select("m_armada","*,concat((case when arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(arm_norangka,-5),'-',arm_nolambung) as armada","") as $val22){
	if($val['driver_armada'] == $val22['arm_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val22[arm_id]' $s>$val22[armada]</option>"; 

}
?>