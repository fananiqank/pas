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
    <input style="height:26px; line-height: 0;" type="button" id="donexel" class="btn btn-info" value="Excel"  onclick="tableToExcel('lapinvoicemutasi')"></button>
    <table class="table table-striped table-bordered" id="lapinvoicemutasi" style="margin-bottom: 1%;font-size: 11px;border-collapse: separate;font-weight: 600px;">
                <thead style=" position: sticky; top: 0; z-index: 1;background-color: white;color: black">
                     <tr><td colspan="11" align="left" style="color:black;font-size:12px;">Laporan Invoice <br> Periode <?=$judul?></td></tr>
                    
                    <tr>
                        <th width="3%">No</th>
                        <th width="8%">Tanggal</th>
                        <th width="8%">Shift</th>
                        <th width="8%">Cust</th>
                        <th width="8%">Rom</th>
                        <th width="20%">Lambung</th>
                        <th width="20%">Driver</th>
                        <th width="8%">Ritase</th>
                        <th width="8%">Tonase</th>
                        <th width="8%">Jarak</th>
                        <th width="8%">Harga</th>
                        <th width="8%">Jumlah Harga</th>
                    </tr>           
                </thead>
                <tbody>
                     <?php $no=1;

                        if($_GET['cust'] != ''){
                            $cust = "and e.cust_id = '$_GET[cust]'";
                            $cst="AND cust_id='$_GET[cust]'";
                        } else {
                            $cust = "";
                            $cst = "";
                        }

                        if($_GET['sf'] != ''){
                            $sfh = "and a.txangkut_shift = '$_GET[sf]'";
                        } else {
                            $sfh = "";
                        }

$datainv=$db->select("(SELECT GROUP_CONCAT(invdtl_ritdtl) dt FROM `tx_invoice` a JOIN tx_invoice_dtl b using(inv_id) where ('$_GET[tg1]' between inv_periode1 and inv_periode2 or '$_GET[tg2]' between inv_periode1 and inv_periode2) $cst) a","*");
foreach($datainv as $vdatainv){}
 //    echo "(select txangkut_tgl, '' txangkut_shift,  m_customer.cust_codecust_code, rom_name, txangkut_nolambung armada,  driver_name, txangkut_ritase rit, txangkut_tonase tonase,txangkut_jarak rutejarak_jarak,invdtl_harga tarif_harga,invdtl_harga*txangkut_tonase*(txangkut_jarak/txangkut_ritase) total from (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where cust_id=c.cust_id and type_armada=c.arm_type_armada and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) 
 // JOIN m_armada c ON c.arm_nolambung=b.txangkut_nolambung
 // where trxangkutdtl_id in ($vdatainv[dt]))a 
 // JOIN tx_invoice_dtl ON invdtl_ritdtl like CONCAT('%', trxangkutdtl_id ,'%')
 // JOIN tx_invoice ON tx_invoice.inv_id=tx_invoice_dtl.inv_id
 // JOIN m_customer ON m_customer.cust_id=tx_invoice.cust_id
 // JOIN m_rutejarak ON m_rutejarak.rutejarak_id=a.rutejarak_id
 // JOIN m_runofmine ON m_runofmine.rom_id=m_rutejarak.rom_id
 // JOIN m_tujuan ON m_tujuan.tujuan_id=m_rutejarak.tujuan_id
 // JOIN m_driver ON m_driver.driver_id=a.driver_id)a";
$persediaan=$db->select("(select txangkut_tgl, '' txangkut_shift,  m_customer.cust_code cust_code, rom_name, txangkut_nolambung armada,  driver_name, txangkut_ritase rit, txangkut_tonase tonase,txangkut_jarak rutejarak_jarak,invdtl_harga tarif_harga,invdtl_harga*txangkut_tonase*(txangkut_jarak/txangkut_ritase) total from (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where cust_id=c.cust_id and type_armada=c.arm_type_armada and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) 
 JOIN m_armada c ON c.arm_nolambung=b.txangkut_nolambung
 where trxangkutdtl_id in ($vdatainv[dt]))a 
 JOIN tx_invoice_dtl ON invdtl_ritdtl like CONCAT('%', trxangkutdtl_id ,'%')
 JOIN tx_invoice ON tx_invoice.inv_id=tx_invoice_dtl.inv_id
 JOIN m_customer ON m_customer.cust_id=tx_invoice.cust_id
 JOIN m_rutejarak ON m_rutejarak.rutejarak_id=a.rutejarak_id
 JOIN m_runofmine ON m_runofmine.rom_id=m_rutejarak.rom_id
 JOIN m_tujuan ON m_tujuan.tujuan_id=m_rutejarak.tujuan_id
 JOIN m_driver ON m_driver.driver_id=a.driver_id)a",'*');


//                           $persediaan = $db->select("(SELECT a.txangkut_tgl,e.rom_name,rit,tonase,e.rutejarak_jarak,concat(e.norangka,'-',e.arm_nolambung) armada,e.cust_id,f.tarif_harga,
// (tonase * f.tarif_harga) total,a.txangkut_shift,g.cust_code,e.driver_name
// FROM `tx_ritase` a JOIN m_site b ON a.id_site=b.id_site 
// JOIN (SELECT a.txangkut_id,c.tujuan_name, d.rom_name, e.driver_name,f.arm_nolambung,SUBSTR(f.arm_norangka,-5) norangka,sum(txangkut_ritase) rit,sum(txangkut_tonase) tonase,f.cust_id,b.rutejarak_jarak,b.rutejarak_id FROM `tx_ritase_dtl` a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_tujuan c ON c.tujuan_id=b.tujuan_id JOIN m_runofmine d ON d.rom_id=b.rom_id JOIN m_driver e ON e.driver_id=a.driver_id join m_armada f on a.arm_id=f.arm_id GROUP BY txangkut_id,a.arm_id,rom_name) e 
// on a.txangkut_id=e.txangkut_id
// join (select max(tarif_tglmulai) tgl_mulai,cust_id,rutejarak_id,tarif_harga from m_tarif GROUP BY cust_id,rutejarak_id) f on e.rutejarak_id=f.rutejarak_id 
// left join m_customer g on e.cust_id=g.cust_id
// where a.txangkut_tgl between '$_GET[tg1]' and '$_GET[tg2]' $cust $sfh
//  ) as asi","*","","txangkut_tgl,txangkut_shift ASC");
 
//  echo "SELECT a.txangkut_tgl,e.rom_name,rit,tonase,e.rutejarak_jarak,concat(e.norangka,'-',e.arm_nolambung) armada,e.cust_id,f.tarif_harga,
// (tonase * f.tarif_harga) total,a.txangkut_shift,g.cust_code,e.driver_name
// FROM `tx_ritase` a JOIN m_site b ON a.id_site=b.id_site 
// JOIN (SELECT a.txangkut_id,c.tujuan_name, d.rom_name, e.driver_name,f.arm_nolambung,SUBSTR(f.arm_norangka,-5) norangka,sum(txangkut_ritase) rit,sum(txangkut_tonase) tonase,f.cust_id,b.rutejarak_jarak,b.rutejarak_id FROM `tx_ritase_dtl` a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_tujuan c ON c.tujuan_id=b.tujuan_id JOIN m_runofmine d ON d.rom_id=b.rom_id JOIN m_driver e ON e.driver_id=a.driver_id join m_armada f on a.arm_id=f.arm_id GROUP BY txangkut_id,a.arm_id,rom_name) e 
// on a.txangkut_id=e.txangkut_id
// join (select max(tarif_tglmulai) tgl_mulai,cust_id,rutejarak_id,tarif_harga from m_tarif GROUP BY cust_id,rutejarak_id) f on e.rutejarak_id=f.rutejarak_id 
// left join m_customer g on e.cust_id=g.cust_id
// where a.txangkut_tgl between '$_GET[tg1]' and '$_GET[tg2]' $cust $sfh
//  ";                         
                    foreach ($persediaan as $arrdt) {
                     ?>
                    <tr>
                        <td align="left"><?php echo $no; ?></td>
                        <td align="left"><?php echo $arrdt['txangkut_tgl']?></td>
                        <td align="left"><?php echo $arrdt['txangkut_shift']?></td>
                        <td align="left"><?php echo $arrdt['cust_code']?></td>
                        <td align="left"><?php echo $arrdt['rom_name']?></td>
                        <td align="left"><?php echo $arrdt['armada']?></td>
                        <td align="left"><?php echo $arrdt['driver_name']?></td>
                        <td align="right"><?php echo number_format($arrdt['rit'])?></td>
                        <td align="right"><?php echo number_format($arrdt['tonase'],2)?></td>
                        <td align="right"><?php echo number_format($arrdt['rutejarak_jarak'],2)?></td>
                        <td align="right"><?php echo number_format($arrdt['tarif_harga'])?></td>
                        <td align="right"><?php echo number_format($arrdt['total'])?></td>
                        
                    </tr>
                   <?php $no++;
                         $totalrit += $arrdt['rit'];
                         $totalton += $arrdt['tonase'];
                         $totalrute += $arrdt['rutejarak_jarak'];
                         $totaltarif += $arrdt['total'];

                    } ?>
                    <tr>
                        <td colspan="7">Total</td>
                        <td align="right"><?=number_format($totalrit)?></td>
                        <td align="right"><?=number_format($totalton)?></td>
                        <td align="right"><?=number_format($totalrute)?></td>
                        <td>&nbsp;</td>
                        <td align="right"><?=number_format($totaltarif)?></td>

                    </tr>
                    <tr>
                        <td colspan="7">PPN 11%</td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td>&nbsp;</td>
                        <td align="right"><?=number_format($totaltarif*(11/100))?></td>
                    </tr>
                    <tr>
                        <td colspan="7">PPh 2%</td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td>&nbsp;</td>
                        <td align="right"><?=number_format($totaltarif*(2/100))?></td>
                    </tr>
                    <tr>
                        <td colspan="7">Grand Total</td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td>&nbsp;</td>
                        <td align="right"><?=number_format($totaltarif+($totaltarif*(11/100))+($totaltarif*(2/100)))?></td>
                    </tr>
                </tbody>
    </table>