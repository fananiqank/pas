<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, b.arm_norangka,b.arm_nopol,b.arm_nolambung FROM m_armada b JOIN (SELECT @rownum:=0) r where b.arm_id='$_GET[id]') a","*") as $val2){}



?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No Rangka</th>
                <th><?=$val2[arm_norangka]?></th>
                <th>Nopol</th>
                <th><?=$val2[arm_nopol]?></th>
            </tr>
            <tr>
                <th>No Lambung</th>
                <th><?=$val2[arm_nolambung]?></th>
            </tr>
        </thead>
    </table>
     <input id="myInputmodalbyprocess" type="text" placeholder="Search.." style="float: right;margin-right: 2%" >
    <table class="table" id="modsumwip2">
        <thead>
            <tr>
                <th>No</th>
                <th>No Mtc</th>
                <th>Tgl</th>
            </tr>
        </thead>
        <tbody >
           
</div>
<?php
$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*,DATE(a.tgl_mtc) as tglshow,b.arm_norangka,b.arm_nopol,b.arm_nolambung,supp_nama FROM tx_maintenance a JOIN m_armada b ON a.arm_id=b.arm_id JOIN (SELECT @rownum:=0) r JOIN m_supplier c on a.supp_mtc=c.supp_id where a.arm_id='$_GET[id]' order by id_mtc desc) a","*") as $val){

	// foreach($db->select("(select GROUP_CONCAT(nama_mekanik,',') as mekanik from tx_mekanik where id_mtc='$val[id_mtc]' group by id_mtc) a","*") as $val3){}
	
    //echo "<tr data-toggle='collapse' data-target='#$val[no_mtc]' style='cursor:pointer;background-color:#DCDCDC'>";
    echo "<tr>
                <td scope=\"row\">$no</td>
                <td>$val[no_mtc]</td>
                <td>$val[tglshow]</td>
                <td><a href='apps/maintenance/cetakmtc.php?id=$_GET[id]&mtc=$val[no_mtc]' class='label label-primary' style='cursor:pointer;float:right' title='print' target='_blank'><i class='ft-printer' aria-hidden='true' style='font-size:16px;'></i></a>
                    <a href='apps/maintenance/pdfmtc.php?id=$_GET[id]&mtc=$val[no_mtc]' class='label label-success' style='cursor:pointer;float:right' title='PDF' target='_blank'><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
                </td>
            </tr>
            <tr id='$val[no_mtc]' class='collapse'>
                <td colspan=4>
                    <a href='apps/maintenance/cetakmtc.php?id=$_GET[id]&mtc=$val[no_mtc]' class='label label-primary' style='cursor:pointer;float:right' title='print' target='_blank'><i class='ft-printer' aria-hidden='true' style='font-size:16px;'></i></a>
                    <a href='apps/maintenance/pdfmtc.php?id=$_GET[id]&mtc=$val[no_mtc]' class='label label-success' style='cursor:pointer;float:right' title='PDF' target='_blank'><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
                    <table width='100%'>
                        <tr>
                            <td width='20%'><b>Supplier</b></td>
                            <td width='80%'>$val[supp_nama]</td>
                        </tr>
                        <tr>
                            <td><b>Keterangan</b></td>
                            <td>$val[keterangan_mtc]</td>
                        </tr>
                        
                    </table>";?>
                   
                    <table width='100%' style='font-size:12px' border='1'>
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Mekanik</b></td>
                            <td colspan='2'><b>Jasa</b></td>
                            <td><b>Biaya</b></td>
                        </tr>
                    <?php 
                        $totaljasa = 0;
                        foreach($db->select("tx_mekanik a join m_mekanik b using(id_mekanik)","a.*,b.name_mekanik","id_mtc=$val[id_mtc]") as $bj){
                    ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><?=$bj['name_mekanik']?></td>
                            <td colspan="2"><?=$bj['pekerjaan']?></td>
                            <td align="right"><?=number_format($bj['biaya'])?></td>
                        </tr>
                    <?php 
                            $totaljasa += $bj[biaya];
                        } 
                    ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3" align="right"><b>Sub Total Biaya Jasa</b></td>
                            <td align="right"><b><?=number_format($totaljasa);?></b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Material/Part</b></td>
                            <td><b>Jumlah</b></td>
                            <td><b>Biaya Satuan</b></td>
                            <td><b>Biaya Total</b></td>
                        </tr>
                    <?php 
                        $totalmaterial = 0;
                        // echo "tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
                        //                      join m_barang c on b.id_barang=c.id_barang
                        //                      join tx_mutasi d on a.no_mtc=d.no_transmutasi and jenismutasi=2 where a.id_mtc = $val[id_mtc]";
                        foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
                                             join m_barang c on b.id_barang=c.id_barang
                                             join (SELECT * FROM `tx_mutasi` where jenismutasi='2') d on a.no_mtc=d.no_transmutasi  and d.id_barang=c.id_barang",
                                             "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
                                             CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){ ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><?=$dtlmtc[nama_barang];?></td>
                            <td><?=$dtlmtc[keluarmutasi];?></td>
                            <td align='right'><?=number_format($dtlmtc[hargajual]);?></td>
                            <td align='right'><?=number_format($totalmat=$dtlmtc[keluarmutasi]*$dtlmtc[hargajual]);?></td>
                        </tr>
                    <?php 
                        $totalmaterial += $totalmat; 
                    } ?>
                      
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3" align="right"><b>Sub Total Material</b></td>
                            <td align='right'><b><?=number_format($totalmaterial);?></b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3" align="right"><b>Grand Total</b></td>
                            <td align='right'><b><?=number_format($totaljasa+$totalmaterial);?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
<?php 
    $no++;
}
?>      
        </tbody>
    </table>


<script type="text/javascript">
    $(document).ready(function(){
        $("#myInputmodalbyprocess").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#modsumwip2 tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
     });
</script>