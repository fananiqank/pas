<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/rutejarak/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/rutejarak/proses.php?act=post',data,
                        function(msg) {
                            if(msg!==""){alert(msg);}
                            
                           $('#prosesloading').html('');
                            location.reload();
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
    $.get( "apps/rutejarak/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#rutejarak_rom').val(counter.rom_id).trigger('change');
            $('#rutejarak_tujuan').val(counter.tujuan_id).trigger('change');
            $('#rutejarak_jarak').val(counter.rutejarak_jarak);
            $('#rutejarak_id').val(counter.rutejarak_id);
        }
        
    });
    
}

$(document).on('click','#history',function(e){
            
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/rutejarak/historyjarak.php?id='+$(this).attr("data-id"),
                function(html){
                $("#jarakubahhis").html(html);
                }   
            );
});


</script>