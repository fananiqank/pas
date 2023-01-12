<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();
// echo "SELECT @rownum:=@rownum+1 norut, b.*,c.kdbarang,c.qtyakhir,c.qtyfisik,c.selisih,c.keterangan_so_dtl,c.hargabeli,c.noref,d.nama_barang,e.nama_satuan,f.nama_gudang,CASE WHEN b.jenis_brg = 1 THEN 'Baru' ELSE 'Bekas/Repair' END jenisbarang FROM tx_stokopname b join tx_stockopname_dtl c on b.idso=c.idso join m_barang d on c.id_barang=d.id_barang join m_satuan e on d.id_satuan=e.id_satuan join m_gudang f on b.idgudang=f.id_gudang JOIN (SELECT @rownum:=0) r where b.idso='$_GET[id]'";
$selstock = $db->select("(SELECT @rownum:=@rownum+1 norut, b.*,c.kdbarang,c.qtyakhir,c.qtyfisik,c.selisih,c.keterangan_so_dtl,c.hargabeli,c.noref,d.nama_barang,e.nama_satuan,f.nama_gudang,CASE WHEN b.jenis_brg = 1 THEN 'Baru' ELSE 'Bekas/Repair' END jenisbarang FROM tx_stockopname b join tx_stockopname_dtl c on b.idso=c.idso join m_barang d on c.idbarang=d.id_barang join m_satuan e on d.id_satuan=e.id_satuan join m_gudang f on b.idgudang=f.id_gudang JOIN (SELECT @rownum:=0) r where b.idso='$_GET[id]') a","*");
foreach($selstock as $hstock){}

?>

<div class="table-responsive">
    <span style="float: right;"><input style="height:26px; line-height: 0;" type="button" class="btn btn-info btn-sm" style="color:white" value="Excel"  onclick="tableToExcel('stockopname2')"></button></span>
        
    <table class="table" id="stockopname2">
        <thead>
            <tr>
                <th align="left">No SO</th>
                <th align="left" colspan="2"><?=$hstock['noso']?></th>
                <th align="left">Tanggal</th>
                <th align="left" colspan="4"><?=date('Y-m-d',strtotime($hstock['inputdt_so']))?></th>
            </tr>
            <tr>
                <th align="left">Gudang</th>
                <th align="left" colspan="2"><?=$hstock['nama_gudang']?></th>
                <th align="left">Jenis Barang</th>
                <th align="left" colspan="4"><?=$hstock['jenisbarang']?></th>
            </tr>
            <tr>
                <th colspan="8">&nbsp;</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Qty System</th>
                <th>Qty Fisik</th>
                <th>Selisih</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
                   
</div>
<?php
$no=1;
foreach($selstock as $val){

	
	echo "<tr style='cursor:pointer'>
                <td scope=\"row\">$no</td>
                <td>$val[kdbarang]</td>
                <td>$val[nama_barang]</td>
                <td>$val[nama_satuan]</td>
                <td align='right'>$val[qtyakhir]</td>
                <td align='right'>$val[qtyfisik]</td>
                <td align='right'>$val[selisih]</td>
                <td>$val[keterangan_so_dtl]</td>
          </tr>";
    $no++;
}
?>      
        </tbody>
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