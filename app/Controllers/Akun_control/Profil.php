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
        $Get = new Get();
        session()->get();
        if(isset($_SESSION['loginData'])){
            $db = $_SESSION['loginData']['db'];
            $id = $_SESSION['loginData']['id'];

            //sengaja nda di join2 karena datanya sendiri2 utk tiap tabel data, di join2 malah bingung misah datanya per tabel
            if($db == "dosbing"){
                $dataDosbing = [
                    'nama_tabel' => 'Data Dosen',
                    'db'         => 'dosbing',
                    'data'       => $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE)
                ];

                $id_instansi = $dataDosbing['data']['id_instansi_dosbing'];

                $dataInstansi = [
                    'nama_tabel' => 'Data Instansi',
                    'db'         => 'instansi',
                    'data'       => $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE)
                ];

                $data['tables'] = [$dataDosbing,$dataInstansi];
            
            
            }else if($db == "pemlap"){
                $dataPemlap = [
                    'nama_tabel' => 'Data Pembimbing',
                    'db'         => 'pemlap',
                    'data'       => $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE)
                ];

                $id_instansi = $dataPemlap['data']['id_instansi_pemlap'];

                $dataInstansi = [
                    'nama_tabel' => 'Data Instansi',
                    'db'         => 'instansi',
                    'data'       => $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE)
                ];

                $data['tables'] = [$dataPemlap,$dataInstansi];
            
            
            }else if($db == "mhs"){
                $dataMhs = [
                    'nama_tabel' => 'Data Mahasiswa',
                    'db'         => 'mhs',
                    'data'       => $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE)
                ];

                $id_dosbing = $dataMhs['data']['id_dosbing_mhs'];
                $id_pemlap = $dataMhs['data']['id_pemlap_mhs'];
                $id_instansi = $dataMhs['data']['id_instansi_mhs'];

                $dataDosbing = [
                    'nama_tabel' => 'Dosen Pembimbing',
                    'db'         => 'dosbing',
                    'data'       => $Get->get('dosbing',NULL,NULL,['id_dosbing' => $id_dosbing],TRUE)
                ];

                $dataInstansi = [
                    'nama_tabel' => 'Data Instansi',
                    'db'         => 'instansi',
                    'data'       => $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE)
                ];

                if($id_pemlap == NULL){
                    $data['tables'] = [$dataMhs,$dataDosbing,$dataInstansi];
                }else{
                    $dataPemlap = [
                        'nama_tabel' => 'Pembimbing Lapangan',
                        'db'         => 'pemlap',
                        'data'       => $Get->get('pemlap',NULL,NULL,['id_pemlap' => $id_pemlap],TRUE)
                    ];

                    $data['tables'] = [$dataMhs,$dataDosbing,$dataPemlap,$dataInstansi];
                }
                
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            return view('profil/lihat_profil',$data);
    
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_profil(){
        $Get = new Get();
        session()->get();
   
        $data['required'] = $this->required;  

        $db = $_SESSION['loginData']['db'];
        $id = $_SESSION['loginData']['id'];
        $data['edit_data'] = $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE); 
        $data['edit_data']['db'] = $db;
        return view('profil/edit_profil', $data);

    }

    public function auth_edit_profil(){
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

    public function save_edit_profil(){
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