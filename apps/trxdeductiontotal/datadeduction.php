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
	array('db'      => 'driver_name','dt'   => 1, 'field' => 'driver_name',
		   'formatter' => function( $d, $row ) {
			$as=explode("-",$d);
			return $d;
					 
			}
		  ),
	array('db'      => 'total','dt'   => 2, 'field' => 'total',
		   'formatter' => function( $d, $row ) {
			$exp1 = explode("_",$d);
			return"<a href='javascript:void(0)' data-id=\"$exp1[0]\" data-type=\"1\" data-toggle=\"modal\" id=\"detailrh\">$exp1[1]</a>";
			}
		  ),

	array('db'      => 'bayar','dt'   => 3, 'field' => 'bayar',
		   'formatter' => function( $d, $row ) {
			$exp2 = explode("_",$d);
			return"<a href='javascript:void(0)' data-id=\"$exp2[0]\" data-type=\"2\" data-toggle=\"modal\" id=\"detailrh\">$exp2[1]</a>";
					 
			}
		  ),

	array('db'      => 'sisa','dt'   => 4, 'field' => 'sisa',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	
	// array('db'      => 'driver_id','dt'   => 5, 'field' => 'driver_id',
	// 	   'formatter' => function( $d, $row ) {
	// 		return "<a href='javascript:void(0)' data-id=\"$d\" data-toggle=\"modal\" id=\"detailrh\">Detail</a>";
			
					 
	// 		}
	// 	  ),
	
		  
	
	
		
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

$joinQuery = "FROM (SELECT norut,driver_name,driver_id,(total-bayar) sisa,concat(driver_id,'_',total) total,concat(driver_id,'_',bayar) bayar from (
select @rownum:=@rownum+1 norut,a.driver_id,b.driver_name,sum(a.tddc_jumlah) total,(select sum(ddcdriver_jumlah) bayar from txdeduction where driver_id=a.driver_id GROUP BY driver_id) as bayar  
from txdeductiontotal a join m_driver b using(driver_id) JOIN (SELECT @rownum:=0) r
GROUP BY a.driver_id) a ) a";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);