<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['surat_izin']]) ?>
<div class='container' style='margin-bottom:3em;'>
<?=
    view_cell('\App\Libraries\Cells::simple_table',
    [
        'judul_tabel' => 'Pengajuan Mahasiswa',
        'data_tabel' => 
            [
                ['Nama Mahasiswa',$edit_data['nama_mhs']],
                ['NRP',$edit_data['nrp']],
                ['Dosen Pembimbing',$edit_data['nama_dosbing']]
            ]
    ]); 
?>
</div>

<?= view_cell('\App\Libraries\Cells::form_tppi',
        [
            'config' => ['form_title' => 'Detail Pengajuan', 'form_action' => base_url().'/TPPI/Form/auth_form_tppi'],
            'liveSearch' => $liveSearch,
            'info' => 'Anda dapat mengedit data sebelum menyetujui. Ketika anda menekan setujui maka email akan otomatis terkirim ke calon pembimbing lapangan berdasarkan data ini.',
            'button' =>
                [
                    ['button_type' => 'btn-success', 'button_text' => 'Setujui', 'button_id' => 'btn-setuju'],
                    ['button_type' => 'btn-primary', 'button_text' => 'Simulasi Surat', 'button_id' => 'btn-simulasi', 'button_action' => ''],
                    ['button_type' => 'btn-danger', 'button_text' => 'Tolak', 'button_id' => 'btn-tolak' ,'button_action' => '']
                ],
            'is_tppi_edit' => TRUE,
            'edit_data' => $edit_data
        ]
    )
?>
<script>
	$('form').submit(function(e){
        if( ! confirm("Yakin setujui? setelah ini surat akan langsung dilayangkan ke email pembimbing lapangan.")){
            e.preventDefault();
            $('#bg-for-loading').css('display','none');
            $('#lds-dual-ring').css('display','none');
        }
    });
</script>
<?= $this->endSection() ?>