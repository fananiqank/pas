<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/departemen/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/departemen/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           $('#form').load("apps/departemen/tampilform.php?reload=1");
                           $('#departementable').DataTable().ajax.reload();
                           

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

    
});
function getEdit(a){
    $.get( "apps/departemen/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_dep').val(counter.id_dep);
            $('#kd_dep').val(counter.kd_dep);
            $('#nama_dep').val(counter.nama_dep);
        }
        
    });
    
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/departemen/tampilform.php?reload=1");
    $('#departementable').DataTable().ajax.reload();

}

function detail(id){
    javascript: window.location.href="index.php?x=typearmada&sub="+id;
}
</script>

