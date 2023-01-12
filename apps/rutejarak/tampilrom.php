
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih ROM</option>";
 foreach($db->select("m_runofmine","*","rom_status='1'") as $val){
	if($_GET['rom_id'] == $val['rom_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[rom_id]' $s>$val[rom_name]</option>"; 

}
?>