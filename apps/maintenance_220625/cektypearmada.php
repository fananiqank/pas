<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("m_armada","arm_status_milik","arm_id = $_POST[arm_id]")as $val){}

	echo $val[arm_status_milik];
?>