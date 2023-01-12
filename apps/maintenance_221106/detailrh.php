<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, b.arm_norangka,b.arm_nopol,b.arm_nolambung FROM m_armada b JOIN (SELECT @rownum:=0) r where b.arm_id='$_GET[id]') a","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No Rangka</th>
                <th><?=$val2[arm_norangka]?></th>
                <th>Nopol</th>
                <th><?=$val2[arm_nopol]?></th>
            </tr>
            <tr>
                <th>No Lambung</th>
                <th><?=$val2[arm_nolambung]?></th>
            </tr>
        </thead>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No Mtc</th>
                <th>Tgl</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*,DATE(a.tgl_mtc) as tglshow,b.arm_norangka,b.arm_nopol,b.arm_nolambung,supp_nama FROM tx_maintenance a JOIN m_armada b ON a.arm_id=b.arm_id JOIN (SELECT @rownum:=0) r JOIN m_supplier c on a.supp_mtc=c.supp_id where a.arm_id='$_GET[id]') a","*") as $val){

	
	echo "<tr data-toggle='collapse' data-target='#$val[no_mtc]' style='cursor:pointer'>
                <td scope=\"row\">$no</td>
                <td>$val[no_mtc]</td>
                <td>$val[tglshow]</td>
            </tr>
            <tr id='$val[no_mtc]' class='collapse'>
                <td colspan=4>$val[supp_nama] : $val[keterangan_mtc]</td>
            </tr>";
    $no++;
}
?>      
        </tbody>
    </table>