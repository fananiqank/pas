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
if($_GET[id]){
	$where = "where id_gudang = $_GET[id] and jenisbrg ='$_GET[jns]'";
} else {
	$where = "";
}
// DB table to use

$table = "m_barang";

// Table's primary key
$primaryKey = 'id_barang';

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
	array('db'      => 'kode_barang','dt'   => 1, 'field' => 'kode_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'nama_barang','dt'   => 2, 'field' => 'nama_barang',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'min_stock','dt'   => 3, 'field' => 'min_stock',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	// array('db'      => 'max_stock','dt'   => 4, 'field' => 'max_stock',
	// 	   'formatter' => function( $d, $row ) {
			
	// 		return"$d";
					 
	// 		}
	// 	  ),
	array('db'      => 'stokakhir','dt'   => 4, 'field' => 'stokakhir',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'balance','dt'   => 5, 'field' => 'balance',
		   'formatter' => function( $d, $row ) {
				if($d < 0){
					return "<font style='color:red'>Dibawah Min. Stock</font>";
				} else {
					return "<font style='color:green'></font>";
				}
					 
			}
		  ),
	array('db'      => 'cont','dt'   => 6, 'field' => 'cont',
		   'formatter' => function( $d, $row ) {
		   	$exp = explode('_',$d);
			//return "<a href='javascript:void(0)' onclick=\"delCart('$d')\">Hapus</a>";
				if($exp[0] <> ''){
					return "<a href='index.php?x=stockmutasi&id=$exp[0]&gd=$exp[1]&jns=$_GET[jns]'>History</a>";
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

$joinQuery = "FROM (SELECT @rownum:=@rownum+1 no_urut, a.id_barang,a.kode_barang,a.nama_barang,COALESCE(masukmutasi,0) masukmutasi,
COALESCE(keluarmutasi,0) keluarmutasi,COALESCE(masukmutasi-keluarmutasi,0) as stokakhir,concat(a.id_barang,'_',id_gudang) as cont,min_stock,max_stock, COALESCE(COALESCE(masukmutasi-keluarmutasi,0)-COALESCE(min_stock,0),0) as balance FROM m_barang a JOIN (SELECT @rownum:=0) r
left join (select sum(masukmutasi) as masukmutasi, sum(keluarmutasi) as keluarmutasi,id_barang,id_gudang 
           from tx_mutasi $where GROUP BY id_barang) c on a.id_barang=c.id_barang) a
			";
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);