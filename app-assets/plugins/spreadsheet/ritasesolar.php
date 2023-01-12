<?php
session_start();
require 'vendor/autoload.php';
require '../../../webclass.php';

$db= new kelas();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
 
$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //echo isset($_FILES['file']['name']);

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
	$total=0;
   foreach($sheetData as $k => $v){
        //echo"$k --- $v <br>";
        // echo "--------- $v[0] | $v[1] | $v[2] | \n";
   		
        if($k>0){
        	$cek="";
            foreach($db->select("m_driver","driver_id","driver_code='$v[1]'") as $driver);
            foreach($db->select("m_armada","arm_id","arm_nolambung='$v[3]'") as $nolamb);
            foreach($db->select("m_supplier","supp_id","supp_kode='$v[6]'") as $nosupp);
             
            if($driver[driver_id]=="" OR $nolamb[arm_id]=="" OR $nosupp[supp_id]==""){
            	// echo "kosong\n";
            	$error=1;
            	$msg="No Lambung:".$v[3]."-".$nolamb[arm_id]." Kode Driver:".$v[1]."-".$driver[driver_id]." Nama Driver :".$v[2]." Kode Supplier:".$v[6]."-".$nosupp[supp_id]." Nama Supplier :".$v[7]." Tidak Ditemukan";
            	break;
            } else {
            	$total=$v[4]*$v[5];
            	// echo "Ditemukan rute ID $cek[rutejarak_id]\n";
            	
            	$query.="insert into tx_solar_dtl_tmp (
							arm_id,
							driver_id,
							txsolardtl_liter,
							txsolardtl_harga,
							txsolardtl_total,
							txsolardtl_petugas,
							userid,
							supp_id
						) 
						values (
							'$nolamb[arm_id]',
							'$driver[driver_id]',
							'$v[4]',
							'$v[5]',
							'$total',
							'$v[8]',
							'$_SESSION[ID_PEG]',
							'$nosupp[supp_id]'
						);";
            }
        }
    }

    $db->query($query);
    if($error==1){
    	echo $msg;	
    } else {
    	$data=array(
					"txsolar_tgl"=>$_POST[txsolar_tgl],
					"txsolar_user"=>$_SESSION[ID_PEG],
					"id_site"=>$_POST[id_site],
					"txsolar_shift"=>$_POST[txsolar_shift]
				);
		$in=$db->insertID("tx_solar",$data);

			$db->query("
				insert into tx_solar_dtl (
					txsolar_id,
					arm_id,
					driver_id,
					txsolardtl_liter,
					txsolardtl_harga,
					txsolardtl_total,
					txsolardtl_tgl,
					txsolardtl_petugas,
					supp_id
				) 
				select '$in',
						arm_id,
						driver_id,
						txsolardtl_liter,
						txsolardtl_harga,
						txsolardtl_total,
						txsolardtl_tgl,
						txsolardtl_petugas,
						supp_id
 				from tx_solar_dtl_tmp where userid='$_SESSION[ID_PEG]';
				delete FROM tx_solar_dtl_tmp where userid='$_SESSION[ID_PEG]';

				");
		echo "Data Terupload";
    }
    
    // var_dump($dtsheet);
    // echo json_encode($datanya);
}
?>