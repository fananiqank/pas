<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

$tg=explode("_",$_GET[id]);
foreach($db->select("m_deduction a where a.id_ddc='$tg[2]'","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            
            <tr>
                <th>No</th>
                <th>Driver</th>
                <th>Armada</th>
                <th>Jumlah <?=$val2[nama_ddc]?></th>
                
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 

foreach($db->select("(select @rownum:=@rownum+1 norut, b.ddcdriver_id, ddcdriver_bulan,ddcdriver_tahun,a.driver_id, c.driver_name, id_ddc, sum(ddcdriver_jumlah) ddcdriver_jumlah,a.arm_id,concat((case when d.arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(d.arm_norangka,-5),'-',d.arm_nolambung) armadax from txdeduction a JOIN (SELECT max(ddcdriver_id) ddcdriver_id FROM txdeduction group by ddcdriver_bulan,ddcdriver_tahun,driver_id, id_ddc,arm_id) b 
ON a.ddcdriver_id=b.ddcdriver_id 
JOIN m_driver c ON c.driver_id=a.driver_id
LEFT JOIN m_armada d on a.arm_id=d.arm_id
JOIN (SELECT @rownum:=0) r where ddcdriver_bulan='$tg[0]' and ddcdriver_tahun='$tg[1]' and id_ddc='$tg[2]'
group by ddcdriver_bulan,ddcdriver_tahun, a.driver_id, id_ddc,arm_id) a",
"*") as $val){

    ?>

	<tr>
            <td><?=$no?></td>
            <td><?=$val[driver_name]?></td>
            <td><?=$val[armadax]?></td>
            <td align="right"><?=number_format($val[ddcdriver_jumlah],2)?></td>
            

    </tr>
    <?php
    $no++;

}
?>          
           
				
        </tbody>
    </table>