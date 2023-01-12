
<?php 
if($_GET['reload'] == 1){
session_start();
require_once "../../webclass.php";
$db = new kelas();

}

echo "<option value=''>Pilih Supplier</option>";
 foreach($db->select("(select * from m_supplier where supp_type = 2 union select * from m_supplier where supp_id = 1) a","*","") as $val){
	if($_GET['suppid'] == $val['supp_id']){$s = "selected";}else{$s="";}
	echo "<option value='$val[supp_id]' $s>$val[supp_nama]</option>"; 

}
?>