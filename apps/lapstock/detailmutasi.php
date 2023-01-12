<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();
foreach($db->select("m_barang a join m_satuan b using(id_satuan)","kode_barang,nama_barang,nama_satuan","id_barang = $_GET[id]") as $headsat){}
?>
<thead>
    <tr>
        <td colspan="2">Kode Barang : <?=$headsat['kode_barang'].' - '.$headsat['nama_barang']?></td>
        <td colspan="2">Satuan : <?=$headsat['nama_satuan']?></td>
    </tr>
    <tr>
        <th>Tanggal</th>
        <th>No Surat</th>
        <th>Masuk</th>
        <th>Keluar</th>
        <th>Saldo Akhir</th>
    </tr>
</thead>
<tbody class="pre-scrollable">
    <?php 
    if($_GET[gd] <> 'A'){
        $gdg = "and id_gudang = $_GET[gd]";
    } else {
        $gdg = "";
    }

    $selmut = $db->select("tx_mutasi","no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir","id_barang=$_GET[id] $gdg and tgl_mutasi between '$_GET[tg1]' and '$_GET[tg2]'");
    foreach($selmut as $mts){
        echo "<tr>
        <td>$mts[tgl_mutasi]</td>
        <td>$mts[no_transmutasi]</td>
        <td>$mts[masukmutasi]</td>
        <td>$mts[keluarmutasi]</td>
        <td>$mts[sdakhir]</td>
        </tr>";
        $totalmasuk += $mts[masukmutasi];
        $totalkeluar += $mts[keluarmutasi];
    }
    ?>
    <tr>
        <td colspan="2" align="center"><b>Total</b></td>
        <td><?=$totalmasuk?></td>
        <td><?=$totalkeluar?></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><b>Stok Akhir</b></td>
        <td colspan="2" align="center"><b><?=$totalmasuk-$totalkeluar?></b></td>
        
    </tr>
</tbody>
