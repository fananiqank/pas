<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/premidriver/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/premidriver/proses.php?act=post',data,
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
    $.get( "apps/premidriver/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#premidriver_rom').val(counter.rom_id).trigger('change');
            $('#premidriver_tujuan').val(counter.tujuan_id).trigger('change');
            $('#premidriver_jarak').val(counter.premidriver_jarak);
            $('#premidriver_id').val(counter.rutejarak_id);
        }
        
    });
    
}

function deleted(id){
    var result = confirm("Want to delete?");
      if (result==true) {
       $.get( "apps/premidriver/proses.php?act=del&id="+id, function( data ) {
            alert("Data terhapus!");
            location.reload();
        });
      } 
  } 

</script>