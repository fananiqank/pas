<?php
require_once "../../lib/fpdf/fpdf.php";


class PDF extends FPDF
{
// Page header
  
  function Header()
  {
      // Logo  //posisi, posisi tinggi ,besar
      $this->Image('../../assets/image/KOP PAS.jpg',10,1,190); 
      // Line break
      $this->SetLineWidth(0.5);
      $this->Line(10,30,200,30);
      $this->SetLineWidth(1);
      $this->Line(10,31,200,31);
      $this->Ln(25);
  }

  // Page footer
  function Footer()
  {
      // Position at 1.5 cm from bottom
      $this->SetY(-15);
      // Arial italic 8
      $this->SetFont('Arial','I',8);
      // Page number
      $this->Cell(0,10,'Halaman '.$this->PageNo().'/{nb}',0,0,'C');
  }

  function garis_tabel(){
    $this->SetLineWidth(0.5);
    $this->Line(10,77,200,77);
  }
  
}



require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, b.arm_norangka,b.arm_nopol,b.arm_nolambung FROM m_armada b JOIN (SELECT @rownum:=0) r where b.arm_id='$_GET[id]') a","*") as $val2){};

$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*,DATE(a.tgl_mtc) as tglshow,b.arm_norangka,b.arm_nopol,b.arm_nolambung,supp_nama FROM tx_maintenance a JOIN m_armada b ON a.arm_id=b.arm_id JOIN (SELECT @rownum:=0) r JOIN m_supplier c on a.supp_mtc=c.supp_id where a.no_mtc='$_GET[mtc]') a","*") as $val){};

$pdf = new PDF("P","mm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();


// $pdf->gbr('./pratama.png');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(190,7,"MAINTENANCE",0,0,'C');
$pdf->ln(12);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"No Rangka        :",0,0,'L');
$pdf->Cell(70,5,$val[arm_norangka],0,0,'L');
$pdf->Cell(60,5,"No Pol :",0,0,'R');
$pdf->Cell(25,5,$val[arm_nopol],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"No Lambung     :",0,0,'L');
$pdf->Cell(70,5,$val[arm_nolambung],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"No Mtc               :",0,0,'L');
$pdf->Cell(70,5,$val[no_mtc],0,0,'L');
$pdf->Cell(60,5,"Tanggal :",0,0,'R');
$pdf->Cell(25,5,$val[tglshow],0,1,'L');
$pdf->ln(2);
// $pdf->garis();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"Supplier            :",0,0,'L');
$pdf->Cell(70,5,$val[supp_nama],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,"Keterangan       :",0,0,'L');
$pdf->Cell(70,5,$val[keterangan_mtc],0,1,'L');
$pdf->ln(2);
$pdf->garis_tabel();

$pdf->ln(2);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60, 5, 'Mekanik', 1, 0, 'C');
$pdf->Cell(70, 5, 'Jasa', 1, 0, 'C');
$pdf->Cell(60, 5, 'Biaya', 1, 1, 'C');

  foreach($db->select("tx_mekanik a join m_mekanik b using(id_mekanik)","a.*,b.name_mekanik","id_mtc=$val[id_mtc]") as $bj){
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(60, 5, $bj['name_mekanik'], 1, 0, 'L');
  $pdf->Cell(70, 5, $bj['pekerjaan'], 1, 0, 'L');
  $pdf->Cell(60, 5, number_format($bj['biaya']), 1, 1, 'R');
  $totaljasa += $bj[biaya];
  }
$pdf->SetFont('Arial','B',10);
$pdf->Cell(130, 5, 'Sub Total Biaya Jasa', 1, 0, 'R');
$pdf->Cell(60, 5, number_format($totaljasa), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60, 5, 'Material/Part', 1, 0, 'C');
$pdf->Cell(30, 5, 'Jumlah', 1, 0, 'C');
$pdf->Cell(40, 5, 'Biaya Satuan', 1, 0, 'C');
$pdf->Cell(60, 5, 'Biaya Total', 1, 1, 'C');

foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
                                             join m_barang c on b.id_barang=c.id_barang
                                             join (SELECT * FROM `tx_mutasi` where jenismutasi='2') d on a.no_mtc=d.no_transmutasi  and d.id_barang=c.id_barang",
                                             "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
                                             CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){ 
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(60, 5, $dtlmtc[nama_barang], 1, 0, 'L');
  $pdf->Cell(30, 5, $dtlmtc[keluarmutasi], 1, 0, 'C');
  $pdf->Cell(40, 5, number_format($dtlmtc[hargajual]), 1, 0, 'R');
  $pdf->Cell(60, 5, number_format($totalmat=$dtlmtc[keluarmutasi]*$dtlmtc[hargajual]), 1, 1, 'R');
  $totalmaterial += $totalmat; 
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(130, 5, 'Sub Total Biaya Jasa', 1, 0, 'R');
$pdf->Cell(60, 5, number_format($totalmaterial), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(130, 5, 'Grand Total', 1, 0, 'R');
$pdf->Cell(60, 5, number_format($totaljasa+$totalmaterial), 1, 1, 'R');

// $pdf->ln(5);
// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(60, 5, 'Sparpart', 1, 0, 'C');
// $pdf->Cell(40, 5, 'Jenis', 1, 0, 'C');
// $pdf->Cell(25, 5, 'Qty Keluar', 1, 0, 'C');
// $pdf->Cell(25, 5, 'Qty Masuk', 1, 0, 'C');
// $pdf->Cell(40, 5, 'Harga', 1, 1, 'C');

// $pdf->SetFont('Arial','i',10);
// $pdf->Cell(190, 5, 'Pemasangan', 1, 1, 'L');

// foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
//                                              join m_barang c on b.id_barang=c.id_barang
//                                              join tx_mutasi d on a.no_mtc=d.no_transmutasi and jenismutasi=2",
//                                              "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
//                                              CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){
// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(60, 5, $dtlmtc[nama_barang], 1, 0, 'L');
// $pdf->Cell(40, 5, $dtlmtc[statusbrg], 1, 0, 'L');
// $pdf->Cell(25, 5, $dtlmtc[keluarmutasi], 1, 0, 'C');
// $pdf->Cell(25, 5, $dtlmtc[masukmutasi], 1, 0, 'C');
// $pdf->Cell(40, 5, number_format($dtlmtc[hargajual]), 1, 1, 'R');

// $totaljual += $dtlmtc[hargajual];

// }
// $pdf->SetFont('Arial','i',10);
// $pdf->Cell(190, 5, 'Pelepasan', 1, 1, 'L');

// foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
//                                              join m_barang c on b.id_barang=c.id_barang
//                                              join tx_mutasi d on a.no_mtc=d.no_transmutasi and jenismutasi=1",
//                                              "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
//                                              CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){

// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(60, 5, $dtlmtc[nama_barang], 1, 0, 'L');
// $pdf->Cell(40, 5, $dtlmtc[statusbrg], 1, 0, 'L');
// $pdf->Cell(25, 5, $dtlmtc[keluarmutasi], 1, 0, 'C');
// $pdf->Cell(25, 5, $dtlmtc[masukmutasi], 1, 0, 'C');
// $pdf->Cell(40, 5, number_format($dtlmtc[hargajual]), 1, 1, 'R');
 
//  $totaljual += $dtlmtc[hargajual];

// }

// $pdf->Cell(150,5,"Biaya Jasa",1,0,'L');
// $pdf->Cell(40, 5, number_format($val[harga_mtc]), 1, 1, 'R');
// $totalall = $totaljual+$val[harga_mtc];

// $pdf->Cell(150,5,"Total",1,0,'L');
// $pdf->Cell(40, 5, number_format($totalall), 1, 0, 'R');



#output file PDF
$pdf->Output("".$val[arm_norangka].".pdf","I");