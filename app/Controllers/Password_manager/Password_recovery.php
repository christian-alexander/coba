<?php
namespace App\Controllers\Password_manager;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;

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
            return view('alertBox',$alert);
        }else{
            $captcha = $this->get_captcha(150);
            $pesan = 'Klik link berikut ini untuk mereset password anda<br><br>Link berlaku selama 60 detik.<br><br>'.base_url().'/Password_manager/Reset/reset_password/'.$captcha;
            //$this->send_email("Pemulihan Password",$pesan,NULL,$email);
            $ses_data = [
                'db' => $dataCocok['db'],
                'email' => $dataCocok['email'] 
            ];
            session()->set('recovery_data',$ses_data);
            $this->session_verif_link($email,$captcha);
            return view('password/look_ur_email');
        } 
    }

    public function save_new_password(){
        session()->get();
        $AddEditDelete = new AddEditDelete();
        $data['password_'.$_SESSION['recovery_data']['db']] = password_hash($_REQUEST['password_akun'],PASSWORD_DEFAULT);
        $email = $_SESSION['recovery_data']['email'];
        $db = $_SESSION['recovery_data']['db'];
        

        $AddEditDelete->edit($db,$data,"email_$db",$email);

        $alert['message'] = "Berhasil mengubah Password";
        $alert['path'] = "";
        return view('alertBox',$alert);
    }
}