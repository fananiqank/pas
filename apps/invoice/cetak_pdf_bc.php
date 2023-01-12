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

  function tanggal_indo($tanggal, $cetak_hari = false) {
    $hari = array ( 1 =>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');        
    $bulan = array (1 =>'Januari',
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
    $split    = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
  
    if ($cetak_hari) {
      $num = date('N', strtotime($tanggal));
      return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
  }



foreach($db->select("(SELECT  @rownum:=@rownum+1 norut, a.*, b.cust_name, b.cust_address FROM `tx_invoice` a JOIN m_customer b ON a.cust_id=b.cust_id JOIN (SELECT @rownum:=0) r) a where a.inv_id='$_GET[id]'","*") as $val2){};

$pdf = new PDF("P","mm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();

//$pdf->Image('pratama.jpg',10,10,189);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,10,"Printed On : ".date("D-d/m/Y"),0,0,'R');
$pdf->ln(5);

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,"Kepada Yth :",0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,"Pimpinan PT. ".$val2[cust_name],0,1,'L');
$pdf->Cell(40,5,$val2[cust_address],0,1,'L');
$pdf->ln(5);

$pdf->SetFont('Arial','BU',10);
$pdf->Cell(190,5,"INVOICE",0,1,'C');
$pdf->SetFont('Arial','IB',10);
$pdf->Cell(190,5,$val2[inv_no],0,1,'C');
$pdf->ln(5);

////////////// TABEL INV ////////////////////
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10, 10, 'NO', 1, 0, 'C');
$pdf->Cell(40, 10, 'Uraian', 1, 0, 'C');
$pdf->Cell(20, 10, 'Ritase', 1, 0, 'C');
$pdf->Cell(30, 5, 'Tonase', 1, 0, 'C');
$pdf->Cell(20, 5, 'Jarak', 1, 0, 'C');
$pdf->Cell(30, 5, 'Harga', 1, 0, 'C');
$pdf->Cell(40, 5, 'Jumlah', 1, 0, 'C');
$pdf->Cell(0,  5, '', 1, 1, 'C'); //CELL BARIS ATAS

$pdf->Cell(70, 5, '', 0, 0, 'C');
$pdf->Cell(30, 5, '( Matrix Ton ) ', 1, 0, 'C');
$pdf->Cell(20, 5, '( Km ) ', 1, 0, 'C');
$pdf->Cell(30, 5, '( TON / Km ) ', 1, 0, 'C');
$pdf->Cell(40, 5, '( Rp ) ', 1, 0, 'C');
$pdf->Cell(0, 5, '', 1, 1, 'C'); //CELL BARIS Bawah

$no =1;
foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$_GET[id]') a","*") as $val){

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10, 5, $val[norut], 1, 0, 'C');
	$pdf->Cell(40, 5, $val[invdtl_uraian], 1, 0, 'C');
	$pdf->Cell(20, 5, $val[invdtl_ritase], 1, 0, 'C');
	$pdf->Cell(30, 5, $val[invdtl_tonase], 1, 0, 'C');
	$pdf->Cell(20, 5, round($val[invdtl_jarak],2), 1, 0, 'C');
	$pdf->Cell(30, 5, number_format($val[invdtl_harga],2), 1, 0, 'R');
	$pdf->Cell(40, 5, number_format($val[invdtl_jumlah],2), 1, 0, 'R');
	$pdf->Cell(0, 5, '', 1, 1, 'C'); //CELL BARIS ATAS
$no++;
}
$pdf->SetFont('Arial','',10);
$pdf->Cell(150, 5, "Sub Total", 1, 0, 'R');
$pdf->Cell(40, 5, number_format($val2[inv_subtotal],2), 1, 1, 'R');


$pdf->Cell(150, 5, "PPN 11%", 1, 0, 'R');
$pdf->Cell(40, 5, number_format($val2[inv_ppn],2), 1, 1, 'R');

$pdf->Cell(150, 5, "PPh (2%)", 1, 0, 'R');
$pdf->Cell(40, 5, number_format($val2[inv_pph],2), 1, 1, 'R');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(150, 5, "Grand Total", 1, 0, 'R');
$pdf->Cell(40, 5, number_format($val2[inv_grandtotal],2), 1, 1, 'R');

$pdf->SetFont('Arial','Bi',10);
// $pdf->Cell(20, 5, "Terbilang :", 1, 0, 'R');
$pdf->MultiCell(190, 5, "Terbilang : ".terbilang($val2[inv_grandtotal])." Rupiah", 1, 1);

//////////////////// END OF DATA TABLE /////////////////////////////////////////

$pdf->ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 5, "Mohon di transfer ke :", 0, 1, 'L');
$pdf->Cell(30, 5, "BANK", 0, 0, 'L');
$pdf->Cell(60, 5, ": BRI", 0, 1, 'L');
$pdf->Cell(30, 2, "No. REKENING", 0, 0, 'L');
$pdf->Cell(60, 2, ": 000901002852308", 0, 1, 'L');
$pdf->Cell(30, 5, "A.N", 0, 0, 'L');
$pdf->Cell(60, 5, ": PT. PRATAMA ABADI SENTOSA", 0, 1, 'L');

$pdf->ln(10);
$pdf->SetFont('Arial','',10);
$pdf->Cell(170, 5, "Blitar, ".date("d/m/Y",strtotime($val2[inv_tgl])), 0, 1, 'R');
$pdf->Cell(168, 2, "Hormat Kami, ", 0, 1, 'R');

$pdf->ln(20);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(170, 5, "AGUS FAUZI", 0, 1, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(171, 2, "Direktur Utama", 0, 1, 'R');


$pdf->AddPage(); // PAGE DETAIL

$pdf->SetFont('Arial','',10);
$pdf->Cell(28,5,"NO REKONSIL :",0,0,'L');
$pdf->Cell(40,5,$val2[inv_no],0,1,'L');
$pdf->Cell(28,5,"PERIODE         :",0,0,'L');
$pdf->Cell(28,5,date("d-m-Y", strtotime($val2[inv_periode1]))." S/d ".date("d-m-Y", strtotime($val2[inv_periode2])),0,1,'L');
$pdf->Cell(28,5,"PENYEWA       :",0,0,'L');
$pdf->Cell(40,5,$val2[cust_name],0,1,'L');
$pdf->ln(5);

////////////// TABEL DTL ////////////////////
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 10, 'DATE', 1, 0, 'C');
$pdf->Cell(40, 5, $val[invdtl_uraian], 1, 0, 'C');
$pdf->Cell(40, 5, 'GRAND TOTAL', 1, 1, 'C');

$pdf->Cell(20, 10, '', 0, 0, 'C');
$pdf->Cell(20, 5, 'RITASE', 1, 0, 'C');
$pdf->Cell(20, 5, 'TONASE', 1, 0, 'C');
$pdf->Cell(20, 5, 'RITASE', 1, 0, 'C');
$pdf->Cell(20, 5, 'TONASE', 1, 1, 'C');

$num = 1;

foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$_GET[id]') a","*") as $val){

  $my_string = $val[invdtl_ritdtl];    

    // passing "," as the delimiter

    $my_array1 = explode(",", $my_string);

    foreach ($my_array1 as $key => $value) {
      //echo $value."<br>";

      foreach($db->select("(select a.*, b.txangkut_tgl from tx_ritase_dtl a join tx_ritase b on a.txangkut_id = b.txangkut_id where trxangkutdtl_id = '$value') a","*") as $value)
      {
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(20, 5, date("d-m-Y", strtotime($value[txangkut_tgl])), 1, 0, 'C');
        $pdf->Cell(20, 5, $value[txangkut_ritase], 1, 0, 'C');
        $pdf->Cell(20, 5, $value[txangkut_tonase], 1, 0, 'C');
        $pdf->Cell(20, 5, $value[txangkut_ritase], 1, 0, 'C');
        $pdf->Cell(20, 5, $value[txangkut_tonase], 1, 1, 'C');

        $jumJar = $jumJar+$value[txangkut_jarak];
        $jumRit = $jumRit+$value[txangkut_ritase];
        $jumTon = $jumTon+$value[txangkut_tonase];
      }    
       
    }
    $pdf->Cell(60, 5, "", 1, 0, 'C');
    $pdf->Cell(20, 5, $jumRit, 1, 0, 'C');
    $pdf->Cell(20, 5, $jumTon, 1, 1, 'C'); 
$num++;
}

$pdf->ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(170, 5, "BLITAR, ".date("d/m/Y",strtotime($val2[inv_tgl])), 0, 1, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(50, 5, "Dibuat Oleh,", 0, 0, 'C');
$pdf->Cell(115, 5, "Diperiksa Oleh,", 0, 1, 'R');
$pdf->ln(10);
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(50, 5, "Tessa Lusiana P", 0, 0, 'C');
$pdf->Cell(112, 5, "Rahillah", 0, 1, 'R');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,2, "Admin Produksi PT.PAS", 0, 0, 'C');
$pdf->Cell(125,2, "Admin Produksi PT.RBT", 0, 1, 'R');


$pdf->AddPage(); // Page BERITA ACARA
$pdf->SetFont('Arial','BU',10);
$pdf->Cell(190,5,"BERITA ACARA INVOICE",0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,$val2[inv_no],0,1,'C');
$pdf->ln(5);
$tgl = date("Y-m-d",strtotime($val2[inv_tgl]));
$pdf->SetFont('Arial','',10);

$col1="Pada hari ini ".tanggal_indo($tgl, true)." Antara PT. PRATAMA ABADI SENTOSA dengan PT. ".$val2[cust_name].", telah menyepakati rekonsiliasi ritase dan tonase hauling, periode ".date("d-m-Y", strtotime($val2[inv_periode1]))." S/d ".date("d-m-Y", strtotime($val2[inv_periode2]))." dengan rincian jumlah Matrik Ton (MT) sebagai berikut :";
$pdf->MultiCell(189, 5, $col1, 0, 1);
$pdf->ln(5);
////////////// TABEL INV ////////////////////
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10, 10, 'NO', 1, 0, 'C');
$pdf->Cell(40, 10, 'Hauling JOB', 1, 0, 'C');
$pdf->Cell(20, 10, 'Ritase', 1, 0, 'C');
$pdf->Cell(30, 5, 'Tonase', 1, 0, 'C');
$pdf->Cell(20, 5, 'Jarak', 1, 1, 'C');

$pdf->Cell(70, 5, '', 0, 0, 'C');
$pdf->Cell(30, 5, '( Matrix Ton ) ', 1, 0, 'C');
$pdf->Cell(20, 5, '( Km ) ', 1, 1, 'C');

$no =1;
foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$_GET[id]') a","*") as $val){

  $pdf->SetFont('Arial','',10);
  $pdf->Cell(10, 5, $val[norut], 1, 0, 'C');
  $pdf->Cell(40, 5, $val[invdtl_uraian], 1, 0, 'C');
  $pdf->Cell(20, 5, $val[invdtl_ritase], 1, 0, 'C');
  $pdf->Cell(30, 5, $val[invdtl_tonase], 1, 0, 'C');
  $pdf->Cell(20, 5, round($val[invdtl_jarak],2), 1, 1, 'C');

$no++;
} // end tabel
$pdf->ln(5);

$col2="Dimana masing-masing jumlah Matrik Ton (TM) tersebut akan dijadikan acuan penagihan dengan nilai value yang telah disepakati bersama.";
$pdf->MultiCell(189, 5, $col2, 0, 1);
$pdf->ln(3);
$col3="Demikian berita acara Invoice ini dibuat dan dapat digunakan sebagaimana mestinya dan tanpa ada paksaan dari pihak manapun.";
$pdf->MultiCell(189, 5, $col3, 0, 1);



#output file PDF
$pdf->Output("".$val2[inv_no]."pdf","I");