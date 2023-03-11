
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxsolar/data.php"
    } );

if($('#filterb').val() == 1){
$('#ritasesolar').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxsolar/datarit.php",
        "columnDefs": [{
                    targets: [3,4],
                    className: 'dt-body-right',
                    },
                    {
                    targets: [2],
                    className: 'dt-body-center',
                    }]
    } );
} else{
$('#ritasesolar').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/trxsolar/datarit2.php",
        "columnDefs": [{
                    targets: [3,4],
                    className: 'dt-body-right',
                    },
                    {
                    targets: [2],
                    className: 'dt-body-center',
                    }]
    } );
}

$(document).ready(function(){
    $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function($form, event){     
            event.preventDefault();
            var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/trxsolar/prosesadd.php?act=post',data,
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
            $.post('apps/trxsolar/proses.php?act=save',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   $('#prosesloading').html('');
                   window.location='index.php?x=trxsolar';
                }
            );
}


$(document).ready(function(){
  $('#upload').on('click', function(event){
    $('#ck').html('<img src="./assets/image/spinner.gif">');
    event.preventDefault();
    var formData = new FormData();
    formData.append('file', $('input[type=file]')[0].files[0]);
    formData.append('txsolar_tgl', $('#txsolar_tgl').val());
    formData.append('txsolar_shift', $('#txsolar_shift').val());
    formData.append('id_site', $('#id_site').val());
    formData.append('driver_id', $('#driver_id').val());
    formData.append('arm_id', $('#arm_id').val());
    $.ajax({
      url:"app-assets/plugins/spreadsheet/ritasesolar.php?act=save",
      method:"POST",
      data:formData,
      contentType:false,
      cache:false,
      processData:false,
      success:function(data)
      {
        alert(data);
         window.location='index.php?x=trxsolar';
        // $('#excel_area').html(data);
        // $('table').css('width','100%');
      }
    })
  });
});



function delCart(a){
    $.get( "apps/trxsolar/proses.php?act=del&id="+a, function( data ) {
        // $( ".result" ).html( data );

        $('.server-side').DataTable().ajax.reload();
    });
    
}

$(document).on('click','#detailrh2',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/trxsolar/detailrh2.php?tgl='+$(this).attr("data-tgl")+'&shift='+$(this).attr("data-shift"),
                function(html){
                $("#jarakubahhis").html(html);
                }   
            );
});

$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/trxsolar/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#jarakubahhis").html(html);
                }   
            );
});

function hapussolar(tgl,shift){
    // alert(a);
    $('#ritasesolar').html('<img src="./assets/image/spinner.gif">');
    $.get( "apps/trxsolar/proses.php?act=hapussolar&tgl="+tgl+"&shift="+shift, function( data ) {
        // $( ".result" ).html( data );

        alert(data);
        //$('#ritasesolar').DataTable().ajax.reload();
        window.location.reload();
    });
}

function hapussolarupd(id){
    // alert(a);
    $('#ritasesolar').html('<img src="./assets/image/spinner.gif">');
    $.get( "apps/trxsolar/proses.php?act=hapussolarupd&id="+id, function( data ) {
        // $( ".result" ).html( data );

        alert(data);
        //$('#ritasesolar').DataTable().ajax.reload();
        window.location.reload();
    });
}

function loader(id){
    window.location.href="index.php?x=trxsolar&fl="+id;
}
</script>