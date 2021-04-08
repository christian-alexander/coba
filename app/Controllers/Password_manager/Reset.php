<?php
namespace App\Controllers\Password_manager;
use App\Controllers\BaseController;

class Reset extends BaseController
{
    private $required = [
        ['password_akun','konfirmasi_password_akun'],
        ['block','block']
    ];


    public function reset_password($captcha){
        session()->get();
        if($captcha == $_SESSION['captcha'] && time()-$_SESSION['captcha_start'] < 60){
            $data['required'] = $this->required;
            return view("password/reset",$data);
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}