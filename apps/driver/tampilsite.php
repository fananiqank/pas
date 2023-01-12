
<?php 
if($_GET['siteid']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Rute</option>";
 foreach($db->select("m_site","*","") as $val){
	if($_GET['siteid'] == $val['id_site']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_site]' $s>$val[nama_site]</option>"; 

}
?>