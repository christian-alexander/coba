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
            $this->buat_session('edit_data',$data['edit_data']); 
            return view('profil/edit_profil', $data);
        }
    }

    public function auth_edit_profil(){
        if($this->is_logged()){
            session()->get();

            $email_dobel = $this->auth_dobel_akun(TRUE)[0];
            $no_unik_dobel = $this->auth_dobel_akun(TRUE)[1];

            if( ! $email_dobel && ! $no_unik_dobel ){
                $this->save_edit_profil();

                //penghapusan sesssion info dobel dari yang sebelumnya
                if(isset($_SESSION['form_akun_not_valid'])){
                    session()->remove('form_akun_not_valid');
                }
                //penghapusan session data_form_akun
                $this->buat_session_form('data_form_akun',TRUE);
                
                $alert['path'] = 'Akun_control/Profil';
                $alert['message'] = "Sukses mengedit profil.";
                return view('alertBox',$alert);
            }else{
                if( $email_dobel !== FALSE &&  $no_unik_dobel !== FALSE){
                    $_SESSION['form_akun_not_valid'] = ['email_akun','no_unik_akun'];
                }else if( $email_dobel !== FALSE){
                    $_SESSION['form_akun_not_valid'] = ['email_akun'];
                }else{
                    $_SESSION['form_akun_not_valid'] = ['no_unik_akun'];
                }
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