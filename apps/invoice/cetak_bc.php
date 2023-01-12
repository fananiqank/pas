<?php
require_once "../../webclass.php";
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

foreach($db->select("(SELECT  @rownum:=@rownum+1 norut, a.*, b.cust_name, b.cust_address FROM `tx_invoice` a JOIN m_customer b ON a.cust_id=b.cust_id JOIN (SELECT @rownum:=0) r) a where a.inv_id='$_GET[id]'","*") as $val2){}

$content ='
	<style>
		 table{
		  border: 1px solid;	
		 }
		 table td{
		  border-bottom:silver 1px solid;
		  border-right:silver 1px solid;
		  padding:5 5px;
		 }
		 table th{
		  border-bottom:silver 1px solid;
		  border-right:silver 1px solid;
		  padding:0 0 0 5px;
		 }
	</style>
';


	$content .='
	<html> 
	<body>
<table class="table1">
  <tbody>
    <tr>
      <td width="500"><h3>PT.PRATAMA ABADI SENTOSA</h3></td>
      <td width="60" rowspan="4"><div align="right"><img src="http://demo.dashteknologi.com/pas/app-assets/images/pratama.png" width="140" height="97" alt=""/></div></td>
    </tr>
    <tr>
      <td>JALAN SOEKARNO - HATTA, WONODADI - BLITAR</td>
    </tr>
    <tr>
      <td>( 0342 - 55564 / 0342 - 553170)</td>
    </tr>
    <tr>
      <td>angkutan.pratamaabadisentosa@gmail.com</td>
    </tr>
  </tbody>
</table>';

$content .='
 <hr><div align="right"><i>'.date("d/m/Y",strtotime($val2[inv_tgl])).'</i></div>

	
	Kepada Yth:
  <br>Pimpinan '.$val2[cust_name].'
  <br>'.$val2[cust_address].'<br>
  <br><br>
  <div align="center"><u>INVOICE</u></div>
  <div align="center"><font><i>'.$val2[inv_no].'</i></font></div>
	
	<hr>
		<table border: 1px solid #000>
			<thead>
	            <tr>
	                <th width="30"  align="center" rowspan="2" style="background-color:#CCC">No</th>
	                <th width="90"  align="center" rowspan="2" style="background-color:#CCC">Uraian</th>
	                <th width="60"  align="center" rowspan="2" style="background-color:#CCC">Ritase</th>
	                <th width="60"  height="30"  align="center" style="background-color:#CCC">Tonase</th>
	                <th width="60"  align="center" style="background-color:#CCC">Jarak</th>
	                <th width="100" align="center" style="background-color:#CCC">Harga</th>
	                <th width="100" align="center" style="background-color:#CCC">Jumlah</th>
	            </tr>
	            <tr>
	                <th width="90"   align="center" style="background-color:#CCC"><h6>(Matrix Ton)</h6></th>
	                <th width="60"   align="center" style="background-color:#CCC"><h6>(Km)</h6></th>
	                <th width="100"  align="center" style="background-color:#CCC"><h6>(Ton/km)</h6></th>
	                <th width="150"  align="center" style="background-color:#CCC"><h6>Rp</h6></th>
	            </tr>
	        </thead>
        	<tbody>';

$no=1;
$p=0; 
foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$_GET[id]') a","*") as $val){

$content .='
			<tr>
                <td align="center">'.$val[norut].'</td>
                <td>'.$val[invdtl_uraian].'</td>
                <td align="center">'.$val[invdtl_ritase].'</td>
                <td align="center">'.$val[invdtl_tonase].'</td>
                <td align="right">'.$val[invdtl_jarak].'</td>
                <td align="right">'.number_format($val[invdtl_harga],2).'</td>
                <td align="right">'.number_format($val[invdtl_jumlah],2).'</td>
    		</tr>';
    	    $no++;
}
$content .='
 			<tr>
                <td colspan="6" align="right"><strong>Sub Total</strong></td>
                <td align="right"><strong>'.number_format($val2[inv_subtotal],2).'</strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>PPN 10%</strong></td>
                <td align="right"><strong>'.number_format($val2[inv_ppn],2).'</strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>PPh (2%)</strong></td>
                <td align="right"><strong>'.number_format($val2[inv_pph],2).'</strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>Grand Total</strong></td>
                <td align="right"><strong>'.number_format($val2[inv_grandtotal],2).'</strong></td>
            </tr>          
        </tbody>
    </table>';
$content .='
      <table>
          <tr>
                <td height ="100" width="90" ><strong : >Terbilang</strong></td>
                <td width="540" height ="50" style="background-color:orange"><strong>'.terbilang($val2[inv_grandtotal]).' Rupiah</strong></td>
                
            </tr>
      </table>
    <br>
   <i> Mohon di transfer ke:</i>
    <br><b>BANK &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : BRI
    <br>NO. REKENING : 000901002852308
    <br>A.N &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp; : PT. PRATAMA ABADI SENTOSA</b>
    <br><br><br><br>
    <div align="right">(&nbsp; &nbsp; &nbsp;   ttd & Cap perusahaan &nbsp; &nbsp; &nbsp;)</div>
    ';
  $content .='
	</body>
	</html>
	';

	require __DIR__.'../../../lib/html2pdf/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	$html2pdf = new Html2Pdf('P','A4','fr', true, 'UTF-8', array(15, 15, 15, 15), false); 
	$html2pdf->writeHTML($content);
	$html2pdf->output();
	//$html2pdf->output($val2['inv_no']."-".$val2['cust_name'].".pdf","D");
?>