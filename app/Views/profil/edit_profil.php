<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<?php
session()->get();
?>

<?= view_cell('\App\Libraries\Cells::nav_'.$_SESSION['loginData']['db'],['selected' => ['profil']]) ?>

<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Edit Profil','form_action' => base_url()."/Akun_control/Profil/auth_edit_profil",'show_password' => FALSE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => ['block','block','block'], //karena ada peran namun none
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Edit', 'button_id' => 'btn-edit'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_id' => 'btn-cancel','button_action' => base_url()."/Home"]
        ],
        'live_search' => [],
        'is_edit_form' => TRUE,
        'edit_data' => $edit_data
    ]
); 
?>
<?= $this->endSection(); ?>