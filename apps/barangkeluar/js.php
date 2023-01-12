<script type="text/javascript">
// $('.server-side').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/barangkeluar/data.php"
//     } );
$('.datalist').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/barangkeluar/data.php"
    } );

function typeFormInp (val) {
  //alert(val);
  $('#typeform').val(val);
}


$(document).ready(function(){
    $("#simpan").click(function(){

        if($('#date_brgkeluar').val() == '' || $('#nama_supp').val() == '' || $('#no_sj').val() == '' || $('#id_gudang').val() == ''){
          alert("Data Tidak Lengkap");
        } else {
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/barangkeluar/proses.php?act=post',data,

                        function(msg) {

                           swal({
                                 title: "Konfirmasi!",
                                 text: msg,
                                 type: "success"
                                 //timer: 1000
                              });
                           location.reload(true);
                        }
                    );
              },
              submitError: function ($form, event, errors) { 
                 //alert("Data Belum Lengkap");
             }
            });
        }
     });    
});

function getModalDetail(a){
    
    $("#defaultSize").modal('show');
    $.post('apps/barangkeluar/detailbrgkeluar.php?id='+a,
        function(html){
        $("#tampilhis").html(html);
        }   
    );
    
}


function simpandetail (){
  if($('#qty').val() == ''){
    alert("Data Tidak Lengkap");

  } else {
    $('#typeform').val(1);
    var data = $('#form').serializeFormJSON();        
    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
    $.post('apps/barangkeluar/proses.php?act=post',data,

        function(msg) {
           $('#prosesloading').html('');
            //$('#tampilformdetail').load("apps/barangkeluar/tampilformdetail.php?reload=1");
            $('.rst1').trigger("reset");
            $('.rst1').val(null).trigger('change');
            $('#caribrg').load("apps/barangkeluar/tampilcari.php?reload=1");
             document.getElementById('id_barang').value = '';
             document.getElementById('qty').value = '';
             document.getElementById('id_satuan').value = '';
             document.getElementById('stok').value = '';
             $('#stokshow').html(''); 
           //$('#barangkeluartable').DataTable().ajax.reload();
           $('#tampiltable').load("apps/barangkeluar/tampiltable.php?reload=1");

           swal({
                 title: "Konfirmasi!",
                 text: msg,
                 type: "success"
                 //timer: 1000
              });
        }
    );
  }
}

function cekSubDep(val) {
    $('#id_sub').load("apps/barangkeluar/tampilsubdep.php?dep="+val);
}

function cekKategori(val){
    $('#id_kat').load("apps/barangkeluar/tampilkategori.php?sub="+val);
}

function cekCariBrg(val){
    $('#caribrg').load("apps/barangkeluar/tampilcari.php?dep="+$('#id_dep').val()+"&sub="+$('#id_sub').val()+"&kat="+val);
}

function cekJenis(val){
  if(val == 2){
    $('#stok').hide();
    $('#stokshow').hide();
    $('.rst1').trigger("reset");
    $('.rst1').val(null).trigger('change');
    $('#stokshow').html('');
    $('#pakai1').show();
    $('#pakai2').show();
  } else {
    $('#stok').show();
    $('#stokshow').show();
    $('.rst1').trigger("reset");
    $('.rst1').val(null).trigger('change');
    $('#stokshow').html(''); 
    $('#pakai1').hide();
    $('#pakai2').hide();
    $('#supplier1').hide();
    $('#supplier1').hide();
  }
}

function cekPakai(val){
  if(val == 1){
   
    $('#supplier1').show();
    $('#supplier2').show();
  } else {
    
    $('#supplier1').hide();
    $('#supplier2').hide();
  }
}

function showBrg(val){
	spl = val.split('_');
    $('#id_barang').val(spl[0]);
    $('#id_satuan').val(spl[1]);
    $.post('apps/barangkeluar/cekqtycari.php?act=save',{idbarang:spl[0],idgudang:$('#id_gudang').val()},
      function(msg) {
          $('#stok').val(msg);
          $('#stokshow').html(msg+" "+spl[2]);
      }
    );    
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/barangkeluar/tampilform.php?reload=1");
    $('#barangkeluartable').DataTable().ajax.reload();

}

function hapuskeluardtl (val) {
  $('#prosesloading').html('<img src="../assets/images/loading.gif">');
  
  
  $.post('apps/barangkeluar/proses.php?act=post',{iddtl:val,typeform:'3'},
      function(msg) {
         $('#prosesloading').html('');
        // $('#tampilformdetail').load("apps/barangkeluar/tampilformdetail.php?reload=1");
        $('.frdet').trigger("reset");
        $('.frdet').val(null).trigger('change');
        $('#caribrg').load("apps/barangkeluar/tampilcari.php?reload=1");
         document.getElementById('id_barang').value = '';
         document.getElementById('qty').value = '';
         document.getElementById('id_satuan').value = '';
         //$('#barangkeluartable').DataTable().ajax.reload();
         $('#tampiltable').load("apps/barangkeluar/tampiltable.php?reload=1");

         swal({
               title: "Deleted!",
               text: msg,
               type: "success"
               //timer: 1000
            });
      }
  );
}

function hitungqty(val){
  if($('#jenisbrg').val() == 1){
    if(parseInt(val) > parseInt($('#stok').val())){
      alert("Stok Kurang!!");
      $('#qty').val('');
      $('#qty').focus();
    }
  }
}


</script>

