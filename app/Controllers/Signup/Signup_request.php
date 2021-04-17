<?php
namespace App\Controllers\Signup;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;

class Signup_request extends BaseController
{
    public function index(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            if($_SESSION['loginData']['db'] == "su"){
                $Get = new Get();
                $data = [];
                
                $joined = [
                    ['instansi','instansi.id_instansi = sg_mhs.id_instansi_sg_mhs'],
                    ['dosbing','dosbing.id_dosbing = sg_mhs.id_dosbing_sg_mhs']
                ];
                $joined_dosbing = [['instansi','instansi.id_instansi = sg_dosbing.id_instansi_sg_dosbing']];

                $data['data_db'][0] = $Get->get('sg_mhs',$joined,'sg_mhs.*,instansi.nama_instansi,dosbing.nama_dosbing');
                $data['data_db'][1] = $Get->get('sg_dosbing',$joined_dosbing,'sg_dosbing.*,instansi.nama_instansi');
                
                return view('signup/signup_request',$data);
            }else if($_SESSION['loginData']['db'] == "dosbing"){
                session()->get();
                $Get = new Get();
                
                $joined = [
                    ['instansi','instansi.id_instansi = sg_mhs.id_instansi_sg_mhs'],
                    ['dosbing','dosbing.id_dosbing = sg_mhs.id_dosbing_sg_mhs']
                ];
                $joined_dosbing = [['instansi','instansi.id_instansi = sg_dosbing.id_instansi_sg_dosbing']];

                $data['data_db'][0] = $Get->get('sg_mhs',$joined,'sg_mhs.*,instansi.nama_instansi,dosbing.nama_dosbing',['id_dosbing_sg_mhs' => $_SESSION['loginData']['id']]);
                $data['data_db'][1] = $Get->get('sg_dosbing',$joined_dosbing,'sg_dosbing.*,instansi.nama_instansi');
                
                return view('signup/signup_request',$data);
            
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();    
            }
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function terima_signup(){
        session()->get();

        $db = $_REQUEST['db'];
        $to_db = explode("_",$_REQUEST['db'])[1];
        $id = $_REQUEST['id'];
        $AddEditDelete = new AddEditDelete();
        $Get = new Get();

        $data_sg = $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE);
        $data['nama_'.$to_db]                                    = $data_sg['nama_'.$db];
        $data['no_unik_'.$to_db]                                 = $data_sg['no_unik_'.$db];
        $data['email_'.$to_db]                                   = $data_sg['email_'.$db];
        $data['no_wa_'.$to_db]                                   = $data_sg['no_wa_'.$db];
        $data['id_instansi_'.$to_db]                             = $data_sg['id_instansi_'.$db];
        $data['password_'.$to_db]                                = $data_sg['password_'.$db];
        $data['acc_by_'.$_SESSION['loginData']['db']]            = $_SESSION['loginData']['nama'];
        if($db == "sg_mhs"){
            $data['id_dosbing_'.$to_db] = $data_sg['id_dosbing_'.$db];
            $data['id_pemlap_'.$to_db] = NULL;
        }

        $utk_email['nama_calon'] = $data_sg['nama_'.$db];
        $utk_email['email_calon'] = $data_sg['email_'.$db];
        $utk_email['nama_admin'] = $_SESSION['loginData']['nama'];
        $this->email_notif($utk_email,'disetujui');
        
        $AddEditDelete->add($to_db,$data);
        $AddEditDelete->hapus($db,'id_'.$db,$id);


        $alert['path'] = 'Signup/Signup_request';
        $alert['message'] = "Sukses menerima permintaaan signup";
        
        return view("alertBox",$alert);
    
    }

    public function tolak_signup(){
        session()->get();
        $db = $_REQUEST['db'];
        $id = $_REQUEST['id'];
        $AddEditDelete = new AddEditDelete();
        $Get = new Get();

        $data_sg = $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE);
        $utk_email['nama_calon'] = $data_sg['nama_'.$db];
        $utk_email['email_calon'] = $data_sg['email_'.$db];
        $utk_email['nama_admin'] = $_SESSION['loginData']['nama'];
        $this->email_notif($utk_email,'ditolak');

        $AddEditDelete = new AddEditDelete();
        $AddEditDelete->hapus($db,'id_'.$db,$id);


        $alert['path'] = 'Signup/Signup_request';
        $alert['message'] = "Sukses menolak permintaaan signup";
        
        return view("alertBox",$alert);
    
    }

    private function email_notif($data,$keputusan){
		
        $pesan = 'Yth, <br>'.$data['nama_calon'].'<br><br>Permohonan akun anda untuk email '.$data['email_calon'].
        			' telah '.$keputusan.
                    ' oleh admin atas nama '.$data['nama_admin'].'.';

        if($keputusan == 'disetujui'){
            $salam_penutup = '<br><br>Sekarang anda bisa login ke '.base_url().' dengan email dan password anda yang telah terdaftar.';
        }else{
            $salam_penutup = '<br><br>Permohonan sign-up anda ditolak karena data yang anda masukkan tidak benar, mohon untuk melakukan sign-up ulang di '.base_url().' dengan data yang benar.';
        }

        $pesan.=$salam_penutup;

        $this->send_email("Pemberitahuan Sign Up",$pesan,NULL,$data['email_calon']);
    }

}