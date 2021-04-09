<?php
    session()->get();
?>

<div style = "margin-bottom:5em;" >
    <!-- Navigation -->
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
                        <a class="nav-link" href="<?= base_url() ?>/Pages/Home">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item" id="signup_request">
                        <a class="nav-link" href="<?= base_url() ?>/#">SignUp Request</a>
                    </li>
                    <li class="nav-item" id="laporan">
                        <a class="nav-link" href="#">Laporan</a>
                    </li>
                    <li class="nav-item dropdown dropdown-nav" id="profil">
                        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profil</a>
                        <div class="dropdown-menu dropdown-menu-nav">
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/Pages/Profil">Lihat Profil</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/#">Edit Profil</a>
                            <a class="dropdown-item dropdown-item-nav" href="<?= base_url()?>/Password_manager/Password_change">Ubah Password</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/Login/logout">Log Out</a>
					</li>       
                </ul>
            </div>
        </div>
    </nav>
</div>

<script>
    $('#<?= $selected[0] ?>').addClass('active');
</script>