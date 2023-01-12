
<?php 
if($_GET['reload']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Supplier</option>";
 foreach($db->select("m_supplier","*","supp_type=3") as $val){
	if($_GET['suppid'] == $val['supp_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[supp_id]' $s>$val[supp_nama]</option>"; 

}
?>