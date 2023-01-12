<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Uraian</th>
                <th>Ritase</th>
                <th>Tonase</th>
                <th>Jarak</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$cust=explode("_",$_POST[cust_id]);
$p=0;

foreach($db->select("tx_invoice where ('$_POST[tglmulai]' between inv_periode1 and inv_periode2 or '$_POST[tglmulai]' between inv_periode1 and inv_periode2) and cust_id='$cust[0]' and arm_type_armada='$_POST[arm_type_armada]'","count(*) as ck") as $vk){}
    // echo "tx_invoice where ('$_POST[tglmulai]' between inv_periode1 and inv_periode2 or '$_POST[tglmulai]' between inv_periode1 and inv_periode2) and cust_id='$cust[0]' and arm_type_armada='$_POST[arm_type_armada]'";
if($vk[ck]>0){
    echo "Periode Laporan Telah Terbit Invoice";

} else {
// echo "SELECT a.rutejarak_id, concat(rom_name,' - ',tujuan_name) as uraian, sum(txangkut_tonase) ton, sum(txangkut_ritase) ritase,sum(txangkut_jarak) jarak, tarif, group_concat(trxangkutdtl_id) as idtxangkut_dtl,periode FROM (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where rutejarak_id=b.rutejarak_id and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) where txangkut_tgl between '$_POST[tglmulai]' and '$_POST[tglakhir]' and left(b.txangkut_nolambung,3)='$cust[1]') a 
//  JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id
//  JOIN m_runofmine c ON c.rom_id=b.rom_id
//  JOIN m_tujuan d ON d.tujuan_id=b.tujuan_id
//  group by rutejarak_id, tarif, periode";
foreach($db->select("(SELECT a.rutejarak_id, concat(rom_name,' - ',tujuan_name) as uraian, sum(txangkut_tonase) ton, sum(txangkut_ritase) ritase,sum(txangkut_jarak) jarak, tarif, group_concat(trxangkutdtl_id) as idtxangkut_dtl,periode FROM (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where cust_id=c.cust_id and type_armada=c.arm_type_armada and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) 
    JOIN m_armada c ON c.arm_nolambung=b.txangkut_nolambung
    where txangkut_tgl between '$_POST[tglmulai]' and '$_POST[tglakhir]' and left(b.txangkut_nolambung,3)='$cust[1]' and arm_type_armada='$_POST[arm_type_armada]' ) a 
 JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id
 JOIN m_runofmine c ON c.rom_id=b.rom_id
 JOIN m_tujuan d ON d.tujuan_id=b.tujuan_id
 group by rutejarak_id, tarif, periode) a","*") as $val){



	$ttarif=$val[tarif]*$val[ton]*($val[jarak]/$val[ritase]);
	echo "<tr>
                <td scope=\"row\">$no</td>
                <td>$val[uraian]</td>
                <td align='right'>$val[ritase]</td>
                <td align='right'>$val[ton]</td>
                <td align='right'>". ($val[jarak]/$val[ritase]) ."</td>
                <td align='right'>$val[tarif]</td>
                <td align='right'>".number_format($ttarif,2)."</td>
            </tr>";
    $no++;
    $subt+=$ttarif;
}
?>          <tr>
                <td colspan="6" align="right"><strong>Sub Total</strong></td>
                <td align="right"><strong><?=number_format($st=$subt,2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>PPN 11%</strong></td>
                <td align="right"><strong><?=number_format($ppn=($subt*11)/100,2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>PPh (2%)</strong></td>
                <td align="right"><strong><?=number_format($pph=($subt*2)/100,2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>Grand Total</strong></td>
                <td align="right"><strong><?=number_format($pph+$st+$ppn,2)?></strong></td>
            </tr>
        </tbody>
    </table>
        <input type="hidden" id="st" name="st" value="<?=$st?>">
        <input type="hidden" id="ppn" name="ppn" value="<?=$ppn?>">
        <input type="hidden" id="pph" name="pph" value="<?=$pph?>">
        <input type="hidden" id="gt" name="gt" value="<?=$pph+$st+$ppn?>">
<?php } ?>