<?= $this->extend('layout/main_constructor'); ?>


<?= $this->section('content'); ?>


<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['akun']]) ?>

<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Tambahkan Akun','form_action' => base_url()."/Akun_control/Akun/auth_tambahkan_akun",'show_password' => FALSE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => ['block','block','block'],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Tambahkan'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_action' => base_url()."/Akun_control/Akun"]
        ],
        'live_search' => $liveSearch,
        'is_edit_form' => FALSE,
    ]
); 
?>

<?= $this->endSection(); ?>