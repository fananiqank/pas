<!-- <script type="text/javascript" src="../../app-assets/js/script/pdfmake.min.js"></script>
<script type="text/javascript" src="../../app-assets/js/script/vfs_fonts.js"></script> -->
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapinvoice/datarit.php"
    } );
//alert($('#tglon').val());
if($('#tglon').val()){
    //alert($('#tglon').val());
     $('#tablestock').DataTable( {
        "processing": true,
        "serverSide": true,
        "paging":false,
        
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapinvoice/data.php?tgl="+$('#tglon').val(),

                           
    } );
} 
// else {
//     $('#lapinvoice').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/lapinvoice/data.php"
//     } );
// }


$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/lapinvoice/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#tampilhis").html(html);
                }   
            );
});


function filtermutasi (tg1,tg2,sf,cust){
    if(tg1 == '' && tg2 == ''){
        alert("Periode Harus di isi!!");
    } else {
        $.post('apps/lapinvoice/detailmutasi.php?tg1='+tg1+'&tg2='+tg2+'&sf='+sf+'&cust='+cust,
                    function(html){
                    $("#lapinvoicemutasix").html(html);
                    }   
                );
    }  
}

function trtarget(id){
    window.location.assign("index.php?x=lapinvoice&tgl="+id);
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