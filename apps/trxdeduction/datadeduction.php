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

$table = "txdeduction";

// Table's primary key
$primaryKey = 'ddcdriver_id';

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
	array('db'      => 'concat(ddcdriver_bulan,"-",ddcdriver_tahun) AS periode','dt'   => 1, 'field' => 'periode',
		   'formatter' => function( $d, $row ) {
			$as=explode("-",$d);
			return $d;
					 
			}
		  ),
	array('db'      => 'nama_ddc','dt'   => 2, 'field' => 'nama_ddc',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
		
	array('db'      => 'concat(ddcdriver_bulan,"_",ddcdriver_tahun,"_",id_ddc) as idk','dt'   => 3, 'field' => 'idk',
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

$joinQuery = "FROM (select @rownum:=@rownum+1 norut, b.ddcdriver_id, ddcdriver_bulan,ddcdriver_tahun,driver_id, a.id_ddc, sum(ddcdriver_jumlah) ddcdriver_jumlah,nama_ddc from txdeduction a JOIN (SELECT max(ddcdriver_id) ddcdriver_id FROM txdeduction group by ddcdriver_bulan,ddcdriver_tahun,driver_id, id_ddc) b 
ON a.ddcdriver_id=b.ddcdriver_id JOIN m_deduction c ON a.id_ddc=c.id_ddc
JOIN (SELECT @rownum:=0) r
group by ddcdriver_bulan,ddcdriver_tahun, a.id_ddc) a";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);