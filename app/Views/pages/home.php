<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?php
session()->get();
if($_SESSION['loginData']['db'] == "su"){
    echo view_cell('\App\Libraries\Cells::nav_su',['selected' => ['home']]);
}else if($_SESSION['loginData']['db'] == "dosbing"){
    echo view_cell('\App\Libraries\Cells::nav_dosbing',['selected' => ['home']]);
}else if($_SESSION['loginData']['db'] == "pemlap"){
    echo view_cell('\App\Libraries\Cells::nav_pemlap',['selected' => ['home']]);
}else if($_SESSION['loginData']['db'] == "mhs"){
    echo view_cell('\App\Libraries\Cells::nav_mhs',['selected' => ['home']]);
}

?>

<?= $this->endSection(); ?>
