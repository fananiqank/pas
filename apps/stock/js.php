
<script type="text/javascript">
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/stock/datarit.php"
    } );

if($('#id_gudang').val()){
     $('#stock').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/stock/data.php?id="+$('#id_gudang').val()+"&jns="+$('#jenisbrg').val()
    } );
} 
// else {
//     $('#stock').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/stock/data.php"
//     } );
// }

$(document).ready(function(){
    $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function($form, event){     
            event.preventDefault();
            var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/maintenance/prosesadd.php?act=post',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   $('#prosesloading').html('');
                   $('.server-side').DataTable().ajax.reload();
                   $('.rst1').trigger("reset");
                   $('.rst1').val(null).trigger('change');
                   $('#stokshow').html('');
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

function simpanstokopname(){
   // alert("asa");
        var data = $('#form').serializeFormJSON();        
            $('#prosesloading').html('<img src="../assets/images/loading.gif">');
            $.post('apps/stock/prosesstokopname.php?act=save',data,
                function(msg) {
                    if(msg!==""){alert(msg);}
                    
                   $('#prosesloading').html('');
                   //window.location='index.php?x=stockopname&id='+$('#idgudang').val()+'&jns='+$('#jenisbrg').val();
                    window.location='index.php?x=stock&id='+$('#idgudang').val()+'&jns='+$('#jenisbrg').val();
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
         window.location='index.php?x=maintenance';
        // $('#excel_area').html(data);
        // $('table').css('width','100%');
      }
    })
  });
});



function delCart(a){
    $.get( "apps/maintenance/proses.php?act=del&id="+a, function( data ) {
        // $( ".result" ).html( data );

        $('.server-side').DataTable().ajax.reload();
    });
    
}

$(document).on('click','#detailrh',function(e){
    e.preventDefault();
        $("#defaultSize").modal('show');
        $.post('apps/stock/detailrh.php?id='+$(this).attr("data-id"),
                function(html){
                $("#tampilhis").html(html);
                }   
            );
});

function showBrg(val){
  spl = val.split('_');
    $('#id_barang').val(spl[0]);
    $('#id_satuan').val(spl[1]);
    $('#stokshow').html(spl[2]);
  $.post('apps/maintenance/cekqtycari.php?act=save',{idbarang:spl[0]},
      function(msg) {
          $('#stok').val(msg);
      }
  );    
}

function hitungqty(val){
  //alert($('#jenis').val());
  if($('#jenis').val() == 1){
    if(parseInt(val) > parseInt($('#stok').val())){
      alert("Stok Kurang!!");
      $('#qty').val('');
      $('#qty').focus();
    }
  }
}

function cekJenis(val){
  if(val == 2){
    $('#stok').hide();
    $('#stokshow').hide();
    $('#qty').val(''); 
    $('#qty').focus();   
  } else {
    $('#stok').show();
    $('#stokshow').show();
    $('#qty').val('');
    $('#qty').focus();
  }
}

function filtermutasi (id,gd,tg1,tg2,jns){
  $.post('apps/stock/detailmutasi.php?id='+id+'&gd='+gd+'&tg1='+tg1+'&tg2='+tg2+'&jns='+jns,
                function(html){
                $("#stockmutasi").html(html);
                }   
            );
}

function cetakfiltermutasi (id,gd,tg1,tg2,jns){
  //  window.location.assign('../apps/stock/pdf.php?id='+id+'&gd='+gd+'&tg1='+tg1+'&tg2='+tg2+'&jns='+jns);
    window.open('https://pas.dashteknologi.com/apps/stock/pdf.php?id='+id+'&gd='+gd+'&tg1='+tg1+'&tg2='+tg2+'&jns='+jns, '_blank');      
}

function cgudang(id){
    window.location.assign("index.php?x=stock&id="+$('#id_gudang').val()+"&jns="+$('#jenisbrg').val());
}
function backstock(id,jns,gd) {
    window.location.assign("index.php?x=stock&id="+gd+"&jns="+jns);
}
</script>