<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();
$id = $_GET['id'];
foreach($db->select("(SELECT  @rownum:=@rownum+1 norut, a.*, b.cust_name FROM `tx_invoice` a JOIN m_customer b ON a.cust_id=b.cust_id JOIN (SELECT @rownum:=0) r) a where a.inv_id='$_GET[id]'","*") as $val2){}


?>
<div align="right" >
    <a href="apps/invoice/cetak_pdf.php?id=<?php echo $id; ?>" target="_blank" title="Cetak PDF"> <button type="button" class="btn btn-success ft-file"> PDF</button></a>
</div>
<br>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th colspan="2">Tgl Inv : <?=date("d/m/Y",strtotime($val2[inv_tgl]))?></th>
                <th colspan="2">Customer : <?=$val2[cust_name]?></th>
                <th colspan="2">No Inv : <?=$val2[inv_no]?></th>
            </tr>
           
            <tr>
                <th>No</th>
                <th>Uraian</th>
                <th style="text-align: center;">Ritase</th>
                <th style="text-align: center;">Tonase</th>
                <th style="text-align: center;">Jarak</th>
                <th style="text-align: center;">Harga</th>
                <th style="text-align: center;">Jumlah</th>

            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 
foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$_GET[id]') a","*") as $val){

    // if($p<>$val[invdtl_periode]){
    //     echo"Periode Ubah";
    //     $p=$val[periode];
    // }
    ?>

	<tr>
                <th><?=$val[norut]?></th>
                <th><?=$val[invdtl_uraian]?></th>
                <th style="text-align: right;"><?=$val[invdtl_ritase]?></th>
                <th style="text-align: right;"><?=number_format($val[invdtl_tonase],3)?></th>
                <th style="text-align: right;"><?=number_format($val[invdtl_jarak],3)?></th>
                <th style="text-align: right;"><?=number_format($val[invdtl_harga])?></th>
                <th style="text-align: right;"><?=number_format($val[invdtl_jumlah],2)?></th>

    </tr>
    <?php
    $no++;
}
?>          <tr>
                <td colspan="6" align="right"><strong>Sub Total</strong></td>
                <td align="right"><strong><?=number_format($val2[inv_subtotal],2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>PPN 11%</strong></td>
                <td align="right"><strong><?=number_format($val2[inv_ppn],2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>PPh (2%)</strong></td>
                <td align="right"><strong><?=number_format($val2[inv_pph],2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>Grand Total</strong></td>
                <td align="right"><strong><?=number_format($val2[inv_grandtotal],2)?></strong></td>
            </tr>
				
        </tbody>
    </table>
    