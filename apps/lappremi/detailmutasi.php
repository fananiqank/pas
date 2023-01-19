<?php 
if($_GET['tg1']){
    session_start();
    require_once "../../webclass.php";
    $db = new kelas();
    $judul = $_GET['tg1'].' - '.$_GET['tg2'];
} else {
    $judul = date('Y')."-".date('m');
}

$bulan = date('m');
$bulan1 = date('m')-1;
$tahun = date('Y');
if($bulan == '12'){
    $tahun1 = date('Y')-1;
} else {
    $tahun1 = date('Y');
}

foreach($db->select("m_customer","*","cust_id = '$_GET[cust]'") as $cs){}
foreach($db->select("(select count(*) jmlarm from m_armada $whr) a","*") as $jarm){}
$colsp = 3+$jarm['jmlarm'];
$carmada = $db->select("(select *,SUBSTR(arm_norangka,-5) norangka,concat((case when arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(arm_norangka,-5),'-',arm_nolambung) armadax,concat(SUBSTR(arm_norangka,-5),'-',arm_nolambung) armada from m_armada order by arm_type_armada DESC) a","*");

?>
<style type="text/css">
    .dailywip tr > :first-child {
          position: -webkit-sticky;
          position: sticky; 
          background: white;
          left: 0; 
        }
    .dailywip tr > :nth-child(2) {
          position: -webkit-sticky;
          position: sticky; 
          background: white;
          color: black;
          left: 64px; 
        }
    .dailywip tr > :nth-child(3) {
          position: -webkit-sticky;
          position: sticky; 
          background: white;
          color: black;
          left: 150px; 
        }
</style>
    <input style="height:26px; line-height: 0;" type="button" id="donexel" class="btn btn-info" value="Excel"  onclick="tableToExcel('laptargetharianmutasi')"></button>
    <table class="table table-striped table-bordered dailywip" id="laptargetharianmutasi" style="margin-bottom: 1%;font-size: 11px;border-collapse: separate;font-weight: 600px;">
                <thead style=" position: sticky; top: 0; z-index: 1;background-color: white;color: black">
                     <tr><td colspan="9" align="left" style="color:black;font-size:12px;">Laporan Premi Driver <br> Periode <?=$judul?></td></tr>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Post</th>
                        <th>Driver</th>
                        <th>Premi</th>
                        <th>Absensi</th>
                        <th>Tonase</th>
                        <th>Ritase</th>
                        <th>Total (Rp)</th>
                    </tr>           
                </thead>
                <tbody>
                     <?php $no=1;
                           
                          $persediaan = $db->select("(SELECT c.txbaspre_tglinput,b.driver_name, sum(case when left(txbaspredtl_uraian,5)='Premi' then txbaspredtl_ttl else 0 end) premi, 
(select sum(hadirdriver_jumlah) as jumhadir from txkehadiran b where hadirdriver_tgl between DATE(txbaspre_tgl1) and DATE(txbaspre_tgl2) and driver_id = a.driver_id) as jumhadir,
sum(case when a.txbaspredtl_jenis = 'Tonase' then a.txbaspredtl_jumlah else 0 end ) tonase,
sum(case when a.txbaspredtl_jenis = 'Ritase' then a.txbaspredtl_jumlah else 0 end ) ritase,
sum(case when left(txbaspredtl_uraian,5)<>'Premi' then txbaspredtl_ttl else 0 end) basic, sum(txbaspredtl_ttl) grandtot,
txbaspre_tgl1,txbaspre_tgl2,a.driver_id
FROM `trx_basicpremi_driver_dtl` a JOIN m_driver b USING(driver_id) join trx_basicpremi_driver c on a.txbaspre_id=c.txbaspre_id 
where DATE(c.txbaspre_tglinput) between '$_GET[tg1]' and '$_GET[tg2]' group by a.driver_id,c.txbaspre_tglinput) as asi","*");
                          
                      
                     foreach($persediaan as $vdtwo){
                     ?>
                    <tr>
                        <td align="left"><?php echo $no; ?></td>
                        <td align="left"><?php echo $vdtwo['txbaspre_tglinput']?></td>
                        <td align="left"><?php echo $vdtwo['driver_name']?></td>
                        <td align="right"><?php echo number_format($vdtwo['premi'])?></td>
                        <td align="right"><?php echo number_format($vdtwo['jumhadir'])?></td>
                        <td align="right"><?php echo number_format($vdtwo['tonase'],2)?></td>
                        <td align="right"><?php echo number_format($vdtwo['ritase'])?></td>
                        <td align="right"><?php echo number_format($vdtwo['grandtot'])?></td>
                    </tr>
                   <?php $no++;
                         $jrit +=$vdtwo['ritase'];
                         $jton +=$vdtwo['tonase'];
                         $ttltotal+=$vdtwo['grandtot'];
                    } ?>
                    <tr>
                        <td align="right" colspan="5"><b>Total</b></td>
                        <td align="right"><b><?=number_format($jton,2)?></b></td>
                        <td align="right" ><b><?=number_format($jrit)?></b></td>
                        <td align="right" ><b><?=number_format($ttltotal)?></b></td>
                    </tr>
                </tbody>
    </table>