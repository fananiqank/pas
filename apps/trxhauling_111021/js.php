
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxhauling/data.php"
    } );

$('#ritasehauling').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxhauling/datarit.php"
    } );

$(document).ready(function(){
    $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function($form, event){     
            event.preventDefault();
            var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/trxhauling/prosesadd.php?act=post',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   $('#prosesloading').html('');
                   $('.server-side').DataTable().ajax.reload();
                   $('.rst1').trigger("reset");
                   $('.rst1').val(null).trigger('change');
                    // location.reload();
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
         alert("Data Belum Lengkap");
     }
    });
});

function simpanall(){
        var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/trxhauling/proses.php?act=save',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   $('#prosesloading').html('');
                   window.location='index.php?x=trxhauling';
                }
            );
}


$(document).ready(function(){
  $('#upload').on('click', function(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append('file', $('input[type=file]')[0].files[0]);
    formData.append('txangkut_tgl', $('#txangkut_tgl').val());
    formData.append('txangkut_shift', $('#txangkut_shift').val());
    formData.append('id_site', $('#id_site').val());
    formData.append('driver_id', $('#driver_id').val());
    formData.append('arm_id', $('#arm_id').val());
    $.ajax({
      url:"app-assets/plugins/spreadsheet/ritasehaul.php?act=save",
      method:"POST",
      data:formData,
      contentType:false,
      cache:false,
      processData:false,
      success:function(data)
      {
        alert(data);
         window.location='index.php?x=trxhauling';
        // $('#excel_area').html(data);
        // $('table').css('width','100%');
      }
    })
  });
});



function delCart(a){
    $.get( "apps/trxhauling/proses.php?act=del&id="+a, function( data ) {
        // $( ".result" ).html( data );

        $('.server-side').DataTable().ajax.reload();
    });
    
}

$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/trxhauling/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#jarakubahhis").html(html);
                }   
            );
});
</script>