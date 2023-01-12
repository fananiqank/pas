
<script type="text/javascript">

$('#invoicelist').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxpremidriver/databasicpremi.php"
    } );

$(document).ready(function(){
    $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function($form, event){     
            event.preventDefault();
            var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/trxpremidriver/proses.php?act=post',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   window.location="index.php?x=trxpremidriver";
                   
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

function detailpremi(){
        var data = $('#form').serializeFormJSON();        
        
        $.post('apps/trxpremidriver/detailpremi.php?act=save',data,
            function(msg) {
                $('#detailinvoice').html(msg);
            }
        );
}




$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/trxpremidriver/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#jarakubahhis").html(html);
                }   
            );
});
</script>