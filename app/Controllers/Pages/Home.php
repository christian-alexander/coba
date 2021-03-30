<?php
namespace App\Controllers\Pages;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index(){
        session()->get(); //harus dipakai untuk manggil variabel session nya
        var_dump($_SESSION);
        //$tes = $_SESSION['loginData']['nama'];
        //echo ($tes);
    }

    public function tes($hehe){
        echo $hehe;
    }
}