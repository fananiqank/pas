<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT * FROM `tx_solar`where txsolar_id='$_GET[id]') a","*") as $val2){}
?>

<div class="table-responsive">
    <input style="height:26px; line-height: 0;" type="button" id="donexel" class="btn btn-info" value="Excel"  onclick="tableToExcel('detailsolar')"></button>
    <table class="table" id="detailsolar">
        <thead>
            <tr>
                <th colspan="2">Tanggal Upload</th>
                <th colspan="6"><?=$val2[txsolar_tgl]." | Upload Ke - ".$val2[txsolar_seq]?></th>
            </tr>
            
            <tr>
                <th>No</th>
                <th>Tgl Trans</th>
                <th>Shift</th>
                <th>No Lambung</th>
                <th>Driver</th>
                <th>Liter</th>
                <th>Harga perLiter (Rp)</th>
                <th>Total (Rp)</th>
                <th>Supplier</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>

<?php
$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*, b.nama_site,
    d.driver_name,e.arm_nolambung,f.supp_nama,c.txsolardtl_liter,c.txsolardtl_harga,
    c.txsolardtl_total,c.txsolardtl_petugas,c.txsolardtl_tgltrans,c.txsolardtl_shift
    FROM `tx_solar` a JOIN m_site b ON a.id_site=b.id_site 
    JOIN tx_solar_dtl c ON a.txsolar_id=c.txsolar_id 
    LEFT JOIN m_driver d on c.driver_id=d.driver_id 
    LEFT JOIN m_armada e on c.arm_id=e.arm_id 
    LEFT JOIN m_supplier f on c.supp_id=f.supp_id JOIN (SELECT @rownum:=0) r 
    where a.txsolar_id='$_GET[id]') a","*") as $val){

	
	echo "<tr>
                <td scope=\"row\">$no</td>
                <td >$val[txsolardtl_tgltrans]</td>
                <td >$val[txsolardtl_shift]</td>
                <td >$val[arm_nolambung]</td>
                <td >$val[driver_name]</td>
                <td align='right'>".number_format($val[txsolardtl_liter],1)."</td>
                <td align='right'>".number_format($val[txsolardtl_harga])."</td>
                <td align='right'>".number_format($val[txsolardtl_total])."</td>
                <td >$val[supp_nama]</td>
                <td>$val[txsolardtl_petugas]</td>
            </tr>";
    $no++;
    $totalliter += $val[txsolardtl_liter];
    $totaltotal += $val[txsolardtl_total];
}
?>      <tr>
                <th></th>
                <th colspan="4" style="text-align: right;">Total</th>
                <th style="text-align: right;"><?=number_format($totalliter,1)?></th>
                <th></th>
                <th style="text-align: right;"><?=number_format($totaltotal)?></th>
                <th></th>
                <th></th>
            </tr>
				
        </tbody>
    </table>
</div>
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