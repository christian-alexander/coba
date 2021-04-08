<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<div style = "margin-top:2em;margin-bottom:2em;">
<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Ubah Password','form_action' => base_url()."/Password_manager/Password_recovery/save_new_password",'show_password' => TRUE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => [],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Ubah'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_action' => base_url()]
        ],
        'live_search' => [],
        'for_auth' => [],
        'is_edit_form' => FALSE
    ]
); 
?>
</div>

<?= $this->endSection(); ?>