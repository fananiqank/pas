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

// if($_GET[id] == ''){
// 	$idmekanik = "";
// } else {
// 	$idmekanik = "and a.id_mekanik = $_GET[id]";
// }

if($_GET[armid] == ''){
	$armada = "";
} else {
	$armada = "and c.arm_id = $_GET[armid]";
}
// DB table to use

$table = "tx_maintenance";

// Table's primary key
$primaryKey = 'id_mtc';

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
	array('db'      => 'no_mtc','dt'   => 1, 'field' => 'no_mtc',
		   'formatter' => function( $d, $row ) {
			$isijam = "<a href='apps/maintenance/pdfmtc.php?id=1&mtc=$d' target='_blank'>$d</a>";
			return"$isijam";
					 
			}
		  ),
	array('db'      => 'tgl_mtc','dt'   => 2, 'field' => 'tgl_mtc',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'gabs','dt'   => 3, 'field' => 'gabs',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_barang','dt'   => 4, 'field' => 'nama_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'qty_mtcdtl','dt'   => 5, 'field' => 'qty_mtcdtl',
		   'formatter' => function( $d, $row ) {
			$isijam = "<a href='apps/maintenance/pdfmtc.php?id=1&mtc=$d' target='_blank'>$d</a>";
			return $d;
					 
			}
		  ),
	array('db'      => 'hargajual','dt'   => 6, 'field' => 'hargajual',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'biaya','dt'   => 7, 'field' => 'biaya',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
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

$joinQuery = "FROM (select @rownum:=@rownum+1 no_urut,a.no_mtc,DATE(a.tgl_mtc) tgl_mtc,b.id_barang,d.nama_barang,b.qty_mtcdtl,
concat(substr(c.arm_norangka,-5),' - ',c.arm_nolambung) as gabs,hargajual,(b.qty_mtcdtl * hargajual) biaya
from tx_maintenance a join tx_maintenancedtl b using(id_mtc) 
join m_armada c using(arm_id) 
join m_barang d using(id_barang)
left join (select * from tx_mutasi where jenismutasi=2) e on a.no_mtc=e.no_transmutasi and b.id_barang=e.id_barang
JOIN (SELECT @rownum:=0) r 
where DATE(tgl_mtc) between '$_GET[tgl1]' and '$_GET[tgl2]' $armada) a";
$extraWhere = "";        

//echo $joinQuery;
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);