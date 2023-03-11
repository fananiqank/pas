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
	array('db'      => 'txsolardtl_tgltrans','dt'   => 1, 'field' => 'txsolardtl_tgltrans',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'txsolardtl_shift','dt'   => 2, 'field' => 'txsolardtl_shift',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'totalliter','dt'   => 3, 'field' => 'totalliter',
		   'formatter' => function( $d, $row ) {
			return number_format($d,2);
			}
		  ),
	array('db'      => 'totaltotal','dt'   => 4, 'field' => 'totaltotal',
		   'formatter' => function( $d, $row ) {
			return number_format($d,0);
			}
		  ),
	array('db'      => 'gabs','dt'   => 5, 'field' => 'gabs',
		   'formatter' => function( $d, $row ) {
		   	$exp = explode("_", $d);
			// return "<a href='javascript:void(0)' data-tgl=\"$exp[0]\" data-shift=\"$exp[1]\" data-toggle=\"modal\" id=\"detailrh\">Detail</a> | <a href='javascript:void(0)' onclick=\"hapussolar($d)\" >Hapus</a>";
			return "<a href='javascript:void(0)' data-tgl=\"$exp[0]\" data-shift=\"$exp[1]\" data-toggle=\"modal\" id=\"detailrh2\">Detail</a> | <a href='javascript:void(0)' onclick=\"hapussolar('$exp[0]','$exp[1]')\" >Hapus</a>";
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

$joinQuery = "FROM (SELECT @rownum:=@rownum+1 norut,txsolardtl_tgltrans,txsolardtl_shift,sum(txsolardtl_liter) totalliter,sum(txsolardtl_total) totaltotal,concat(txsolardtl_tgltrans,'_',txsolardtl_shift) gabs from tx_solar_dtl JOIN (SELECT @rownum:=0) r GROUP BY txsolardtl_tgltrans,txsolardtl_shift ) a
			";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);