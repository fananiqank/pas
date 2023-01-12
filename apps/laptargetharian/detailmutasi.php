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
                     <tr><td colspan="<?php echo $colsp; ?>" align="left" style="color:black;font-size:12px;">Laporan Target Harian Armada <br> Periode <?=$judul?></td></tr>
                    <tr>
                        <th width="3%">&nbsp;</th>
                        <th width="8%">&nbsp;</th>
                        <th>&nbsp;</th>
                        <?php 
                            foreach($carmada as $cd){
                                echo "<th colspan='7'>$cd[armadax]</th>";
                            }
                        ?>
                    </tr> 
                    <tr>
                        <th width="3%">&nbsp;</th>
                        <th width="8%">&nbsp;</th>
                        <th>&nbsp;</th>
                        <?php 
                            foreach($carmada as $cd){
                                echo "<th></th>";
                                echo "<th colspan='2'>Target</th>";
                                echo "<th colspan='2'>Realisasi</th>";
                                echo "<th colspan='2'>Capai</th>";
                            }
                        ?>
                    </tr> 
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th><?php if($cs['cust_name']!=""){echo $cs['cust_name'];}else{echo "All";} ?></th>
                        <?php
                            foreach($carmada as $k){
                              echo "<th>Driver</th>";
                              echo "<th>Rit</th>";
                              echo "<th>Ton</th>";
                              echo "<th>Rit</th>";
                              echo "<th>Ton</th>";
                              echo "<th>Rit</th>";
                              echo "<th>Ton</th>";
                            }
                            //echo "<th>Total Rit</th>";
                            //echo "<th>Total Ton</th>";
                        ?>
                    </tr>           
                </thead>
                <tbody>
                     <?php $no=1;
                        
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
                           
                          $persediaan = $db->select("(SELECT a.txangkut_tgl,e.rom_name,concat(e.norangka,'-',e.arm_nolambung) armada,rit,tonase,driver_name
FROM `tx_ritase` a JOIN m_site b ON a.id_site=b.id_site 
JOIN (SELECT a.txangkut_id,c.tujuan_name, d.rom_name, e.driver_name,f.arm_nolambung,SUBSTR(f.arm_norangka,-5) norangka,sum(txangkut_ritase) rit,sum(txangkut_tonase) tonase,f.cust_id FROM `tx_ritase_dtl` a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_tujuan c ON c.tujuan_id=b.tujuan_id JOIN m_runofmine d ON d.rom_id=b.rom_id left JOIN m_driver e ON e.driver_id=a.driver_id
join m_armada f on a.arm_id=f.arm_id GROUP BY txangkut_id,a.arm_id,rom_name) e 
on a.txangkut_id=e.txangkut_id
where a.txangkut_tgl between '$_GET[tg1]' and '$_GET[tg2]'
 ORDER BY a.txangkut_tgl) as asi","*");
                          
                        foreach ($persediaan as $arrdt) {
                              $txangkut_tgl=$arrdt[txangkut_tgl];
                              $romname=$arrdt[rom_name];
                              $armada=$arrdt[armada];
                              $datanya[$txangkut_tgl][$romname][$armada]["driver_name"]=$arrdt[driver_name];
                              $datanya[$txangkut_tgl][$romname][$armada]["rit"]=$arrdt[rit];
                              $datanya[$txangkut_tgl][$romname][$armada]["tonase"]=$arrdt[tonase];
                              $dthwo[]=array("txangkut_tgl"=>$txangkut_tgl, "rom_name"=>$romname);
                              
                            }
                         
                    
                     $dthwo = array_map("unserialize", array_unique(array_map("serialize", $dthwo)));

                     foreach($dthwo as $vdtwo){
                        $txangkut_tgl = $vdtwo['txangkut_tgl'];
                        $romname = $vdtwo['rom_name'];
                     ?>
                    <tr>
                        <td align="left"><?php echo $no; ?></td>
                        <td align="left"><?php echo $txangkut_tgl?></td>
                        <td align="left"><?php echo $romname?></td>
                        <?php 
                        $taton = 81.49;
                        $tarit = 3;
                         foreach($carmada as $cm){
                            if($datanya[$txangkut_tgl][$romname][$armada]['rit'] == ""){$trit = 0;}else{
                                $trit = $datanya[$txangkut_tgl][$romname][$armada]['rit'];
                            }
                            if($datanya[$txangkut_tgl][$romname][$armada]['tonase'] == ""){$tton = 0;}else{
                                $tton = $datanya[$txangkut_tgl][$romname][$armada]['tonase'];
                            }
                            $armada = $cm['armada'];
                            echo "<td align='left'>".$datanya[$txangkut_tgl][$romname][$armada]['driver_name']."</td>";
                            echo "<td align='right'>".$tarit."</td>";
                            echo "<td align='right'>".$jtaton=$tarit*$taton."</td>";
                            echo "<td align='right'>".$datanya[$txangkut_tgl][$romname][$armada]['rit']."</td>";
                            echo "<td align='right'>".$datanya[$txangkut_tgl][$romname][$armada]['tonase']."</td>";
                            echo "<td align='right'>".($datanya[$txangkut_tgl][$romname][$armada]['rit']-$tarit)."</td>";
                            echo "<td align='right'>".($datanya[$txangkut_tgl][$romname][$armada]['tonase']-$jtaton)."</td>";
                            
                            
                            $ttlwip[$armada][rit]+=$datanya[$txangkut_tgl][$romname][$armada]['rit'];
                            $ttlwip[$armada][tonase]+=$datanya[$txangkut_tgl][$romname][$armada]['tonase'];
                            $ttlwip[$txangkut_tgl][rit]+=$datanya[$txangkut_tgl][$romname][$armada]['rit'];
                            $ttlwip[$txangkut_tgl][tonase]+=$datanya[$txangkut_tgl][$romname][$armada]['tonase'];
                            $totrit += $ttlwip[$txangkut_tgl][rit];
                            $totton += $ttlwip[$txangkut_tgl][ton];
                         }
                         //echo "<td align='right'>".$tirit = $ttlwip[$txangkut_tgl][rit]."</td>";
                         //echo "<td align='right'>".$titon = $ttlwip[$txangkut_tgl][tonase]."</td>";
                        ?>
                        <!-- <td><a href='index.php?x=stockmutasi&id=<?=$arrdt[id_barang]?>&gd=<?=$_GET[gd]?>&jns=<?=$_GET[jns]?>&tg1=<?=$_GET[tg1]?>&tg2=<?=$_GET[tg2]?>&r=1' target='_blank'>Mutasi</a></td> -->
                    </tr>
                   <?php $no++;
                         $jrit +=$tirit;
                         $jton +=$titon;
                         $ttltrit+=$tarit;
                         $ttltjtaton+=$jtaton;
                    } ?>
                    <tr>
                        <td align="right"><b>&nbsp;</b></td>
                        <td align="right"><b>&nbsp;</b></td>
                        <td align="right"><b>Total</b></td>
                        <?php
                            foreach($carmada as $cc){
                              $armada = 0;
                              $armada = $cc['armada'];
                              echo "<td align='right'></td>";
                              echo "<td align='right'>".$ttltrit."</td>";
                              echo "<td align='right'>".$ttltjtaton."</td>";
                              echo "<td align='right'>".$ttlwip[$armada][rit]."</td>";
                              echo "<td align='right'>".$ttlwip[$armada][tonase]."</td>";
                              echo "<td align='right'>".($ttlwip[$armada][rit]-$ttltrit)."</td>";
                              echo "<td align='right'>".($ttlwip[$armada][tonase]-$ttltjtaton)."</td>";
                            }
                            //echo "<td align='right'>".$jrit."</td>";
                            //echo "<td align='right'>".$jton."</td>";
                        ?>
                    </tr>
                </tbody>
    </table>