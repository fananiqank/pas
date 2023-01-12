<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("trx_basicpremi_driver a where a.txbaspre_id='$_GET[id]'","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Tgl Inv</th>
                <th><?=date("d/m/Y",strtotime($val2[txbaspre_tglinput]))?></th>
                <th></th>
                <th></th>
                <th>No Voucher</th>
                <th><?=$val2[txbaspre_no]?></th>
            </tr>           
            <tr>
                <th>No</th>
                <th>Driver</th>
                <th>Premi</th>
                <th>Basic</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 
foreach($db->select("(SELECT b.*, sum(case when left(txbaspredtl_uraian,5)='Premi' then txbaspredtl_ttl else 0 end) premi, sum(case when left(txbaspredtl_uraian,5)<>'Premi' then txbaspredtl_ttl else 0 end) basic, sum(txbaspredtl_ttl) grandtot FROM `trx_basicpremi_driver_dtl` a JOIN m_driver b USING(driver_id) where txbaspre_id='$_GET[id]' group by driver_id) a","*") as $val){

    ?>

	<tr>
            <td><?=$no?></td>
            <td><?=$val[driver_name]?></td>
            <td align="right"><?=number_format($val[premi],2)?></td>
            <td align="right"><?=number_format($val[basic],2)?></td>
            <td align="right"><?=number_format($val[grandtot],2)?></td>
            <td><a href='apps/trxpremidriver/cetakpremi.php?id=<?=$_GET[id]?>&dvr=<?=$val[driver_id]?>' class='label label-primary' style='cursor:pointer' title='print' target='_blank'><i class='ft-printer' aria-hidden='true' style='font-size:16px;'></i></a>
            <a href='apps/trxpremidriver/pdf.php?id=<?=$_GET[id]?>&dvr=<?=$val[driver_id]?>' class='label label-success' style='cursor:pointer' target='_blank' title='PDF'><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
            </td>

    </tr>
    <?php
    $no++;
    $tpre+=$val[premi];
    $tbas+=$val[basic];
    $tgt+=$val[grandtot];
}
?>          <tr>
                <td></td>
                <td><strong>Total</strong></td>
                <td align="right"><strong><?=number_format($tpre,2)?></strong></td>
                <td align="right"><strong><?=number_format($tbas,2)?></strong></td>
                <td align="right"><strong><?=number_format($tgt,2)?></strong></td>
                <td align="right"></td>
            </tr>
           
				
        </tbody>
    </table>