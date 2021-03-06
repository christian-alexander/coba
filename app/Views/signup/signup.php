<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<div style = "margin-top:2em;margin-bottom:2em;">
<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Sign Up','form_action' => base_url()."/Signup/Signup/auth_signup",'show_password' => TRUE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => ['block','none','block'],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Sign Up', 'button_id' => 'btn-sg'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_id' => 'btn-cancel','button_action' => base_url()]
        ],
        'live_search' => $liveSearch,
        'is_edit_form' => FALSE
    ]
); 
?>
</div>

<?= $this->endSection(); ?>