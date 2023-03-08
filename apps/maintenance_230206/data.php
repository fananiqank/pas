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

$table = "m_armada";

// Table's primary key
$primaryKey = 'arm_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db'      => 'no_urut','dt'   => 0, 'field' => 'no_urut',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'arm_norangka','dt'   => 1, 'field' => 'arm_norangka',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_nopol','dt'   => 2, 'field' => 'arm_nopol',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_nolambung','dt'   => 3, 'field' => 'arm_nolambung',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_id','dt'   => 4, 'field' => 'arm_id',
		   'formatter' => function( $d, $row ) {
			//return "<a href='javascript:void(0)' onclick=\"delCart('$d')\">Hapus</a>";
			return "<a href='javascript:void(0)' data-id=\"$d\" data-toggle=\"modal\" id=\"detailrh\">History</a>";
					 
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

$joinQuery = "FROM (SELECT @rownum:=@rownum+1 no_urut, a.arm_id,a.arm_norangka,a.arm_nopol,a.arm_nolambung FROM m_armada a JOIN (SELECT @rownum:=0) r ) a
			";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);