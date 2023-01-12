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
?>
             
                <thead style=" position: sticky; top: 0; z-index: 1;background-color: grey;color: white">
                     <tr><td colspan="15" align="center">Laporan Persediaan <br> Periode <?=$judul?></td></tr>
                    <tr>
                        <th width="3%">No</th>
                        <th width="8%">Kode </th>
                        <th width="50%">Nama Barang</th>
                        <th width="15%">Satuan</th>
                        <th width="10%">Min</th>
                        <th width="15%">Awal</th>
                        <th width="15%">Masuk</th>
                        <th width="15%">Keluar</th>  
                        <th width="15%">Akhir</th>
                        <th width="5%">Hpp (Rp)</th>
                        <th width="5%">Rupiah Awal (Rp)</th>
                        <th width="5%">Rupiah Masuk (Rp)</th>
                        <th width="5%">Rupiah Keluar (Rp)</th>
                        <th width="5%">Rupiah Akhir (Rp)</th>
                        <th width="5%">Mutasi</th> 
                    </tr>            
                </thead>
                <tbody>
                     <?php $no=1;
                        
                            if($_GET[gd] <> 'A'){
                                $gdg = "and id_gudang = $_GET[gd]";
                            } else {
                                $gdg = "";
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

                          $persediaan = $db->select("(select a.*,
concat(COALESCE(b.masukmutasi,0),'_',COALESCE(b.keluarmutasi,0),'_',COALESCE(b.harga,0)) as persediaan,ifnull(b.harga,0) as hpp_mutasi,d.nama_satuan,zz.nama_gudang,COALESCE(sdawal,0) sdawal
from m_barang a 
left join m_satuan d on a.id_satuan=d.id_satuan
left join (
    select max(tx_mutasi.id_mutasi) AS id_mutasi,tx_mutasi.id_gudang AS id_gudang,tx_mutasi.id_barang AS id_barang from tx_mutasi where DATE(tgl_mutasi) < '$_GET[tg2]' $gdg and jenisbrg = $_GET[jns] group by tx_mutasi.id_gudang,tx_mutasi.id_barang
) bb on a.id_barang=bb.id_barang 
left join tx_mutasi b on bb.id_mutasi=b.id_mutasi
left join m_gudang zz on b.id_gudang=zz.id_gudang
left join (select id_barang,(coalesce(sum(masukmutasi),0)-coalesce(sum(keluarmutasi),0)) sdawal from tx_mutasi a where $tglbet1 $gdg and jenisbrg = $_GET[jns] GROUP BY id_barang) c on a.id_barang=c.id_barang) as asi","*");
                          
                         foreach ($persediaan as $arrdt) {
                            foreach($db->select("tx_mutasi","ifnull(sum(masukmutasi),0)as masuk,ifnull(sum(keluarmutasi),0)as keluar","id_gudang='$_GET[gd]' and id_barang='$arrdt[id_barang]' and jenisbrg = $_GET[jns] and $tglbet")as $dts){}
                        echo "id_gudang='$arrdt[id_gudang]' and id_barang='$arrdt[id_barang]' and jenisbrg = $_GET[jns] and $tglbet";
                            $per=explode("_",$arrdt['persediaan']);
                            
                            $awal=$arrdt['sdawal'];
                            $masuk=$dts['masuk'];
                            $keluar=$dts['keluar'];
                            $akhir=$awal+$dts['masuk']-$dts['keluar'];
                            
                            $hpp=$arrdt['hpp_mutasi'];
                            $nawal=$awal*$arrdt['hpp_mutasi'];
                            $nasuk=$masuk*$arrdt['hpp_mutasi'];
                            $nakel=$keluar*$arrdt['hpp_mutasi'];
                            $pers=($awal+$masuk-$keluar)*$arrdt['hpp_mutasi'];
                     ?>
                    <tr>
                        <td align="left"><?php echo $no; ?></td>
                        <td align="left"><?php echo $arrdt['kode_barang']?></td>
                        <td align="left"><?php echo $arrdt['nama_barang']?></td>
                        <td align="left"><?php echo $arrdt['nama_satuan']?></td>
                        <td align="left"><?php echo $arrdt['min']?></td>
                        <td align="right"><?php echo number_format($awal)?></td>
                        <td align="right"><?php echo number_format($masuk)?></td>
                        <td align="right"><?php echo number_format($keluar)?></td>
                        <td align="right"><?php echo number_format($akhir)?></td>
                        <td align="right"><?php echo number_format($hpp)?></td>
                        <td align="right"><?php echo number_format($nawal)?></td>
                        <td align="right"><?php echo number_format($nasuk)?></td>
                        <td align="right"><?php echo number_format($nakel)?></td>
                        <td align="right"><?php echo number_format($pers)?></td>
                        <td><a href='index.php?x=stockmutasi&id=<?=$arrdt[id_barang]?>&gd=<?=$_GET[gd]?>&jns=<?=$_GET[jns]?>&tg1=<?=$_GET[tg1]?>&tg2=<?=$_GET[tg2]?>&r=1' target='_blank'>Mutasi</a></td>
                    </tr>
                    <?php $no++; 
                          $totalawal +=$nawal;
                          $totalmasuk +=$nasuk;
                          $totalkeluar +=$nakel;
                          $totalpers +=$pers; 
                    } 
                    ?>
                    <tr>
                        <td align="left" colspan="10" align="right"><b>Total</b></td>
                        <td align="right"><?php echo number_format($totalawal)?></td>
                        <td align="right"><?php echo number_format($totalmasuk)?></td>
                        <td align="right"><?php echo number_format($totalkeluar)?></td>
                        <td align="right"><?php echo number_format($totalpers)?></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
