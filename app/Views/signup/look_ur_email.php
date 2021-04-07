<?= $this->extend("layout/main_constructor") ?>
<!-- nanti kalau ada yg logged akan ada if, kalau logged dan dilihat db nya apa -->
<!-- nanti akan meng generate cell sesuai db -->
<?= $this->section('content') ?>
<?= view_cell('\App\Libraries\Cells::look_ur_email') ?>
<?= $this->endSection() ?>
