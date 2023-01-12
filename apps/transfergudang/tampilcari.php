
<?php 
if($_GET['reload'] == 1){
session_start();
require_once "../../webclass.php";
$db = new kelas();
}

echo "<option value=''>Pilih Barang</option>";
// echo "select * from m_barang where id_dep = '$_GET[dep]' and id_sub = '$_GET[sub]' and id_kat = '$_GET[kat]' and createdby_brgmasuk = '$_SESSION[ID_PEG]' and id_barang NOT IN (select id_barang from tx_barangmasukdtl where status_brgmasukdtl = 0)";
// echo "select a.*,CONCAT(id_barang,'_',kode_barang,'_',nama_barang,'_',a.id_satuan'_',nama_satuan) as idcon from m_barang a JOIN m_satuan b ON a.id_satuan=b.id_satuan where id_dep = '$_GET[dep]' and id_sub = '$_GET[sub]' and id_kat = '$_GET[kat]'  and id_barang NOT IN (select id_barang from tx_barangmasukdtl where status_brgmasukdtl = 0)";
  foreach($db->select("m_barang a JOIN m_satuan b ON a.id_satuan=b.id_satuan",
					"a.*,CONCAT(a.id_barang,'_',a.id_satuan,'_',b.nama_satuan) as idcon","") as $val){
	echo "<option value='$val[idcon]'>$val[kode_barang] - $val[nama_barang] - $val[stok]</option>"; 

}

?>