<!-- sebenarnya form tppi adalah gabungan dari cell form akun dan form instansi -->

<?php
if($is_tppi_edit === FALSE){ 
    $display_instansi = 'none';
    $display_pemlap = 'none';
}else{
    if($edit_data['id_pemlap_tppi'] === NULL){
        $display_pemlap = 'block';
    }
    if($edit_data['id_instansi_tppi'] === NULL){
        $display_instansi = 'block';
    }
    
} ?>
<div class = "box" style='padding:30px 0 30px 0;'>
    <div class = 'box-title'>
        <b><?= $config['form_title'] ?></b>
    </div>			
        
    <form method = "POST" action = "<?= $config['form_action'] ?>" onsubmit ="return final_verify_tppi();">
        <div class="box-info">
            <a>Sudah menemukan instansi / perusahaan yang mau menerima anda magang? Silahkan pilih data untuk meminta surat izin dari TU.</a>
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
            <?php
            if($is_tppi_edit === FALSE){ ?>
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
            <?php
            } ?>
            <div id = "box-pemlap" class = "box2" style="border:none;display:<?= $display_pemlap ?>;">
                <div class='box-title' style='margin-top:2em;'>
                    <b>Data Pembimbing</b>
                </div>
                <?=
                    view_cell('\App\Libraries\Cells::form_akun',
                    [
                        'config' => ['show_password' => FALSE,'use_box' => FALSE],
                        'required' => 
                            [
                                ['nama_akun','email_akun','no_unik_akun','no_wa_akun','peran_akun'],
                                ['block','block','block','block','none']
                            ],
                        'peran_display' => ['block','block','block'], //peran akun diperlukan karena berkaitan dgn verif typo akun, namun displaynya di none kan
                        'live_search' => [],
                        'button' => [],
                        'is_edit_form' => $is_tppi_edit,
                        'edit_data' => $edit_data
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
                            'required' => 
                            	[
                                    ['nama_instansi','no_telepon_instansi','email_instansi','no_fax_instansi','alamat_instansi'],
                                    ['block','block','block','block','block']
                        		],
                            'button' => [],
                            'is_edit_form' => $is_tppi_edit,
                            'edit_data' => $edit_data
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
	$(document).ready(function(){
        $('#teks_no_unik_akun').html('NIP (Opsional)');
        $('#peran_akun').val('pemlap').change();
        <?php
        session()->get();
        if(isset($_SESSION['data_form_akun'])){ ?>
			$('#show-pemlap').prop('checked','true');
            show_pemlap();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#show-pemlap").offset().top
            }, 1000);
        <?php
        }
        if(isset($_SESSION['data_form_instansi'])){ ?>
			$('#show-instansi').prop('checked','true');
            show_instansi();
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#show-instansi").offset().top
            }, 1000);
        <?php
        } ?>
    });
	
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
            if(final_verify_akun(required_akun)){
                $('#bg-for-loading').css('display','block');
                $('#lds-dual-ring').css('display','inline-block');
                return true;
            }else{
                return false;
            }
        }else if($('#show-instansi:checked').length > 0){
            if(final_verify_instansi(required_instansi)){
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
