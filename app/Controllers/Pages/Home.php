<?php
namespace App\Controllers\Pages;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            return view('pages/home');
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
    }
}