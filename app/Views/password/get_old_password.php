<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>

<?php session()->get() ?>
<?= view_cell("\App\Libraries\Cells::nav_".$_SESSION['loginData']['db'],['selected' => ['profil']]);?>
<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Masukkan Password Lama','form_action' => base_url()."/Password_manager/Password_change/auth",'show_password' => TRUE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => [],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Lanjutkan', 'button_id' => 'btn-submit'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_id' => 'btn-cancel','button_action' => base_url()."/Pages/Home"]
        ],
        'live_search' => [],
        'for_auth' => [],
        'is_edit_form' => FALSE
    ]
); 
?>

<?= $this->endSection() ?>