<?php
session_start();
require 'vendor/autoload.php';
require '../../../webclass.php';

$db= new kelas();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
 
$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// echo isset($_FILES['file']['name'];

if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);
 
    if('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // echo "disini<br>";
    }
 
    $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
	// var_dump($sheetData);
	$query="";
	$error=0;
	$arm=explode("_",$_POST[arm_id]);
	
   foreach($sheetData as $k => $v){
        //echo"$k --- $v <br>";
        // echo "--------- $v[0] | $v[1] | $v[2] | \n";

        if($k>0){
        	$cek="";
            foreach($db->select("m_rutejarak a JOIN m_runofmine b ON a.rom_id=b.rom_id JOIN m_tujuan c ON c.tujuan_id=a.tujuan_id","rutejarak_id, rutejarak_jarak","rom_name='$v[0]' and tujuan_name='$v[1]'")as $cek);
            // echo "disini";
            if($cek[rutejarak_id]=='0' OR empty($cek[rutejarak_id]) OR $cek[rutejarak_id]==""){
            	// echo "kosong\n";
            	$error=1;
            	$msg="Rute Tidak Ditemukan";
            	break;
            } else {
            	// echo "Ditemukan rute ID $cek[rutejarak_id]\n";
            	$ton=$v[4];
            	$query.="insert into tx_ritase_dtltmp (
							arm_id,
							id_site,
							driver_id,
							rutejarak_id,
							txangkut_sk,
							txangkut_ritase,
							txangkut_bruto,
							txangkut_tarra,
							txangkut_tonase,
							txangkut_jam,
							txangkut_solar,
							userid,
							txangkut_nolambung,
							txangkut_jarak
						) 
						values (
							'$arm[0]',
							'$_POST[id_site]',
							'$_POST[driver_id]',
							'$cek[rutejarak_id]',
							'$_POST[txangkut_sk]',
							'1',
							'$v[2]',
							'$v[3]',
							'$ton',
							'$_POST[txangkut_jam]',
							'$_POST[txangkut_solar]',
							'$_SESSION[ID_PEG]',
							'$arm[1]','$cek[rutejarak_jarak]');";
							echo "insert into tx_ritase_dtltmp (
							arm_id,
							id_site,
							driver_id,
							rutejarak_id,
							txangkut_sk,
							txangkut_ritase,
							txangkut_bruto,
							txangkut_tarra,
							txangkut_tonase,
							txangkut_jam,
							txangkut_solar,
							userid,
							txangkut_nolambung,
							txangkut_jarak
						) 
						values (
							'$arm[0]',
							'$_POST[id_site]',
							'$_POST[driver_id]',
							'$cek[rutejarak_id]',
							'$_POST[txangkut_sk]',
							'1',
							'$v[2]',
							'$v[3]',
							'$ton',
							'$_POST[txangkut_jam]',
							'$_POST[txangkut_solar]',
							'$_SESSION[ID_PEG]',
							'$arm[1]','$cek[rutejarak_jarak]');";
            }
        }
    }

    $db->query($query);
    if($error==1){
    	echo $msg;	
    } else {
    	$data=array(
					"arm_id"=>$arm[0],
					"arm_nolambung"=>$arm[1],
					"id_site"=>$_POST[id_site],
					"driver_id"=>$_POST[driver_id],
					"txangkut_tgl"=>$_POST[txangkut_tgl],
					"txangkut_shift"=>$_POST[txangkut_shift],
					"txangkut_input"=>'NOW()',
					"txangkut_user"=>$_SESSION[ID_PEG]
				);
		$in=$db->insertID("tx_ritase",$data);

		$db->query("
			insert into tx_ritase_dtl (
				txangkut_id,
				arm_id,
				id_site,
				driver_id,
				rutejarak_id,
				txangkut_sk,
				txangkut_ritase,
				txangkut_bruto,
				txangkut_tarra,
				txangkut_tonase,
				txangkut_jam,
				txangkut_solar,
				userid,
				txangkut_nolambung,
				txangkut_jarak
			) 
			select '$in',
				'$arm[0]',
				id_site,
				'$_POST[driver_id]',
				rutejarak_id,
				txangkut_sk,
				txangkut_ritase,
				txangkut_bruto,
				txangkut_tarra,
				txangkut_tonase,
				txangkut_jam,
				txangkut_solar,
				userid,
				'$arm[1]',txangkut_jarak from tx_ritase_dtltmp where userid='$_SESSION[ID_PEG]';
			delete FROM tx_ritase_dtltmp where userid='$_SESSION[ID_PEG]';

			");
		echo "Data Terupload";
    }
    
    
    // var_dump($dtsheet);
    // echo json_encode($datanya);
}
?>