<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/deduction/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/deduction/proses.php?act=post',data,

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

    
});
function getEdit(a){
    $.get( "apps/deduction/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_ddc').val(counter.id_ddc);
            $('#nama_ddc').val(counter.nama_ddc);
            $('#status_ddc').val(counter.status_ddc);
            $('#status_ddc').load("apps/deduction/tampilstatus.php?status="+counter.status_ddc);
        }
        
    });
    
}
</script>