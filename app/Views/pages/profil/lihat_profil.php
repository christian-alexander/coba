<?= $this->extend('layout/main_constructor'); ?>

<?= $this->section('content'); ?>

<?php session()->get(); ?>


<?= view_cell('\App\Libraries\Cells::nav_'.$_SESSION['loginData']['db'],['selected' => ['profil']]) ?>

<?php
$array_table = [];
foreach($tables as $item){
    if($item['db'] != 'instansi'){
        if($item['db'] == 'dosbing'){
            $no_unik = "NIDN";
        }else if($item['db'] == 'pemlap'){
            $no_unik = "NIP";
        }else if($item['db'] == 'mhs'){
            $no_unik = "NRP";
        }

        $arrData = [
            ['Nama', $item['data']['nama_'.$item['db']]],
            [$no_unik, $item['data']['no_unik_'.$item['db']]],
            ['WhatsApp', $item['data']['no_wa_'.$item['db']]],
            ['Email', $item['data']['email_'.$item['db']]]
        ];
    }else{
        $arrData = [
            ['Nama Instansi', $item['data']['nama_instansi']],
            ['Email', $item['data']['email_instansi']],
            ['No Telepon', $item['data']['no_telepon_instansi']],
            ['No Fax', $item['data']['no_fax_instansi']],
            ['Alamat', $item['data']['alamat_instansi']]
        ];
    }

    $arrDalam = [
            $item['nama_tabel'],
            $arrData
    ];
    array_push($array_table,$arrDalam);
}
?>

<?= 
    view_cell('\App\Libraries\Cells::simple_table',
        [
            'tables' => $array_table
        ]
    )
?>
<?= $this->endSection() ?>