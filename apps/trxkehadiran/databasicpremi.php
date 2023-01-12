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

$table = "txkehadiran";

// Table's primary key
$primaryKey = 'hadirdriver_id';

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
	array('db'      => 'periode','dt'   => 1, 'field' => 'periode',
		   'formatter' => function( $d, $row ) {
			$as=explode("-",$d);
			return $d;
					 
			}
		  ),
	array('db'      => 'shift','dt'   => 2, 'field' => 'shift',
		   'formatter' => function( $d, $row ) {
			$as=explode("-",$d);
			return $d;
					 
			}
		  ),
	array('db'      => 'type','dt'   => 3, 'field' => 'type',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
		
	array('db'      => 'idk','dt'   => 4, 'field' => 'idk',
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

$joinQuery = "FROM (select @rownum:=@rownum+1 norut, b.hadirdriver_id, hadirdriver_bulan,hadirdriver_tahun,driver_id, hadirdriver_type, sum(hadirdriver_jumlah) hadirdriver_jumlah,DATE(hadirdriver_tgl) as periode,shift,
    concat(DATE(hadirdriver_tgl),'_',hadirdriver_type,'_',shift) as idk,
    case hadirdriver_type when 1 then 'Kehadiran' else 'Perawatan' end as type
    from txkehadiran a JOIN (SELECT max(hadirdriver_id) hadirdriver_id FROM txkehadiran group by hadirdriver_bulan,hadirdriver_tahun,driver_id, hadirdriver_type) b 
ON a.hadirdriver_id=b.hadirdriver_id 
JOIN (SELECT @rownum:=0) r
group by hadirdriver_tgl,shift,hadirdriver_type order by hadirdriver_tgl,shift) a";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);