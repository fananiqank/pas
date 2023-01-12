<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/armada/data.php"
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/armada/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           $('#form').load("apps/armada/tampilform.php?reload=1");
                           //document.getElementById('arm_norangka').readOnly = false;
                           //$('#arm_type_armada').select2('enable');
                           $('.frhead').trigger("reset");
                           $('.frhead').val(null).trigger('change');
                           $('.server-side').DataTable().ajax.reload();
                           

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
    $.get( "apps/armada/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#arm_id').val(counter.arm_id);
            $('#arm_nopol').val(counter.arm_nopol);
            $('#arm_nolambung').val(counter.arm_nolambung);
            $('#arm_norangka').val(counter.arm_norangka);
            $('#arm_nomesin').val(counter.arm_nomesin);
            $('#arm_tahun').val(counter.arm_tahun);
            $('#arm_type_armada').load("apps/armada/tampiltypearmada.php?typearmada="+counter.arm_type_armada);
            //$('#arm_merk').val(counter.arm_merk);
            $('#arm_merk').load("apps/armada/tampilmerk.php?merk="+counter.arm_merk);
            //$('#arm_type').val(counter.arm_type);
            $('#arm_type').load("apps/armada/tampiltype.php?merk="+counter.arm_merk+"&type="+counter.arm_type);
            //$('#arm_status_milik').val(counter.arm_status_milik);
            $('#arm_status_milik').load("apps/armada/tampilmilik.php?milik="+counter.arm_status_milik);
            //$('#arm_status').val(counter.arm_status);
            $('#arm_status').load("apps/armada/tampilstatus.php?status="+counter.arm_status);
            document.getElementById('arm_norangka').readOnly = true;
            $('#arm_type_armada').prop('disabled', 'disabled');
        }
        
    });
    
}

function cekMerk(val) {
  $('#arm_type').load("apps/armada/tampiltype.php?merk="+val);
}

function reset() {
    $('#prosesloading').html('');
   // $('.frhead').trigger("reset");
   // $('.frhead').val(null).trigger('change');
    $('#form').load("apps/armada/tampilform.php?reload=1");
    $('.server-side').DataTable().ajax.reload();

}
</script>

