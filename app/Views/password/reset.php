<?= $this->extend("layout/main_constructor") ?>
<!-- nanti kalau ada yg logged akan ada if, kalau logged dan dilihat db nya apa -->
<!-- nanti akan meng generate cell sesuai db -->
<?= $this->section('content') ?>
<form method = "POST" action="<?= base_url()?>/Password_manager/Password_recovery/save_new_password" onsubmit = "return final_verify()">
    <div style="padding-top:2em;padding-bottom:2em;">
        <div class="container box">
            <div id='box-dalam-login'>
                <div class = teks-login>
                    <b><h3>Ubah Password</h3></b>
                </div>		
                <div>
                    <?= FORM_AKUN_NAMING['password_akun']['input_text'] ?> Baru <a id="warning_<?= FORM_AKUN_NAMING['password_akun']['name/id'] ?>" style="color:red;"> </a>
                    <p>
                        <input type = "<?= FORM_AKUN_NAMING['password_akun']['input_type'] ?>" value ="" 
                        class = "inside-box-login form-control"
                        id = "<?= FORM_AKUN_NAMING['password_akun']['name/id'] ?>"
                        name = "<?= FORM_AKUN_NAMING['password_akun']['name/id'] ?>"
                        style = "text-align : center;">
                    </p>
                </div>
                <div>
                    <?= FORM_AKUN_NAMING['konfirmasi_password_akun']['input_text'] ?> Baru <a id="warning_<?= FORM_AKUN_NAMING['konfirmasi_password_akun']['name/id'] ?>" style="color:red;"> </a>
                    <p>
                        <input type = "<?= FORM_AKUN_NAMING['konfirmasi_password_akun']['input_type'] ?>" value ="" 
                        class = "inside-box-login form-control"
                        id = "<?= FORM_AKUN_NAMING['konfirmasi_password_akun']['name/id'] ?>"
                        name = "<?= FORM_AKUN_NAMING['konfirmasi_password_akun']['name/id'] ?>"
                        style = "text-align : center;">
                    </p>
                </div>
                <!-- checkbox lihat password -->
                <div class="custom-control custom-checkbox" onchange="lihat_pass()">
                    <input type="checkbox" class="custom-control-input" id="lihat_pass">
                    <label class="custom-control-label" for="lihat_pass">Perlihatkan Password</label>
                </div>

                <!-- tombol -->
                <div class = "div-tombol">
                    <button type = "submit" class = "btn btn-success tombol">Ubah Password</button>
                    <a href = "<?= base_url() ?>" class = "btn btn-danger tombol">Cancel</a>
                </div>
            </div>
        </div> 
    </div>
</form>

<script src="<?= base_url() ?>/js/script.js"></script>
<script>
    function final_verify(){
        if(verif_typo_akun(['password_akun','konfirmasi_password_akun'])){
            return true;
        }else{
            return false;
        }
    }
</script>
<?= $this->endSection() ?>
