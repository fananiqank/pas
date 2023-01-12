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
    $this->Line(10,55,200,55);
    // $this->SetLineWidth(0);
    // $this->Line(10,36,190,36);
  }
  
}



require_once "../../webclass.php";
$db = new kelas();


$no=1;
foreach($db->select("(SELECT * FROM tx_barangmasuk where id_brgmasuk='$_GET[id]') a","*") as $val){}

$pdf = new PDF("P","mm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();


// $pdf->gbr('./pratama.png');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(190,7,"Barang Masuk",0,0,'C');
$pdf->ln(15);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"No Transaksi        :",0,0,'L');
$pdf->Cell(50,5,$val[no_brgmasuk],0,0,'L');
$pdf->Cell(60,5,"Supplier :",0,0,'R');
$pdf->Cell(25,5,$val[nama_supp],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"No SPJ                  :",0,0,'L');
$pdf->Cell(50,5,$val[no_sj],0,0,'L');
$pdf->Cell(60,5,"Tanggal  :",0,0,'R');
$pdf->Cell(25,5,date("d/m/Y",strtotime($val[date_brgmasuk])),0,1,'L');
$pdf->ln(2);
$pdf->garis();

$pdf->ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10, 5, 'No', 1, 0, 'C');
$pdf->Cell(30, 5, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(50, 5, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(20, 5, 'Qty', 1, 0, 'C');
$pdf->Cell(20, 5, 'Satuan', 1, 0, 'C');
$pdf->Cell(30, 5, 'Harga', 1, 0, 'C');
$pdf->Cell(30, 5, 'Jumlah', 1, 1, 'C');

$no=1;

  foreach($db->select("(SELECT a.*, b.nama_barang, b.kode_barang, c.nama_satuan FROM `tx_barangmasukdtl` a join m_barang b ON a.id_barang=b.id_barang
                         join m_satuan c on c.id_satuan=b.id_satuan
                         where id_brgmasuk='$_GET[id]') a","*") as $bj){
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(10, 5, $no, 1, 0, 'C');
  $pdf->Cell(30, 5, $bj['kode_barang'], 1, 0, 'L');
  $pdf->Cell(50, 5, $bj['nama_barang'], 1, 0, 'L');
  $pdf->Cell(20, 5, $bj['qty'], 1, 0, 'C');
  $pdf->Cell(20, 5, $bj['nama_satuan'], 1, 0, 'C');
  $pdf->Cell(30, 5, number_format($bj['harga']), 1, 0, 'R');
  $pdf->Cell(30, 5, number_format($bj[harga]*$bj[qty]), 1, 1, 'R');

  $ttl+=$bj[harga]*$bj[qty];
  $no++;
  }
$pdf->SetFont('Arial','B',10);
$pdf->Cell(130, 5, 'Total', 1, 0, 'R');
$pdf->Cell(60, 5, number_format($ttl), 1, 1, 'R');




#output file PDF
$pdf->Output("".$val[arm_norangka].".pdf","I");