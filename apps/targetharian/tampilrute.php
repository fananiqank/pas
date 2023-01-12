
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Rute</option>";
 foreach($db->select("m_rutejarak a JOIN m_runofmine b USING (rom_id)
						JOIN m_tujuan c USING (tujuan_id)","a.*, rom_name, tujuan_name","") as $val){
	if($_GET['rutejarak_id'] == $val['rutejarak_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[rutejarak_id]' $s>$val[rom_name] - $val[tujuan_name] ($val[rutejarak_jarak] km)</option>"; 

}
?>