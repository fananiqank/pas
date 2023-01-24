
<script type="text/javascript">

$('#ddctotal').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxdeductiontotal/datadeduction.php",
        columnDefs: [
                      {
                        targets: 4,
                        render: $.fn.dataTable.render.number(',', '.', 0, ''),
                        className: 'dt-body-right'
                      },
                      
                    ],
    } );

$(document).ready(function(){
    $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function($form, event){     
            event.preventDefault();
            var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/trxdeductiontotal/proses.php?act=post',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   window.location="index.php?x=trxdeductiontotal";
                   
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
        
        $.post('apps/trxdeductiontotal/detaildeduction.php?act=save',data,
            function(msg) {
                $('#detailinvoice').html(msg);
            }
        );
        $('#tambah2').hide();
        $('#tambah3').show();
}

$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/trxdeductiontotal/detailrh.php?id='+$(this).attr("data-id")+'&type='+$(this).attr("data-type"),
                function(html){
                $("#tampilhis").html(html);
                }   
            );
});
</script>