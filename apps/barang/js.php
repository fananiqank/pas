<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/barang/data.php",
        //dom: 'Bfrtip',
//         buttons: [
// { extend: 'collection', className: 'exportButton', text: 'Data Export',
// buttons: [
// { extend: 'copy',  exportOptions: { modifier: { page: 'all', search: 'none' } } },
// { extend: 'excel', exportOptions: { modifier: { page: 'all', search: 'none' } } },
// { extend: 'csv',   exportOptions: { modifier: { page: 'all', search: 'none' } } },
// { extend: 'pdf',   exportOptions: { modifier: { page: 'all', search: 'none' } } },
// { extend: 'print', exportOptions: { modifier: { page: 'all', search: 'none' } } }
// ]
// }
// ]

    } );

$(document).ready(function(){
    // $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/barang/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           $('#form').load("apps/barang/tampilform.php?reload=1");
                           $('#barangtable').DataTable().ajax.reload();
                           

                           swal({
                                 title: "Konfirmasi!",
                                 text: msg,
                                 type: "success"
                                 //timer: 1000
                              });
                        }
                    );
              },
              submitError: function ($form, event, errors) { 
                 //alert("Data Belum Lengkap");
             }
         });

     });

    
// });
function getEdit(a){
    $.get( "apps/barang/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_barang').val(counter.id_barang);
            $('#kode_barang').val(counter.kode_barang); 
            $('#nama_barang').val(counter.nama_barang);
            $('#partnumber_barang').val(counter.partnumber_barang);
            $('#id_dep').load("apps/barang/tampildepartemen.php?dep="+counter.id_dep);
            $('#id_sub').load("apps/barang/tampilsubdep.php?dep="+counter.id_dep+"&sub="+counter.id_sub);
            $('#id_kat').load("apps/barang/tampilkategori.php?sub="+counter.id_sub+"&kat="+counter.id_kat);
            $('#id_dep_edit').val(counter.id_dep);
            $('#id_sub_edit').val(counter.id_sub);
            $('#id_kat_edit').val(counter.id_kat);
            $('#min_stock').val(counter.min_stock);
            $('#max_stock').val(counter.max_stock);
            $('#id_satuan').load("apps/barang/tampilsatuan.php?idsatuan="+counter.id_satuan);
            $('#status').load("apps/barang/tampilstatus.php?status="+counter.status);
            document.getElementById('kode_barang').readOnly = true;
            $('#id_dep').prop('disabled', 'disabled');
            $('#id_sub').prop('disabled', 'disabled');
            $('#id_kat').prop('disabled', 'disabled');
                      
        }
        
    });
    
}

function cekSubDep(val) {
    $('#id_sub').load("apps/barang/tampilsubdep.php?dep="+val);
}

function cekKategori(val){
    $('#id_kat').load("apps/barang/tampilkategori.php?sub="+val);
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/barang/tampilform.php?reload=1");
    $('#barangtable').DataTable().ajax.reload();

}
</script>

