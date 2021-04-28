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
        $email_dobel = $this->auth_dobel_akun()[0];
        $no_unik_dobel = $this->auth_dobel_akun()[1];

        if( ! $email_dobel && ! $no_unik_dobel ){
            $this->captcha_signup();

            //penghapusan sesssion info dobel dari yang sebelumnya
            if(isset($_SESSION['form_akun_not_valid'])){
                session()->remove('form_akun_not_valid');
            }
            //penghapusan session data_form_akun
            $this->buat_session_form('data_form_akun',TRUE);
            
            return view('signup/look_ur_email');
        }else{
            if( $email_dobel !== FALSE &&  $no_unik_dobel !== FALSE){
                $_SESSION['form_akun_not_valid'] = ['email_akun','no_unik_akun'];
            }else if( $email_dobel !== FALSE){
                $_SESSION['form_akun_not_valid'] = ['email_akun'];
            }else{
                $_SESSION['form_akun_not_valid'] = ['no_unik_akun'];
            }
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
                    $peran = $_SESSION['data_form_akun']['peran_akun'];
                    $data[$field.'_sg_'.$peran] = $item;
                }
            }
            $AddEditDelete -> add('sg_'.$peran,$data);
            
            // destroy session data form akun
            $this->buat_session_form('data_form_akun',TRUE);
            $this->session_verif_link();
            $alert['message'] = "Sukses Mengajukan Permintaan Sign Up. Harap Menghubungi TU atau Dosen Pembimbing Anda Untuk Meminta Persetujuan.";
            $alert['path'] = "";
            return view('alertBox',$alert);

            
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }           
    }
}