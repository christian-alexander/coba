<?php

//ini untuk code download an, on progress
//nanti hanya download pdf saja
?>

<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['surat_izin']]) ?>

<?= 
view_cell('\App\Libraries\Cells::data_table',
    [
        'config' => 
            [
                'judul_tabel' => "Riwayat Pengajuan",
                'id_tabel' => "tabel_riwayat",
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
            ['~time_pengajuan_tppi',FALSE],
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
                'href' => NULL, 
                'class' => 'detail_btn',
                'id' => '~id_tppi',
                'confirm_func' => NULL,
                'confirm_msg' => NULL,
                
                'id_clicked' => '~id_tppi',
                'db_clicked' => 'tppi'
            ],
            [
                'jenis_icon' => 'download',
                'toggle' => 'Download PDF',
                'href' => base_url()."/TPPI/Data/daftar_pengajuan/riwayat", 
                'class' => 'download_btn',
                'id' => NULL,
                'confirm_func' => NULL,
                'confirm_msg' => NULL,
                
                'id_clicked' => '~id_tppi',
                'db_clicked' => 'tppi'
            ]
        ],
        'is_lama_magang' => FALSE,
        'data' => $data_tppi
    ]);


foreach($data_tppi as $item){ ?>
    <div id='detail_<?= $item['id_tppi'] ?>' class='div-tabel detail' style='display:none;'>
        <div class='row'>
            <div class='col-md-6'>
                <?=
                view_cell('\App\Libraries\Cells::simple_table',
                [
                    'judul_tabel' => 'Calon Pembimbing',
                    'data_tabel' => 
                        [
                            ['Nama',$item['nama_pemlap_tppi']],
                            ['NIP',$item['no_unik_pemlap_tppi']],
                            ['Email',$item['email_pemlap_tppi']],
                            ['No WhatsApp',$item['no_wa_pemlap_tppi']],
                            ['Status',$item['acc_pemlap_tppi']],
                            ['Tanggal Disetujui / Ditolak',$item['time_acc_kampus_tppi']]
                        ]
                ]);
                ?>
            </div>
            <div class='col-md-6'>
                <?=
                view_cell('\App\Libraries\Cells::simple_table',
                [
                    'judul_tabel' => 'Calon Instansi',
                    'data_tabel' => 
                        [
                            ['Nama',$item['nama_instansi_tppi']],
                            ['Alamat',$item['alamat_instansi_tppi']],
                            ['No Telepon',$item['no_telepon_instansi_tppi']],
                            ['No Fax',$item['no_fax_instansi_tppi']],
                            ['Email',$item['email_instansi_tppi']],
                            ['Status',$item['acc_pemlap_tppi']],
                            ['Tanggal Disetujui / Ditolak',$item['time_acc_pemlap_tppi']]
                        ]
                ]); 
                ?>
            </div>
        </div>
    </div>                       
<?php
} ?>


<script>
    $('.detail_btn').click(function(){
        $('.detail').css('display','none');
        $('#detail_'+this.id).css('display','block');
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#detail_"+this.id).offset().top
        }, 1000);
    });
</script>

<?= $this->endSection() ?>