<!-- fully customised template, dont change anything bisa kacau balau nanti -->

<?php

if(isset($config['use_box'])){if($config['use_box']){ ?>    
    <div class = "box">
        <div class = 'box-title'>
            <b><?= $config['form_title'] ?></b>
        </div>			
            
        <form method = "POST" action = "<?= $config['form_action'] ?>" onsubmit ="return final_verify_akun();">
            <div class="container" style="padding-left:2em;"><?php
}} ?>
                <div class = "row"><?php
                    $i = 0; //untuk display per div nya
                    foreach(FORM_AKUN_NAMING as $item){ 
                        if(in_array($item['name/id'],$required[0])){ 
                            if($item['input_type'] != 'selection') { ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box" style="display:<?= $required[1][$i] ?>;"><?php 
                                    if($item['name/id'] == 'no_unik_akun'){ ?>
                                        <a id = "teks_<?= $item['name/id'] ?>"> <?= $item['input_text'] ?> </a> <a id="warning_<?= $item['name/id'] ?>" style="color:red;"></a><?php
                                    }else{ ?>
                                        <?= $item['input_text'] ?> <a id="warning_<?= $item['name/id'] ?>" style="color:red;"></a><?php
                                    } ?>
                                    <p>
                                        <input type = "<?= $item['input_type'] ?>" name="<?= $item['name/id'] ?>" id="<?= $item['name/id'] ?>" class = "inside-box form-control form-control-akun" value="" placeholder = "<?= $item['placeholder'] ?>">
                                    </p>
                                </div><?php
                            }else if($item['name/id'] == 'peran_akun'){ ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box" style="display:<?= $required[1][$i] ?>;">
                                <?= $item['input_text'] ?> <br>
                                <p>
                                    <select name="<?= $item['name/id'] ?>" class="selectpicker" id="<?= $item['name/id'] ?>" onchange="gantiNNN()">
                                        <option value="dosbing" style="display:<?= $peran_display[0] ?>;">Dosen Pembimbing</option>
                                        <option value="pemlap" style="display:<?= $peran_display[1] ?>;">Pembimbing Lapangan</option>
                                        <option value="mhs" style="display:<?= $peran_display[2] ?>;" selected>Mahasiswa</option>
                                    </select>
                                </p>
                                </div><?php
                            }else if($item['name/id'] == 'id_instansi_akun'){ ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box" style="display:<?= $required[1][$i] ?>;">
                                    <?= $item['input_text'] ?> <br>
                                    <p>
                                        <select name="<?= $item['name/id'] ?>" class="selectpicker" id="<?= $item['name/id'] ?>"> <?php
                                            foreach($live_search['instansi'] as $result){ ?>
                                                <option value="<?= $result['id_instansi']?>" data-subtext = "<?= $result['alamat_instansi'] ?>" ><?= $result['nama_instansi']?></option><?php
                                            } ?>
                                        </select>
                                    </p> 
                                </div><?php
                            }else{ ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box utkmhs" style="display:<?= $required[1][$i] ?>;">
                                    <?= $item['input_text'] ?> <br>
                                    <p>
                                    <!-- mungkin akan bertanya2 kenapa ada id di tiap option dosbing pemlap-->
                                    <!-- jangan dihilangkan karena terkait dengan view su control edit akun, penjelasam ada disana -->
                                        <select name="<?= $item['name/id'] ?>" class="selectpicker select_utkmhs" id="<?= $item['name/id'] ?>"><?php
                                            if($item['name/id'] == 'id_dosbing_akun'){
                                                foreach($live_search['dosbing'] as $result){ ?>
                                                    <option value="<?= $result['id_dosbing']?>" id='option_dosbing_<?= $result['id_dosbing'] ?>' ><?= $result['nama_dosbing']?></option><?php
                                                } ?><?php
                                            }else if($item['name/id'] == 'id_pemlap_akun'){?>
                                                <option value= 'null'>Belum Ada</option> <?php
                                                foreach($live_search['pemlap'] as $result){ ?>
                                                    <option value="<?= $result['id_pemlap']?>" id='option_pemlap_<?= $result['id_pemlap'] ?>' data-subtext = "<?= $result['nama_instansi'] ?>" ><?= $result['nama_pemlap']?></option><?php
                                                } ?><?php
                                            } ?>
                                        </select>
                                    </p>
                                </div><?php
                            }
                            $i++;
                        }
                        
                    } 
                    ?>
                </div>
                <!-- checkbox lihat password --><?php
                if(isset($config['show_password'])){if($config['show_password']){ ?>
                    <div class="custom-control custom-checkbox" style='margin-top:1em;margin-left:1em;'>
                        <input type="checkbox" class="custom-control-input" id="lihat_pass">
                        <label class="custom-control-label" for="lihat_pass">Perlihatkan Password</label>
                    </div><?php
                }} ?>
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
                }
if(isset($config['use_box'])){if($config['use_box']){ ?>
            </div>
        </form>
    </div><?php
}} ?>
<!-- <button onclick = "final_verify_akun()">djkaja</button> -->
<!-- loading bar -->
<div id = 'bg-for-loading'>
    <div id = 'lds-dual-ring'></div>
</div>
<script src = "<?= base_url() ?>/js/script.js"></script>
<script>
    //jquery bila ada dobel (tak valid) email_akun or no_unik_akun dalam kasus dari controller auth balik sini lagi
    <?php
    session()->get();
    if(isset($_SESSION['form_akun_not_valid'])){ session()->get();?>
        $(document).ready(function(){ <?php
            // mengisikan data sebelumnya
            foreach($_SESSION['data_form_akun'] as $key => $item){ 
                if($item == 'peran_akun' || $item == 'id_instansi_akun' || $item == 'id_dosbing_akun' || $item == "id_pemlap_akun"){?>
                    $("#<?= $key ?>").val("<?= $item ?>").change(); <?php
                }else{ ?>
                    $("#<?= $key ?>").val("<?= $item ?>"); <?php
                }
            } 
            //memberi class betul pada semua form-control
            ?>
            $('.form-control-akun').addClass('correct');

            <?php
            //menyalahkan email atau no unik
            if( in_array('email_akun',$_SESSION['form_akun_not_valid']) ){ ?>
                $('#warning_email_akun').html(' *Sudah ada, pakai lainnya');
                $('#email_akun').removeClass('correct');
                $('#email_akun').addClass('wrong'); 
                <?php        
            } 

            if( in_array('no_unik_akun',$_SESSION['form_akun_not_valid']) ){ ?>
                $('#warning_no_unik_akun').html(' *Sudah ada, pakai lainnya');
                $('#no_unik_akun').removeClass('correct');
                $('#no_unik_akun').addClass('wrong'); 
                <?php
            } ?>
        }); <?php
    }else{ ?>

        //jquery bila edit form
        <?php
        if($is_edit_form){$db = $edit_data['db'];?>
            $(document).ready(function(){
                $("#peran_akun").val("<?= $db ?>").change();

                if($('#nama_akun').length > 0){
                    $('#nama_akun').val("<?= $edit_data['nama_'.$db] ?>");
                }
                if($('#no_unik_akun').length > 0){
                    $('#no_unik_akun').val("<?= $edit_data['no_unik_'.$db] ?>");
                }
                if($('#email_akun').length > 0){
                    $('#email_akun').val("<?= $edit_data['email_'.$db] ?>");
                }
                if($('#no_wa_akun').length > 0){
                    $('#no_wa_akun').val("<?= $edit_data['no_wa_'.$db] ?>");
                }
                <?php if($db == "mhs"){ ?>
                if($('#id_dosbing_akun').length > 0){ 
					<?php
                    $id_dosbing = $edit_data['id_dosbing_'.$db];
                    if($id_dosbing === NULL){
                        $id_dosbing = 'null';
                    }
                    ?>
                    $('#id_dosbing_akun').val("<?= $id_dosbing ?>").change();
                }<?php } ?>
                <?php if($db == "mhs"){ ?>
                if($('#id_pemlap_akun').length > 0){
                    <?php
					$id_pemlap = $edit_data['id_pemlap_'.$db];
                    if($id_pemlap === NULL){
                        $id_pemlap = 'null';
                    }
                    ?>
                    $('#id_pemlap_akun').val("<?= $id_pemlap ?>").change();
                }<?php } ?>
                if($('#id_instansi_akun').length > 0){
                    <?php
					$id_instansi = $edit_data['id_instansi_'.$db];
                    if($id_instansi === NULL){
                        $id_instansi = 'null';
                    }
                    ?>
                    $('#id_instansi_akun').val("<?= $id_instansi ?>").change();
                }
            });    <?php
        } 
    }?>

    //bila ada peran_akun
    
    <?php
    if(in_array("peran_akun",$required[0]) && in_array("no_unik_akun",$required[0])){ ?>
        $(document).ready(function(){
            gantiNNN();
        }); <?php
    } ?>


    //jquery untuk hilangkan class bila wrong
    $(document).ready(function(){
        $("#nama_akun").keyup(function(){
            $("#nama_akun").removeClass('wrong');
            $("#nama_akun").removeClass('correct');
        });
        $("#no_unik_akun").keyup(function(){
            $("#no_unik_akun").removeClass('wrong');
            $("#no_unik_akun").removeClass('correct');
        });
        $("#email_akun").keyup(function(){
            $("#email_akun").removeClass('wrong');
            $("#email_akun").removeClass('correct');
        });
        $("#password_akun").keyup(function(){
            $("#password_akun").removeClass('wrong');
            $("#password_akun").removeClass('correct');
        });
        $("#konfirmasi_password_akun").keyup(function(){
            $("#konfirmasi_password_akun").removeClass('wrong');
            $("#konfirmasi_password_akun").removeClass('correct');
        });
        $("#no_wa_akun").keyup(function(){
            $("#no_wa_akun").removeClass('wrong');
            $("#no_wa_akun").removeClass('correct');
        });
    });

    //js untuk masukkan required ke arr js
    var required_akun = new Array();
    <?php
    foreach($required[0] as $item){ ?>
		required_akun.push('<?= $item ?>');<?php
    }?>
    
    function final_verify_akun(){
        if(verif_typo_akun(required_akun)){
            $('#bg-for-loading').css('display','block');
            $('#lds-dual-ring').css('display','inline-block');
            return true;
        }else{
            return false;
        }
    }
</script>
