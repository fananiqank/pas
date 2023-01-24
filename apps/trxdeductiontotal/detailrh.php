<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

$tg=explode("_",$_GET[id]);
foreach($db->select("m_driver a join m_site b on a.id_site=b.id_site","a.*,b.nama_site","driver_id='$_GET[id]'") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr><th colspan= "2">Driver Name : <?=$val2[driver_name]?></th>
                <th colspan= "2">Site : <?=$val2[nama_site]?></th></tr>
            <tr>
                <th>No</th>
                <th>Tgl</th>
                <th>Type</th>
                <th style="text-align: center;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 

if($_GET[type] == 1){
    $vaval =$db->select("(select @rownum:=@rownum+1 norut,a.*,DATE(tddc_tglinput) tglinput,b.nama_ddc from txdeductiontotal a join m_deduction b on a.id_ddc=b.id_ddc join (SELECT @rownum:=0) r where driver_id ='$_GET[id]') a","*");
} else {
    $vaval = $db->select("(select @rownum:=@rownum+1 norut,a.*,DATE(ddcdriver_tgl) tglinput,b.nama_ddc,ddcdriver_jumlah as tddc_jumlah from txdeduction a join m_deduction b on a.id_ddc=b.id_ddc join (SELECT @rownum:=0) r where driver_id ='$_GET[id]') a","*");
}
foreach($vaval as $val){

    ?>

	   <tr>
            <td><?=$no?></td>
            <td><?=$val[tglinput]?></td>
            <td><?=$val[nama_ddc]?></td>
            <td align="right"><?=number_format($val[tddc_jumlah])?></td>
        </tr>
    <?php
    $no++;
    $ttdc +=$val[tddc_jumlah]; 
}
?>        
        <tr>
            <td colspan="3" style="text-align:right;"><b>Total</b></td>
            <td style="text-align:right;"><b><?=number_format($ttdc)?></b></td>
        </tr>     
				
        </tbody>
    </table>