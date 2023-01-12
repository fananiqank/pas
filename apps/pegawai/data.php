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
$table = "m_armada";

// Table's primary key
$primaryKey = 'arm_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db'      => 'arm_id','dt'   => 0, 'field' => 'arm_id',
		   'formatter' => function( $d, $row ) {
			return"$d";
			}
		  ),
	array('db'      => 'arm_nopol','dt'   => 1, 'field' => 'arm_nopol',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_nolambung','dt'   => 2, 'field' => 'arm_nolambung',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_norangka','dt'   => 3, 'field' => 'arm_norangka',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_nomesin','dt'   => 4, 'field' => 'arm_nomesin',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_type_armada','dt'   => 5, 'field' => 'arm_type_armada',
		   'formatter' => function( $d, $row ) {
			if($d == 1) {
				$showtypearmada = "DT 10 Roda";
			} else {
				$showtypearmada = "SDT 26 Roda";
			}
			return"$showtypearmada";
					 
			}
		  ),
	array('db'      => 'arm_merk_name','dt'   => 6, 'field' => 'arm_merk_name',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_type_name','dt'   => 7, 'field' => 'arm_type_name',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_tahun','dt'   => 8, 'field' => 'arm_tahun',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_status_milik','dt'   => 9, 'field' => 'arm_status_milik',
		   'formatter' => function( $d, $row ) {
			if($d == 1) {
				$showmilik = "Milik Sendiri";
			} else {
				$showmilik = "Sewa";
			}
			return"$showmilik";
					 
			}
		  ),
	array('db'      => 'arm_status','dt'   => 10, 'field' => 'arm_status',
		   'formatter' => function( $d, $row ) {
			if($d == 1) {
				$showstatus = "<span class='success'>Aktif</span>";
			} else {
				$showstatus = "<span class='danger'>Nonaktif</span>";
			}
			return"$showstatus";
					 
			}
		  ),
	array('db'      => 'arm_id','dt'   => 11, 'field' => 'arm_id',
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

$joinQuery = "FROM (select a.*,b.arm_merk_name,c.arm_type_name from m_armada a JOIN m_armada_merk b on a.arm_merk=b.arm_merk_id JOIN m_armada_type c on a.arm_type=c.arm_type_id) as asi";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);