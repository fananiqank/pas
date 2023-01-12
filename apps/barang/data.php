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
	array('db'      => 'id_barang','dt'   => 0, 'field' => 'id_barang',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'kode_barang','dt'   => 1, 'field' => 'kode_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'partnumber_barang','dt'   => 2, 'field' => 'partnumber_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_barang','dt'   => 3, 'field' => 'nama_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_dep','dt'   => 4, 'field' => 'nama_dep',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_sub','dt'   => 5, 'field' => 'nama_sub',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_kat','dt'   => 6, 'field' => 'nama_kat',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_satuan','dt'   => 7, 'field' => 'nama_satuan',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'min_stock','dt'   => 8, 'field' => 'min_stock',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	// array('db'      => 'max_stock','dt'   => 8, 'field' => 'max_stock',
	// 	   'formatter' => function( $d, $row ) {
			
	// 		return"$d";
					 
	// 		}
	// 	  ),
	array('db'      => 'status','dt'   => 9, 'field' => 'status',
		   'formatter' => function( $d, $row ) {
			if($d == 1) {
				$showstatus = "<span class='success'>Aktif</span>";
			} else {
				$showstatus = "<span class='danger'>Nonaktif</span>";
			}
			return"$showstatus";
					 
			}
		  ),
	array('db'      => 'id_barang','dt'   => 10, 'field' => 'id_barang',
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

$joinQuery = "FROM (select id_barang,kode_barang,nama_barang,nama_dep,nama_sub,nama_kat,nama_satuan,a.status,a.min_stock,a.max_stock,a.partnumber_barang
			  		from m_barang a 
			  		join m_dep b on a.id_dep=b.id_dep
			  		join m_subdep c on a.id_sub=c.id_sub
			  		join m_kat d on a.id_kat=d.id_kat
			  		join m_satuan e on a.id_satuan=e.id_satuan) as asi";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);