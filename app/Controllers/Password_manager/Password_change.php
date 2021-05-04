<?php
namespace App\Controllers\Password_manager;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;

class Password_change extends BaseController
{
    private $required_old = [
        ['password_akun'],
        ['block']
    ];
    private $required_new = [
        ['password_akun','konfirmasi_password_akun'],
        ['block','block']
    ];

    public function index(){
        if($this->filter_user(['su','dosbing','pemlap','mhs'])){
            $data['required'] = $this->required_old;
            return view('password/get_old_password',$data);
        }
    }   

    public function auth(){
        if($this->filter_user(['su','dosbing','pemlap','mhs'])){
            $Get = new Get();
            session()->get();

            $db = $_SESSION['loginData']['db']; 
            $id = $_SESSION['loginData']['id'];

            $inputted_password = $_REQUEST['password_akun'];
            $real_password = $Get->get($db,NULL,"password_".$db,["id_".$db => $id],TRUE);
            $real_password = $real_password['password_'.$db];
            if(password_verify($inputted_password,$real_password)){
                $data['required'] = $this->required_new;
                return view('password/reset',$data);
            }else{
                $alert['message'] = "Password yang anda masukkan salah";
                $alert['path'] = "Password_manager/Password_change";
                return view("alertBox",$alert);
            }
        }
    }

    private function save_new_password(){
        session()->get();
        $AddEditDelete = new AddEditDelete();
        $data['password_'.$_SESSION['loginData']['db']] = password_hash($_REQUEST['password_akun'],PASSWORD_DEFAULT);
        $email = $_SESSION['loginData']['email'];
        $db = $_SESSION['loginData']['db'];
        

        $AddEditDelete->edit($db,$data,"email_$db",$email);

        $alert['message'] = "Berhasil mengubah Password";
        $alert['path'] = "Pages/Home";
        return view('alertBox',$alert);
    }
}