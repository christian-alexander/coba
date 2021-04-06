<!-- fully customised template, dont change anything bisa kacau balau nanti -->

<?php
if(isset($config['use_box'])){if($config['use_box']){ ?>    
    <div class = "box">
        <div class = 'box-title'>
            <b><?= $config['form_title'] ?></b>
        </div>			
            
        <form method = "POST" action = "<?= $config['form_action'] ?>" onsubmit ="return final_verify();">
            <div class="container" style="padding-left:2em;"><?php
}} ?>
                <div class = "row"><?php
                    $i = 0; //untuk display per div nya
                    foreach(FORM_AKUN_NAMING as $item){ 
                        if(in_array($item['name/id'],$required)){ 
                            if($item['input_type'] != 'selection') { ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box" style="display:<?= $display[$i] ?>;"><?php 
                                    if($item['name/id'] == 'no_unik_akun'){ ?>
                                        <a id = "teks_<?= $item['name/id'] ?>"> <?= $item['input_text'] ?> </a> <a id="warning_<?= $item['name/id'] ?>" style="color:red;"></a><?php
                                    }else{ ?>
                                        <?= $item['input_text'] ?> <a id="warning_<?= $item['name/id'] ?>" style="color:red;"></a><?php
                                    } ?>
                                    <p>
                                        <input type = "<?= $item['input_type'] ?>" name="<?= $item['name/id'] ?>" id="<?= $item['name/id'] ?>" class = "inside-box form-control" value="">
                                    </p>
                                </div><?php
                            }else if($item['name/id'] == 'peran_akun'){ ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box">
                                <?= $item['input_text'] ?> <br>
                                <p>
                                    <select name="<?= $item['name/id'] ?>" class="selectpicker" id="<?= $item['name/id'] ?>" onchange="gantiNNN()">
                                        <option value="dosbing" style="display:<?= $peran_display[0] ?>;">Dosen Pembimbing</option>
                                        <option value="pemlap" style="display:<?= $peran_display[1] ?>;">Pembimbing Lapangan</option>
                                        <option value="mhs" style="display:<?= $peran_display[2] ?>;" selected>Mahasiswa</option>
                                    </select>
                                </p>
                                </div><?php
                            }else if($item['name/id'] == 'instansi_akun'){ ?>
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box">
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
                                <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box utkmhs">
                                <?= $item['input_text'] ?> <br>
                                <p>
                                    <select name="<?= $item['name/id'] ?>" class="selectpicker" id="<?= $item['name/id'] ?>"><?php
                                        if($item['name/id'] == 'dosbing_akun'){
                                            foreach($live_search['dosbing'] as $result){ ?>
                                                <option value="<?= $result['id_dosbing']?>" data-subtext = "<?= $result['nama_instansi'] ?>" ><?= $result['nama_dosbing']?></option><?php
                                            } ?><?php
                                        }else if($item['name/id'] == 'pemlap_akun'){
                                            foreach($live_search['pemlap'] as $result){ ?>
                                                <option value="<?= $result['id_pemlap']?>" data-subtext = "<?= $result['nama_instansi'] ?>" ><?= $result['nama_pemlap']?></option><?php
                                            } ?><?php
                                        } ?>
                                    </select>
                                </p>
                                </div><?php
                            }
                        }
                        $i++;
                    } 
                    ?>
                </div>
                <!-- checkbox lihat password --><?php
                if(isset($config['show_password'])){if($config['show_password']){ ?>
                    <div class="custom-control custom-checkbox" style='margin-top:1em;margin-left:1em;'>
                        <input type="checkbox" class="custom-control-input" id="lihat_pass">
                        <label class="custom-control-label" for="lihat_pass">Perlihatkan Kata Sandi</label>
                    </div><?php
                }} ?>
                <!-- buttons -->
                <div class="div-tombol"> <?php
                    foreach($button as $item){ ?><?php
                        if(!isset($item['button_action'])){ ?>
                            <button type = "submit" class = "btn <?= $item['button_type'] ?> tombol"><?= $item['button_text'] ?></button><?php
                        }else{ ?>
                            <a href = "<?= $item['button_action'] ?>" class = "btn <?= $item['button_type'] ?> tombol"><?= $item['button_text'] ?></a><?php    
                        }
                    } ?>
                </div><?php
if(isset($config['use_box'])){if($config['use_box']){ ?>
            </div>
        </form>
    </div><?php
}} ?>

<!-- loading bar -->
<div id = 'bg-for-loading'>
    <div id = 'lds-dual-ring'></div>
</div>
<script src = "<?= base_url() ?>/js/script.js"></script>
<script>
    <?php
    if(in_array("peran_akun",$required) && in_array("no_unik_akun",$required)){ ?>
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

    //js untuk memasukkan for_auth ke dalam array js;
    <?php
    if(isset($for_auth)){ ?>
        var for_auth = new Array(); <?php
        foreach($for_auth as $item){//karena for_auth strukturnya array 3 dimensi
            foreach($item as $item2){ ?>
                var arrDalam = new Array();<?php
                foreach($item2 as $item3){ // item3 hanya ada email dan no unik, akan di masukkan ke arrDalam ?>
                    arrDalam.push('<?= $item3 ?>');<?php
                } ?>
                for_auth.push(arrDalam);<?php
            }
        }
    } //disini suda campur aduk semua email dosbing email mhs dll, karena gapenting yang penting cuma apakah ada email atau no unik dobel ?> 
    
    //js untuk masukkan required ke arr js
    var required = new Array();
    <?php
    foreach($required as $item){ ?>
		required.push('<?= $item ?>');<?php
    }?>
    
    function final_verify(){
        <?php
        if($is_edit_form){ session()->get() ?>

            var edit_data = new Array();
            edit_data.push(<?= $_SESSION['loginData']['email'] ?>)
            edit_data.push(<?= $_SESSION['loginData']['no_unik'] ?>)
            


            var valid = true;
            required = verif_dobel_data_akun(for_auth,required);
            if( ! verif_typo_akun(required)){
                valid = false;
            }
 

            if(valid){
                $('#bg-for-loading').css('display','block');
                $('#lds-dual-ring').css('display','inline-block');
                return true;
            }else{
                return false;
            }
            
            <?php
        }else{ ?>
            var valid = true;
            required = verif_dobel_data_akun(for_auth,required);
            console.log(required);
            if( ! verif_typo_akun(required)){
                valid = false;
            }
        


            if(valid){
                $('#bg-for-loading').css('display','block');
                $('#lds-dual-ring').css('display','inline-block');
                return true;
            }else{
                alert("ehjhehe")
                return false;
            }
            
            <?php
        } ?>
    }
</script>