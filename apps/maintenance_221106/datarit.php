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

$table = "tx_maintenancedtl";

// Table's primary key
$primaryKey = 'id_mtcdtl';

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
	array('db'      => 'nama_barang','dt'   => 1, 'field' => 'nama_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'qty_mtcdtl','dt'   => 2, 'field' => 'qty_mtcdtl',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_satuan','dt'   => 3, 'field' => 'nama_satuan',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'jenis','dt'   => 4, 'field' => 'jenis',
		   'formatter' => function( $d, $row ) {
			if($d == 1){
				$jenisbrg = "Baru";
			} else {
				$jenisbrg = "Repair";
			}
			return"$jenisbrg";
					 
			}
		  ),
	array('db'      => 'id_mtcdtl','dt'   => 5, 'field' => 'id_mtcdtl',
		   'formatter' => function( $d, $row ) {
			return "<a href='javascript:void(0)' onclick='delCart($d)'>Del</a>";
			
					 
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

$joinQuery = "FROM (SELECT @rownum:=@rownum+1 norut, a.*, b.nama_barang, c.nama_satuan FROM tx_maintenancedtl a JOIN m_barang b ON a.id_barang=b.id_barang JOIN m_satuan c ON b.id_satuan=c.id_satuan JOIN (SELECT @rownum:=0) r where status_mtcdtl = 0) a";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);