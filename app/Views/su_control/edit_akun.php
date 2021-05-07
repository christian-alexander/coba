<?= $this->extend('layout/main_constructor'); ?>


<?= $this->section('content'); ?>


<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['akun']]) ?>

<?php
echo view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => 'Edit Akun','form_action' => base_url()."/Akun_control/Akun/auth_edit_akun",'show_password' => FALSE,'use_box' => TRUE],
        'required' => $required,
        'peran_display' => ['block','block','block'],
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => 'Edit', 'button_id' => 'btn-edit'],
            ['button_type' => 'btn-danger', 'button_text' => 'Cancel', 'button_id' => 'btn-cancel' ,'button_action' => base_url()."/Akun_control/Akun"]
        ],
        'live_search' => $liveSearch,
        'is_edit_form' => TRUE,
        'edit_data' => $edit_data
    ]
); 
?>

<script>
	// utk tiap option dosbing dan pemlap ada id, jadi in case ada pergantian peran
    // dari dosbing/pemlap ke mhs maka otomatis option dosbing pemlap yg akan berganti peran
    // ini akan di hide, sngt vital dan penting utk menghindari kekacauan sistem
	$('#peran_akun').change(function(){
		alert('Mengganti peran akun dapat menyebabkan mahasiswa yang menjadikan akun ini sebagai dosen pembimbing / pembimbing lapangannya akan kehilangan dosen / pembimbing mereka (di set menjadi tidak ada)')
    	<?php
        if($edit_data['db'] == 'dosbing'){ ?>
			$('#option_dosbing_<?= $edit_data['id'] ?>').css('display','none');
        <?php
        } ?>

		<?php
        if($edit_data['db'] == 'pemlap'){ ?>
			$('#option_pemlap_<?= $edit_data['id'] ?>').css('display','none');
        <?php
        } ?>
    });


</script>
<?= $this->endSection(); ?>