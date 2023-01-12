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
$etgl=explode("-",$_GET['tgl']);
$unit=$_GET['unit'];
$table = "m_supplier";

// Table's primary key
$primaryKey = 'supp_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db'      => 'supp_id','dt'   => 0, 'field' => 'supp_id',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'supp_nama','dt'   => 1, 'field' => 'supp_nama',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'supp_alamat','dt'   => 2, 'field' => 'supp_alamat',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'supp_notelp','dt'   => 3, 'field' => 'supp_notelp',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'supp_type','dt'   => 4, 'field' => 'supp_type',
		   'formatter' => function( $d, $row ) {
		   	if($d == 1){
		   		$rtn = "Supplier";
		   	} else if($d== 2) {
		   		$rtn = "Vendor Jasa";
		   	} else {
		   		$rtn = "Vendor Solar";
		   	}
			
			return"$rtn";
					 
			}
		  ),
	array('db'      => 'supp_status','dt'   => 5, 'field' => 'supp_status',
		   'formatter' => function( $d, $row ) {
		   	if($d == 1){
		   		$rtn = "Aktif";
		   	} else {
		   		$rtn = "Non Aktif";
		   	}
			
			return"$rtn";
					 
			}
		  ),
	array('db'      => 'supp_id','dt'   => 6, 'field' => 'supp_id',
		   'formatter' => function( $d, $row ) {	
			return "<a href='javascript:void(0)' onclick=\"getEdit('$d')\">Edit</a>";
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

$joinQuery = "FROM m_supplier";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);