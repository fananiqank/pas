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
if($_GET['cust'] <> ""){
    $whr = "where cust_id = '$_GET[cust]'";
} else {
    $whr = "";
}
foreach($db->select("m_customer","*","cust_id = '$_GET[cust]'") as $cs){}
foreach($db->select("(select count(*) jmlarm from m_armada $whr) a","*") as $jarm){}
$colsp = 3+$jarm['jmlarm'];
$carmada = $db->select("(select *,SUBSTR(arm_norangka,-5) norangka,concat(SUBSTR(arm_norangka,-5),'-',arm_nolambung) armadax,concat((case when arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(arm_norangka,-5),'-',arm_nolambung) as armada from m_armada $whr order by arm_id) a","*");

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
    <input style="height:26px; line-height: 0;" type="button" id="donexel" class="btn btn-info" value="Excel"  onclick="tableToExcel('laptranshaulingmutasi')"></button>
    <table class="table table-striped table-bordered dailywip" id="laptranshaulingmutasi" style="margin-bottom: 1%;font-size: 11px;border-collapse: separate;font-weight: 600px;">
                <thead style=" position: sticky; top: 0; z-index: 1;background-color: white;color: black">
                    <tr><td colspan="<?php echo $colsp; ?>" align="left" style="color:black;font-size:12px;">Laporan Transaksi Hauling <br> Periode <?=$judul?></td></tr>
                    <tr>
                        <th width="3%">No</th>
                        <th width="8%">Tanggal</th>
                        <th width="8%">Driver</th>
                        <th width="10%">No Lambung</th>
                        <th>SK</th>
                        <th>ROM</th>
                        <th>Dumping</th>
                        <th>Tonase</th>
                        
                    </tr>           
                </thead>
                <tbody>
                     <?php $no=1;
                        
                            if($_GET[arm] <> ''){
                                $arm = "and arm_id = $_GET[arm]";
                            } else {
                                $arm = "";
                            }

                            if($_GET[cust] <> ''){
                                $cust = "and e.cust_id = $_GET[cust]";
                            } else {
                                $cust = "";
                            }

                            if($_GET[tg1] <> '') {
                                $tglbet1 = "DATE(tgl_mutasi) < '$_GET[tg1]'";
                                $tglbet = "DATE(tgl_mutasi) between '$_GET[tg1]' and '$_GET[tg2]'";
                                $judulsaldo = "Saldo Akhir sampai tanggal ".date('Y-m-d', strtotime("-1 day", strtotime($_GET[tg1])));
                            } else {
                                $tglbet1 = "MONTH(tgl_mutasi) = '$bulan1' and YEAR(tgl_mutasi) = '$tahun1'";
                                //$tglbet = "MONTH(tgl_mutasi) = '$bulan' and YEAR(tgl_mutasi) = '$tahun'";
                                $tglbet = "YEAR(tgl_mutasi) = '$tahun'";
                                $judulsaldo = "Saldo Bulan Lalu ".$tahun1."-".$bulan1;
                            }
                           
                          $persediaan = $db->select("(SELECT a.txangkut_tgl,e.rom_name,tujuan_name,concat((case when e.arm_type_armada = 1 then 'DT' else 'SDT' end),'-',norangka,'-',e.arm_nolambung) as armada,rit,tonase,e.driver_name,nosk
FROM `tx_ritase` a JOIN m_site b ON a.id_site=b.id_site 
JOIN (SELECT a.txangkut_id,c.tujuan_name, d.rom_name, e.driver_name,f.arm_nolambung,SUBSTR(f.arm_norangka,-5) norangka,sum(txangkut_ritase) rit,sum(txangkut_tonase) tonase,f.cust_id,f.arm_type_armada,nosk FROM `tx_ritase_dtl` a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_tujuan c ON c.tujuan_id=b.tujuan_id JOIN m_runofmine d ON d.rom_id=b.rom_id left JOIN m_driver e ON e.driver_id=a.driver_id
join m_armada f on a.arm_id=f.arm_id GROUP BY trxangkutdtl_id,txangkut_id,a.arm_id,rom_name) e 
on a.txangkut_id=e.txangkut_id
where a.txangkut_tgl between '$_GET[tg1]' and '$_GET[tg2]' $cust
 ORDER BY a.txangkut_tgl) as asi","*");
                          

                        foreach ($persediaan as $arrdt) {
                              $txangkut_tgl=$arrdt[txangkut_tgl];
                              $romname=$arrdt[rom_name];
                              $armada=$arrdt[armada];
                              $driver_name=$arrdt[driver_name];
                              $armada=$arrdt[armada];
                              $nosk=$arrdt[nosk];
                              $rom=$arrdt[rom_name];
                              $tujuan_name=$arrdt[tujuan_name];
                              $tonase=$arrdt[tonase];
                              
                              
                            
                     ?>
                    <tr>
                        <td align="left"><?php echo $no; ?></td>
                        <td align="left"><?php echo $txangkut_tgl?></td>
                        <td align="left"><?php echo $driver_name?></td>
                        <td align="left"><?php echo $armada?></td>
                        <td align="left"><?php echo $nosk?></td>
                        <td align="left"><?php echo $rom?></td>
                        <td align="left"><?php echo $tujuan_name?></td>
                        <td align="left"><?php echo $tonase?></td>
                        
                        <!-- <td><a href='index.php?x=stockmutasi&id=<?=$arrdt[id_barang]?>&gd=<?=$_GET[gd]?>&jns=<?=$_GET[jns]?>&tg1=<?=$_GET[tg1]?>&tg2=<?=$_GET[tg2]?>&r=1' target='_blank'>Mutasi</a></td> -->
                    </tr>
                   <?php $no++;
                         $jrit +=$tirit;
                         $jton +=$tonase;
                    } ?>
                    <tr>
                        <td colspan="7" align="center"><b>Total</b></td>
                        
                        <?php
                            
                            echo "<td><b>".number_format($jton,2)."</b></td>";
                        ?>
                    </tr>
                </tbody>
    </table>