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
if($_GET[tgl]){
	$gettgl = "$_GET[tgl]";
} else {
	$gettgl = "";
}

if($_GET[id] == ''){
	$iddriver = "";
} else {
	$iddriver = "and a.driver_id = $_GET[id]";
}

if($_GET[sf] == 0){
	$idshift = "";
} else {
	$idshift = "and a.shift = $_GET[sf]";
}

$tgl1 = new DateTime($_GET[tgl1]);
$tgl2 = new DateTime($_GET[tgl2]);
$jarak = $tgl2->diff($tgl1);

$jrk = $jarak->d;
// DB table to use

$table = "txkehadiran";

// Table's primary key
$primaryKey = 'hadirdriver_id';

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
	array('db'      => 'driver_name','dt'   => 1, 'field' => 'driver_name',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'shift','dt'   => 2, 'field' => 'shift',
		   'formatter' => function( $d, $row ) {
			return "$d";		 
			}
		  ),
	array('db'      => 'selisih','dt'   => 3, 'field' => 'selisih',
		   'formatter' => function( $d, $row ) {
			return "$d";		 
			}
		  ),
	array('db'      => 'gabs','dt'   => 4, 'field' => 'gabs',
		   'formatter' => function( $d, $row ) {
		   	$expd = explode("_", $d);
			return "<a href='javascript:void(0)' data-id='$expd[1]' data-shift='$expd[2]' data-tgl1='$_GET[tgl1]' data-tgl2='$_GET[tgl2]' data-toggle=modal\" id=\"detailrh\">$expd[0]</a>";
			
			//return "$expd[0]"."-"."$expd[1]";
					 
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

$joinQuery = "FROM (select @rownum:=@rownum+1 no_urut,b.driver_name,a.shift,(select datediff('$_GET[tgl2]', '$_GET[tgl1]'))+1 as selisih, sum(hadirdriver_jumlah) jmlkehadiran,concat(sum(hadirdriver_jumlah),'_',a.driver_id,'_',a.shift) gabs
from txkehadiran a join m_driver b on a.driver_id=b.driver_id
JOIN (SELECT @rownum:=0) r 
where hadirdriver_type = 1 $iddriver $idshift
and DATE(hadirdriver_tgl) between '$_GET[tgl1]' and '$_GET[tgl2]' GROUP BY a.driver_id,a.shift) a ";
$extraWhere = "";        

//echo $joinQuery;
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);