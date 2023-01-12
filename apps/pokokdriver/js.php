<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "apps/pokokdriver/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/pokokdriver/proses.php?act=post',data,
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
    $.get( "apps/pokokdriver/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#basicdriver_rom').val(counter.rom_id).trigger('change');
            $('#basicdriver_tujuan').val(counter.tujuan_id).trigger('change');
            $('#basicdriver_jarak').val(counter.basicdriver_jarak);
            $('#basicdriver_id').val(counter.rutejarak_id);
        }
        
    });
    
}
</script>