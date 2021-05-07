<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>

<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['surat_izin']]) ?>


<div class = "box">
    <div class = 'box-title'>
        <b>Ubah Template</b>
    </div>  
    <div class="box-info">
        Template yang diizinkan adalah file ber-ekstensi ".docx". Gunakan keyword dibawah ini untuk menambahkan keterangan dinamis pada surat ataupun isi email.               
    </div>
    <div class="container">
        <div class = "row">
            <div class = "col-lg-6 col-md-6">
                <?=
                view_cell('\App\Libraries\Cells::simple_table',
                [
                    'judul_tabel' => '',
                    'data_tabel' => 
                        [
                            ['${nama_mhs}','nama mahasiswa'],
                            ['${nrp_mhs}','nrp mahasiswa'],
                            ['${email_mhs}','email mahasiswa'],
                            ['${no_wa_mhs}','no whatsapp mahasiswa']
                        ]
                ]);
                ?>
            </div>
            <div class = "col-lg-6 col-md-6">
                <?=
                view_cell('\App\Libraries\Cells::simple_table',
                [
                    'judul_tabel' => '',
                    'data_tabel' => 
                        [
                            ['${nama_cp}','nama pembimbing'],
                            ['${nip_cp}','nip pembimbing'],
                            ['${email_cp}','email pembimbing'],
                            ['${no_wa_cp}','no whatsapp pembimbing']
                        ]
                ]);
                ?>
            </div>
            <div class = "col-lg-6 col-md-6">
                <?=
                view_cell('\App\Libraries\Cells::simple_table',
                [
                    'judul_tabel' => '',
                    'data_tabel' => 
                        [
                            ['${nama_ci}','nama instansi'],
                            ['${alamat_ci}','alamat instansi'],
                            ['${email_ci}','email instansi'],
                            ['${no_telepon_ci}','no telepon instansi'],
                            ['${no_fax_ci}','no fax instansi']
                        ]
                ]);
                ?>
            </div>
            <div class = "col-lg-6 col-md-6">
                <?=
                view_cell('\App\Libraries\Cells::simple_table',
                [
                    'judul_tabel' => '',
                    'data_tabel' => 
                        [
                            ['${tanggal}','tanggal surat dibuat'],
                            ['${url_kp}','url sistem kp']
                        ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <form method = "post" id="form_template_izin" action = "<?= base_url() ?>/TPPI/Template/save_new_template" onsubmit='return final_verify()' enctype="multipart/form-data">
        <div class="container" style="text-align:center;">
            <div style="margin-top:2em;margin-bottom:2em;text-align:center;">
                <h5>Edit Subjek Email</h5>
            </div>
            <input type = 'text' name = 'subjek_email' id='subjek_email' class='form-control' value="<?= $template['subjek_email_template_izin'] ?>" style="width:90%;">
            <div style="margin-top:2em;margin-bottom:2em;text-align:center;">
                <h5>Edit Isi Email</h5>
            </div>
            <textarea name="isi_email" id="isi_email" form="form_template_izin" class='ckeditor'><?= $template['isi_email_template_izin'] ?></textarea>
            <!-- disini mustinya cell upload, blm dibuat -->
        </div>
        <div class='div-tombol'>
        	<a class='btn btn-primary tombol' href='#'>Download Template Lama</a>
        	<button class='btn btn-success tombol'>Ganti Template</button>
        </div>
    </form>
</div>

<!-- loading bar -->
<div id = 'bg-for-loading'>
    <div id = 'lds-dual-ring'></div>
</div>

<script>
	function fileValidation(){
        //sementara, selama cell form blm dibuat
        return true;
    }

	
    function validasiInput(){
        var valid = true;
		var regInput = /^(.{1,})$/;

        var subjek_valid = regInput.test($('#subjek_email'));
        var isi_valid = regInput.test($('#isi_email'));

        if( ! subjek_valid){
            alert('Anda belum memasukkan subjek email');
            valid = false;
        }

        if( ! isi_valid){
            alert('Anda belum memasukkan isi email');
			valid = false;
        }

    	return valid;
    }

	function final_verify(){
        if(validasiInput() & fileValidation()){
            // reveal loading
            document.getElementById('bg-for-loading').style.display = "block";
            document.getElementById('lds-dual-ring').style.display = "inline-block";                                  
            return true;
        }else{
            return false;
        }
    }
</script>


<?= $this->endSection() ?>