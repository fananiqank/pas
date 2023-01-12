<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();


$armada=$db->select("m_armada","*","arm_id='$_GET[id]'");

$norangka=$armada[0][arm_norangka];

$dtl=$db->select("m_armada a LEFT JOIN m_customer b ON a.cust_id=b.cust_id","arm_id, b.cust_name, arm_nolambung , arm_norangka","arm_norangka='$norangka'");
$no=1;
foreach($dtl as $vdtl){
?>
<tr>
    <td><?=$no?></td>
    <td><?=$vdtl[cust_name]?></td>
    <td><?=$vdtl[arm_nolambung]?></td>
    <td></td>
</tr>
<?php
$no++; 
} 
?>

