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
foreach($db->select("(select * 
    from tx_barangkeluar a 
    JOIN m_gudang using(id_gudang)
    join m_site using(id_site) where id_brgkeluar='$_GET[id]') a","*") as $val){}

$pdf = new PDF("P","mm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();


// $pdf->gbr('./pratama.png');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(190,7,"Barang Keluar",0,0,'C');
$pdf->ln(15);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"No Transaksi        :",0,0,'L');
$pdf->Cell(50,5,$val[no_brgkeluar],0,0,'L');
$pdf->Cell(60,5,"Tanggal :",0,0,'R');
$pdf->Cell(25,5,date("d/m/Y",strtotime($val2[date_brgkeluar])),0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"Site                        :",0,0,'L');
$pdf->Cell(50,5,$val[nama_site],0,0,'L');
$pdf->Cell(60,5,"Gudang  :",0,0,'R');
$pdf->Cell(25,5,$val[nama_gudang],0,1,'L');
$pdf->ln(2);
$pdf->garis();

$pdf->ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10, 5, 'No', 1, 0, 'C');
$pdf->Cell(30, 5, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(50, 5, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(20, 5, 'Qty', 1, 0, 'C');
$pdf->Cell(20, 5, 'Jenis', 1, 0, 'C');
$pdf->Cell(30, 5, 'Remark', 1, 0, 'C');
$pdf->Cell(30, 5, 'Supplier', 1, 1, 'C');

$no=1;

 foreach($db->select("(select kode_barang, nama_barang, qty, nama_satuan,case when a.jenisbrg = 1 then 'Baru' when a.jenisbrg = 2 then 'Repair/Bekas' else '-' end jenisbarang, case when a.status_pakai = '1' then 'Service' when a.status_pakai = '2' then 'Rusak' else '-' end statuspakai from 
                 tx_barangkeluardtl a
                 JOIN m_barang using(id_barang)
                 JOIN m_satuan using(id_satuan)
                 left join m_supplier using(supp_id)
                 where id_brgkeluar='$_GET[id]') a","*") as $bj){

  $pdf->SetFont('Arial','',10);
  $pdf->Cell(10, 5, $no, 1, 0, 'C');
  $pdf->Cell(30, 5, $bj['kode_barang'], 1, 0, 'L');
  $pdf->Cell(50, 5, $bj['nama_barang'], 1, 0, 'L');
  $pdf->Cell(20, 5, $bj['qty'], 1, 0, 'C');
  $pdf->Cell(20, 5, $bj['jenisbarang'], 1, 0, 'L');
  $pdf->Cell(30, 5, $bj['statuspakai'], 1, 0, 'L');
  $pdf->Cell(30, 5, $bj['supplier'], 1, 1, 'L');

  $no++;
  }



#output file PDF
$pdf->Output("".$val[arm_norangka].".pdf","I");