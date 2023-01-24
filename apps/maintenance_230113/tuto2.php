<?php
require_once "../../lib/fpdf/fpdf.php";

class PDF extends FPDF
{
// Page header
	
	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(24);
      // $this->SetX(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,8,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

require_once "../../webclass.php";
//var_dump($db);
//default 19cm untuk tabel

$db = new kelas();

 function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
      $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
  }
 
   function terbilang($nilai, $style=2) {
    if($nilai<0) {
      $hasil = "minus ". trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    } 
    switch ($style) {
        case 1:
            // mengubah semua karakter menjadi huruf besar
            $hasil = strtoupper($hasil);
            break;
        case 2:
            // mengubah karakter pertama dari setiap kata menjadi huruf besar
            $hasil = ucwords($hasil);
            break;
        case 3:
            // mengubah karakter pertama menjadi huruf besar
            $hasil = ucfirst($hasil);
            break;
    }         
    return $hasil;
  }



foreach($db->select("(SELECT  @rownum:=@rownum+1 norut, a.*, b.cust_name, b.cust_address FROM `tx_invoice` a JOIN m_customer b ON a.cust_id=b.cust_id JOIN (SELECT @rownum:=0) r) a where a.inv_id='$_GET[id]'","*") as $val2){};

$pdf = new PDF("P","cm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();

//$pdf->Image('pratama.jpg',10,10,189);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(19,0.7,"Printed On : ".date("D-d/m/Y"),0,0,'R');
$pdf->ln(1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(4,0.7,"Kepada Yth :",0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(4,0,"Pimpinan ".$val2[cust_name],0,0,'L');
$pdf->ln(1);

$pdf->SetFont('Arial','BU',10);
$pdf->Cell(19,0.7,"INVOICE",0,1,'C');
$pdf->SetFont('Arial','IB',10);
$pdf->Cell(19,0,$val2[inv_no],0,1,'C');
$pdf->ln(0.3);

////////////// TABEL INV ////////////////////
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1, 1.6, 'NO', 1, 0, 'C');
$pdf->Cell(4, 1.6, 'Uraian', 1, 0, 'C');
$pdf->Cell(2, 1.6, 'Ritase', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Tonase', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Jarak', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Harga', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(0, 0.8, '', 1, 1, 'C'); //CELL BARIS ATAS

$pdf->Cell(7, 0.8, '', 0, 0, 'C');
$pdf->Cell(3, 0.8, '( Matrix Ton ) ', 1, 0, 'C');
$pdf->Cell(2, 0.8, '( Km ) ', 1, 0, 'C');
$pdf->Cell(3, 0.8, '( TON / Km ) ', 1, 0, 'C');
$pdf->Cell(4, 0.8, '( Rp ) ', 1, 0, 'C');
$pdf->Cell(0, 0.8, '', 1, 1, 'C'); //CELL BARIS Bawah

$no =1;
foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$_GET[id]') a","*") as $val){

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1, 0.8, $val[norut], 1, 0, 'C');
	$pdf->Cell(4, 0.8, $val[invdtl_uraian], 1, 0, 'C');
	$pdf->Cell(2, 0.8, $val[invdtl_ritase], 1, 0, 'C');
	$pdf->Cell(3, 0.8, $val[invdtl_tonase], 1, 0, 'C');
	$pdf->Cell(2, 0.8, $val[invdtl_jarak], 1, 0, 'C');
	$pdf->Cell(3, 0.8, number_format($val[invdtl_harga],2), 1, 0, 'R');
	$pdf->Cell(4, 0.8, number_format($val[invdtl_jumlah],2), 1, 0, 'R');
	$pdf->Cell(0, 0.8, '', 1, 1, 'C'); //CELL BARIS ATAS
$no++;
}
$pdf->SetFont('Arial','',10);
$pdf->Cell(15, 0.8, "Sub Total", 1, 0, 'R');
$pdf->Cell(4, 0.8, number_format($val2[inv_subtotal],2), 1, 1, 'R');


$pdf->Cell(15, 0.8, "PPN 10%", 1, 0, 'R');
$pdf->Cell(4, 0.8, number_format($val2[inv_ppn],2), 1, 1, 'R');

$pdf->Cell(15, 0.8, "PPh (2%)", 1, 0, 'R');
$pdf->Cell(4, 0.8, number_format($val2[inv_pph],2), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(15, 0.8, "Grand Total", 1, 0, 'R');
$pdf->Cell(4, 0.8, number_format($val2[inv_grandtotal],2), 1, 1, 'R');

$pdf->SetFont('Arial','i',10);
$pdf->Cell(2, 0.8, "Terbilang :", 0, 0, 'R');
$pdf->MultiCell(17, 0.8, terbilang($val2[inv_grandtotal])." Rupiah", 0, 1);

//////////////////// END OF DATA TABLE /////////////////////////////////////////

$pdf->ln(0.5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(2, 0.8, "Mohon di transfer ke :", 0, 1, 'L');
$pdf->Cell(3.3, 0.8, "BANK", 0, 0, 'L');
$pdf->Cell(6, 0.8, ": BRI", 0, 1, 'L');
$pdf->Cell(3.3, 0, "No. REKENING", 0, 0, 'L');
$pdf->Cell(6, 0, ": 000901002852308", 0, 1, 'L');
$pdf->Cell(3.3, 0.8, "A.N", 0, 0, 'L');
$pdf->Cell(6, 0.8, ": PT. PRATAMA ABADI SENTOSA", 0, 1, 'L');

$pdf->ln(1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(17, 0.8, "Blitar, ".date("d/m/Y",strtotime($val2[inv_tgl])), 0, 1, 'R');
$pdf->Cell(16.8, 0, "Hormat Kami, ", 0, 1, 'R');

$pdf->ln(2);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(16.8, 0.8, "AGUS FAUZI", 0, 1, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(16.9, 0, "Direktur Utama", 0, 1, 'R');




#output file PDF
$pdf->Output("".$val2[inv_no]."pdf","I");