
<?php 
if($_GET['reload'] == 1){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Gudang</option>";
 foreach($db->select("m_gudang","*","id_gudang <> '$_GET[id]'") as $val){
	
	echo "<option value='$val[id_gudang]'>$val[nama_gudang]</option>"; 

}
?>