<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<div style = "margin-top:2em;margin-bottom:2em;">
<?= 
view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Sign Up','form_action' => base_url()."/Signup/Signup/save_signup",'show_password' => TRUE,'use_box' => TRUE],
        'required' => ['nama_akun','no_unik_akun','email_akun','password_akun','konfirmasi_password_akun','no_wa_akun','peran_akun','dosbing_akun'],
        'display' => ['block','block','block','block','block','block'],
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