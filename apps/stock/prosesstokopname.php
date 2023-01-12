<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();
$date = date("Y-m-d H:i:s");

if($_GET[act]=='save'){

	$bulan=date("m");
	$tahun=date("Y");
	$cnregis   = $db->selectcount("tx_stockopname","id_sto","month(id_sto_dtl_inputdt) = '$bulan' and year(id_sto_dtl_inputdt)='$tahun'");
	$regno="SO".sprintf("%05s",$cnregis+1);
//input ke tx_stockopname	
	$data=array(
					'noso' => $regno,
					'keterangan_so' => '',
					'createdby_so' => $_SESSION[ID_PEG],
					'inputdt_so' => date("Y-m-d H:i:s"),
					'idgudang'=> $_POST[idgudang],
					'jenis_brg'=> $_POST[jenisbrg],
					);
	$so=$db->insertID("tx_stockopname",$data);
	

	foreach ($_POST['idbarang'] as $key => $value) {
		if ($_POST['selisih'][$key] == 'NaN' || $_POST['selisih'][$key] == '') {
			$selisihnya = 0;
		} else {
			$selisihnya = $_POST['selisih'][$key];
		}

		if ($_POST['keterangan'][$key] == '') {
			$keter = " ";
		} else {
			$keter = $_POST['keterangan'][$key];
		}
		$data2=array(
					'idso'  => $so,
					'idbarang'  => $_POST['idbarang'][$key],
					'kdbarang'  => $_POST['kdbarang'][$key],
					'qtyakhir'  => $_POST['qtytotalnow'][$key],
					'qtyfisik'  => $_POST['fisik'][$key],
					'selisih'  => $selisihnya,
					'keterangan_so_dtl'  => $keter,
					'inputdt_so_dtl'  => date("Y-m-d H:i:s"),
					'noref'  => $_POST['brgmasuk'][$key],
					'hargabeli'  => $_POST['hargabeli'][$key],
					'createdby_so_dtl'  => $_SESSION[ID_PEG],
				);
		$sodtl=$db->insertID("tx_stockopname_dtl",$data2);	
		
		if($selisihnya==0 OR $selisihnya=="" OR empty($selisihnya)){

		} else {
			if($selisihnya<0){
				$k=abs($selisihnya);
				$m=0;
			} else {
				$m=abs($selisihnya);
				$k=0;
			}

			if ($_POST['brgmasuk'][$key] == '') {
				$norefmutasi1 = $regno;
			} else {
				$norefmutasi1 = $_POST['brgmasuk'][$key];
			}
			$datamutasib=array(
							'id_transmutasi'=>$so,
							'no_transmutasi'=>$regno,
							'no_refmutasi1'=> $norefmutasi1,
							'id_barang'=>$_POST['idbarang'][$key],
							'harga' => $_POST['hargabeli'][$key],
							'masukmutasi'=>"$m",
							'keluarmutasi'=>"$k",
							'jenismutasi'=>"4",
							'tgl_mutasi'=>date("Y-m-d H:i:s"),
							'created_by'=>$_SESSION[ID_PEG],
							'jenisbrg'=>$_POST['jenisbrg'],
							'id_gudang'=>$_POST['idgudang']
							);
			//var_dump($datamutasib);
			$mutasi=$db->insertID("tx_mutasi",$datamutasib);
			//echo $mutasi;
		}
	}


} else if($_GET[act]=='del'){
	
	$dt=$db->delete("tx_maintenancedtl",array("id_mtcdtl"=> $_GET[id]));
	// echo json_encode($dt);

}