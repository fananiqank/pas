<?php
require_once "../../lib/fpdf/fpdf.php";


class PDF extends FPDF
{
// Page header
  
  // Page footer


  function gbr($gambar){
  //memasukkan gambar untuk header
  $this->Image($gambar,10,10,20,25);
  //menggeser posisi sekarang
  }

  function garis(){
    $this->SetLineWidth(0.5);
    $this->Line(10,40,200,40);
    // $this->SetLineWidth(0);
    // $this->Line(10,36,190,36);
  }
  function garis2(){
    $this->SetLineWidth(1);
    $this->Line(10,56,200,56);
    // $this->SetLineWidth(0);
    // $this->Line(10,36,190,36);
  }
  function garis3(){
    $this->SetLineWidth(0.5);
    $this->Line(10,30,200,30);
    // $this->SetLineWidth(0);
    // $this->Line(10,36,190,36);
  }
  
}

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



require_once "../../webclass.php";
$db = new kelas();

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


$pdf = new PDF("P","mm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','BU',12);
$pdf->Cell(190,7,"KARTU STOK",0,1,'C');
$pdf->ln(2);

$pdf->SetFont('Arial','',9);
$pdf->Cell(21,5,"Periode         : ",0,0,'L');
$pdf->Cell(165,5,$judul,0,1,'L');

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,5,"Kode Barang : ".$headsat['kode_barang'].' - '.$headsat['nama_barang'],0,0,'L');
$pdf->Cell(40,5,"Jenis : ".$jns,0,0,'C');
$pdf->Cell(30,5,"Satuan : ".$headsat['nama_satuan'],0,1,'C');
$pdf->ln(2);
$pdf->garis3();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,5,"Tanggal",1,0,'C');
$pdf->Cell(60,5,"No Surat",1,0,'C');
$pdf->Cell(20,5,"Masuk",1,0,'C');
$pdf->Cell(20,5,"Keluar",1,0,'C');
$pdf->Cell(30,5,"Saldo Akhir",1,1,'C');

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
        //$tglbet = "MONTH(tgl_mutasi) = '$bulan' and YEAR(tgl_mutasi) = '$tahun'";
        $tglbet = "YEAR(tgl_mutasi) = '$tahun'";
        $judulsaldo = "Saldo Bulan Lalu ".$tahun1."-".$bulan1;
    }


    foreach ($db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir,date(tgl_mutasi)as tglsaldo
           from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*") as $ax){}

    if($_GET[tg1] > $ax[tglsaldo] ){ 

       if($_GET[tg1] >= $tglSkrng){
        $selawal = $db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir,date(tgl_mutasi)as tglsaldo
           from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*");

        foreach ($selawal as $awal) {}

        $totalsdakhir = $awal[sdakhir];

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(160,5,$judulsaldo,1,0,'L');
        $pdf->Cell(30,5,$totalsdakhir,1,1,'C');

       }else{
        $tglbet = "DATE(tgl_mutasi) between '$ax[tglsaldo]' and '$_GET[tg2]'";

        $selawal = $db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir,date(tgl_mutasi)as tglsaldo
             from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*");

        foreach ($selawal as $awal) {}

        $totalsdakhir = $awal[sdakhir];

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(160,5,$judulsaldo,1,0,'L');
        $pdf->Cell(30,5,$totalsdakhir,1,1,'C');

        $selmut = $db->select("(select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,sum(masukmutasi-keluarmutasi) over (ORDER BY tgl_mutasi,no_transmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]) a","*");
       }   

    }

    else{
      $selawal = $db->select("(select (coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdakhir
           from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet1 and jenisbrg = $_GET[jns] GROUP BY id_barang) a","*");

      $selmut = $db->select("(select no_transmutasi,id_barang,masukmutasi,keluarmutasi,tgl_mutasi,sum(masukmutasi-keluarmutasi) over (ORDER BY tgl_mutasi,no_transmutasi) as sdakhir from tx_mutasi where id_barang=$_GET[id] $gdg and $tglbet and jenisbrg = $_GET[jns]) a","*");
    }

    foreach($selmut as $mts){

      $pdf->SetFont('Arial','',9);
      $pdf->Cell(60,5,$mts[tgl_mutasi],1,0,'L');
      $pdf->Cell(60,5,$mts[no_transmutasi],1,0,'L');
      $pdf->Cell(20,5,$mts[masukmutasi],1,0,'C');
      $pdf->Cell(20,5,$mts[keluarmutasi],1,0,'C');
      $pdf->Cell(30,5,$mts[sdakhir],1,1,'R');
        
        $totalmasuk += $mts[masukmutasi];
        $totalkeluar += $mts[keluarmutasi];
        $toalsaldo =$mts[sdakhir];
    }

      $pdf->SetFont('Arial','',9);
      $pdf->Cell(120,5,"Total",1,0,'R');
      $pdf->Cell(20,5,$totalmasuk,1,0,'C');
      $pdf->Cell(20,5,$totalkeluar,1,0,'C');
      $pdf->Cell(30,5,"",1,1,'C');

      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(120,5,"Stok Akhir",1,0,'R');
      $pdf->Cell(70,5,$toalsaldo,1,1,'R');



#output file PDF
$pdf->Output("TES.pdf","I");