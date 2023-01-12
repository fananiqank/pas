
<?php 
if($_GET['reload'] == 1){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Supplier</option>";
 foreach($db->select("m_supplier","*","supp_type = 1") as $val){
	
	echo "<option value='".$val[supp_id].'_'.$val[supp_nama]."'>$val[supp_nama]</option>"; 

}
?>