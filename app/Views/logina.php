<?php

session()->get();

$_SESSION['he'] = [ '1' => 'hoho', '2' => 'hehe' ];
session()->markAsFlashdata('he');

if(isset($_SESSION['he'])){
	echo $_SESSION['he']['1'];
	echo $_SESSION['he']['2'];
	
}


