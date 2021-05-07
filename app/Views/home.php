<?= $this->extend('layout/main_constructor') ?>

<?= $this->section('content') ?>
<?php
session()->get();

echo view_cell('\App\Libraries\Cells::nav_'.$_SESSION['loginData']['db'],['selected' => ['home']]);


if($_SESSION['loginData']['db'] == "su" || $_SESSION['loginData']['db'] == "dosbing" || $_SESSION['loginData']['db'] == "pemlap"){
    

    $data_dalam_bimbingan = [];
    $data_selesai_bimbingan = [];
    
    if($data_db !== NULL){
        foreach($data_db as $item){
            $arr_dalam = [];
            $arr_dalam['id_mhs'] = $item['id_mhs'];
            $arr_dalam['nama_mhs'] = $item['nama_mhs'];
            $arr_dalam['no_unik_mhs'] = $item['no_unik_mhs'];
            $arr_dalam['nama_dosbing'] = $item['nama_dosbing'];
            $arr_dalam['nama_instansi'] = $item['nama_instansi'];
            $arr_dalam['nama_pemlap'] = $item['nama_pemlap'];
    
            //untuk menghitung lama magang
            if($item['time4']!="" && $item['time4']!=NULL){ 
                //untuk tanggal mulai
                $tanggalMulai = $item['time1'];
    
                //untuk menghitung lama magang dlm bulan 
                $awal = strtotime($item['time4']);
                if($item['time6'] != NULL){
                    $now = strtotime($item['time6']);
                }else{
                    $now = strtotime(date("Y-m-d G:i:s"));
                }
                $rentangBulan = floor(($now - $awal)/(30.4*24*60*60)); 
            }else{
                $tanggalMulai = 'Belum Memulai';
                $rentangBulan = "0";
            }
            
            $arr_dalam['tanggal_mulai'] = $tanggalMulai;
            $arr_dalam['lama_magang'] = $rentangBulan;
    
            if($item['time6'] != null && $item['time6'] != ''){
                $tanggalSelesai = $item['time6'];
                $arr_dalam['tanggal_selesai'] = $tanggalSelesai;
            }
    
            //sekarang ada 2 array data untuk 2 tabel
            if($item['time6'] != null && $item['time6'] != ''){
                array_push($data_selesai_bimbingan,$arr_dalam);
            }else{
                array_push($data_dalam_bimbingan,$arr_dalam);
            }
        }
    }
	

	//merender tabel mhs dlm bimbingan
	echo view_cell('\App\Libraries\Cells::data_table',
        [
            'config' => 
                [
                    'judul_tabel' => "Mahasiswa Dalam Bimbingan",
                    'id_tabel' => "tabel_dalam_bimbingan",
                    'default_display' => 'block'
                ],
            'arr_head' =>   
                [
                    ['Tanggal Mulai',FALSE],
                    ['Nama',TRUE],
                    ['NRP',TRUE],
                    ['Instansi',FALSE],
                    ['Dosen Pembimbing',FALSE],
                    ['Pembimbing Lapangan',FALSE],
                    ['Lama Magang (Bulan)',FALSE],
                ], 
            'head_clickable' => 'Detail',
            'arr_item' => 
                [
                    ['~tanggal_mulai',FALSE],
                    ['~nama_mhs',TRUE],
                    ['~no_unik_mhs',TRUE],
                    ['~nama_instansi',FALSE],
                    ['~nama_dosbing',FALSE],
                    ['~nama_pemlap',FALSE],
                    ['~lama_magang',FALSE],
                ],
            'arr_clickable' =>
                [
                    [
                        'jenis_icon' => 'description',
                        'toggle' => 'Detail',
                        'href' => '', 
                        'class' => 'detail',
                        'id' => '~nama_mhs',
                        'confirm_func' => NULL,
                        'confirm_msg' => NULL,
                        
                        'id_clicked' => '~id_mhs',
                        'db_clicked' => 'mhs'
                    ]
                ],
            'is_lama_magang' => TRUE,
            'kolom_lama_magang' => '~lama_magang',
            'data' => $data_dalam_bimbingan
        ]
    );

    //merender tabel mhs selesai bimbingan
    echo view_cell('\App\Libraries\Cells::data_table',
        [
            'config' => 
                [
                    'judul_tabel' => "Mahasiswa Selesai KP",
                    'id_tabel' => 'tabel_selesai_bimbingan',
                    'default_display' => 'block'
                ],
            'arr_head' =>   
                [
                    ['Tanggal Mulai',FALSE],
                    ['Tanggal Selesai',FALSE],
                    ['Nama',TRUE],
                    ['NRP',TRUE],
                    ['Instansi',FALSE],
                    ['Dosen Pembimbing',FALSE],
                    ['Pembimbing Lapangan',FALSE],
                    ['Lama Magang (Bulan)',FALSE],
                ], 
            'head_clickable' => 'Detail',
            'arr_item' => 
                [
                    ['~tanggal_mulai',FALSE],
                    ['~tanggal_selesai',FALSE],
                    ['~nama_mhs',TRUE],
                    ['~no_unik_mhs',TRUE],
                    ['~nama_instansi',FALSE],
                    ['~nama_dosbing',FALSE],
                    ['~nama_pemlap',FALSE],
                    ['~lama_magang',FALSE],
                ],
            'arr_clickable' =>
                [
                    [
                        'jenis_icon' => 'description',
                        'toggle' => 'Detail',
                        'href' => '', 
                        'class' => 'detail',
                        'id' => '~nama_mhs',
                        'confirm_func' => NULL,
                        'confirm_msg' => NULL,
                        
                        'id_clicked' => '~id_mhs',
                        'db_clicked' => 'mhs'
                    ]
                ],
            'is_lama_magang' => FALSE,
            'data' => $data_selesai_bimbingan
        ]
    );

}else{
    //nah ini untuk home mhs
    if($is_accepted){
        //kalo acc maka manggil cells apa, blm dibuat
    }else if($wait){ ?>
        <div class='container'>
        	<div class='box-info' style='font-size:15pt;'>
            	Mohon menunggu, pengajuan anda sedang ditinjau oleh TU dan Pembimbing Lapangan.
            </div>
        </div>
    <?php
        echo view_cell('\App\Libraries\Cells::riwayat_tppi',
            [
                'tppi_si_mhs' => $tppi_si_mhs
            ]
        );
    }else{
        //kalo blm dpt acc manggil cell form isian
        echo view_cell('\App\Libraries\Cells::form_tppi',
    		[
				'config' => ['form_title' => 'Ajukan Pembimbing dan Instansi', 'form_action' => base_url().'/TPPI/Form/auth_form_tppi'],
                'liveSearch' => $liveSearch,
                'info' => 'Sudah menemukan instansi / perusahaan yang mau menerima anda magang? Silahkan pilih data untuk meminta surat izin dari TU.',
                'button' =>
                	[
                        ['button_type' => 'btn-success', 'button_text' => 'Ajukan', 'button_id' => 'btn-ajukan']
                    ],
                'is_tppi_edit' => FALSE
            ]
    	);
        echo view_cell('\App\Libraries\Cells::riwayat_tppi',
        	[
				'tppi_si_mhs' => $tppi_si_mhs
            ]
        );
    }

}
?>

<?= $this->endSection(); ?>
