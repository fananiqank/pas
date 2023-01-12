<?php
$id = $_GET['id'];
$jns  = $_GET['jns'];

// echo $id;

require_once "../../webclass.php";
$db = new kelas();

if($_GET[id]){
    $AND = "AND id_gudang = '$_GET[id]' and jenisbrg ='$_GET[jns]'";
} else {
    $AND = "";
}


header("Content-type: application/vnd-ms-excel");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=laporan-stok.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

    ?>
 <div align="center">LAPORAN STOK</div>
 <table border="1">
  <tr>
    <th align="center">Kode</th>
    <th align="center">Nama</th>
    <th align="center">Stok</th>
  </tr>

  <?php

foreach ($db->select("(SELECT a.id_barang, a.kode_barang, a.nama_barang,ifnull((SELECT sum(masukmutasi-keluarmutasi)from tx_mutasi WHERE id_barang = a.id_barang $AND group by id_barang),0)as stok FROM m_barang a) b ","*")as $value) {  
    echo "<tr>
            <td>".$value['kode_barang']."</td>
            <td>".$value['nama_barang']."</td>
            <td>".$value['stok']."</td>
    </tr>";
}
//var_dump($value);
?>
