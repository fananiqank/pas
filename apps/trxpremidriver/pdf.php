<?php
require_once "../../lib/fpdf182/fpdf.php";


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
    $this->Line(10,40,138,40);
  }

  function garis2(){
    $this->SetLineWidth(1);
    $this->Line(10,41,138,41);
  }

  function garis3(){
    $this->SetLineWidth(0.5);
    $this->Line(10,48,138,48);
  }

  function garis4(){
    $this->SetLineWidth(0.5);
    $this->Line(10,48,138,48);
  }

  
}



require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("m_driver a JOIN m_armada b ON a.driver_armada=b.arm_id","a.*,b.arm_nolambung","driver_id = $_GET[dvr]") as $head){}
foreach($db->select("(SELECT sum(case when left(txbaspredtl_uraian,5)<>'Premi' then txbaspredtl_jumlah else 0 end) as hari, sum(case when left(txbaspredtl_uraian,5)<>'Premi' then txbaspredtl_ttl else 0 end) basic, sum(txbaspredtl_ttl) grandtot,txbaspre_tgl1,txbaspre_tgl2,DATEDIFF(txbaspre_tgl2,txbaspre_tgl1) as jumlah_hari,CONCAT(MONTH(txbaspre_tgl2),'_',YEAR(txbaspre_tgl2)) as periodetrans
FROM `trx_basicpremi_driver_dtl` a JOIN m_driver b USING(driver_id) JOIN trx_basicpremi_driver c 
USING(txbaspre_id) where txbaspre_id='$_GET[id]' group by driver_id) a","*") as $basic){}

foreach($db->select("(select count(*) as jumlah_hari from txkehadiran where hadirdriver_type='1' and hadirdriver_jenis<>'0' and date(hadirdriver_tgl) between '$basic[txbaspre_tgl1]' and '$basic[txbaspre_tgl2]' and driver_id='$_GET[dvr]') a","*") as $basic1){}

$bln=date("m",strtotime($basic['txbaspre_tgl1']));
$thn=date("Y",strtotime($basic['txbaspre_tgl1']));
$mbasic="(SELECT * FROM `m_basicdriver` where '$basic[txbaspre_tgl1]'>=basicdriver_tglmulai order by basicdriver_id desc limit 1) a";


foreach($db->select("$mbasic",'basicdriver_jumlah') as $dbasic){}
foreach($db->select("(select * from txkehadiran where hadirdriver_bulan='$bln' AND hadirdriver_tahun='$thn' and hadirdriver_type='1') a",'hadirdriver_jumlah') as $hadir){}
foreach($db->select("(select * from txkehadiran where hadirdriver_bulan='$bln' AND hadirdriver_tahun='$thn' and hadirdriver_type='2') a",'hadirdriver_jumlah') as $unit){}

$perawatanunit = '0';
if($basic['jumlah_hari'] > 0){
  $dayrawatunit = ($perawatanunit/$basic['jumlah_hari']);
} else {
  $dayrawatunit = 0;
}
$totalrawat = (round(($dayrawatunit*$unit['hadirdriver_jumlah'])  / 100, 0)) * 100;
$upah = '0';




$pdf = new PDF("P","mm","A5");
$pdf->AliasNbPages();
$pdf->AddPage();


// $pdf->gbr('./pratama.png');
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(138,8,"SLIP GAJI KARYAWAN PT. PAS",0,0,'C');
$pdf->ln(4);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(138,8,"Periode ".date('d-M-Y',strtotime($basic['txbaspre_tgl1']))." sd ".date('d-M-Y',strtotime($basic['txbaspre_tgl2'])),0,0,'C');
$pdf->ln(10);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,"Nama                :",0,0,'L');
$pdf->Cell(40,5,$head[driver_name],0,1,'L');


$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,"Jabatan            :",0,0,'L');
$pdf->Cell(70,5,"Driver",0,1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,"No Lambung   :",0,0,'L');
$pdf->Cell(40,5,$head[arm_nolambung],0,0,'L');
$pdf->Cell(60,5,"No Rek : ".$head['driver_bank']." - ".$head['driver_rekening'],0,1,'R');
$pdf->ln(2);
$pdf->garis();
$pdf->garis2();

$pdf->ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(8,5,"No.",0,0,'C');
$pdf->Cell(45,5,"HAULING",0,0,'C');
$pdf->Cell(25,5,"JUMLAH",0,0,'C');
$pdf->Cell(20,5,"UPAH ",0,0,'C');
$pdf->Cell(30,5,"TOTAL",0,1,'C');
$pdf->ln(2);
$pdf->garis3();

$no = 1;

foreach($db->select("(select c.rom_name,d.tujuan_name, txbaspredtl_jenis, sum(txbaspredtl_jumlah) txbaspredtl_jumlah, sum(txbaspredtl_ttl) txbaspredtl_ttl from m_rutejarak a LEFT JOIN (select b.*
                                  from trx_basicpremi_driver a 
                                  JOIN trx_basicpremi_driver_dtl b ON a.txbaspre_id=b.txbaspre_id
                                  where b.driver_id='$_GET[dvr]' and b.txbaspre_id='$_GET[id]') b on a.rutejarak_id=b.rutejarak_id
                                  JOIN m_runofmine c ON c.rom_id=a.rom_id 
                                  JOIN m_tujuan d ON d.tujuan_id=a.tujuan_id
                                  group by a.rutejarak_id) as a where txbaspredtl_ttl>0","*") as $val){
            //echo is_nan($val['txbaspredtl_ttl']/$val['txbaspredtl_jumlah']);
            $ritman = !is_nan($val['txbaspredtl_ttl']/$val['txbaspredtl_jumlah']) ? $val['txbaspredtl_ttl']/$val['txbaspredtl_jumlah'] : 0;
            
            if($val['txbaspredtl_jenis']<>"") {
               $ton =" (".$val['txbaspredtl_jenis'].")";
            } 

            if($val['txbaspredtl_jenis'] == "Tonase")
            {$basjumlah= number_format($val['txbaspredtl_jumlah'],3);} 
            else {$basjumlah= number_format($val['txbaspredtl_jumlah']);}

$pdf->SetFont('Arial','B',8);
$pdf->Cell(8,5,$no,0,0,'C');
$pdf->Cell(45,5,$val['rom_name']." ke ".$val['tujuan_name'],0,0,'L');
$pdf->Cell(25,5,$basjumlah.$ton,0,0,'C');
$pdf->Cell(20,5,number_format($ritman),0,0,'R');
$pdf->Cell(30,5,number_format($val['txbaspredtl_ttl']),0,1,'R');
$no++;
$totalrit += $val['txbaspredtl_ttl'];
}

$grandtotal = $totalrit + $basic['basic'] + $totalrawat;

$pdf->SetFont('Arial','B',8);
$pdf->Cell(53,5,"Basic ".$basic1['jumlah_hari']." Hari",0,0,'L');
$pdf->Cell(25,5,number_format($basic['hari']),0,0,'C');
$pdf->Cell(20,5,number_format($dbasic['basicdriver_jumlah']),0,0,'R');
$pdf->Cell(30,5,number_format($dbasic['basicdriver_jumlah']/30*$basic1['jumlah_hari']),0,1,'R');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(78,5,"Perawatan Unit",0,0,'L');
$pdf->Cell(20,5,number_format($perawatanunit),0,0,'R');
$pdf->Cell(30,5,number_format($totalrawat),0,1,'R');

// $pdf->SetFont('Arial','B',8);
// $pdf->Cell(98,5,"Sub Total (Income)",0,0,'L');
// $pdf->Cell(30,5,"Rp. ".number_format(($dbasic['basicdriver_jumlah']/30*$basic[jumlah_hari])),0,1,'R');

foreach($db->select("txdeduction a JOIN m_deduction b using(id_ddc)","a.*,nama_ddc","driver_id = $_GET[dvr] and CONCAT(ddcdriver_bulan,'_',ddcdriver_tahun) = '$basic[periodetrans]'","id_ddc DESC") as $bpjs){

$pdf->SetFont('Arial','B',8);
$pdf->Cell(78,5,"Potongan ".$bpjs['nama_ddc'],0,0,'L');
$pdf->Cell(50,5,"Rp ".number_format($bpjs['ddcdriver_jumlah']),0,1,'R');

$grandtotal -= $bpjs[ddcdriver_jumlah];
}

$pdf->SetFont('Arial','B',8);
$pdf->Cell(98,5,"Grand Total (Total - Potongan)",0,0,'L');
$pdf->Cell(30,5,"Rp. ".number_format($grandtotal+($dbasic['basicdriver_jumlah']/30*$basic1[jumlah_hari])),0,1,'R');

// $pdf->SetLineWidth(0.5);
// $pdf->Line(10,105,138,105);



#output file PDF
$pdf->Output("Premi - ".$head['arm_nolambung']."-".$head['driver_name'].".pdf","I");