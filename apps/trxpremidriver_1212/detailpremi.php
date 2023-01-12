<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();


foreach($db->select("`trx_basicpremi_driver` where ('$_POST[txangkut_tgl1]' between txbaspre_tgl1 and txbaspre_tgl2) OR ('$_POST[txangkut_tgl2]' between txbaspre_tgl1 and txbaspre_tgl2)","count(*) c") as $no){}

if($no[c]){
    echo "Terdapat Periode Yang Pernah di posting";
} else {
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Driver</th>
                <th>No Lambung</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$cust=explode("_",$_POST[cust_id]);
$p=0;

// foreach($db->select("tx_invoice where '$_POST[tglmulai]' between inv_periode1 and inv_periode2 or '$_POST[tglmulai]' between inv_periode1 and inv_periode2","count(*) as ck") as $vk){}
// if($vk[ck]>0){
    // echo "Periode Laporan Telah Terbit Invoice";

// } else {

// $tbl="(select '' p, case when arm_type_armada='1' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, arm_type_armada, sum(tpremi) tpremi,sum(case when arm_type_armada='1' then ritase else tonase end) as x, case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x2,txangkut_nolambung from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 1 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.premidriver_type=c.arm_type_armada order by premidriver_id desc limit 1) premi, b.txangkut_nolambung from tx_ritase a 
//                             JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id
//                             JOIN m_armada c ON c.arm_id=b.arm_id where month(a.txangkut_tgl)='$_POST[bpbulan]' and year(a.txangkut_tgl)='$_POST[bptahun]') a) a group by arm_type_armada,txangkut_nolambung UNION ALL
// select '' as p, 'Basic' tipegaji, driver_id,'' , sum(basic) tbasic,sum(harikerja) harikerja,'Hari','X' from (select driver_id, count(driver_id) harikerja, (case when bhari>=30 then (basic/30)*count(driver_id) else (basic/bhari)*count(driver_id) end) as basic from (
// select *, DAY(LAST_DAY(NOW())) bhari, (select basicdriver_jumlah from m_basicdriver x where a.txangkut_tgl>=x.basicdriver_tglmulai order by basicdriver_id desc limit 1) basic from tx_ritase a where month(a.txangkut_tgl)='$_POST[bpbulan]' and year(a.txangkut_tgl)='$_POST[bptahun]') a group by driver_id, basic) a group by driver_id)a join m_driver b using(driver_id)";

$tbl="(select '' p, case when arm_type_armada='1' then 'Premi Ritase' else 'Premi Tonase' end as tipegaji,   driver_id, arm_type_armada, sum(tpremi) tpremi,sum(case when arm_type_armada='1' then ritase else tonase end) as x, case when arm_type_armada='1' then 'Ritase' else 'Tonase' end as x2,txangkut_nolambung from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 1 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, (select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.premidriver_type=c.arm_type_armada order by premidriver_id desc limit 1) premi, b.txangkut_nolambung from tx_ritase a 
                            JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id
                            JOIN m_armada c ON c.arm_id=b.arm_id where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]') a) a group by arm_type_armada,txangkut_nolambung UNION ALL
select '' as p, 'Basic' tipegaji, driver_id,'' , sum(basic) tbasic,sum(harikerja) harikerja,'Hari','X' from (select driver_id, count(driver_id) harikerja, (case when bhari>=30 then (basic/30)*count(driver_id) else (basic/bhari)*count(driver_id) end) as basic from (
select *, DAY(LAST_DAY(NOW())) bhari, (select basicdriver_jumlah from m_basicdriver x where a.txangkut_tgl>=x.basicdriver_tglmulai order by basicdriver_id desc limit 1) basic from tx_ritase a where date(a.txangkut_tgl) between '$_POST[txangkut_tgl1]' and '$_POST[txangkut_tgl2]') a group by driver_id, basic) a group by driver_id)a join m_driver b using(driver_id)";
// echo "$tbl";
foreach($db->select("$tbl","*") as $val){

	if($val[txangkut_nolambung]=='X'){
        $tx="";
    } else {
        $tx=$val[txangkut_nolambung];
    }
	echo "<tr>
                <td scope=\"row\">$no</td>
                <td>$val[driver_name] - $val[tipegaji]</td>
                <td>$tx</td>
                <td align='right'>$val[x2]</td>
                <td align='right'>$val[x]</td>
                <td align='right'>$val[x2]</td>
                <td align='right'>".number_format($val[tpremi],2)."</td>
            </tr>";
    $no++;
    if($val[tipegaji]=='Basic'){
    $tbas+=$val[tpremi];} else {
    $tpre+=$val[tpremi];}
    $subt+=$val[tpremi];
}
?>          
            <tr>
                <td colspan="6" align="right"><strong>Sub Total Basic</strong></td>
                <td align="right"><strong><?=number_format($tbas,2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>Grand Premi</strong></td>
                <td align="right"><strong><?=number_format($tpre,2)?></strong></td>
            </tr>
            <tr>
                <td colspan="6" align="right"><strong>Grand Total (Basic + Premi)</strong></td>
                <td align="right"><strong><?=number_format($subt,2)?></strong></td>
            </tr>
            
        </tbody>
    </table>
        <input type="hidden" id="tbas" name="tbas" value="<?=$tbas?>">
        <input type="hidden" id="tpre" name="tpre" value="<?=$tpre?>">
        <input type="hidden" id="subt" name="subt" value="<?=$subt?>">
<?php //} 
}
?>