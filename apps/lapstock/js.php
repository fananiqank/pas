<!-- <script type="text/javascript" src="../../app-assets/js/script/pdfmake.min.js"></script>
<script type="text/javascript" src="../../app-assets/js/script/vfs_fonts.js"></script> -->
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapstock/datarit.php"
    } );
if($('#id_gudang').val()){
     $('#tablestock').DataTable( {
        "processing": true,
        "serverSide": true,
        "paging":false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Minimum Stock',
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Minimum Stock',
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Minimum Stock',
            },
           // 'copy', 'csv', 'print','excel',
        ],
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapstock/data.php?id="+$('#id_gudang').val(),
        "columnDefs": [{ targets: [3,4], className: 'dt-body-right',
                         render: $.fn.dataTable.render.number(',', '.',0, '') },
                       { targets: [0], className: 'dt-body-center' }],

                           
    } );
} 
// else {
//     $('#lapstock').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/lapstock/data.php"
//     } );
// }


$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/lapstock/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#tampilhis").html(html);
                }   
            );
});


function filtermutasi (id,gd,tg1,tg2){
  $.post('apps/lapstock/detailmutasi.php?id='+id+'&gd='+gd+'&tg1='+tg1+'&tg2='+tg2,
                function(html){
                $("#lapstockmutasi").html(html);
                }   
            );
}

function cgudang(id){
    window.location.assign("index.php?x=lapminstock&id="+id);
}


// var tableToExcel = (function() {
        
// var uri = 'data:application/vnd.ms-excel;base64,';
// var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
//     var bases = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
//     var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
//     return function(table, name) {
//         if (!table.nodeType) table = document.getElementById(table)
//         var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
//         window.location.href = uri + bases(format(template, ctx))
//     }
    
// })()

</script>