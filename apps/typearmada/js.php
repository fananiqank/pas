<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/typearmada/data.php?sub="+$('#idsub').val()
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/typearmada/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           $('#form').load("apps/typearmada/tampilform.php?reload=1");
                           $('#typearmadatable').DataTable().ajax.reload();
                           

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
    $.get( "apps/typearmada/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#arm_type_id').val(counter.arm_type_id);
            $('#arm_type_name').val(counter.arm_type_name);
            $('#arm_type_status').load("apps/typearmada/tampilstatus.php?status="+counter.arm_merk_status);
        }
        
    });
    
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/typearmada/tampilform.php?reload=1");
    $('#typearmadatable').DataTable().ajax.reload();

}

function backup(){
    javascript: window.location.href="index.php?x=merkarmada";
}
</script>

