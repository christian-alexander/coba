<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<?php
session()->get();
if(isset($_SESSION['loginData'])){
    $path = base_url()."/Password_manager/Password_change/save_new_password";
    $path_cancel = base_url()."/Pages/Home";

    echo view_cell("\App\Libraries\Cells::nav_".$_SESSION['loginData']['db'],['selected' => ['profil']]);
}else{
    $path = base_url()."/Password_manager/Password_recovery/save_new_password";
    $path_cancel = base_url();

    echo "<div style = 'margin-top:2em;margin-bottom:2em;'>";
}
?>


<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Ubah Password','form_action' => $path ,'show_password' => TRUE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => [],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Ubah', 'button_id' => 'btn-submit'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_id' => 'btn-cancel', 'button_action' => $path_cancel]
        ],
        'live_search' => [],
        'for_auth' => [],
        'is_edit_form' => FALSE
    ]
); 
?>

<?php
if(!isset($_SESSION['loginData'])){
    echo "</div>";
}
?>
<?= $this->endSection(); ?>