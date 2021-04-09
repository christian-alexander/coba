<?php
namespace App\Controllers\Signup;
use App\Controllers\BaseController;
use App\Models\LiveSearch;
use App\Models\AddEditDelete;


class Signup extends BaseController
{
    private $required = [
        ['nama_akun','no_unik_akun','email_akun','password_akun','konfirmasi_password_akun','no_wa_akun','peran_akun','dosbing_akun'],
        ['block','block','block','block','block','block','block','block']
    ];

    public function index(){
        $liveSearh = new LiveSearch();
        
        $data['liveSearch'] = ['dosbing' => $liveSearh->get_dosbing()];
        $data['for_auth'] = $this->akun_for_auth();    
        $data['required'] = $this->required;  
        return view('signup/signup', $data);
    }

    public function captcha_signup(){
        $session = session();
        $ses_data = [
            'nama_akun' => $_REQUEST['nama_akun'],
            'no_unik_akun' => $_REQUEST['no_unik_akun'],
            'email_akun' => $_REQUEST['email_akun'],
            'password_akun' => password_hash($_REQUEST['password_akun'], PASSWORD_DEFAULT),
            'no_wa_akun' => $_REQUEST['no_wa_akun'],
            'peran_akun' => $_REQUEST['peran_akun'],
            'dosbing_akun' => $_REQUEST['dosbing_akun'],
        ];
        $session->set('signup_data',$ses_data);

        $email = $_REQUEST['email_akun'];
        $captcha = $this->get_captcha(150);
        $pesan = 'Klik link berikut ini untuk verifikasi email anda<br><br>'.base_url().'/Signup/Signup/save_signup/'.$captcha."<br><br>Link berlaku selama 60 detik.";
        $this->send_email("Verifikasi Email",$pesan,NULL,$email);
        $this->session_verif_link($email,$captcha);
        return view('signup/look_ur_email');
    }

    public function save_signup($captcha){
        session()->get();
        if($captcha == $_SESSION['captcha'] && time()-$_SESSION['captcha_start'] < 60){

            //panggil model AddEditDelete
            $AddEditDelete = new AddEditDelete();
            
            if($_SESSION['signup_data']['peran_akun'] == "dosbing"){
                $data = [
                    'nama_sg_dosbing' => $_SESSION['signup_data']['nama_akun'],
                    'no_unik_sg_dosbing' => $_SESSION['signup_data']['no_unik_akun'],
                    'email_sg_dosbing' => $_SESSION['signup_data']['email_akun'],
                    'password_sg_dosbing' => $_SESSION['signup_data']['password_akun'],
                    'no_wa_sg_dosbing' => $_SESSION['signup_data']['no_wa_akun'],
                    'id_instansi_sg_dosbing' => 0
                ];
                $AddEditDelete->add('sg_dosbing',$data);
            }else{
                $data = [
                    'nama_sg_mhs' => $_SESSION['signup_data']['nama_akun'],
                    'no_unik_sg_mhs' => $_SESSION['signup_data']['no_unik_akun'],
                    'email_sg_mhs' => $_SESSION['signup_data']['email_akun'],
                    'password_sg_mhs' => $_SESSION['signup_data']['password_akun'],
                    'no_wa_sg_mhs' => $_SESSION['signup_data']['no_wa_akun'],
                    'id_dosbing_sg_mhs' => $_SESSION['signup_data']['dosbing_akun'],
                    'id_pemlap_sg_mhs' => NULL,
                    'id_instansi_sg_mhs' => 0
                ];
                $AddEditDelete->add('sg_mhs',$data);
            }

            session()->remove('signup_data');
            $alert['message'] = "Sukses Mengajukan Permintaan Sign Up. Harap Menghubungi TU atau Dosen Pembimbing Anda Untuk Meminta Persetujuan.";
            $alert['path'] = "";
            return view('alertBox',$alert);

            
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }           
    }
}