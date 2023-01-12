

<!-- <form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()"> -->
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Site / Lokasi Kerja</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6" id="tampilform">        
        <?php include "tampilform.php"; ?>
    </div>

    <div class="col-lg-6">
        <div class="table-responsive">
            <table class="table table-striped table-bordered server-side" id="sitetable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lokasi Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                        <th>ID</th>
                        <th>Lokasi Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
</form>
