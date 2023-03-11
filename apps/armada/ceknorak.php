<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();


$armada=$db->selectcount("m_armada","*","arm_norangka='$_GET[val]'");
echo $armada;
?>
