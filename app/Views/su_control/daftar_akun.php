<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?= view_cell('App\Libraries\Cells::nav_su',['selected' => ['akun']]) ?>

<div class = "container">
    Tampilkan Tabel :
    <select id = "seleksi" onchange="show()">
        <option value = "semua">Semua</option>
        <option value = "Dosen Pembimbing ">Dosen Pembimbing</option>
        <option value = "Pembimbing Lapangan ">Pembimbing Lapangan</option>
        <option value = "Mahasiswa ">Mahasiswa</option>
    </select>
</div>

<?php

    for($i = 1 ; $i <= 6 ; $i++){
        if($i % 2 == 1){
            $status = 'Aktif';
            $btn = "delete";
            $btn_msg = "Hapus";
            $href = base_url()."/Akun_control/Akun/delete_akun";
        }else{
            $status = 'Non-Aktif';
            $btn = 'restore_from_trash';
            $btn_msg = "Restore";
            $href = base_url()."/Akun_control/Akun/restore_akun";
        }

    	if($i == 1 || $i ==2){
            $class_btn = $btn."_dosbing";
            $confirm_func = $btn."_action_dosbing";
        }else if($i == 3 || $i == 4){
            $class_btn = $btn."_pemlap";
            $confirm_func = $btn."_action_pemlap";
        }else if($i == 5 || $i == 6){
            $class_btn = $btn."_mhs";
            $confirm_func = $btn."_action_mhs";
        }
        $confirm_msg = "Yakin $btn_msg -id ?" ;

        if($i == 1) { $tabel = $dosbing_on ;}
        if($i == 2) { $tabel = $dosbing_off;}
        if($i == 3) { $tabel = $pemlap_on  ;}
        if($i == 4) { $tabel = $pemlap_off ;}
        if($i == 5) { $tabel = $mhs_on     ;}
        if($i == 6) { $tabel = $mhs_off    ;}
    
        if($i <= 2){
            $identitas = 'dosbing';
            $judul_tabel = "Dosen Pembimbing ";
            $no_unik = 'NIDN';
            $peran = 'Dosen Pembimbing';
        }else if($i == 3 || $i ==4){
            $identitas = 'pemlap';
            $judul_tabel = "Pembimbing Lapangan ";
            $no_unik = 'NIP';
            $peran = 'Pembimbing Lapangan';
        }else{
            $identitas = 'mhs';
            $judul_tabel = "Mahasiswa ";
            $no_unik = 'NRP' ;
            $peran = 'Mahasiswa';
        } 


        //arr head dan item bila ternyata waktunya mhs
        if($i >= 5){
            $arr_head = [
                ['Tanggal Bergabung',FALSE],
                ['Diterima Oleh',FALSE],
                ['Nama',TRUE],
                [$no_unik,TRUE],
                ['No WhatsApp',FALSE],
                ['Email',FALSE],
                ['Instansi',FALSE],
                ['Dosen Pembimbing',FALSE],
                ['Pembimbing Lapangan',FALSE]
            ];

            $arr_item = [
                ['~timestamp_'.$identitas,FALSE],
                ['~acc_by_'.$identitas,FALSE],
                ['~nama_'.$identitas,TRUE],
                ['~no_unik_'.$identitas,TRUE],
                ['~no_wa_'.$identitas,FALSE],
                ['~email_'.$identitas,FALSE],
                ['~nama_instansi',FALSE],
                ['~nama_dosbing',FALSE],
                ['~nama_pemlap',FALSE],
            ];
        //arr head dan item bila ternyata waktunya dosbing pemlap
        }else{
            $arr_head = [
                ['Tanggal Bergabung',FALSE],
                ['Diterima Oleh',FALSE],
                ['Nama',TRUE],
                [$no_unik,TRUE],
                ['No WhatsApp',FALSE],
                ['Email',FALSE],
                ['Instansi',FALSE],
            ];

            $arr_item = [
                ['~timestamp_'.$identitas,FALSE],
                ['~acc_by_'.$identitas,FALSE],
                ['~nama_'.$identitas,TRUE],
                ['~no_unik_'.$identitas,TRUE],
                ['~no_wa_'.$identitas,FALSE],
                ['~email_'.$identitas,FALSE],
                ['~nama_instansi',FALSE]
            ];
        }

        echo view_cell('\App\Libraries\Cells::data_table',
        [
            'config' => 
                [
                    'judul_tabel' => $judul_tabel.$status,
                    'id_tabel' => $judul_tabel.$status,
                    'default_display' => 'block'
                ],
            'arr_head' => $arr_head,
            'head_clickable' => 'Aksi',
            'arr_item' => $arr_item,
            'arr_clickable' =>
                [
                    [
                        'jenis_icon' => 'edit',
                        'toggle' => 'Edit',
                        'href' => base_url()."/Akun_control/Akun/edit_akun", 
                        'class' => 'edit',
                        'id' => NULL,
                        'confirm_func' => NULL,
                        'confirm_msg' => NULL,
                        
                        'id_clicked' => '~id_'.$identitas,
                        'db_clicked' => $identitas
                    ],
                    [
                        'jenis_icon' => $btn,
                        'toggle' => $btn_msg,
                        'href' => $href, 
                        'class' => $class_btn,
                        'id' => '~nama_'.$identitas,
                        'confirm_func' => $confirm_func,
                        'confirm_msg' => $confirm_msg,
                        
                        'id_clicked' => '~id_'.$identitas,
                        'db_clicked' => $identitas
                    ],
                ],
            'is_lama_magang' => FALSE,
            'data' => $tabel
        ]);
    }
?>

<script>
    function show(){
        var identitas = document.getElementById('seleksi').value;
        var deselect = document.getElementsByClassName('div-tabel');
        
        if(identitas == 'semua'){
            var terpilih = document.getElementsByClassName('div-tabel');
            for(var i = 0 ; i < terpilih.length ; i++){
                terpilih[i].style.display = 'block';
            }
        }else{
            for(var i = 0 ; i < deselect.length ; i++){
                deselect[i].style.display = 'none';
            }
            var terpilih_on = document.getElementById(identitas + "Aktif");
            var terpilih_off = document.getElementById(identitas + "Non-Aktif");
            terpilih_on.style.display = 'block';
            terpilih_off.style.display = 'block';
            
            
        }
    }
</script>

<?= $this->endSection() ?>