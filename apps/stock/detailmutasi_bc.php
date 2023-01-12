<?php 
function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

if($_GET['tg1']){
    session_start();
    require_once "../../webclass.php";
    $db = new kelas();
    $judul = $_GET['tg1'].' - '.$_GET['tg2'];
} else {
    $judul = date('Y')."-".date('m');
}

foreach($db->select("m_barang a join m_satuan b using(id_satuan)","kode_barang,nama_barang,nama_satuan","id_barang = $_GET[id]") as $headsat){}
$bulan = date('m');
$bulan1 = date('m')-1;
$tahun = date('Y');
if($bulan == '12'){
    $tahun1 = date('Y')-1;
} else {
    $tahun1 = date('Y');
}

if($_GET[jns] == 1){$jns = "Baru";} else {$jns = "Bekas/Repair";}
?>
<thead>
    <tr>
        <td colspan="5">Periode : <?php echo $judul;?></td>
        
    </tr>
    <tr>
        <td colspan="2">Kode Barang : <?=$headsat['kode_barang'].' - '.$headsat['nama_barang']?></td>
        <td colspan="2">jenis : <?=$jns?></td>
        <td colspan="1">Satuan : <?=$headsat['nama_satuan']?></td>
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


    if($_GET[tg1] <> '') {
        $tglbet1 = "DATE(tgl_mutasi) < '$_GET[tg1]'";
        $tglbet = "DATE(tgl_mutasi) between '$_GET[tg1]' and '$_GET[tg2]'";
        $judulsaldo = "Saldo Akhir sampai tanggal ".date('Y-m-d', strtotime("-1 day", strtotime($_GET[tg1])));
    } else {
        $tglbet1 = "MONTH(tgl_mutasi) = '$bulan1' and YEAR(tgl_mutasi) = '$tahun1'";
        $tglbet = "MONTH(tgl_mutasi) = '$bulan' and YEAR(tgl_mutasi) = '$tahun'";
        $judulsaldo = "Saldo Bulan Lalu ".$tahun1."-".$bulan1;
    }
    // echo "select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]";
    $selawal = $db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir
           from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*");
    $selmut = $db->select("(select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]) a","*");
     // echo "select 'saldolalu' as no_transmutasi,'$_GET[id]' as id_barang,coalesce(sum(masukmutasi),0) as masukmutasi, coalesce(sum(keluarmutasi),0) as keluarmutasi,'' as tgl_mutasi,(coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir
     //       from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang
     //    union
     //    select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]";
    foreach ($selawal as $awal) {}
           echo "<tr>
            <td colspan='4'>$judulsaldo</td>
            <td>$awal[sdakhir]</td>
            </tr>";
    $totalsdakhir = $awal[sdakhir]; 
    foreach($selmut as $mts){
            echo "<tr>
            <td>$mts[tgl_mutasi]</td>
            <td>$mts[no_transmutasi]</td>
            <td>$mts[masukmutasi]</td>
            <td>$mts[keluarmutasi]</td>
            <td>";$totalsdakhir = ($totalsdakhir+$mts[masukmutasi])-$mts[keluarmutasi];
            echo $totalsdakhir;
            echo "</td>
            </tr>";
        
        $totalmasuk += $mts[masukmutasi];
        $totalkeluar += $mts[keluarmutasi];
    }
    ?>
    <tr>
        <td colspan="2" align="center"><b>Total</b></td>
        <td><?=$totalmasuk?></td>
        <td><?=$totalkeluar?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" align="center"><b>Stok Akhir</b></td>
        <td colspan="1" align="center"><b><?=$totalsdakhir?></b></td>
        
    </tr>
</tbody>
