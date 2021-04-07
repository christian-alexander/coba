<?php
namespace App\Controllers\Password_manager;
use App\Controllers\BaseController;

class Reset extends BaseController
{
    public function reset_password($captcha){
        session()->get();
        if($captcha == $_SESSION['captcha'] && time()-$_SESSION['captcha_start'] < 60){
            return view("password/reset");
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}