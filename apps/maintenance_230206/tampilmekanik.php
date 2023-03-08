
<?php 
if($_GET['reload']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

if($mtc[supp_mtc] != ''){
	$getsupp = $mtc['supp_mtc'];
} else {
	$getsupp = $_GET['suppid'];
}

echo "<option value=''>Pilih Mekanik</option>";
 foreach($db->select("m_mekanik","*","status_mekanik = 1 and supp_id = '$getsupp'") as $val){
	if($_GET['id_mekanik'] == $val['id_mekanik']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[id_mekanik]' $s>$val[name_mekanik]</option>"; 

}
?>