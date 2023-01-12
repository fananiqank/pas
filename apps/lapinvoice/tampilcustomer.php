
<?php 
if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Customer</option>";
 foreach($db->select("m_customer","*","") as $val){
	if($_GET['cust_id'] == $val['cust_id']) {
		$s = "selected";
	} else {
		$s = "";
	}
	echo "<option value='$val[cust_id]' $s>$val[cust_name]</option>"; 

}
?>