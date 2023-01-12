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
	array('db'      => 'txsolar_tgl','dt'   => 1, 'field' => 'txsolar_tgl',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'txsolar_shift','dt'   => 2, 'field' => 'txsolar_shift',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'total_liter','dt'   => 3, 'field' => 'total_liter',
		   'formatter' => function( $d, $row ) {
			return number_format($d,2);
			}
		  ),
	array('db'      => 'total_harga','dt'   => 4, 'field' => 'total_harga',
		   'formatter' => function( $d, $row ) {
			return number_format($d,0);
			}
		  ),
	array('db'      => 'txsolar_id','dt'   => 5, 'field' => 'txsolar_id',
		   'formatter' => function( $d, $row ) {
			return "<a href='javascript:void(0)' data-id=\"$d\" data-toggle=\"modal\" id=\"detailrh\">Detail</a> | <a href='javascript:void(0)' onclick=\"hapushaul($d)\" >Hapus</a>";
			// return "";
			
					 
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

$joinQuery = "FROM (SELECT @rownum:=@rownum+1 norut, a.*, b.nama_site,sum(txsolardtl_liter) as total_liter, sum(txsolardtl_total) as total_harga FROM `tx_solar` a JOIN m_site b ON a.id_site=b.id_site JOIN tx_solar_dtl c ON a.txsolar_id=c.txsolar_id JOIN (SELECT @rownum:=0) r group by a.txsolar_id) a
			";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);