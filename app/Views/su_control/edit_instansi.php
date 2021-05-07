<?= $this->extend('layout/main_constructor'); ?>


<?= $this->section('content'); ?>


<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['instansi']]) ?>

<?= 
view_cell('\App\Libraries\Cells::form_instansi',
    [
        'config' => ['form_title' => 'Edit Instansi','form_action' => base_url()."/Akun_control/Instansi/auth_edit_instansi",'use_box' => TRUE],
        'required' => $required,
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Edit', 'button_id' => 'btn-edit'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_id' => 'btn-cancel','button_action' => base_url()."/Akun_control/Instansi"]
        ],
        'is_edit_form' => TRUE,
        'edit_data' => $edit_data
    ]
); 
?>

<?= $this->endSection(); ?>