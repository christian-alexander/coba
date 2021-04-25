<?php
namespace App\Controllers\Akun_control;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;
use App\Models\LiveSearch;

class Profil extends BaseController
{
    private $required = [
        ['nama_akun','no_unik_akun','email_akun','no_wa_akun','peran_akun'],
        ['block','block','block','block','none']
    ];

    private function is_logged(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            return TRUE;
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function index(){
        if($this->is_logged()){
            $Get = new Get();
            session()->get();

            $db = $_SESSION['loginData']['db'];
            $id = $_SESSION['loginData']['id'];
			if($db == 'mhs'){
                $join = [
                    ['instansi','mhs.id_instansi_mhs = instansi.id_instansi','left'],
                    ['dosbing','mhs.id_dosbing_mhs = dosbing.id_dosbing','left'],
                    ['pemlap','mhs.id_pemlap_mhs = pemlap.id_pemlap','left']
                ];
				$data['data_tabel'] = $Get->get('mhs',$join,NULL,['id_mhs' => $id],TRUE);
            }else{
                $fk = $db.'.id_instansi_'.$db;
                $join = [['instansi',"$fk = instansi.id_instansi",'left']];
                $data['data_tabel'] = $Get->get($db,$join,NULL,['id_'.$db => $id],TRUE);
            }
            return view('profil/lihat_profil',$data);
        }
    }


    public function edit_profil(){
        if($this->is_logged()){
            $Get = new Get();
            session()->get();
    
            $data['required'] = $this->required;  

            $db = $_SESSION['loginData']['db'];
            $id = $_SESSION['loginData']['id'];
            $data['edit_data'] = $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE); 
            $data['edit_data']['db'] = $db;
            return view('profil/edit_profil', $data);
        }
    }

    public function auth_edit_profil(){
        if($this->is_logged()){
            session()->get();
            $email = $_SESSION['loginData']['email'];
            $no_unik = $_SESSION['loginData']['no_unik'];

            $this->session_form_akun();
            if( $this -> auth_form_akun('both',$email,$no_unik) ){
                $this->save_edit_profil();
                
                //penghapusan session
                session()->remove('form_akun_not_valid');
                $this->session_form_akun(TRUE);
                
                $alert['message'] = "Berhasil mengedit profil";
                $alert['path'] = "Akun_control/Profil";
                return view('alertBox',$alert);
            }else{
                return redirect()->to(base_url()."/Akun_control/Profil/edit_profil");
            }
        }
    }

    public function save_edit_profil(){
        if($this->is_logged()){
            session()->get();
            $AddEditDelete = new AddEditDelete();
            $db = $_SESSION['loginData']['db'];
            $id = $_SESSION['loginData']['id'];

            $data = [
                'nama_'.$db => $_REQUEST['nama_akun'],
                'no_unik_'.$db => $_REQUEST['no_unik_akun'],
                'email_'.$db => $_REQUEST['email_akun'],
                'no_wa_'.$db => $_REQUEST['no_wa_akun']
            ];

            $AddEditDelete->edit($db,$data,"id_".$db,$id);

            //session tentu harus ikut berubah juga, karena verif dobel data bergantung dari session
            $_SESSION['loginData']['nama'] = $_REQUEST['nama_akun'];
            $_SESSION['loginData']['no_unik'] = $_REQUEST['no_unik_akun'];
            $_SESSION['loginData']['email'] = $_REQUEST['email_akun'];
        }
    }
}