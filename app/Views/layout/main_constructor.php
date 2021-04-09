<!DOCTYPE html>
<head>
    <title><?= TITLE ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <!-- komponen bootstrap -->
	<link rel="stylesheet" href="<?= base_url() ?>/bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<!-- utk datalivesearch -->
    <link rel="stylesheet" href="<?= base_url() ?>/bootstrap-select-1.13.18/css/bootstrap-select.min.css">
    <!-- utk dataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>/DataTables-1.10.24/css/jquery.dataTables.min.css">
    <!-- utk icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- css lokal -->
	<link rel="stylesheet" href="<?= base_url() ?>/css/style.css">
</head>
<body>
	<!-- jquery -->
	<script src="<?= base_url() ?>/jquery-3.6.0/jquery-3.6.0.min.js"></script>
	
    
    
    <?= $this->renderSection('content') ?>
    
    
    
    <!-- bootstrap bundle suda dengan popper -->
	<script src="<?= base_url() ?>/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
    <!-- untuk selectpicker dan data-live-search -->
    <script src ="<?= base_url() ?>/bootstrap-select-1.13.18/js/bootstrap-select.min.js"></script>
    <!-- untuk data tables -->
    <script src="<?= base_url() ?>/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function(){
        $('table.table').dataTable();
    });
    </script>
</body>