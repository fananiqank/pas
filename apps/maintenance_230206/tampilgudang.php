
<?php 
if($_GET['reload'] == 1){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Gudang</option>";
 foreach($db->select("m_gudang","*","") as $val){
	if($mtc['idgud'] == $val[id_gudang]){$s = "selected";}else{$s="";}
	echo "<option value='$val[id_gudang]' $s>$val[nama_gudang]</option>"; 

}
?>