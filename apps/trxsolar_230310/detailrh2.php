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
                <th colspan="2">Tanggal Transaksi</th>
                <th colspan="6"><?=$_GET[tgl]?></th>
            </tr>
            <tr>
                <th colspan="2">Shift</th>
                <th colspan="6"><?=$_GET[shift]?></th>
            </tr>
            <tr>
                <th>No</th>
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
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*, 
    d.driver_name,e.arm_nolambung,f.supp_nama
    FROM `tx_solar_dtl` a 
    JOIN m_driver d on a.driver_id=d.driver_id 
    LEFT JOIN m_armada e on a.arm_id=e.arm_id 
    LEFT JOIN m_supplier f on a.supp_id=f.supp_id JOIN (SELECT @rownum:=0) r  
    where a.txsolardtl_tgltrans='$_GET[tgl]' and a.txsolardtl_shift = '$_GET[shift]') a","*") as $val){

	
	echo "<tr>
                <td scope=\"row\">$no</td>
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
                <th colspan="2">Total</th>
                <th align="right"><?=number_format($totalliter,1)?></th>
                <th></th>
                <th align="right"><?=number_format($totaltotal)?></th>
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