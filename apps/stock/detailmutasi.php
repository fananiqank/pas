<?php 
$tglSkrng = date('Y-m-d');

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

if($_GET['tg1'] && $_GET['r'] <> 1){
    session_start();
    require_once "../../webclass.php";
    $db = new kelas();
    $judul = $_GET['tg1'].' - '.$_GET['tg2'];
} else if($_GET['r'] == 1){
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
        <td colspan="6">Periode : <?php echo $judul;?></td>
        
    </tr>
    <tr>
        <td colspan="3">Kode Barang : <?=$headsat['kode_barang'].' - '.$headsat['nama_barang']?></td>
        <td colspan="2">jenis : <?=$jns?></td>
        <td colspan="1">Satuan : <?=$headsat['nama_satuan']?></td>
    </tr>
    <tr>
        
        <th>Tanggal</th>
        <th>No Surat</th>
        <th>Keterangan</th>
        <th>Masuk</th>
        <th>Keluar</th>
        <th>Saldo Akhir</th>
    </tr>
</thead>
<tbody class="pre-scrollable">
    <?php 
    if($_GET[gd] <> 'A'){
        $gdg = "and a.id_gudang = $_GET[gd]";
    } else {
        $gdg = "";
    }


    if($_GET[tg1] <> '') {
        $tglbet1 = "DATE(tgl_mutasi) < '$_GET[tg1]'";
        $tglbet = "DATE(tgl_mutasi) between '$_GET[tg1]' and '$_GET[tg2]'";
        $judulsaldo = "Saldo Akhir sampai tanggal ".date('Y-m-d', strtotime("-1 day", strtotime($_GET[tg1])));
    } else {
        $tglbet1 = "MONTH(tgl_mutasi) = '$bulan1' and YEAR(tgl_mutasi) = '$tahun1'";
        //$tglbet = "MONTH(tgl_mutasi) = '$bulan' and YEAR(tgl_mutasi) = '$tahun'";
        $tglbet = "YEAR(tgl_mutasi) = '$tahun'";
        $judulsaldo = "Saldo Bulan Lalu ".$tahun1."-".$bulan1;
    }
    // echo "select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]";
    foreach ($db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir,date(tgl_mutasi)as tglsaldo
           from tx_mutasi a where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*") as $ax){}

    if($_GET[tg1] > $ax[tglsaldo] ){

    	 if($_GET[tg1] > $tglSkrng){
    	 	$selawal = $db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir,date(tgl_mutasi)as tglsaldo from tx_mutasi a where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*");

    	 	foreach ($selawal as $awal) {}
           echo "<tr>
            <td colspan='5'>$judulsaldo</td>
            <td>$awal[sdakhir]</td>
            </tr>";
    		$totalsdakhir = $awal[sdakhir];

    	 }else{
    	 	
	    	$selmut = $db->select("(select no_transmutasi,id_barang,sum(masukmutasi) masukmutasi,sum(keluarmutasi) keluarmutasi,tgl_mutasi,sum(sum(masukmutasi)-sum(keluarmutasi)) over (ORDER BY tgl_mutasi,no_transmutasi) as sdakhir from (
select 'Saldo Akhir Tanggal Sebelumnya' as no_transmutasi,sum(masukmutasi) masukmutasi,sum(keluarmutasi) keluarmutasi,id_barang,'' as tgl_mutasi 
from tx_mutasi a where id_barang=68 and a.id_gudang = 2 and jenisbrg = 1 and DATE(tgl_mutasi) < '$_GET[tg1]'
union 
select no_transmutasi,sum(masukmutasi) masukmutasi,sum(keluarmutasi) keluarmutasi,id_barang,tgl_mutasi
from tx_mutasi a where id_barang=68 and a.id_gudang = 2 and jenisbrg = 1 and DATE(tgl_mutasi) between '$_GET[tg1]' and '$_GET[tg2]' GROUP BY no_transmutasi,tgl_mutasi) a GROUP BY no_transmutasi,tgl_mutasi ORDER BY tgl_mutasi) a","*");
    	 }	 

    }

    else{
    	
    	$selmut = $db->select("(select no_transmutasi,id_barang,sum(masukmutasi) masukmutasi,sum(keluarmutasi) keluarmutasi,tgl_mutasi,sum(sum(masukmutasi)-sum(keluarmutasi)) over (ORDER BY tgl_mutasi,no_transmutasi) as sdakhir
from (
select 'Saldo Akhir Bulan Sebelumnya' as no_transmutasi,sum(masukmutasi) masukmutasi,sum(keluarmutasi) keluarmutasi,id_barang,'' as tgl_mutasi 
from tx_mutasi a where id_barang=$_GET[id] $gdg and jenisbrg = $_GET[jns] and concat(YEAR(tgl_mutasi),MONTH(tgl_mutasi)) < concat(YEAR(now()),MONTH(now()))
union
select no_transmutasi,sum(masukmutasi) masukmutasi,sum(keluarmutasi) keluarmutasi,id_barang,tgl_mutasi
from tx_mutasi a where id_barang=$_GET[id] $gdg and jenisbrg = $_GET[jns] and concat(YEAR(tgl_mutasi),MONTH(tgl_mutasi)) = concat(YEAR(now()),MONTH(now())) GROUP BY no_transmutasi,tgl_mutasi) a GROUP BY no_transmutasi,tgl_mutasi ORDER BY tgl_mutasi
) a","*");
        
    }

    // $selmut = $db->select("(select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]) a","*");

    

     // echo "select 'saldolalu' as no_transmutasi,'$_GET[id]' as id_barang,coalesce(sum(masukmutasi),0) as masukmutasi, coalesce(sum(keluarmutasi),0) as keluarmutasi,'' as tgl_mutasi,(coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir
     //       from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang
     //    union
     //    select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,(masukmutasi-keluarmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]";

    

    foreach($selmut as $mts){

        if(substr($mts[no_transmutasi], 0,2) == 'MT'){
            foreach($db->select("tx_maintenance b join m_armada d on b.arm_id=d.arm_id","concat('Maintenance Armada : ',substr(d.arm_norangka,-5),' - ',d.arm_nolambung) as keterangan","no_mtc='$mts[no_transmutasi]'") as $mtc){}
                $notamutasi = "<a href='apps/maintenance/pdfmtc.php?id=1&mtc=$mts[no_transmutasi]' target='_blank'>$mts[no_transmutasi]</a>";
                $remarks= $mtc[keterangan];
        } else if(substr($mts[no_transmutasi], 0,2) == 'BM'){
            foreach($db->select("tx_barangmasuk","concat('Terima dari Supplier : ',nama_supp) as keterangan,id_brgmasuk","no_brgmasuk='$mts[no_transmutasi]' and substr(no_brgmasuk,1,2) = 'BM'") as $mtc){}
                $notamutasi = "<a href='apps/barangmasuk/cetak_pdf.php?id=$mtc[id_brgmasuk]' target='_blank'>$mts[no_transmutasi]</a>";
                $remarks= $mtc[keterangan];
        } else if(substr($mts[no_transmutasi], 0,2) == 'SO'){
            foreach($db->select("tx_stockopname","concat('Stock Opname tgl : ',DATE(inputdt_so)) as keterangan","noso='$mts[no_transmutasi]'") as $mtc){}
                $notamutasi = $mts[no_transmutasi];
                $remarks= $mtc[keterangan];
        } else if(substr($mts[no_transmutasi], 0,2) == 'BK'){
            foreach($db->select("tx_barangkeluar","concat('Barang Keluar : ',DATE(date_brgkeluar)) as keterangan,id_brgkeluar","no_brgkeluar='$mts[no_transmutasi]'") as $mtc){}
                $notamutasi = "<a href='apps/barangkeluar/cetak_pdf.php?id=$mtc[id_brgkeluar]' target='_blank'>$mts[no_transmutasi]</a>";
                $remarks= $mtc[keterangan];
        } else {
            $notamutasi = "-";
            $remarks = $mts[no_transmutasi];
        }
            echo "<tr>
            <td>$mts[tgl_mutasi]</td>
            <td>$notamutasi</td>
            <td>$remarks</td>
            <td>$mts[masukmutasi]</td>
            <td>$mts[keluarmutasi]</td>
            <td>$mts[sdakhir]</td>
            </tr>";
        
        $totalmasuk += $mts[masukmutasi];
        $totalkeluar += $mts[keluarmutasi];
        $toalsaldo =$mts[sdakhir];
        
    }
    ?>
    <tr>
        <td colspan="3" align="center"><b>Total</b></td>
        <td><?=$totalmasuk?></td>
        <td><?=$totalkeluar?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5" align="center"><b>Stok Akhir</b></td>
        <td colspan="1" align="center"><b><?=$toalsaldo?></b></td>
        
    </tr>
</tbody>
