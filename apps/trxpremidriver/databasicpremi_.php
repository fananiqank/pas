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

$table = "trx_basicpremi_driver";

// Table's primary key
$primaryKey = 'txbaspre_id';

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
	array('db'      => 'concat(txbaspre_bulan,"-",txbaspre_tahun) AS periode','dt'   => 1, 'field' => 'periode',
		   'formatter' => function( $d, $row ) {
			$as=explode("-",$d);
			return $d;
					 
			}
		  ),
	array('db'      => 'id_site','dt'   => 2, 'field' => 'id_site',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'txbaspre_tbas','dt'   => 3, 'field' => 'txbaspre_tbas',
		   'formatter' => function( $d, $row ) {
			
			return number_format($d,2);
					 
			}
		  ),
	array('db'      => 'txbaspre_tpre','dt'   => 4, 'field' => 'txbaspre_tpre',
		   'formatter' => function( $d, $row ) {
			return number_format($d,2);
			
					 
			}
		  ),
	array('db'      => 'txbaspre_gttl','dt'   => 5, 'field' => 'txbaspre_gttl',
		   'formatter' => function( $d, $row ) {
			return number_format($d,2);
			
					 
			}
		  ),
	
	array('db'      => 'txbaspre_id','dt'   => 6, 'field' => 'txbaspre_id',
		   'formatter' => function( $d, $row ) {
			return "<a href='javascript:void(0)' data-id=\"$d\" data-toggle=\"modal\" id=\"detailrh\">Detail</a>";
			
					 
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

$joinQuery = "FROM (SELECT  @rownum:=@rownum+1 norut, a.* FROM trx_basicpremi_driver a JOIN (SELECT @rownum:=0) r) a";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);