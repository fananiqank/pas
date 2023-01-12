<!-- <script type="text/javascript" src="../../app-assets/js/script/pdfmake.min.js"></script>
<script type="text/javascript" src="../../app-assets/js/script/vfs_fonts.js"></script> -->
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapkehadiran/datarit.php"
    } );
//alert($('#tglon').val());
if($('#tgl1').val()){
    //alert($('#tglon').val());
     $('#tablemekanik').DataTable( {
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
                title: 'Laporan Mekanik : '+$('#tgl1').val()+'-'+$('#tgl2').val(),
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Mekanik : '+$('#tgl1').val()+'-'+$('#tgl2').val(),
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Mekanik Periode : '+$('#tgl1').val()+'-'+$('#tgl2').val(),
            },
           // 'copy', 'csv', 'print','excel',
        ],
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapkehadiran/data.php?id="+$('#id_driver').val()+"&tgl1="+$('#tgl1').val()+"&tgl2="+$('#tgl2').val()+"&sf="+$('#shiftid').val(),
        "columnDefs": [{ targets: [3], className: 'dt-body-center' },
                       { targets: [2], className: 'dt-body-center' },
                       { targets: [0], className: 'dt-body-center' }],
        

                           
    } );
} 
// else {
//     $('#lapmekanik').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/lapmekanik/data.php"
//     } );
// }


$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/lapkehadiran/detailrh.php?id='+$(this).attr("data-id")+'&tgl1='+$(this).attr("data-tgl1")+'&tgl2='+$(this).attr("data-tgl2")+'&sf='+$(this).attr("data-shift"),
                function(html){
                $("#tampilhis").html(html);
                }   
            );
});


function filtermutasi (id,gd,tg1,tg2){
  $.post('apps/lapkehadiran/detailmutasi.php?id='+id+'&gd='+gd+'&tg1='+tg1+'&tg2='+tg2,
                function(html){
                $("#lapmekanikmutasi").html(html);
                }   
            );
}

function trtarget(id,tgl1,tgl2,shift){
    if(tgl1 == ''){
        alert("Pilih Periode!!");
    } else {
        window.location.assign("index.php?x=lapabsensi&id="+id+"&tgl1="+tgl1+"&tgl2="+tgl2+"&sf="+shift);
    }
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