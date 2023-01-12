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
	$where = "where id_gudang = $_GET[id]";
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
	array('db'      => 'nama_satuan','dt'   => 3, 'field' => 'nama_satuan',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	
	array('db'      => 'min_stock','dt'   => 4, 'field' => 'min_stock',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => '0','dt'   => 5, 'field' => '0',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	array('db'      => 'min_stock','dt'   => 6, 'field' => 'min_stock',
		   'formatter' => function( $d, $row ) {
			
			return"$d";
					 
			}
		  ),
	
	array('db'      => 'balance','dt'   => 5, 'field' => 'balance',
		   'formatter' => function( $d, $row ) {
		   	//$exp = explode('_',$d);
				if($d < 0){
					return "<font style='color:red'>Dibawah Min. Stock</font>";
				} else {
					return "<font style='color:green'></font>";
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

$joinQuery = "FROM (select * from 
(select @rownum:=@rownum+1 no_urut,a.*,
concat(ifnull(b.masukmutasi,0),'_',ifnull(b.keluarmutasi,0),'_',ifnull(b.harga,0)) as persediaan,ifnull(b.harga,0) as hpp_mutasi,d.nama_satuan,zz.nama_gudang
from m_barang a 
left join m_satuan d on a.id_satuan=d.id_satuan
left join (
	select max(tx_mutasi.id_mutasi) AS id_mutasi,tx_mutasi.id_gudang AS id_gudang,tx_mutasi.id_barang AS id_barang from tx_mutasi where tgl_mutasi<='2022-08-27' and id_gudang = 2 group by tx_mutasi.id_gudang,tx_mutasi.id_barang
) bb on a.id_barang=bb.id_barang 
left join tx_mutasi b on bb.id_mutasi=b.id_mutasi
left join m_gudang zz on b.id_gudang=zz.id_gudang
JOIN (SELECT @rownum:=0) r) as asi ) as a 
			";
			
$extraWhere = "";        

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);