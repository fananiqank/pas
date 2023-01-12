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

$table = "tx_invoice";

// Table's primary key
$primaryKey = 'inv_id';

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
	array('db'      => 'inv_tgl','dt'   => 1, 'field' => 'inv_tgl',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'invperiode','dt'   => 2, 'field' => 'invperiode',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'cust_name','dt'   => 3, 'field' => 'cust_name',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'inv_no','dt'   => 4, 'field' => 'inv_no',
		   'formatter' => function( $d, $row ) {
			return"$d";
			
					 
			}
		  ),
	array('db'      => 'inv_grandtotal','dt'   => 5, 'field' => 'inv_grandtotal',
		   'formatter' => function( $d, $row ) {
			return number_format($d,2);
			
					 
			}
		  ),
	
	array('db'      => 'inv_id','dt'   => 6, 'field' => 'inv_id',
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

$joinQuery = "FROM (SELECT  @rownum:=@rownum+1 norut, a.*, b.cust_name,concat(a.inv_periode1,' - ',a.inv_periode2) as invperiode FROM `tx_invoice` a JOIN m_customer b ON a.cust_id=b.cust_id JOIN (SELECT @rownum:=0) r) a";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);