<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, b.arm_norangka,b.arm_nopol,b.arm_nolambung FROM m_armada b JOIN (SELECT @rownum:=0) r where b.arm_id='$_GET[id]') a","*") as $val2){}

$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*,DATE(a.tgl_mtc) as tglshow,b.arm_norangka,b.arm_nopol,b.arm_nolambung,supp_nama FROM tx_maintenance a JOIN m_armada b ON a.arm_id=b.arm_id JOIN (SELECT @rownum:=0) r JOIN m_supplier c on a.supp_mtc=c.supp_id where a.no_mtc='$_GET[mtc]') a","*") as $val){}
?>
<style>
    @media print{
       .noprint{
           display:none;
       }
    }
</style>
<input style="height:26px; line-height: 0;prin" type="button" id="donexel" class="btn btn-info noprint" value="Excel"  onclick="tableToExcel('cetakmtc')"></button>
<div class="table-responsive">

    <table class="table" width="100%" id="cetakmtc">
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
            <tr>
                <td colspan="4"><hr></td>
            </tr>
        </thead>
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
                            <td><b>Mekanik</b></td>
                            <td colspan="2"><b>Jasa</b></td>
                            <td><b>Biaya</b></td>
                        </tr>
                        <?php foreach($db->select("tx_mekanik a join m_mekanik b using(id_mekanik)","a.*,b.name_mekanik","id_mtc=$val[id_mtc]") as $bj){ ?>
                        <tr>
                            <td><?=$bj['name_mekanik']?></td>
                            <td colspan="2"><?=$bj['pekerjaan']?></td>
                            <td align="right"><?=number_format($bj['biaya'])?></td>
                        </tr>
                        <?php 
                            $totaljasa += $bj[biaya];
                        } ?>
                        <tr>
                            <td colspan="3" align="right"><b>Sub Total Biaya Jasa</b></td>
                            <td align="right"><b><?=number_format($totaljasa);?></b></td>
                        </tr>
                        <tr>
                            <td><b>Material/Part</b></td>
                            <td><b>Jumlah</b></td>
                            <td><b>Biaya Satuan</b></td>
                            <td><b>Biaya Total</b></td>
                        </tr>
                        <?php 
                        foreach($db->select("tx_maintenance a join tx_maintenancedtl b on a.id_mtc=b.id_mtc
                                             join m_barang c on b.id_barang=c.id_barang
                                             join (SELECT * FROM `tx_mutasi` where jenismutasi='2') d on a.no_mtc=d.no_transmutasi  and d.id_barang=c.id_barang",
                                             "b.id_mtc,c.nama_barang,qty_mtcdtl,masukmutasi,keluarmutasi,jenismutasi,hargajual,
                                             CASE WHEN jenismutasi=1 THEN 'Bekas' Else 'Baru' End statusbrg","a.id_mtc = $val[id_mtc]","jenismutasi DESC") as $dtlmtc){ ?>
                        <tr>
                            <td><?=$dtlmtc[nama_barang];?></td>
                            <td><?=$dtlmtc[keluarmutasi];?></td>
                            <td align='right'><?=number_format($dtlmtc[hargajual]);?></td>
                            <td align='right'><?=number_format($totalmat=$dtlmtc[keluarmutasi]*$dtlmtc[hargajual]);?></td>
                        </tr>
                        <?php 
                        $totalmaterial += $totalmat; 
                        } ?>
                        <tr>
                            <td colspan="3" align="right"><b>Sub Total Biaya Jasa</b></td>
                            <td align='right'><b><?=number_format($totalmaterial);?></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>Grand Total</b></td>
                            <td align='right'><b><?=number_format($totaljasa+$totalmaterial);?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
  
    </table>

    <script type="text/javascript">
        var tableToExcel = (function() {
        
        var uri = 'data:application/vnd.ms-excel;base64,';
        var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
            var bases = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
            return function(table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
                window.location.href = uri + bases(format(template, ctx))
            }
            
        })()

    </script>