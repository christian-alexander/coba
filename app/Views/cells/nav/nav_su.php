<?php
    session()->get();
?>

<div style = "margin-bottom:5em;" >
    <!-- Navigation -->
    <!-- tambahkan navbar-expand-lg utk expand -->
    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#" id='nama_user'>
                <?php
                if(strlen($_SESSION['loginData']['nama']) <= 35){
                    echo $_SESSION['loginData']['nama'];
                }else{
                    $nama_user = substr($_SESSION['loginData']['nama'],0,35).'...';
                    echo $nama_user;
                }
                
                ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" id="home">
                        <a class="nav-link" href="<?= base_url() ?>/Home">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item" id="signup_request">
                        <a class="nav-link" href="<?= base_url() ?>/Signup/Signup_request">SignUp Request</a>
                    </li>
                    <li class="nav-item dropdown dropdown-nav" id="surat_izin">
                        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Surat Izin</a>
                        <div class="dropdown-menu dropdown-menu-nav">
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/#">Permohonan</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/#">Ubah Template</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/#">Riwayat</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-nav" id="instansi">
                        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Instansi</a>
                        <div class="dropdown-menu dropdown-menu-nav">
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/#">Daftar Instansi</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/#">Tambahkan Instansi</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-nav" id="akun">
                        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akun</a>
                        <div class="dropdown-menu dropdown-menu-nav">
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/Akun_control/Akun">Daftar Akun</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/Akun_control/Akun/tambahkan_akun">Tambahkan Akun</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/Password_manager/Password_change">Ubah Password</a>
                        </div>
                    </li>
                    <li class="nav-item">
                    	<a class="nav-link" href="<?= base_url()?>/Login/logout">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<script>
    $('#<?= $selected[0] ?>').addClass('active');
</script>