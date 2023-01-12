<!-- <script type="text/javascript" src="../../app-assets/js/script/pdfmake.min.js"></script>
<script type="text/javascript" src="../../app-assets/js/script/vfs_fonts.js"></script> -->
<script type="text/javascript">

function filtermutasi (tg1,tg2,gd,jns){
  if(tg2 == '' || gd == '' || jns == ''){
    alert('Periode, gudang, jenis harap di isi !!');
  } else {
    $.post('apps/lappersediaan/detailmutasi.php?tg1='+tg1+'&tg2='+tg2+'&gd='+gd+'&jns='+jns,
                  function(html){
                  $("#lappersediaanmutasi").html(html);
                  }   
              );
    $('#donexel').show();
  }
}

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