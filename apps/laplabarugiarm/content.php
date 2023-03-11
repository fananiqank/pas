<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Laporan Laba Rugi Armada</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="form-group row">
    <!-- <label class="col-sm-2 control-label" for="w1-username" style="text-align: center;">Gudang</label>
        <div class="col-sm-4">
            <select class="select2" id="id_gudang" name="id_gudang" onchange="cgudang(this.value)">
                <?php //include "tampilgudang.php"; ?>
            </select>
        </div>
       
    </div> -->
        <label class="col-sm-1 control-label" for="w1-username" style="text-align: center;">Periode</label> 
        <div class="col-sm-2">
            <select class="select2 form-control block headmas" id="bpbulan" name="bpbulan" required>
                    <option value="0" <?php if($_GET[bln] == 0){echo "selected";} ?>>Pilih Bulan</option>
                    <option value="1" <?php if($_GET[bln] == 1){echo "selected";} ?>>Januari</option>
                    <option value="2" <?php if($_GET[bln] == 2){echo "selected";} ?>>Februari</option>
                    <option value="3" <?php if($_GET[bln] == 3){echo "selected";} ?>>Maret</option>
                    <option value="4" <?php if($_GET[bln] == 4){echo "selected";} ?>>April</option>
                    <option value="5" <?php if($_GET[bln] == 5){echo "selected";} ?>>Mei</option>
                    <option value="6" <?php if($_GET[bln] == 6){echo "selected";} ?>>Juni</option>
                    <option value="7" <?php if($_GET[bln] == 7){echo "selected";} ?>>Juli</option>
                    <option value="8" <?php if($_GET[bln] == 8){echo "selected";} ?>>Agustus</option>
                    <option value="9" <?php if($_GET[bln] == 9){echo "selected";} ?>>September</option>
                    <option value="10" <?php if($_GET[bln] == 10){echo "selected";} ?>>Oktober</option>
                    <option value="11" <?php if($_GET[bln] == 11){echo "selected";} ?>>November</option>
                    <option value="12" <?php if($_GET[bln] == 12){echo "selected";} ?>>Desember</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select class="select2 form-control block headmas" id="bptahun" name="bptahun" required>
                <option value="0">Pilih Tahun</option>
                <?php 
                    $thn=date("Y");
                    for($i=$thn;$i>=2021;$i--){
                ?>
                <option value="<?=$i?>"  <?php if($_GET[thn] == $i){echo "selected";} ?>><?=$i?></option>
                <?php        
                    }
                ?>
            </select>
        </div>
        
        <!-- <div class="col-sm-2">
            <select class="select2" id="id_mekanik" name="id_mekanik" >
                <?php include "tampilmekanik.php"; ?>
            </select>
        </div> -->
        <div class="col-sm-2">
            <select class="select2" id="arm_id" name="arm_id" >
                <?php include "tampilarmada.php"; ?>
            </select>
        </div>
        <div class="col-sm-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="trtarget(bpbulan.value,bptahun.value,arm_id.value)">Search</a>
        </div>
       
    </div>
</div>
<div class="row">
    
    <div class="col-lg-12">
        <div class="table-responsive">
            <!-- <input style="height:26px; line-height: 0;" type="button" class="btn btn-info" value="Excel"  onclick="tableToExcel('tablestock')"></button> -->
            <table class="table table-striped table-bordered" id="tablelaru">
                <thead>
                    <tr>
                        <th colspan="5">Periode : <?=$_GET['bln']." - ".$_GET['thn']?></th>
                    </tr>
                    <tr>
                        <th colspan="5">Lambung : <?=$_GET['bln']." - ".$_GET['thn']?></th>
                    </tr>
                    <tr>
                        <th colspan="5">Serial : <?=$_GET['bln']." - ".$_GET['thn']?></th>
                    </tr>
                    <tr>
                        <th colspan="5">Produksi & Pendapatan Hauling</th>
                    </tr>
                    <tr>
                        <th>Rute</th>
                        <th>Jarak</th>
                        <th>Tonase</th>
                        <th>Ritase</th>
                        <th>Upah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query="(select rutejarak_id, d.rom_name, c.tujuan_name, b.rutejarak_jarak, max(tarif) tarif, sum(txangkut_tonase) tonase, sum(txangkut_ritase) txangkut_ritase, sum(txangkut_jarak) txangkut_jarak,
                        max(tarif)*sum(txangkut_tonase)*(sum(txangkut_jarak)/sum(txangkut_ritase)) total
                        
                        
                          from (SELECT a.txangkut_tgl, case when day(a.txangkut_tgl)<=15 then 1 else 2 end as periode, (select tarif_harga from m_tarif where cust_id=c.cust_id and type_armada=c.arm_type_armada and a.txangkut_tgl>=tarif_tglmulai order by tarif_id desc limit 1) as tarif, b.* FROM `tx_ritase` a JOIN tx_ritase_dtl b using (txangkut_id) JOIN m_armada c ON c.arm_nolambung=b.txangkut_nolambung where txangkut_tgl between '2023-01-01' and '2023-01-31' and left(b.txangkut_nolambung,10)='KMB 1033' and arm_type_armada='1' ) a 
                            JOIN m_rutejarak b using(rutejarak_id)
                            JOIN m_tujuan c using(tujuan_id)
                            JOIN m_runofmine d using(rom_id)
                            group by rutejarak_id)a";
                        $execquery=$db->select("$query","*");
                        foreach($execquery as $vexecquery){

                        
                    ?>
                    <tr>
                        <td><?=$vexecquery[rom_name]." - ".$vexecquery[tujuan_name]?></td>
                        <td align="right"><?=number_format(round($vexecquery[rutejarak_jarak],3),2)?></td>
                        <td align="right"><?=number_format(round($vexecquery[tonase],3),2)?></td>
                        <td><?=$vexecquery[txangkut_ritase]?></td>
                        <td align="right"><?=number_format(round($vexecquery[tarif],3),2)?></td>
                        <td align="right"><?=number_format(round($vexecquery[total],3),2)?></td>
                    </tr>
                    <?php 
                    $tritase+=$vexecquery[txangkut_ritase];
                    $ttotal+=$vexecquery[total];
                    $ttonase+=$vexecquery[tonase];
                
                    } ?>
                    <tr>
                        <td>Sub Total</td>
                        <td></td>
                        <td align="right"><?=number_format(round($ttonase,3),2)?></td>
                        <td><?=$tritase?></td>
                        <td></td>
                        <td align="right"><?=number_format(round($ttotal,3),2)?></td>
                    </tr>
                    <tr>
                        <td>PPh ps.23 (2%)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><?=number_format(round($pph=($ttotal*(2/100))*-1,3),2)?></td>
                    </tr>
                    <tr>
                        <td>PPn (11%)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><?=number_format(round($ppn=($ttotal+($ttotal*(2/100))*-1)*(11/100),3),2)?></td>
                    </tr>
                    <tr>
                        <td>Proforma</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><?=number_format(round($ttotal+$pph+$ppn,3),2)?></td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>Perhitungan Biaya Operasional & Overhead</strong></td>
                    </tr>
                    <tr>
                        <td>Biaya Solar</td>
                        <td>Litre</td>
                        <td></td>
                        <td>Harga</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                        $solar="SELECT sum(txsolardtl_liter) liter, txsolardtl_harga, sum(txsolardtl_liter) * txsolardtl_harga totalsolar FROM `tx_solar_dtl` where txsolardtl_tgltrans between '2023-01-01' and '2023-01-31' 
                        -- and arm_id='3' 
                        group by txsolardtl_harga";
                        foreach($db->query($solar) as $vsol){

                        
                    ?>
                    <tr>
                        <td></td>
                        <td align="right"><?=number_format($vsol[liter],2)?></td>
                        <td>x</td>
                        <td align="right"><?=number_format($vsol[txsolardtl_harga],2)?></td>
                        <td>=</td>
                        <td align="right"><?=number_format($vsol[totalsolar],2)?></td>
                    </tr>
                    <?php
                        $tsolar+=$vsol[totalsolar];
                        $tsolarlt+=$vsol[liter];
                        }

                    ?>
                    <tr>
                        <td>Total Biaya Solar</td>
                        <td align="right"><?=number_format($tsolarlt,2)?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><?=number_format($tsolar,2)?></td>
                    </tr>
                    <?php
                        $basic="select sum(jumlah_hari) jumlah_hari, sum(jumlah_hari*basicdriver_jumlah) total from (select driver_id, date(hadirdriver_tgl) hadirdriver_tgl, max(jumlah_hari) jumlah_hari, max(basicdriver_id) basicdriver_id from (select * from (select driver_id, hadirdriver_tgl, count(*) as jumlah_hari from txkehadiran 
                        where hadirdriver_type='1' and hadirdriver_jenis<>'0' and date(hadirdriver_tgl) between '2023-01-01' and '2023-01-31' 
                        
                        and driver_id in (select driver_id from tx_ritase_dtl where arm_id='3' group by driver_id)
                        group by driver_id, hadirdriver_tgl) a 
                        JOIN m_basicdriver ON a.hadirdriver_tgl>=basicdriver_tglmulai 
                        order by basicdriver_id desc) a group by driver_id, date(hadirdriver_tgl)) a 
                        JOIN m_basicdriver b using(basicdriver_id)";
                        
                        foreach($db->query($basic) as $vbasic){}
                    ?>
                    <tr>
                        <td>Biaya Basic Driver</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?=number_format($vbasic[total],2)?></td>
                    </tr>
                    <tr>
                        <td>Biaya Premi Driver</td>
                        <td>Rute</td>
                        <td>Rit/Ton</td>
                        <td>X</td>
                        <td>Premi</td>
                        <td></td>
                    </tr>
                    <?php
                         $premi="select sum(x) tox, GROUP_CONCAT(DISTINCT tipegaji) tipegaji, c.rutename,max(premi) premi, sum(tpremi) tpremi 
                                from (select '' p, case when arm_type_armada='2' then 'Rit' else 'Ton' end as tipegaji, driver_id, arm_type_armada, sum(tpremi) tpremi,
                                sum(case when arm_type_armada='2' then ritase else tonase end) as x, case when arm_type_armada='2' then 'Ritase' else 'Tonase' end as x2,
                                txangkut_nolambung,rutejarak_id, id_site, sum(ritase) ritase, sum(tonase) tonase, max(premi) premi 
                                from (select txangkut_tgl,driver_id,arm_type_armada, case when arm_type_armada = 2 then ritase*premi else tonase*premi end as tpremi, ritase, tonase,txangkut_nolambung,rutejarak_id, id_site, premi from (select a.txangkut_tgl, b.driver_id, c.arm_type_armada, (txangkut_ritase) ritase, (txangkut_tonase) tonase, COALESCE((select premidriver_jumlah from m_premidriver x where a.txangkut_tgl>=x.premidriver_tglmulai and x.arm_type_armada=c.arm_type_armada and x.rom_id=d.rom_id order by premidriver_id desc limit 1),0) premi, b.txangkut_nolambung,b.rutejarak_id, b.id_site from tx_ritase a JOIN tx_ritase_dtl b ON a.txangkut_id=b.txangkut_id JOIN m_armada c ON c.arm_id=b.arm_id JOIN m_rutejarak d ON d.rutejarak_id=b.rutejarak_id where date(a.txangkut_tgl) between '2023-01-01' and '2023-01-31' and c.arm_id='3') a) a group by arm_type_armada,txangkut_nolambung,rutejarak_id, id_site, driver_id )a join m_driver b using(driver_id) LEFT join (select a.rutejarak_id, concat(b.rom_name) rutename from m_rutejarak a JOIN m_runofmine b on a.rom_id=b.rom_id join m_tujuan c ON a.tujuan_id=c.tujuan_id) c using(rutejarak_id) group by rutename,premi
                         ";
                         
                         foreach($db->query($premi) as $vpremi){

                    ?>
                    <tr>
                        <td></td>
                        <td><?=$vpremi[rutename]?></td>
                        <td align="right"><?=number_format(round($vpremi[tox],3))." ".$vpremi[tipegaji]?></td>
                        <td>X</td>
                        <td align="right"><?=number_format(round($vpremi[premi],3))?></td>
                        <td align="right"><?=number_format(round($vpremi[tpremi],3))?></td>
                    </tr>
                    <?php 
                            $tpremix+=$vpremi[tox];
                            $tpremi+=$vpremi[tpremi];
                        } ?>
                    <tr>
                        <td>Total Premi</td>
                        <td></td>
                        <td align="right"><?=number_format(round($tpremix,3))." ".$vpremi[tipegaji]?></td>
                        <td></td>
                        <td align="right"></td>
                        <td align="right"><?=number_format(round($tpremi,3))?></td>
                    </tr>
                    <tr>
                        <td>Penggunaan Sparepart</td>
                        <td>Item</td>
                        <td>Qty</td>
                        <td>X</td>
                        <td>Harga</td>
                        <td>Total</td>
                    </tr>
                    <?php
                        $sparepart="select *, harga*keluarmutasi as tharga from (SELECT a.arm_id, c.nama_barang, max(harga) harga, keluarmutasi, count(b.id_barang) jumbarang, b.id_barang FROM `tx_maintenance` a
                        LEFT JOIN tx_mutasi b on b.no_transmutasi=a.no_mtc
                        LEFT JOIN m_barang c on c.id_barang=b.id_barang
                        where tgl_mtc between '2023-01-01' and '2023-01-31' and a.arm_id='28' and jenismutasi='2'
                        group by id_barang,harga) a;";
                         
                         foreach($db->query($sparepart) as $vsparepart){

                    ?>
                    <tr>
                        <td></td>
                        <td><?=$vsparepart[nama_barang]?></td>
                        <td align="right"><?=number_format(round($vsparepart[keluarmutasi],3))?></td>
                        <td>X</td>
                        <td align="right"><?=number_format(round($vsparepart[harga],3))?></td>
                        <td align="right"><?=number_format(round($vsparepart[tharga],3))?></td>
                    </tr>
                    <?php 
                            $tpremix+=$vpremi[tox];
                            $tsparepart+=$vsparepart[tharga];
                        } ?>
                    <tr>
                        <td>Total Sparepart</td>
                        <td></td>
                        <td align="right"></td>
                        <td></td>
                        <td align="right"></td>
                        <td align="right"><?=number_format(round($tsparepart,3))?></td>
                    </tr>
                    <tr>
                        <td>Biaya Jasa Bengkel</td>
                        <td>Pekerjaan</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Biaya</td>
                    </tr>
                    <?php
                        $mekanik="SELECT pekerjaan, biaya FROM `tx_maintenance` a
                        LEFT JOIN tx_mekanik b on b.id_mtc=a.id_mtc
                        where tgl_mtc between '2023-01-01' and '2023-01-31' and a.arm_id='3' 
                        ";
                         
                         foreach($db->query($mekanik) as $vmekanik){

                    ?>
                    <tr>
                        <td></td>
                        <td><?=$vmekanik[pekerjaan]?></td>
                        <td align="right"></td>
                        <td></td>
                        <td align="right"></td>
                        <td align="right"><?=number_format(round($vmekanik[biaya],3))?></td>
                    </tr>
                    <?php 
                            
                            $tmekanik+=$vmekanik[biaya];
                        } ?>
                    <tr>
                        <td>Total Biaya Jasa Bengkel</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><?=number_format($tmekanik,3)?></td>
                    </tr>
                    <tr>
                        <td>Biaya Workshop</td>
                        <td>lt</td>
                        <td>x</td>
                        <td>rp</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Biaya Bendera</td>
                        <td>lt</td>
                        <td>x</td>
                        <td>rp</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Biaya Leasing Bulanan</td>
                        <td>lt</td>
                        <td>x</td>
                        <td>rp</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
         
    </div>
</div>
</section>
<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>History Mutasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="tampilhis">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>                                      
