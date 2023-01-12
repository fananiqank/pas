

<!-- <form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()"> -->
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Departemen</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6" id="tampilform">    
    
        <?php 
            if($_GET['type'] == 1){
                include "tampilformsubdep.php"; 
            } else if($_GET['type'] == 2){
                include "tampilformkat.php"; 
            } else {
                include "tampilform.php"; 
            }
        ?>
    </div>

    <div class="col-lg-6">
        <div class="table-responsive">
        <?php if($_GET['type'] == 1){ ?>
            <table class="table table-striped table-bordered server-side" id="departementable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Sub Dep</th>
                        <th>Nama Sub Dep</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                        <th>ID</th>
                        <th>Kode Sub Dep</th>
                        <th>Nama Sub Dep</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                </tfoot>
            </table>
        <?php } else if($_GET['type'] == 2){ ?>
            <table class="table table-striped table-bordered server-side" id="departementable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Kat</th>
                        <th>Nama Kat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                        <th>ID</th>
                        <th>Kode Kat</th>
                        <th>Nama Kat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                </tfoot>
            </table>
        <?php } else { ?>
            <table class="table table-striped table-bordered server-side" id="departementable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Dep</th>
                        <th>Nama Dep</th>
                        <th>Sub Dep</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                        <th>ID</th>
                        <th>Kode Dep</th>
                        <th>Nama Dep</th>
                        <th>Sub Dep</th>
                        <th>Aksi</th>
                </tfoot>
            </table>
        <?php } ?>
        </div>
    </div>
</div>
</section>
</form>
