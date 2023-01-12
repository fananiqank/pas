<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/supplier/data.php"
    } );

$(document).ready(function(){
    // $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/supplier/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           // $('#customertable').DataTable().ajax.reload();
                           location.reload();
                           // document.getElementById("form").reset();
                            // $('#form').trigger("reset");
                           // swal({
                           //       title: "Konfirmasi!",
                           //       text: msg,
                           //       type: "success"
                           //       //timer: 1000
                           //    });
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
    $.get( "apps/supplier/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#supp_id').val(counter.supp_id);
            $('#supp_nama').val(counter.supp_nama);
            $('#supp_alamat').val(counter.supp_alamat);
            $('#supp_notelp').val(counter.supp_notelp);
            $('#supp_type').val(counter.supp_type);
            $('#supp_type').load("apps/supplier/tampiltype.php?type="+counter.supp_type);
            $('#supp_status').val(counter.supp_status);
            $('#supp_status').load("apps/supplier/tampilstatus.php?status="+counter.supp_status);
        }
        
    });
    
}
</script>