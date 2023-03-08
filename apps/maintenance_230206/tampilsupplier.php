
<?php 
if($_GET['reload'] == 1){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}
if($mtc['supp_mtc'] != ''){
	$whs = "and supp_id = '$mtc[supp_mtc]'";
} else { $whs= "";}

echo "<option value=''>Pilih Supplier</option>";
 foreach($db->select("m_supplier","*","supp_type = 2 $whs") as $val){
	if($mtc['supp_mtc'] == $val['supp_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[supp_id]' $s>$val[supp_nama]</option>"; 

}
?>