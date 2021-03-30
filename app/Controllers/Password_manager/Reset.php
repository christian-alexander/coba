<?php
namespace App\Controllers\Password_manager;
use App\Controllers\BaseController;

class Reset extends BaseController
{
    public function reset_password($captcha){
        session()->get();
        if($captcha == $_SESSION['captcha']){
            return view("password/reset");
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}