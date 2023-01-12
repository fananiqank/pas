
<?php 
if($_GET['armid']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value='0'>Pilih Armada</option>";
 foreach($db->select("m_armada","*,SUBSTR(arm_norangka,-5) norangka,case when arm_type_armada = 1 then 'DT' else 'SDT' end as typearamada","") as $val){
	if($_GET['armid'] == $val['arm_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[arm_id]' $s>$val[typearamada] - $val[norangka] -  $val[arm_nolambung]</option>"; 

}
?>