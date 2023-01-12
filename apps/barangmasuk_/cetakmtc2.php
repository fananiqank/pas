<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, b.arm_norangka,b.arm_nopol,b.arm_nolambung FROM m_armada b JOIN (SELECT @rownum:=0) r where b.arm_id='$_GET[id]') a","*") as $val2){}

$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*,DATE(a.tgl_mtc) as tglshow,b.arm_norangka,b.arm_nopol,b.arm_nolambung,supp_nama FROM tx_maintenance a JOIN m_armada b ON a.arm_id=b.arm_id JOIN (SELECT @rownum:=0) r JOIN m_supplier c on a.supp_mtc=c.supp_id where a.no_mtc='$_GET[mtc]') a","*") as $val){}
?>

<div class="table-responsive">

    <table class="table" width="100%">
        <thead align="left">
            <tr>
              <td colspan="4" align="center"><h3><u>Maintenance PAS</u></h3></td>
            </tr>
            <tr>
                <th>No Rangka</th>
                <th>: <?=$val2[arm_norangka]?></th>
                <th>Nopol</th>
                <th>: <?=$val2[arm_nopol]?></th>
            </tr>
            <tr>
                <th>No Lambung</th>
                <th>: <?=$val2[arm_nolambung]?></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>No Mtc</th>
                <th>: <?=$val[no_mtc]?></th>
                <th>Tgl</th>
                <th>: <?=$val[tglshow]?></th>
            </tr>
        </thead>
    </table>
    <hr>
    <table class="table" width="100%">
            <tr>
                <td colspan=4>
                    <a href='apps/maintenance/cetakmtc.php?id=$_GET[id]' class='label label-primary' style='cursor:pointer;float:right' title='print' target='_blank'><i class='ft-printer' aria-hidden='true' style='font-size:16px;'></i></a>
                    <table width='100%'>
                        <tr>
                            <td width='20%'><b>Supplier</b></td>
                            <td width='80%'><?=$val[supp_nama];?></td>
                        </tr>
                        <tr>
                            <td><b>Keterangan</b></td>
                            <td><?=$val[keterangan_mtc];?></td>
                        </tr>
                    </table>
                    <table width='100%' style='font-size:12px' border='1'>
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Jenis</b></td>
                            <td><b>Qty Keluar</b></td>
                            <td><b>Qty Masuk</b></td>
                            <td><b>Harga</b></td>
                        </tr>
                        <tr>
                            <td colspan='5'  align='left'><b><i>Sparepart</i></b></td>
                        </tr>
                        <tr><td colspan='5' align='left'><i>Pemasangan</i></td></tr>
                    <?php 
                        foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
                                             join m_barang c on b.id_barang=c.id_barang
                                             join tx_mutasi d on a.no_mtc=d.no_transmutasi and jenismutasi=2",
                                             "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
                                             CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){
                    ?>
                        <tr>
                                <td><?=$dtlmtc[nama_barang];?></td>
                                <td><?=$dtlmtc[statusbrg];?></td>
                                <td><?=$dtlmtc[keluarmutasi];?></td>
                                <td><?=$dtlmtc[masukmutasi];?></td>
                                <td align='right'><?=number_format($dtlmtc[hargajual]);?></td>
                            </tr>
                    <?php
                            
                            $totaljual += $dtlmtc[hargajual]; 
                        }
                    ?>
                        <tr><td colspan='5' align='left'><i>Pelepasan</i></td></tr>
                     <?php 
                        foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
                                             join m_barang c on b.id_barang=c.id_barang
                                             join tx_mutasi d on a.no_mtc=d.no_transmutasi and jenismutasi=1",
                                             "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
                                             CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){
                    ?>
                        <tr>
                                <td><?=$dtlmtc[nama_barang];?></td>
                                <td><?=$dtlmtc[statusbrg];?></td>
                                <td><?=$dtlmtc[keluarmutasi];?></td>
                                <td><?=$dtlmtc[masukmutasi];?></td>
                                <td align='right'><?=number_format($dtlmtc[hargajual]);?></td>
                            </tr>
                    <?php
                            
                            $totaljual += $dtlmtc[hargajual]; 
                        }
                    ?>
                        <tr>
                            <td colspan='4'><b>Biaya Jasa</b></td>
                            <td align='right'><?=number_format($val[harga_mtc])?></td>
                        </tr>
                    <?php   
                            $totalall = $totaljual+$val[harga_mtc];
                    ?>
                        <tr>
                            <td colspan='4'><b>Total</b></td>
                            <td align='right'><?=number_format($totalall)?></td>
                        </tr>
                    </table>
                </td>
            </tr>
  
    </table>