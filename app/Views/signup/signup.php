<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<div style = "margin-top:2em;margin-bottom:2em;">
<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Sign Up','form_action' => base_url()."/Signup/Signup/captcha_signup",'show_password' => TRUE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => ['block','none','block'],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Sign Up'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_action' => base_url()]
        ],
        'live_search' => ['dosbing' => $dosbing],
        'for_auth' => $for_auth,
        'is_edit_form' => FALSE
    ]
); 
?>
</div>

<?= $this->endSection(); ?>