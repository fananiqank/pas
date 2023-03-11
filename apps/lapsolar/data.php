<?php
session_start();
error_reporting(0);
include "../../webclass.php";
$db=new kelas();

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
if($_GET[tgl]){
	$gettgl = "$_GET[tgl]";
} else {
	$gettgl = "";
}

if($_GET[shift] == ''){
	$shift = "";
} else {
	$shift = "and a.txsolardtl_shift = $_GET[shift]";
}

if($_GET[driverid] == ''){
	$driverid = "";
} else {
	$driverid = "and a.driver_id = $_GET[driverid]";
}

if($_GET[armid] == ''){
	$armada = "";
} else {
	$armada = "and a.arm_id = $_GET[armid]";
}

if($_GET[suppid] == ''){
	$suppid = "";
} else {
	$suppid = "and a.supp_id = $_GET[suppid]";
}
// DB table to use

$table = "tx_solar";

// Table's primary key
$primaryKey = 'txsolar_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db'      => 'norut','dt'   => 0, 'field' => 'norut',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'txsolardtl_tgltrans','dt'   => 1, 'field' => 'txsolardtl_tgltrans',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'txsolardtl_shift','dt'   => 2, 'field' => 'txsolardtl_shift',
		   'formatter' => function( $d, $row ) {
			//$isijam = "<a href='apps/maintenance/pdfmtc.php?id=1&mtc=$d' target='_blank'>$d</a>";
			return $d;
			}
		  ),
	array('db'      => 'arm_nolambung','dt'   => 3, 'field' => 'arm_nolambung',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'driver_name','dt'   => 4, 'field' => 'driver_name',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'supp_nama','dt'   => 5, 'field' => 'supp_nama',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	
	array('db'      => 'txsolardtl_harga','dt'   => 6, 'field' => 'txsolardtl_harga',
		   'formatter' => function( $d, $row ) {
			$bbiaya = number_format($d);
			return"$d";
					 
			}
		  ),
	array('db'      => 'txsolardtl_liter','dt'   => 7, 'field' => 'txsolardtl_liter',
		   'formatter' => function( $d, $row ) {
			$bliter = number_format($d);
			return"$d";
					 
			}
		  ),
	array('db'      => 'txsolardtl_total','dt'   => 8, 'field' => 'txsolardtl_total',
		   'formatter' => function( $d, $row ) {
			$bbiaya = number_format($d);
			return"$d";
			}
		  ),
	
		  
	
	
		
);

// SQL server connection information
$sql_details = array(
	'user' => $db->usernya(),
	'pass' => $db->passnya(),
	'db'   => $db->dbnya(),
	'host' => $db->hostnya()
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('../../lib/ssp.customized.class.php' );

$joinQuery = "FROM (SELECT @rownum:=@rownum+1 norut, a.*,
    d.driver_name,e.arm_nolambung,f.supp_nama
    FROM tx_solar_dtl a  
    JOIN m_driver d on a.driver_id=d.driver_id 
    JOIN m_armada e on a.arm_id=e.arm_id 
    JOIN m_supplier f on a.supp_id=f.supp_id JOIN (SELECT @rownum:=0) r where 
    txsolardtl_tgltrans between ('$_GET[tgl1]') and ('$_GET[tgl2]') $shift $armada $driverid $suppid) a ";
$extraWhere = "";        

//echo $joinQuery;
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);