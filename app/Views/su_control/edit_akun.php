<?= $this->extend('layout/main_constructor'); ?>


<?= $this->section('content'); ?>


<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['akun']]) ?>

<?php
if($edit_data['db'] == 'dosbing'){
	$peran_display = ['block','none','none'];
}else if($edit_data['db'] == 'pemlap'){
	$peran_display = ['none','block','none'];
}else if($edit_data['db'] == 'mhs'){
	$peran_display = ['none','none','block'];
}
echo view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Edit Akun','form_action' => base_url()."/Akun_control/Akun/auth_edit_akun",'show_password' => FALSE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => $peran_display,
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Edit'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_action' => base_url()."/Akun_control/Akun"]
        ],
        'live_search' => $liveSearch,
        'is_edit_form' => TRUE,
        'edit_data' => $edit_data
    ]
); 
?>

<?= $this->endSection(); ?>