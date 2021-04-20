<?php
namespace App\Controllers\Signup;
use App\Controllers\BaseController;
use App\Models\LiveSearch;
use App\Models\AddEditDelete;


class Signup extends BaseController
{
    private $required = [
        ['nama_akun','no_unik_akun','email_akun','password_akun','konfirmasi_password_akun','no_wa_akun','peran_akun','id_dosbing_akun'],
        ['block','block','block','block','block','block','block','block']
    ];

    public function index(){
        $liveSearh = new LiveSearch();

        $data['liveSearch'] = ['dosbing' => $liveSearh->get_dosbing()];  
        $data['required'] = $this->required;  
        return view('signup/signup', $data);
    }

    public function auth_signup(){
        $this->session_form_akun();
        if( $this -> auth_form_akun() ){
            $this->captcha_signup();

            //penghapusan sesssion
            session()->remove('form_akun_not_valid');
            
            return view('signup/look_ur_email');
        }else{
            return redirect()->to(base_url()."/Signup/Signup");
        }
    }

    private function captcha_signup(){
        $email = $_SESSION['data_form_akun']['email_akun'];
        $captcha = $this->get_captcha(150);
        $pesan = 'Klik link berikut ini untuk verifikasi email anda<br><br>Link berlaku selama 5 menit.<br>'.base_url().'/Signup/Signup/save_signup/'.$captcha;
        $this->send_email("Verifikasi Email",$pesan,NULL,$email);
        $this->session_verif_link($email,$captcha);
    }

    public function save_signup($captcha){
        session()->get();
        if($captcha == $_SESSION['captcha'] && time()-$_SESSION['captcha_start'] < 360){

            //panggil model AddEditDelete
            $AddEditDelete = new AddEditDelete();
            
            foreach ($_SESSION['data_form_akun'] as $key => $item){
                $field = explode("_akun",$key)[0];
                if($field != 'konfirmasi_password' && $field != 'peran'){
                    $peran = $_SESSION['data_akun']['peran_akun'];
                    $data[$field.'_sg_'.$peran] = $item;
                }
            }
            $AddEditDelete -> add('sg_'.$peran,$data);
            
            // destroy session
            $this->session_form_akun(TRUE);
            $alert['message'] = "Sukses Mengajukan Permintaan Sign Up. Harap Menghubungi TU atau Dosen Pembimbing Anda Untuk Meminta Persetujuan.";
            $alert['path'] = "";
            return view('alertBox',$alert);

            
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }           
    }
}