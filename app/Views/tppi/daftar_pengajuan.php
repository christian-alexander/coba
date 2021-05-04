<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['surat_izin']]) ?>

<?= 
view_cell('\App\Libraries\Cells::data_table',
    [
        'config' => 
            [
                'judul_tabel' => "Daftar Pengajuan",
                'id_tabel' => "tabel_pengajuan",
                'default_display' => 'block'
            ],
        'arr_head' => [
            ['Tanggal Pengajuan',FALSE],
            ['Nama',TRUE],
            ['NRP',TRUE],
            ['Dosen Pembimbing',FALSE],
            ['Calon Pembimbing Lapangan',FALSE],
            ['Calon Instansi',FALSE],
        ],
        'head_clickable' => 'Aksi',
        'arr_item' =>  [
            ['~timestamp_tppi',FALSE],
            ['~nama_mhs',TRUE],
            ['~no_unik_mhs',TRUE],
            ['~nama_dosbing',FALSE],
            ['~nama_pemlap_tppi',FALSE],
            ['~nama_instansi_tppi',FALSE]
        ],
        'arr_clickable' => 
        [
            [
                'jenis_icon' => 'description',
                'toggle' => 'Detail',
                'href' => base_url().'/TPPI/Data/detail_pengajuan', 
                'class' => 'detail_btn',
                'id' => '~id_tppi',
                'confirm_func' => NULL,
                'confirm_msg' => NULL,
                
                'id_clicked' => '~id_tppi',
                'db_clicked' => 'tppi'
            ]
        ],
        'is_lama_magang' => FALSE,
        'data' => $data_tppi
    ]);
?>
<?= $this->endSection() ?>