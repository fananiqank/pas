<script type="text/javascript">
if($('#typeform').val() == 2) {
    isiajax = "apps/departemen/data_kategori.php?dep="+$('#iddep').val()+"&sub="+$('#idsub').val();
    formreload = "tampilformkat.php" ;
    dep = "&dep="+$('#iddep').val()+"&sub="+$('#idsub').val();
} else if($('#typeform').val() == 1) {
    isiajax = "apps/departemen/data_subdep.php?dep="+$('#iddep').val();
    formreload = "tampilformsubdep.php" ;
    dep = "&dep="+$('#iddep').val();
} else {
    isiajax = "apps/departemen/data.php";
    formreload = "tampilform.php" ;
     dep = "";
}
$('.server-side').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": isiajax
    } );

$(document).ready(function(){
    $("#simpan").click(function(){
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $('#form').load("apps/departemen/"+formreload+"?reload=1"+dep)
                    $.post('apps/departemen/proses.php?act=post',data,

                        function(msg) {
                           $('#prosesloading').html('');
                           formreload;
                            $('#departementable').DataTable().ajax.reload();                         

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
  $.get( "apps/departemen/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_dep').val(counter.id_dep);
            $('#kd_dep').val(counter.kd_dep);
            $('#nama_dep').val(counter.nama_dep);
        }
        
    });
}

function getEdit2(a){
  var b = $('#iddep').val(); 
  $.get( "apps/departemen/proses.php?act=get&id="+a+"&dep="+b+"&typeform=1", function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_sub').val(counter.id_sub);
            $('#kd_sub').val(counter.kd_sub);
            $('#nama_sub').val(counter.nama_sub);
            $('#status').load("apps/departemen/tampilstatus.php?status="+counter.status);
        }
        
    });

}

function getEdit3(a){
  var b = $('#iddep').val(); 
  var c = $('#idsub').val(); 
  $.get( "apps/departemen/proses.php?act=get&id="+a+"&dep="+b+"&sub="+c+"&typeform=2", function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_kat').val(counter.id_kat);
            $('#kd_kat').val(counter.kd_kat);
            $('#nama_kat').val(counter.nama_kat);
            $('#status').load("apps/departemen/tampilstatus.php?status="+counter.status);
        }
        
    });

}

function reset() {
    $('#prosesloading').html('');
    if($('#typeform').val() == 1) {
        $('#form').load("apps/departemen/tampilformsubdep.php?reload=1&type=1&dep="+$('#iddep').val());
    } else if($('#typeform').val() == 2) {
        $('#form').load("apps/departemen/tampilformkat.php?reload=1&type=2&dep="+$('#iddep').val()+"&sub="+$('#idsub').val());
    } else {
        $('#form').load("apps/departemen/tampilform.php?reload=1");
    }
    $('#departementable').DataTable().ajax.reload();

}

function subdep(id){
    javascript: window.location.href="index.php?x=marchandise&type=1&dep="+id;
}

function kategori(dep,sub){
    javascript: window.location.href="index.php?x=marchandise&type=2&dep="+dep+"&sub="+sub;
}

function backdep(){
    javascript: window.location.href="index.php?x=marchandise";
}

function backsub(id){
    javascript: window.location.href="index.php?x=marchandise&type=1&dep="+id;
}
</script>

