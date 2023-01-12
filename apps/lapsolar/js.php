<!-- <script type="text/javascript" src="../../app-assets/js/script/pdfmake.min.js"></script>
<script type="text/javascript" src="../../app-assets/js/script/vfs_fonts.js"></script> -->
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapsolar/datarit.php"
    } );
//alert($('#tglon').val());
if($('#tgl1').val()){
    //alert($('#tglon').val());
     $('#tablelapsolar').DataTable( {
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var biayaTotal = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
            var biayaTotalz = biayaTotal.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");;
                
            // Update footer by showing the total with the reference of the column index 
            $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 8 ).footer() ).html(biayaTotalz);
        },
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
                title: 'Laporan Solar : '+$('#tgl1').val()+'-'+$('#tgl2').val(),
            },
            {
                extend: 'pdf',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Solar : '+$('#tgl1').val()+'-'+$('#tgl2').val(),
            },
            {
                extend: 'print',
                footer: true,
                exportOptions: {
                columns: ':visible'
                },
                title: 'Laporan Solar Periode : '+$('#tgl1').val()+'-'+$('#tgl2').val(),
            },
           // 'copy', 'csv', 'print','excel',
        ],
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/lapsolar/data.php?shift="+$('#shift').val()+"&tgl1="+$('#tgl1').val()+"&tgl2="+$('#tgl2').val()+"&armid="+$('#arm_id').val()+"&driverid="+$('#driver_id').val()+"&suppid="+$('#supp_id').val(),
        "columnDefs": [{ targets: [8], className: 'dt-body-right',
                         render: $.fn.dataTable.render.number(',', '.',0, '') },
                       { targets: [0], className: 'dt-body-center' }],
        

                           
    } );
} 
// else {
//     $('#lapsolar').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/lapsolar/data.php"
//     } );
// }


$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/lapsolar/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#tampilhis").html(html);
                }   
            );
});


function filtermutasi (id,gd,tg1,tg2){
  $.post('apps/lapsolar/detailmutasi.php?id='+id+'&gd='+gd+'&tg1='+tg1+'&tg2='+tg2,
                function(html){
                $("#lapsolarmutasi").html(html);
                }   
            );
}

function trtarget(tgl1,tgl2,shift,armid,driverid,suppid){
    if(tgl1 == ''){
        alert("Pilih Periode!!");
    } else {
        window.location.assign("index.php?x=lapsolar&&tgl1="+tgl1+"&tgl2="+tgl2+"&shift="+shift+"&armid="+armid+"&driverid="+driverid+"&suppid="+suppid);
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