<?= $this->extend('layout/main_constructor') ?>


<?= $this->section('content') ?>

<?php
session()->get();

echo view_cell('\App\Libraries\Cells::nav_'.$_SESSION['loginData']['db'],['selected' => ['home']]);

//membuat array data, disini sg secara general jadi jgn lupa untuk mengubah lagi ke sg msg2 di controller, ketika akan get datanya lewat $_REQUEST
$data = [];

if($data_db[0] != NULL){
    foreach($data_db[0] as $item){
        $arr_dalam = [];
        $arr_dalam['db'] = 'sg_mhs';
        $arr_dalam['peran'] = 'Mahasiswa';
        $arr_dalam['id_'] = $item['id_sg_mhs'];
        $arr_dalam['nama_'] = $item['nama_sg_mhs'];
        $arr_dalam['email_'] = $item['email_sg_mhs'];
        $arr_dalam['no_unik_'] = $item['no_unik_sg_mhs'];
        $arr_dalam['password_'] = $item['password_sg_mhs'];
        $arr_dalam['no_wa_'] = $item['no_wa_sg_mhs'];
        $arr_dalam['nama_instansi'] = $item['nama_instansi'];
        $arr_dalam['nama_dosbing'] = $item['nama_dosbing'];
        $arr_dalam['timestamp_'] = $item['timestamp_sg_mhs'];

        array_push($data,$arr_dalam);
    }
}

if($data_db[1] != NULL){
    foreach($data_db[1] as $item){
        $arr_dalam = [];
        $arr_dalam['db'] = 'sg_dosbing';
        $arr_dalam['peran'] = 'Dosen Pembimbing';
        $arr_dalam['id_'] = $item['id_sg_dosbing'];
        $arr_dalam['nama_'] = $item['nama_sg_dosbing'];
        $arr_dalam['email_'] = $item['email_sg_dosbing'];
        $arr_dalam['no_unik_'] = $item['no_unik_sg_dosbing'];
        $arr_dalam['password_'] = $item['password_sg_dosbing'];
        $arr_dalam['no_wa_'] = $item['no_wa_sg_dosbing'];
        $arr_dalam['nama_instansi'] = $item['nama_instansi'];
        $arr_dalam['nama_dosbing'] = "Tidak Ada";
        $arr_dalam['timestamp_'] = $item['timestamp_sg_mhs'];
        
        array_push($data,$arr_dalam);
    }
}


echo view_cell('\App\Libraries\Cells::data_table',
[
    'config' => 
        [
            'judul_tabel' => "Permintaan Sign Up",
            'id_tabel' => "tabel_signup_request",
            'default_display' => 'block'
        ],
    'arr_head' =>   
        [
            ['Tanggal Signup',FALSE],
            ['Nama',TRUE],
            ['NRP / NIDN',FALSE],
            ['Peran',TRUE],
            ['No WhatsApp',FALSE],
            ['Email',FALSE],
            ['Instansi',FALSE],
            ['Dosen Pembimbing',FALSE],
        ], 
    'head_clickable' => 'Aksi',
    'arr_item' => 
        [
            ['~timestamp_',FALSE],
            ['~nama_',TRUE],
            ['~no_unik_',FALSE],
            ['~peran',TRUE],
            ['~no_wa_',FALSE],
            ['~email_',FALSE],
            ['~nama_instansi',FALSE],
            ['~nama_dosbing',FALSE],
        ],
    'arr_clickable' =>
        [
            [
                'jenis_icon' => 'done',
                'toggle' => 'Terima',
                'href' => '', 
                'class' => 'terima',
                'id' => '~nama_',
                'confirm_func' => 'terima',
                'confirm_msg' => 'Yakin terima permintaan signup -id ?',
                
                'id_clicked' => '~id_',
                'db_clicked' => '~db'
            ],
            [
                'jenis_icon' => 'block',
                'toggle' => 'Tolak',
                'href' => '', 
                'class' => 'tolak',
                'id' => '~nama_',
                'confirm_func' => 'tolak',
                'confirm_msg' => 'Yakin tolak permintaan signup -id ?',
                
                'id_clicked' => '~id_',
                'db_clicked' => '~db'
            ]
        ],
    'is_lama_magang' => FALSE,
    'kolom_lama_magang' => NULL,
    'data' => $data
]
);



?>


<?= $this->endSection() ?>