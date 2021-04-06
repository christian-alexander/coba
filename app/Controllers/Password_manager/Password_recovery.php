<?php
namespace App\Controllers\Password_manager;
use App\Controllers\BaseController;
use App\Models\Get;

class Password_recovery extends BaseController
{
    public function index(){
        return view('password/get_email');
    }   

    public function auth(){
        $Get = new Get();
        if(isset($_REQUEST['email'])){
            $email = $_REQUEST['email'];
        }else{
            session()->get();
            $email = $_SESSION['email'];
        }

        $arrMhs = $Get->get('mhs',NULL,NULL,['email_mhs' => $email, 'status_mhs' => 'on']);
        $arrDosbing = $Get->get('dosbing',NULL,NULL,['email_dosbing' => $email, 'status_dosbing' => 'on']);
        $arrPemlap = $Get->get('pemlap',NULL,NULL,['email_pemlap' => $email, 'status_pemlap' => 'on']);
        
        $arrDatabase = array([$arrMhs,'email_mhs','mhs'],[$arrDosbing,'email_dosbing','dosbing'],[$arrPemlap,'email_pemlap','pemlap']);
        
        $dataCocok = $this->matching($email,$arrDatabase,TRUE,TRUE);

        if(!$dataCocok){
            $alert['message'] = "Email tidak terdaftar di sistem atau telah non-aktif";
            $alert['path'] = "Password_manager/Password_recovery";
            return $this->view('alertBox',$alert);
        }else{
            $captcha = $this->get_captcha(15);
            $pesan = 'Klik link berikut ini untuk mereset password anda<br>'.base_url().'/Password_manager/Reset/reset_password/'.$captcha;
            $this->send_email("Pemulihan Password",$pesan,NULL,$email);
            $this->session_verif_link($email,$captcha);
            return view('look_ur_email');
        } 
    }
}