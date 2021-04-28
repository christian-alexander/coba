<?php
namespace App\Controllers\Akun_control;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;

class Instansi extends BaseController
{
    private $required = [
        ['nama_instansi','no_telepon_instansi','no_fax_instansi','email_instansi','alamat_instansi'],
        ['block','block','block','block','block']
    ];

    private function verif_su(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            if($_SESSION['loginData']['db'] == 'su'){
                return TRUE;
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            	return FALSE;
        	}
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            return FALSE;
        }
    }

    private function change_data_name(){
        //dari form nama data adalah nama_akun,email_akun, dst
        //maka dari itu ketika proses add atau edit ke db harus diubah
        //ke nama_instansi atau email_instansi, itulah gunanya method ini
        foreach($_REQUEST as $key => $item){
            $data[explode('akun',$key)[0].'instansi'] = $item;
        }
        return $data;
    }

    public function index(){
        if($this->verif_su()){
            $Get = new Get();
            $data['instansi_on'] = $Get->get('instansi',NULL,NULL,['status_instansi' => 'on']);  
            $data['instansi_off'] = $Get->get('instansi',NULL,NULL,['status_instansi' => 'off']);

            return view('su_control/daftar_instansi.php',$data);
        }
    }


    public function delete_instansi(){
        if($this->verif_su()){
            $id = $_REQUEST['id'];
            
            $AddEditDelete = new AddEditDelete();
    
            $AddEditDelete->edit('instansi',['status_instansi' => 'off'],'id_instansi',$id);
    
            $alert['path'] = 'Akun_control/Instansi';
            $alert['message'] = 'Berhasil menonaktifkan instansi';
    
            return view('alertBox',$alert);
        }
    }

    public function restore_instansi(){
        if($this->verif_su()){
            $id = $_REQUEST['id'];
            
            $AddEditDelete = new AddEditDelete();
            
            $AddEditDelete->edit('instansi',['status_instansi' => 'on'],'id_instansi',$id);

            $alert['path'] = 'Akun_control/Instansi';
            $alert['message'] = 'Berhasil mengaktifkan instansi';

            return view('alertBox',$alert);
        }
    }

    public function tambahkan_instansi(){
        if($this->verif_su()){
            $data['required'] = $this->required;  
            return view('su_control/tambahkan_instansi', $data);
        }
    }

    public function auth_tambahkan_instansi(){
        if($this->verif_su()){
            $email_dobel = $this->auth_dobel_instansi()[0];
            $no_telepon_dobel = $this->auth_dobel_instansi()[1];
            $no_fax_dobel = $this->auth_dobel_instansi()[2];

            if( ! $email_dobel && ! $no_telepon_dobel && ! $no_fax_dobel){
                $this->save_tambahkan_instansi();

                //penghapusan sesssion info dobel dari yang sebelumnya
                if(isset($_SESSION['form_instansi_not_valid'])){
                    session()->remove('form_instansi_not_valid');
                }
                //penghapusan session data_form_instansi
                $this->buat_session_form('data_form_instansi',TRUE);
                
                $alert['path'] = 'Akun_control/Instansi';
                $alert['message'] = "Sukses menambahkan instansi.";
                return view('alertBox',$alert);
            }else{
                $arr = [
                    [$email_dobel,'email_instansi'],
                    [$no_telepon_dobel,'no_telepon_instansi'],
                    [$no_fax_dobel,'no_fax_instansi'],
                ];
                $_SESSION['form_instansi_not_valid'] = [];
                foreach($arr as $item){
                    if($item[0] !== FALSE){
                        array_push($_SESSION['form_instansi_not_valid'],$item[1]);
                    }
                }
                return redirect()->to(base_url()."/Akun_control/Instansi/tambahkan_instansi");
            }
        }
    }

    public function save_tambahkan_instansi(){
        session()->get();
        $dataForm = $_SESSION['data_form_instansi'];
        $AddEditDelete = new AddEditDelete();

        $data = [
            'nama_instansi' => $dataForm['nama_instansi'],
            'no_telepon_instansi' => $dataForm['no_telepon_instansi'],
            'email_instansi' => $dataForm['email_instansi'],
            'no_fax_instansi' => $dataForm['no_fax_instansi'],
            'alamat_instansi' => $dataForm['alamat_instansi'],
            'acc_by_instansi' => $_SESSION['loginData']['nama']
        ];
        $AddEditDelete->add('instansi',$data);
    }

    public function edit_instansi(){
        if($this->verif_su()){
            $Get = new Get();

            if(isset($_SESSION['edit_data'])){
                $id = $_SESSION['edit_data']['id_instansi'];
            }else{
                $id = $_REQUEST['id'];
            }

            $data['required'] = $this->required;  
            $data['edit_data'] = $Get->get('instansi',NULL,NULL,['id_instansi' => $id],TRUE);
			$this->buat_session('edit_data',$data['edit_data']);
            return view('su_control/edit_instansi', $data);
        }
    }

    
    public function auth_edit_instansi(){
        if($this->verif_su()){
            $email_dobel = $this->auth_dobel_instansi(TRUE)[0];
            $no_telepon_dobel = $this->auth_dobel_instansi(TRUE)[1];
            $no_fax_dobel = $this->auth_dobel_instansi(TRUE)[2];

            if( ! $email_dobel && ! $no_telepon_dobel && ! $no_fax_dobel){
                $this->save_edit_instansi();

                //penghapusan sesssion info dobel dari yang sebelumnya
                if(isset($_SESSION['form_instansi_not_valid'])){
                    session()->remove('form_instansi_not_valid');
                }
                //penghapusan session data_form_instansi
                $this->buat_session_form('data_form_instansi',TRUE);
                
                $alert['path'] = 'Akun_control/Instansi';
                $alert['message'] = "Sukses mengedit instansi.";
                return view('alertBox',$alert);
            }else{
                $arr = [
                    [$email_dobel,'email_instansi'],
                    [$no_telepon_dobel,'no_telepon_instansi'],
                    [$no_fax_dobel,'no_fax_instansi'],
                ];
                $_SESSION['form_instansi_not_valid'] = [];
                foreach($arr as $item){
                    if($item[0] !== FALSE){
                        array_push($_SESSION['form_instansi_not_valid'],$item[1]);
                    }
                }
                return redirect()->to(base_url()."/Akun_control/Instansi/edit_instansi");
            }
        }
    }

    public function save_edit_instansi(){
        session()->get();
        $AddEditDelete = new AddEditDelete();

        $id = $_SESSION['edit_data']['id_instansi'];

        $data = [
            'nama_instansi' => $_SESSION['data_form_instansi']['nama_instansi'],
            'no_telepon_instansi' => $_SESSION['data_form_instansi']['no_telepon_instansi'],
            'email_instansi' => $_SESSION['data_form_instansi']['email_instansi'],
            'no_fax_instansi' => $_SESSION['data_form_instansi']['no_fax_instansi'],
            'alamat_instansi' => $_SESSION['data_form_instansi']['alamat_instansi'],
        ];

        $AddEditDelete->edit('instansi',$data,'id_instansi',$id);
    }
}