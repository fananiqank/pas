<?php
// XML Example from GitHub

require(__DIR__ . '/../bootstrap.php');

use \Httpful\Request;

$data = "1000";
   $secretKey = "7789";
         // Computes the timestamp
          date_default_timezone_set('UTC');
          $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
           // Computes the signature by hashing the salt with the secret key as the key
   $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
 
   // base64 encode…
   $encodedSignature = base64_encode($signature);

   // urlencode…
   // $encodedSignature = urlencode($encodedSignature);
 /*
   echo "X-cons-id: " .$data ."<br>";
   echo "X-timestamp:" .$tStamp ."<br>";
   echo "X-signature: " .$encodedSignature;
*/
$uri = "http://api.asterix.co.id/SepWebRest/peserta/0001701917245";

$response = \Httpful\Request::get($uri)
	->expects('application/json;charset=UTF-8') 
    ->addHeaders(array(
        'X-cons-id' => $data,              // Or add multiple headers at once
        'X-timestamp' => $tStamp,              // in the form of an assoc array
		'X-signature' => $encodedSignature,
    ))
    ->send();
	
$result =json_decode($response);
?>

<table width="386" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>NIK</td>
    <td>&nbsp;</td>
    <td><?=$result->response->peserta->nik?></td>
  </tr>
  <tr>
    <td>Nama&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$result->response->peserta->nama?>&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal Lahir</td>
    <td>&nbsp;</td>
    <td><?=date("d/m/Y",strtotime($result->response->peserta->tglLahir))?></td>
  </tr>
  <tr>
    <td>Jenis Peserta&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$result->response->peserta->jenisPeserta->nmJenisPeserta?>&nbsp;</td>
  </tr>
  <tr>
    <td>Kelas Perawatan&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$result->response->peserta->kelasTanggungan->nmKelas?>&nbsp;</td>
  </tr>
</table>