<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['instansi']]) ?>

<?php
for($i = 1 ; $i <= 2 ; $i++){
    if     ($i == 1) { $tabel = $instansi_on  ;}
    else if($i == 2) { $tabel = $instansi_off ;}

    if($i % 2 == 1){
        $status = 'Aktif';
        $btn = "delete";
        $btn_msg = "Hapus";
        $href = base_url()."/Akun_control/Instansi/delete_restore_instansi/delete";
    }else{
        $status = 'Non Aktif';
        $btn = "restore_from_trash";
        $btn_msg = "Restore";
        $href = base_url()."/Akun_control/Instansi/delete_restore_instansi/restore";
    }

    $class_btn = $btn.'_instansi';
    $confirm_func = $btn.'_action_instansi';

    $confirm_msg = "Yakin $btn_msg -id ?" ;

    echo view_cell('\App\Libraries\Cells::data_table',
    [
        'config' => 
            [
                'judul_tabel' => "Instansi ".$status,
                'id_tabel' => "Instansi ".$status,
                'default_display' => 'block'
            ],
        'arr_head' => [
            ['Tanggal Bergabung',FALSE],
            ['Diterima Oleh',FALSE],
            ['Nama',TRUE],
            ['Alamat',TRUE],
            ['No Telepon',FALSE],
            ['No Fax',FALSE],
            ['Email',FALSE],
        ],
        'head_clickable' => 'Aksi',
        'arr_item' =>  [
            ['~timestamp_instansi',FALSE],
            ['~acc_by_instansi',FALSE],
            ['~nama_instansi',TRUE],
            ['~alamat_instansi',TRUE],
            ['~no_telepon_instansi',FALSE],
            ['~no_fax_instansi',FALSE],
            ['~email_instansi',FALSE]
        ],
        'arr_clickable' =>
            [
                [
                    'jenis_icon' => 'edit',
                    'toggle' => 'Edit',
                    'href' => base_url()."/Akun_control/Instansi/edit_instansi", 
                    'class' => 'edit',
                    'id' => NULL,
                    'confirm_func' => NULL,
                    'confirm_msg' => NULL,
                    
                    'id_clicked' => '~id_instansi',
                    'db_clicked' => 'instansi'
                ],
                [
                    'jenis_icon' => $btn,
                    'toggle' => $btn_msg,
                    'href' => $href, 
                    'class' => $class_btn,
                    'id' => '~nama_instansi',
                    'confirm_func' => $confirm_func,
                    'confirm_msg' => $confirm_msg,
                    
                    'id_clicked' => '~id_instansi',
                    'db_clicked' => 'instansi'
                ],
            ],
        'is_lama_magang' => FALSE,
        'data' => $tabel
    ]);
}

?>
<?= $this->endSection() ?>