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


    public function index(){
        if($this->filter_user(['dosbing','pemlap','mhs'])){
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
        if($this->filter_user(['dosbing','pemlap','mhs'])){
            $Get = new Get();
            session()->get();
    
            $data['required'] = $this->required;  

            $db = $_SESSION['loginData']['db'];
            $id = $_SESSION['loginData']['id'];
            $edit_data = $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE); 
            //foreach untuk mengganti key nama_pemlap,nama_dosbing menjadi seragam nama_akun dsb
            foreach($edit_data as $key => $item){
                foreach($this->required[0] as $req_item){
                    $needed = explode("akun",$req_item)[0];
                    if(strpos($key,$needed) !== FALSE){
                        //menempatkan item yang sesuai di key yang sesuai, new key sudah nama_akun dsb
                        $new_key = $needed."akun";
                        $data['edit_data'][$new_key] = $item;
                        break; 
                    }
                }
            }
            $data['edit_data']['db'] = $db;
            $data['edit_data']['id'] = $id;
            $this->buat_session('edit_data',$data['edit_data']); 
            return view('profil/edit_profil', $data);
        }
    }

    public function auth_edit_profil(){
        if($this->filter_user(['dosbing','pemlap','mhs'])){
            session()->get();
            $dobel_akun = $this->auth_dobel_akun(TRUE);
            $email_dobel = $dobel_akun[0];
            $no_unik_dobel = $dobel_akun[1];

            if( ! $email_dobel && ! $no_unik_dobel ){
                $this->save_edit_profil();

                //penghapusan sesssion info dobel dari yang sebelumnya
                if(isset($_SESSION['form_akun_not_valid'])){
                    session()->remove('form_akun_not_valid');
                }
                //penghapusan session data_form_akun
                $this->buat_session_form('data_form_akun','akun',TRUE);
                
                $alert['path'] = 'Akun_control/Profil';
                $alert['message'] = "Sukses mengedit profil.";
                return view('alertBox',$alert);
            }else{
                $arr = [
                    [$email_dobel,'email_akun'],
                    [$no_unik_dobel,'no_unik_akun']
                ];
                $_SESSION['form_akun_not_valid'] = [];
                foreach($arr as $item){
                    if($item[0] !== FALSE){
                        array_push($_SESSION['form_akun_not_valid'],$item[1]);
                    }
                }
                return redirect()->to(base_url()."/Akun_control/Profil/edit_profil");
            }
        }
    }

    private function save_edit_profil(){
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