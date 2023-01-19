<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();
$id = $_GET['id'];
$q1 = "delete from tx_invoice where inv_id='$_GET[id]'";
$q2 = "delete from tx_invoice_dtl where inv_id='$_GET[id]'";

$db->query($q1);
$db->query($q2);

// echo "$q1 X $q2";
?>

    