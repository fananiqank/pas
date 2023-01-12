<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("trx_basicpremi_driver a where a.txbaspre_id='$_GET[id]'","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <!-- <tr>
                <th>Tgl Inv</th>
                <th><?=date("d/m/Y",strtotime($val2[txbaspre_tglinput]))?></th>
                <th></th>
                <th></th>
                <th>No Voucher</th>
                <th><?=$val2[txbaspre_no]?></th>
            </tr> -->           
            <tr>
                <th>No</th>
                <th>Driver</th>
                <th>Jumlah Hari</th>
                
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 
$tg=explode("_",$_GET[id]);
foreach($db->select("(select @rownum:=@rownum+1 norut, b.hadirdriver_id, hadirdriver_bulan,hadirdriver_tahun,a.driver_id, c.driver_name, hadirdriver_type, sum(hadirdriver_jumlah) hadirdriver_jumlah from txkehadiran a JOIN (SELECT max(hadirdriver_id) hadirdriver_id FROM txkehadiran group by hadirdriver_bulan,hadirdriver_tahun,driver_id, hadirdriver_type) b 
ON a.hadirdriver_id=b.hadirdriver_id 
JOIN m_driver c ON c.driver_id=a.driver_id
JOIN (SELECT @rownum:=0) r where hadirdriver_bulan='$tg[0]' and hadirdriver_tahun='$tg[1]' and hadirdriver_type='$tg[2]'
group by hadirdriver_bulan,hadirdriver_tahun, a.driver_id, hadirdriver_type) a","*") as $val){

    ?>

	<tr>
            <td><?=$no?></td>
            <td><?=$val[driver_name]?></td>
            <td align="right"><?=number_format($val[hadirdriver_jumlah],2)?></td>
            

    </tr>
    <?php
    $no++;

}
?>          
           
				
        </tbody>
    </table>