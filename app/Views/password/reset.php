<?= $this->extend("layout/main_constructor") ?>
<!-- nanti kalau ada yg logged akan ada if, kalau logged dan dilihat db nya apa -->
<!-- nanti akan meng generate cell sesuai db -->
<?= $this->section('content') ?>


<!-- THINGS TO DO -->
<!-- HARUSNYA INI PAKE AKUN_NAMING, YANG BELUM DIBUAT -->
<!-- MAO TIDUR CAPEK LAPER -->
    <div id="body-login" style="position:fixed;width:100%;height:100%;">
        <div class="container" id='box-login'>
            <div id='box-dalam-login'>
                <div class = teks-login>
                    <b><h3>Ubah Kata Sandi</h3></b>
                </div>		
                <div>
                    <?= LOGIN_NAMING['password'][2] ?> Baru
                    <p>
                        <input type = "<?= LOGIN_NAMING['password'][0] ?>" value ="<?= LOGIN_NAMING['password'][3] ?>" 
                        class = "inside-box-login form-control"
                        id = "<?= LOGIN_NAMING['password'][0] ?>"
                        name = "<?= LOGIN_NAMING['password'][0] ?>"
                        onfocus="if(this.value == '<?= LOGIN_NAMING['password'][3] ?>'){this.value = '';}"
                        onblur="if (this.value == '') {this.value = '<?= LOGIN_NAMING['password'][3] ?>';}">
                    </p>
                </div>
                <div>
                    Konfirmasi Password
                    <p>
                        <input type = "password" value ="<?= LOGIN_NAMING['password'][3] ?>" 
                        class = "inside-box-login form-control"
                        id = "<?= LOGIN_NAMING['password'][0] ?>"
                        name = "<?= LOGIN_NAMING['password'][0] ?>"
                        onfocus="if(this.value == '<?= LOGIN_NAMING['password'][3] ?>'){this.value = '';}"
                        onblur="if (this.value == '') {this.value = '<?= LOGIN_NAMING['password'][3] ?>';}">
                    </p>
                </div>
            </div>
        </div>
    </div>


    <script src="<?= base_url() ?>/js/validator.js"></script>

<?= $this->endSection() ?>
