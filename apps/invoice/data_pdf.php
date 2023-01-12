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
?>

  <table class="table1">
    <tbody>
      <tr>
        <td width="500" class="col1"><h3>PT.PRATAMA ABADI SENTOSA</h3></td>
        <td width="95" rowspan="4" class="col1"><div align="right"><img src="http://demo.dashteknologi.com/pas/app-assets/images/pratama.png" width="140" height="97" alt=""/></div></td>
      </tr>
      <tr>
        <td class="col1">JALAN SOEKARNO - HATTA, WONODADI - BLITAR</td>
      </tr>
      <tr>
        <td class="col1">( 0342 - 55564 / 0342 - 553170)</td>
      </tr>
      <tr>
        <td class="col1">angkutan.pratamaabadisentosa@gmail.com</td>
      </tr>
    </tbody>
  </table>