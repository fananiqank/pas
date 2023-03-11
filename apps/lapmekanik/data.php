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
	$idmekanik = "";
} else {
	$idmekanik = "and a.id_mekanik = $_GET[id]";
}

if($_GET[armid] == ''){
	$armada = "";
} else {
	$armada = "and d.arm_id = $_GET[armid]";
}
// DB table to use

$table = "tx_mekanik";

// Table's primary key
$primaryKey = 'id_mekanik';

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
	array('db'      => 'name_mekanik','dt'   => 1, 'field' => 'name_mekanik',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'no_mtc','dt'   => 2, 'field' => 'no_mtc',
		   'formatter' => function( $d, $row ) {
			$isijam = "<a href='apps/maintenance/pdfmtc.php?id=1&mtc=$d' target='_blank'>$d</a>";
			return $isijam;
					 
			}
		  ),
	array('db'      => 'gabs','dt'   => 3, 'field' => 'gabs',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'tgl_mtc','dt'   => 4, 'field' => 'tgl_mtc',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'tgltransinput','dt'   => 5, 'field' => 'tgltransinput',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'pekerjaan','dt'   => 6, 'field' => 'pekerjaan',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'biaya','dt'   => 7, 'field' => 'biaya',
		   'formatter' => function( $d, $row ) {
			
			$bbiaya = number_format($d);
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

$joinQuery = "FROM (select @rownum:=@rownum+1 no_urut,a.*,b.name_mekanik,c.no_mtc,concat(substr(d.arm_norangka,-5),' - ',d.arm_nolambung) as gabs,DATE(c.tgl_mtc) as tgl_mtc from tx_mekanik a join m_mekanik b using(id_mekanik) join tx_maintenance c using(id_mtc) join m_armada d using(arm_id) JOIN (SELECT @rownum:=0) r where DATE(c.tgl_mtc) between '$_GET[tgl1]' and '$_GET[tgl2]' $idmekanik $armada) a ";
$extraWhere = "";        

//echo $joinQuery;
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);