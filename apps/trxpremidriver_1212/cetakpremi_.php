<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("m_driver a JOIN m_armada b ON a.driver_armada=b.arm_id","a.*,b.arm_nolambung","driver_id = $_GET[id]") as $head){}

foreach($db->select("(SELECT sum(case when left(txbaspredtl_uraian,5)<>'Premi' then txbaspredtl_jumlah else 0 end) as hari, sum(case when left(txbaspredtl_uraian,5)<>'Premi' then txbaspredtl_ttl else 0 end) basic, sum(txbaspredtl_ttl) grandtot,txbaspre_tgl1,txbaspre_tgl2,DATEDIFF(txbaspre_tgl2,txbaspre_tgl1) as jumlah_hari
FROM `trx_basicpremi_driver_dtl` a JOIN m_driver b USING(driver_id) JOIN trx_basicpremi_driver c 
USING(txbaspre_id) where txbaspre_id='$_GET[id]' group by driver_id) a","*") as $basic){}

$perawatanunit = '500000';
$dayrawatunit = ($perawatanunit/$basic['jumlah_hari']);
$totalrawat = (round(($dayrawatunit*$basic['hari'])  / 100, 0)) * 100;
$upah = '0';

?>

<table width="800" border="0" cellpadding="1" cellspacing="0" id="testTable">
    <tr>
    <td align="center" >
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="5" align="center"><h3><u>SLIP GAJI KARYAWAN</u><br><font style="font-size: 16px">Periode: <?=date('d-M-Y',strtotime($basic['txbaspre_tgl1']))?> - <?=date('d-M-Y',strtotime($basic['txbaspre_tgl2']))?></font></h3>
          </td>
        </tr>
        <tr>
          <td class="tx" colspan="5" align="center"></td>
        </tr>
        <tr>
          <td>Nama</td>
          <td>: <?=$head['driver_name']?></td>
          <td colspan="3" rowspan="3" align="center">TF dari rekening om wawan</td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>: Driver</td>
          
        </tr>
        <tr>
          <td>No. Lambung</td>
          <td>: <?=$head['arm_nolambung']?></td>
          
        </tr>
        <tr>
          <td class="tx" colspan="5" align="center"><h4><?php echo $ak?></h4><hr style="border:double"></td>
        </tr>
      </table>
      <table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size: 14px;">
        <thead>
          <tr>
            <th width="5%" style="padding: 5px;">No</th>
            <th width="20%">HAULING</th>
            <th width="15%">JUMLAH RITASE</th>
            <th width="20%">UPAH/RIT</th>
            <th width="20%">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $no = 1;
                    
              foreach($db->select("(SELECT txbaspredtl_jumlah,upahrit,txbaspredtl_ttl FROM trx_basicpremi_driver a JOIN trx_basicpremi_driver_dtl b ON a.txbaspre_id = b.txbaspre_id JOIN m_driver c ON b.driver_id = c.driver_id
                JOIN (SELECT 'Ritase' AS ritase, premidriver_jumlah AS upahrit FROM m_premidriver WHERE premidriver_type = 1 
                ORDER BY premidriver_tglmulai DESC LIMIT 1) as d 
                ON b.txbaspredtl_jenis = d.ritase where b.driver_id = $_GET[dvr]) as a","*") as $val){
          ?>
            <tr>
              <td align="center"><?=$no?></td>
              <td >&nbsp;</td>
              <td align="center"><?=number_format($val['txbaspredtl_jumlah'])?></td>
              <td >&ensp;Rp <span style="float: right;"><?=number_format($val['upahrit'])?>&nbsp;</span></td>
              <td >&ensp;Rp <span style="float: right;"><?=number_format($val['txbaspredtl_ttl'])?>&nbsp;</td>
            </tr>
          <?php $no++; 
                $totalrit += $val['txbaspredtl_ttl'];
          } 
                $grandtotal = $totalrit+$basic['basic']+$totalrawat;
          ?>
            <tr>
              <td colspan="2">Basic <?=$basic['jumlah_hari']?> Hari</td>
              <td align="center"><?=number_format($basic['hari'])?></td>
              <td >&ensp;Rp <span style="float: right;"><?=number_format($upah)?>&nbsp;</span></td>
              <td >&ensp;Rp <span style="float: right;"><?=number_format($basic['basic'])?>&nbsp;</span></td>
            </tr>
            <tr>
              <td colspan="2">Perawatan Unit</td>
              <td >&nbsp;</td>
              <td >&ensp;Rp <span style="float: right;"><?=number_format($perawatanunit)?>&nbsp;</span></td>
              <td >&ensp;Rp <span style="float: right;"><?=number_format($totalrawat)?>&nbsp;</span></td>
            </tr>
            <tr>
              <td colspan="4">Potongan BPJS</td>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">Potongan Lain-lain</td>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><b>Total</b></td>
              <td ><b>&ensp;Rp <span style="float: right;"><?=number_format($grandtotal)?>&nbsp;</span></b></td>
            </tr>
        </tbody>
           
      </table>
      
      
      