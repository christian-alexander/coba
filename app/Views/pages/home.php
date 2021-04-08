<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?php
session()->get();
if($_SESSION['loginData']['db'] == "su"){
    echo view_cell('\App\Libraries\Cells::nav_su');
}else if($_SESSION['loginData']['db'] == "dosbing"){
    echo view_cell('\App\Libraries\Cells::nav_dosbing');
}else if($_SESSION['loginData']['db'] == "pemlap"){
    echo view_cell('\App\Libraries\Cells::nav_pemlap');
}else if($_SESSION['loginData']['db'] == "mhs"){
    echo view_cell('\App\Libraries\Cells::nav_mhs');
}

?>

<?= $this->endSection(); ?>
