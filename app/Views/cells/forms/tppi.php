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
        
    <form method = "POST" action = "<?= $config['form_action'] ?>" onsubmit ="return final_verify();">
        <div class="box-info">
            <a>Sudah menemukan instansi / perusahaan yang mau menerima anda magang? Silahkan pilih data untuk meminta surat izin dari TU.</a>
        </div>

        <div class="container">
            <div class = "row" style='text-align:center;'>
                <div class = "col-md-6 select-calon" id='div-select-pemlap'>
                    Pembimbing Lapangan<br>
                    <select name = "pembimbing_lapangan" id="select-pemlap" class="selectpicker" data-live-search="true">
                        <?php
                        foreach($liveSearch['pemlap'] as $item){ ?>
                            <option value="<?= $item['id_pemlap']?>" data-subtext="<?= $item['nama_instansi'] ?>"><?= $item['nama_pemlap']?></option><?php
                        } ?>
                    </select>
                </div>
                <div class = "col-md-6 select-calon" id='div-select-instansi'> 
                    Instansi<br>
                    <select name = "id_instansi" id= "select-instansi" class="selectpicker" data-live-search="true"><?php
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
<?php
session()->get();
if($_SESSION['loginData']['db'] == 'mhs'){ 
	echo view_cell('\App\Libraries\Cells::data_table',
        [
            'config' => 
                [
                    'judul_tabel' => "Riwayat Pengajuan",
                    'id_tabel' => "riwayat",
                    'default_display' => 'block'
                ],
            'arr_head' =>   
                [
                    ['Tanggal',FALSE],
                    ['Pembimbing',TRUE],
                    ['Instansi',TRUE],
                    ['Acc Kampus',FALSE],
                    ['Acc Instansi',FALSE]
                ], 
            'head_clickable' => 'Detail',
            'arr_item' => 
                [
                    ['~timestamp_tppi',FALSE],
                    ['~nama_pemlap_tppi',TRUE],
                    ['~nama_instansi_tppi',TRUE],
                    ['~acc_kampus_tppi',FALSE],
                    ['~acc_pemlap_tppi',FALSE]
                ],
            'arr_clickable' => 
            [
                [
                    'jenis_icon' => 'description',
                    'toggle' => 'Detail',
                    'href' => NULL, 
                    'class' => 'detail_btn',
                    'id' => '~id_tppi',
                    'confirm_func' => NULL,
                    'confirm_msg' => NULL,
                    
                    'id_clicked' => '~id_tppi',
                    'db_clicked' => 'tppi'
                ]
            ],
            'is_lama_magang' => FALSE,
            'data' => $tppi_si_mhs
        ]
    ); 
    foreach($tppi_si_mhs as $item){
    ?>
        <div id='detail_<?= $item['id_tppi'] ?>' class='div-tabel detail' style='display:none;'>
            <div class='row'>
                <div class='col-md-6'>
                    <?=
                    view_cell('\App\Libraries\Cells::simple_table',
                    [
                        'judul_tabel' => 'Data Pembimbing',
                        'data_tabel' => 
                            [
                                ['Nama',$item['nama_pemlap_tppi']],
                                ['NIP',$item['no_unik_pemlap_tppi']],
                                ['Email',$item['email_pemlap_tppi']],
                                ['No WhatsApp',$item['no_wa_pemlap_tppi']],
                                ['Status',$item['acc_pemlap_tppi']]
                            ]
                    ]);
                    ?>
                </div>
                <div class='col-md-6'>
                    <?=
                    view_cell('\App\Libraries\Cells::simple_table',
                    [
                        'judul_tabel' => 'Data Instansi',
                        'data_tabel' => 
                            [
                                ['Nama',$item['nama_instansi_tppi']],
                                ['Alamat',$item['alamat_instansi_tppi']],
                                ['No Telepon',$item['no_telepon_instansi_tppi']],
                                ['No Fax',$item['no_fax_instansi_tppi']],
                                ['Email',$item['email_instansi_tppi']],
                                ['Status',$item['acc_kampus_tppi']]
                            ]
                    ]); 
                    ?>
                </div>
            </div>
        </div>                       
    <?php
    }
} ?>
<script>
	$(document).ready(function(){
        $('#teks_no_unik_akun').html('NIP (Opsional)');
        $('#peran_akun').val('pemlap').change();
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

    $('.detail_btn').click(function(){
        $('.detail').css('display','none');
        $('#detail_'+this.id).css('display','block');
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#detail_"+this.id).offset().top
        }, 1000);
    });
</script>
