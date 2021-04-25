<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<?php session()->get(); ?>


<?= view_cell('\App\Libraries\Cells::nav_'.$_SESSION['loginData']['db'],['selected' => ['profil']]) ?>


<?php
session()->get();
$db = $_SESSION['loginData']['db']; ?>
<div class='container'>
<div class='row'>
<?php
if($db == 'dosbing'){ ?>
	<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
	<?php
    echo view_cell('\App\Libraries\Cells::simple_table',
    	[
			'judul_tabel' => 'Data Dosen',
            'data_tabel' => 
            	[
                    ['Nama',$data_tabel['nama_dosbing']],
                    ['NIDN',$data_tabel['no_unik_dosbing']],
                    ['Email',$data_tabel['email_dosbing']],
                    ['No WhatsApp',$data_tabel['no_wa_dosbing']]
                ]
        ]); ?>
	</div>
<?php
}else if($db == 'pemlap'){ ?>
	<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
    <?php
    echo view_cell('\App\Libraries\Cells::simple_table',
    	[
			'judul_tabel' => 'Data Pembimbing',
            'data_tabel' => 
            	[
                    ['Nama',$data_tabel['nama_pemlap']],
                    ['NIP',$data_tabel['no_unik_pemlap']],
                    ['Email',$data_tabel['email_pemlap']],
                    ['No WhatsApp',$data_tabel['no_wa_pemlap']]
                ]
        ]); ?>
    </div>
<?php
}else{ ?>
	<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
    <?php
    echo view_cell('\App\Libraries\Cells::simple_table',
    [
        'judul_tabel' => 'Data Mahasiswa',
        'data_tabel' => 
            [
                ['Nama',$data_tabel['nama_mhs']],
                ['NRP',$data_tabel['no_unik_mhs']],
                ['Email',$data_tabel['email_mhs']],
                ['No WhatsApp',$data_tabel['no_wa_mhs']]
            ]
    ]); ?>
    </div>
    <?php
    if($data_tabel['id_dosbing_mhs'] !== NULL){ ?>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
        <?php
        echo view_cell('\App\Libraries\Cells::simple_table',
    	[
			'judul_tabel' => 'Data Dosen',
            'data_tabel' => 
            	[
                    ['Nama',$data_tabel['nama_dosbing']],
                    ['NIDN',$data_tabel['no_unik_dosbing']],
                    ['Email',$data_tabel['email_dosbing']],
                    ['No WhatsApp',$data_tabel['no_wa_dosbing']]
                ]
        ]);?>
    </div>
    <?php
    }

    if($data_tabel['id_pemlap_mhs'] !== NULL){ ?>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
        <?php
        echo view_cell('\App\Libraries\Cells::simple_table',
    	[
			'judul_tabel' => 'Data Pembimbing',
            'data_tabel' => 
            	[
                    ['Nama',$data_tabel['nama_pemlap']],
                    ['NIP',$data_tabel['no_unik_pemlap']],
                    ['Email',$data_tabel['email_pemlap']],
                    ['No WhatsApp',$data_tabel['no_wa_pemlap']]
                ]
        ]); ?>
        </div>
    <?php
    }
}


if($data_tabel['id_instansi_'.$db] !== NULL){ ?>
	<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
    <?php
    echo view_cell('\App\Libraries\Cells::simple_table',
    [
        'judul_tabel' => 'Data Instansi',
        'data_tabel' => 
            [
                ['Nama',$data_tabel['nama_instansi']],
                ['Alamat',$data_tabel['alamat_instansi']],
                ['No Telepon',$data_tabel['no_telepon_instansi']],
                ['No Fax',$data_tabel['no_fax_instansi']],
                ['Email',$data_tabel['email_instansi']]
            ]
    ]); ?>
<?php
}

?>
</div>
</div>
<?= $this->endSection() ?>