<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/site/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/site/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           $('#form').load("apps/site/tampilform.php?reload=1");
                           $('#sitetable').DataTable().ajax.reload();
                           //alert("sukses");
                           

                           Swal.fire({
                                      title: "Konfiramasi",
                                      text: "Proses sukses!",
                                      type: "success",
                                      timer: 1000
                                      // confirmButtonClass: 'btn btn-primary',
                                      // buttonsStyling: false,
                                    });
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
    $.get( "apps/site/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_site').val(counter.id_site);
            $('#nama_site').val(counter.nama_site);
            $('#status_site').load("apps/site/tampilstatus.php?status="+counter.status_site);
        }
        
    });
    
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/site/tampilform.php?reload=1");
    $('#sitetable').DataTable().ajax.reload();

}

// function detail(id){
//     javascript: window.location.href="index.php?x=site";
// }
</script>

