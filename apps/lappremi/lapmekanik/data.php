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
	array('db'      => 'arm_type_armada','dt'   => 1, 'field' => 'arm_type_armada',
		   'formatter' => function( $d, $row ) {
			
			if($d == 1) {
				$showtypearmada = "DT 10 Roda";
			} else {
				$showtypearmada = "SDT 26 Roda";
			}
			return"$showtypearmada";
					 
			}
		  ),
	array('db'      => 'arm_nolambung','dt'   => 2, 'field' => 'arm_nolambung',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'arm_target_rit','dt'   => 3, 'field' => 'arm_target_rit',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'jmlrit','dt'   => 4, 'field' => 'jmlrit',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	
	array('db'      => 'balance','dt'   => 5, 'field' => 'balance',
		   'formatter' => function( $d, $row ) {
		   	//$exp = explode('_',$d);
				if($d < 0 ){
					return "<font style='color:red'>No Target</font>";
				} else {
					return "Targeted";
				}
			
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

$joinQuery = "FROM (select @rownum:=@rownum+1 no_urut,a.* from (select arm_nolambung,arm_type_armada,arm_target_rit,COALESCE(sum(rit),0) jmlrit,COALESCE((COALESCE(sum(rit),0)-arm_target_rit),0) balance from (select a.arm_norangka,a.arm_nolambung,a.arm_type_armada,arm_target_rit,b.txangkut_id,b.trxangkutdtl_id,b.rit
from m_armada a
left join (select b.arm_id,b.txangkut_id,trxangkutdtl_id,'1' as rit
					 from tx_ritase b join tx_ritase_dtl c on b.txangkut_id=c.txangkut_id
					 where txangkut_tgl = '$gettgl') b on a.arm_id=b.arm_id) z
GROUP BY arm_nolambung,arm_type_armada,arm_target_rit) a JOIN (SELECT @rownum:=0) r) z";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);