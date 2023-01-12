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
$table = "m_barang";

// Table's primary key
$primaryKey = 'id_barang';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db'      => 'id_brgmasuk','dt'   => 0, 'field' => 'id_brgmasuk',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'no_brgmasuk','dt'   => 1, 'field' => 'no_brgmasuk',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_supp','dt'   => 2, 'field' => 'nama_supp',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'no_sj','dt'   => 3, 'field' => 'no_sj',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'date_brgmasuk','dt'   => 4, 'field' => 'date_brgmasuk',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_gudang','dt'   => 5, 'field' => 'nama_gudang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'harga_total','dt'   => 6, 'field' => 'harga_total',
		   'formatter' => function( $d, $row ) {
			
			return number_format($d);
					 
			}
		  ),
	array('db'      => 'id_brgmasuk','dt'   => 7, 'field' => 'id_brgmasuk',
		   'formatter' => function( $d, $row ) {
			return "<a href='javascript:void(0)' onclick=\"getModalDetail('$d')\">Detail</a>";
					 
			}
		  ),
	array('db'      => 'harga_total','dt'   => 8, 'field' => 'harga_total',
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

$joinQuery = "FROM (select * from tx_barangmasuk a JOIN m_gudang b USING(id_gudang)) as asi";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);