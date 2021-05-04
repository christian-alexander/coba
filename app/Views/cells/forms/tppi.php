<!-- sebenarnya form tppi adalah gabungan dari cell form akun dan form instansi -->

<?php
if($is_tppi_edit === FALSE){ 
    $display_instansi = 'none';
    $display_pemlap = 'none'; 
    $display_checkbox = 'block';
}else{
    $display_instansi = 'none';
    $display_pemlap = 'none';
    $display_checkbox = 'none';
}
?>
<div class = "box" style='padding:30px 0 30px 0;'>
    <div class = 'box-title'>
        <b><?= $config['form_title'] ?></b>
    </div>			
        
    <form method = "POST" action = "<?= $config['form_action'] ?>" onsubmit ="return final_verify_tppi();">
        <div class="box-info">
            <a><?= $info ?></a>
        </div>

        <div class="container">
            <div class = "row" style='text-align:center;'>
                <div class = "col-md-6 select-calon" id='div-select-pemlap'>
                    Pembimbing Lapangan<br>
                    <select name = "id_pemlap_tppi" id="select-pemlap" class="selectpicker" data-live-search="true">
                        <?php
                        foreach($liveSearch['pemlap'] as $item){ ?>
                            <option value="<?= $item['id_pemlap']?>" data-subtext="<?= $item['nama_instansi'] ?>"><?= $item['nama_pemlap']?></option><?php
                        } ?>
                    </select>
                </div>
                <div class = "col-md-6 select-calon" id='div-select-instansi'> 
                    Instansi<br>
                    <select name = "id_instansi_tppi" id= "select-instansi" class="selectpicker" data-live-search="true"><?php
                        foreach($liveSearch['instansi'] as $item){ 
                            if($item['id_instansi'] != 0){ ?>
                                <option value="<?= $item['id_instansi']?>" data-subtext= "<?= $item['alamat_instansi'] ?>" ><?= $item['nama_instansi']?></option><?php
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <br>
            <div id = 'box-checkbox' style='display:<?= $display_checkbox ?>;'>
                <div style = "text-align:center;">
                    <p style="color:red">Instansi atau pembimbing lapangan belum terdaftar?</p>
                </div>
                <div class="row" style="text-align:center;">
                    <div class = "col-md-6">
                        <!-- checkbox lihat pemlap -->
                        <div class="custom-control custom-checkbox" onchange="show_pemlap()">
                            <input type="checkbox" class="custom-control-input" id="show-pemlap">
                            <label class="custom-control-label" for="show-pemlap">Daftarkan Pembimbing Baru</label>
                        </div>
                    </div>
                    <div class = "col-md-6">
                        <!-- checkbox lihat instansi -->
                        <div class="custom-control custom-checkbox" onchange="show_instansi()">
                            <input type="checkbox" class="custom-control-input" id="show-instansi">
                            <label class="custom-control-label" for="show-instansi">Daftarkan Instansi Baru</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id = "box-pemlap" class = "box2" style="border:none;display:<?= $display_pemlap ?>;">
                <div class='box-title' style='margin-top:2em;'>
                    <b>Data Pembimbing</b>
                </div>
                <?=
                    view_cell('\App\Libraries\Cells::form_akun',
                    [
                        'config' => ['show_password' => FALSE,'use_box' => FALSE],
                        'required' => $required_akun,
                        'peran_display' => ['block','block','block'], //peran akun diperlukan karena berkaitan dgn verif typo akun, namun displaynya di none kan
                        'live_search' => [],
                        'button' => [],
                        'is_edit_form' => FALSE
                    ]
                    ); 
                ?>
            </div> 
            <div id = "box-instansi" class = "box2" style="border:none;display:<?= $display_instansi ?>;">
            	<div class='box-title' style='margin-top:2em;'>
                    <b>Data Instansi</b>
                </div>
                <?=
                    view_cell('\App\Libraries\Cells::form_instansi',
                        [
                            'config' => ['use_box' => FALSE],
                            'required' => $required_instansi,
                            'button' => [],
                            'is_edit_form' => FALSE
                        ]
                    ); 
                ?>
            </div>
        </div>
        <!-- buttons -->
        <?php
        if(count($button) != 0){ ?>
            <div class="div-tombol"> <?php
                foreach($button as $item){ ?><?php
                    if(!isset($item['button_action'])){ ?>
                        <button type = "submit" class = "btn <?= $item['button_type'] ?> tombol"><?= $item['button_text'] ?></button><?php
                    }else{ ?>
                        <a href = "<?= $item['button_action'] ?>" class = "btn <?= $item['button_type'] ?> tombol"><?= $item['button_text'] ?></a><?php    
                    }
                } ?>
            </div><?php
        } ?>
    </form>
</div>

<script>
    function show_pemlap(){
        if($('#show-pemlap:checked').length > 0){
        	$('#box-pemlap').css('display','block');
            $('#select-pemlap').val('null').change();
            $('#div-select-pemlap').css('display','none');
            $('#div-select-instansi').removeClass('col-md-6').addClass('col-md-12');
        }else{
        	$('#box-pemlap').css('display','none');
            $('#div-select-pemlap').css('display','block');
            $('#div-select-instansi').removeClass('col-md-12').addClass('col-md-6');
        	$('#select-pemlap').change();
        	$('#select-pemlap').val(<?= $liveSearch['pemlap'][0]['id_pemlap'] ?>).change();
        }
    }

    function show_instansi(){
        if($('#show-instansi:checked').length > 0){
        	$('#box-instansi').css('display','block');
            $('#select-instansi').val('null').change();
            $('#div-select-instansi').css('display','none');
            $('#div-select-pemlap').removeClass('col-md-6').addClass('col-md-12');
        }else{
        	$('#box-instansi').css('display','none');
            $('#div-select-instansi').css('display','block');
            $('#div-select-pemlap').removeClass('col-md-12').addClass('col-md-6');
            $('#select-instansi').val($('#value-instansi-before').val());
            $('#select-instansi').val(<?= $liveSearch['instansi'][1]['id_instansi'] ?>).change();
        
        }
    }
	$(document).ready(function(){
        $('#teks_no_unik_akun').html('NIP (Opsional)');
        $('#peran_akun').val('pemlap').change();
        <?php
        session()->get();
        if( isset($_SESSION['form_akun_not_valid']) || isset($_SESSION['form_instansi_not_valid']) ){
            //bila balenan karena dobel data
            if(isset($_SESSION['data_form_akun'])){ ?>
                $('#show-pemlap').prop('checked','true');
                show_pemlap();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#box-pemlap").offset().top
                }, 1000);
            <?php
            }
            if(isset($_SESSION['data_form_instansi'])){ ?>
                $('#show-instansi').prop('checked','true');
                show_instansi();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#box-instansi").offset().top
                }, 1000);
            <?php
            } 
        }else{
            // bila edit2 an
            if(isset($edit_data)){
                if($edit_data['id_instansi_tppi'] === NULL){ ?>
                    $('#show-instansi').prop('checked','true');
                    show_instansi();
                <?php
                } 
                if($edit_data['id_pemlap_tppi'] === NULL){ ?>
                    $('#show-pemlap').prop('checked','true');
                    show_pemlap();
                <?php
                } ?>
                isi_data_edit();
            <?php
            }
        }?>
        
        
    });
	
    <?php
    if(isset($edit_data)){ ?>
        function isi_data_edit(){
            //mengisi data akun bila ada
            if($('#show-pemlap:checked').length > 0){
                $('#nama_akun').val('<?= $edit_data['nama_akun'] ?>');
                $('#email_akun').val('<?= $edit_data['email_akun'] ?>');
                $('#no_wa_akun').val('<?= $edit_data['no_wa_akun'] ?>');
                <?php
                if($edit_data['no_unik_akun'] === 'Tidak Ada'){ $no_unik = ''; }
                else{ $no_unik = $edit_data['no_unik_akun'] ;} ?>
                $('#no_unik_akun').val('<?= $no_unik ?>');
            }

            //mengisi data instansi bila ada
            if($('#show-instansi:checked').length > 0){
                $('#nama_instansi').val('<?= $edit_data['nama_instansi'] ?>');
                $('#email_instansi').val('<?= $edit_data['email_instansi'] ?>');
                $('#no_telepon_instansi').val('<?= $edit_data['no_telepon_instansi'] ?>');
                $('#no_fax_instansi').val('<?= $edit_data['no_fax_instansi'] ?>');
                $('#alamat_instansi').val('<?= $edit_data['alamat_instansi'] ?>');
            }
        }
    <?php
    } ?>


    function final_verify_tppi(){
        if($('#show-pemlap:checked').length > 0 && $('#show-instansi:checked').length > 0){
            var valid_akun = verif_typo_akun(required_akun);
            var valid_instansi = verif_typo_instansi(required_instansi);
            if(valid_akun && valid_instansi){
                $('#bg-for-loading').css('display','block');
                $('#lds-dual-ring').css('display','inline-block');
                return true;
            }else{
                return false;
            }
        }else if($('#show-pemlap:checked').length > 0){
            if(verif_typo_akun(required_akun)){
                $('#bg-for-loading').css('display','block');
                $('#lds-dual-ring').css('display','inline-block');
                return true;
            }else{
                return false;
            }
        }else if($('#show-instansi:checked').length > 0){
            if(verif_typo_instansi(required_instansi)){
                $('#bg-for-loading').css('display','block');
                $('#lds-dual-ring').css('display','inline-block');
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
</script>
