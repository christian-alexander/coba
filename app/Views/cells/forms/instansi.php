<!-- fully customised template, dont change anything bisa kacau balau nanti -->

<?php
if(isset($config['use_box'])){if($config['use_box']){ ?>    
    <div class = "box">
        <div class = 'box-title'>
            <b><?= $config['form_title'] ?></b>
        </div>			
            
        <form method = "POST" action = "<?= $config['form_action'] ?>" onsubmit ="return final_verify_instansi();">
            <div class="container" style="padding-left:2em;"><?php
}} ?>
                <div class = "row"><?php
                    $i = 0; //untuk display per div nya
                    foreach(FORM_INSTANSI_NAMING as $item){ 
                        if(in_array($item['name/id'],$required[0])){ ?>
                            <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 input-box" style="display:<?= $required[1][$i] ?>;"> 
                                <?= $item['input_text'] ?> <a id="warning_<?= $item['name/id'] ?>" style="color:red;"></a>
                                <p>
                                    <input type = "<?= $item['input_type'] ?>" name="<?= $item['name/id'] ?>" id="<?= $item['name/id'] ?>" class = "inside-box form-control form-control-instansi" value="" placeholder="<?= $item['placeholder'] ?>">
                                </p>
                            </div>
                            <?php
                            $i++;
                        }           
                    } 
                    ?>
                </div>
                <!-- buttons -->
                <div class="div-tombol"> <?php
                    foreach($button as $item){ ?><?php
                        if(!isset($item['button_action'])){ ?>
                            <button type = "submit" class = "btn <?= $item['button_type'] ?> tombol" id='<?= $item['button_id'] ?>'><?= $item['button_text'] ?></button><?php
                        }else{ ?>
                            <a href = "<?= $item['button_action'] ?>" class = "btn <?= $item['button_type'] ?> tombol" id='<?= $item['button_id'] ?>'><?= $item['button_text'] ?></a><?php    
                        }
                    } ?>
                </div><?php
if(isset($config['use_box'])){if($config['use_box']){ ?>
            </div>
        </form>
    </div><?php
}} ?>
<!-- <button onclick = "final_verify_instansi()">djkaja</button> -->
<!-- loading bar -->
<div id = 'bg-for-loading'>
    <div id = 'lds-dual-ring'></div>
</div>
<script src = "<?= base_url() ?>/js/script.js"></script>
<script>
    //jquery bila ada dobel (tak valid) email_instansi or no_telepon_instansi or no_fax_instansi dalam kasus dari controller auth balik sini lagi
    <?php
    session()->get();
    if(isset($_SESSION['form_instansi_not_valid'])){ session()->get();?>
        $(document).ready(function(){ <?php
            // mengisikan data sebelumnya
            foreach($_SESSION['data_form_instansi'] as $key => $item){  ?>
                $("#<?= $key ?>").val("<?= $item ?>");
            <?php
            } ?>
            //memberi class betul pada semua form-control
            
            $('.form-control-instansi').addClass('correct');

            <?php
            //menyalahkan email atau no telepon atau no fax
            if( in_array('email_instansi',$_SESSION['form_instansi_not_valid']) ){ ?>
                $('#warning_email_instansi').html(' *Sudah ada, pakai lainnya');
                $('#email_instansi').removeClass('correct');
                $('#email_instnsi').addClass('wrong'); 
                <?php        
            } 

            if( in_array('no_telepon_instansi',$_SESSION['form_instansi_not_valid']) ){ ?>
                $('#warning_no_telepon_instansi').html(' *Sudah ada, pakai lainnya');
                $('#no_telepon_instansi').removeClass('correct');
                $('#no_telepon_instansi').addClass('wrong'); 
                <?php
            } 

            if( in_array('no_fax_instansi',$_SESSION['form_instansi_not_valid']) ){ ?>
                $('#warning_no_fax_instansi').html(' *Sudah ada, pakai lainnya');
                $('#no_fax_instansi').removeClass('correct');
                $('#no_fax_instansi').addClass('wrong'); 
                <?php
            } ?>
        }); <?php
    }else{ ?>

        //jquery bila edit form
        <?php
        if($is_edit_form){ ?>
            $(document).ready(function(){
                if($('#nama_instansi').length > 0){
                    $('#nama_instansi').val("<?= $edit_data['nama_instansi'] ?>");
                }
                if($('#no_telepon_instansi').length > 0){
                    $('#no_telepon_instansi').val("<?= $edit_data['no_telepon_instansi'] ?>");
                }
                if($('#email_instansi').length > 0){
                    $('#email_instansi').val("<?= $edit_data['email_instansi'] ?>");
                }
                if($('#no_fax_instansi').length > 0){
                    $('#no_fax_instansi').val("<?= $edit_data['no_fax_instansi'] ?>");
                }
                if($('#alamat_instansi').length > 0){
                    $('#alamat_instansi').val("<?= $edit_data['alamat_instansi'] ?>");
                }
            });    <?php
        } 
    }?>


    //jquery untuk hilangkan class bila wrong
    $(document).ready(function(){
        $("#nama_instansi").keyup(function(){
            $("#nama_instansi").removeClass('wrong');
            $("#nama_instansi").removeClass('correct');
        });
        $("#no_telepon_instansi").keyup(function(){
            $("#no_telepon_instansi").removeClass('wrong');
            $("#no_telepon_instansi").removeClass('correct');
        });
        $("#email_instansi").keyup(function(){
            $("#email_instansi").removeClass('wrong');
            $("#email_instansi").removeClass('correct');
        });
        $("#no_fax_instansi").keyup(function(){
            $("#no_fax_instansi").removeClass('wrong');
            $("#no_fax_instansi").removeClass('correct');
        });
        $("#alamat_instansi").keyup(function(){
            $("#alamat_instansi").removeClass('wrong');
            $("#alamat_instansi").removeClass('correct');
        });
    });

    //js untuk masukkan required ke arr js
    var required_instansi = new Array();
    <?php
    foreach($required[0] as $item){ ?>
		required_instansi.push('<?= $item ?>');<?php
    }?>

    function final_verify_instansi(){
        if(verif_typo_instansi(required_instansi)){
            $('#bg-for-loading').css('display','block');
            $('#lds-dual-ring').css('display','inline-block');
            return true;
        }else{
            return false;
        }
    } 
</script>
