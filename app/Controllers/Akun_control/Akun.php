<?php
namespace App\Controllers\Akun_control;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;
use App\Models\LiveSearch;


class Akun extends BaseController
{
    private $required = [
        ['nama_akun','no_unik_akun','email_akun','no_wa_akun','peran_akun','id_instansi_akun','id_dosbing_akun','id_pemlap_akun'],
        ['block','block','block','block','block','block','block','block']
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

    public function index(){
        if($this->verif_su()){
            $Get = new Get();
            
            $joined_mhs = [
                ['instansi','instansi.id_instansi = mhs.id_instansi_mhs','left'],
                ['dosbing','dosbing.id_dosbing = mhs.id_dosbing_mhs','left'],
                ['pemlap','mhs.id_pemlap_mhs = pemlap.id_pemlap','left']
            ];
            $select_mhs = 'mhs.timestamp_mhs,mhs.id_mhs,mhs.nama_mhs,mhs.email_mhs,mhs.no_unik_mhs,mhs.no_wa_mhs,mhs.acc_by_mhs,IFNULL(dosbing.nama_dosbing,"Tidak Ada") as nama_dosbing,IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi,IFNULL(pemlap.nama_pemlap,"Tidak Ada") as nama_pemlap';
            $data['mhs_on']     = $Get->get('mhs',$joined_mhs,$select_mhs,['status_mhs' => 'on']);
            $data['mhs_off']     = $Get->get('mhs',$joined_mhs,$select_mhs,['status_mhs' => 'off']);

            $joined_dosbing = [['instansi','instansi.id_instansi = dosbing.id_instansi_dosbing','left']];
            $select_dosbing = 'dosbing.timestamp_dosbing,dosbing.id_dosbing,dosbing.nama_dosbing,dosbing.email_dosbing,dosbing.no_unik_dosbing,dosbing.no_wa_dosbing,dosbing.acc_by_dosbing,IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi';
            $data['dosbing_on'] = $Get->get('dosbing',$joined_dosbing,$select_dosbing,['status_dosbing' => 'on']);
            $data['dosbing_off'] = $Get->get('dosbing',$joined_dosbing,$select_dosbing,['status_dosbing' => 'off']);
            
            $joined_pemlap = [['instansi','instansi.id_instansi = pemlap.id_instansi_pemlap','left']];
            $select_pemlap = 'pemlap.timestamp_pemlap,pemlap.id_pemlap,pemlap.nama_pemlap,pemlap.email_pemlap,pemlap.no_unik_pemlap,pemlap.no_wa_pemlap,pemlap.acc_by_pemlap,IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi';
            $data['pemlap_on']  = $Get->get('pemlap',$joined_pemlap,$select_pemlap,['status_pemlap' => 'on']);
            $data['pemlap_off']  = $Get->get('pemlap',$joined_pemlap,$select_pemlap,['status_pemlap' => 'off']);
    
            return view("su_control/daftar_akun",$data);
        }
    }

    public function delete_akun(){
        if($this->verif_su()){
            $db = $_REQUEST['db'];
            $id = $_REQUEST['id'];
            
            $AddEditDelete = new AddEditDelete();
    
            $AddEditDelete->edit($db,['status_'.$db => 'off'],'id_'.$db,$id);
    
            $alert['path'] = 'Akun_control/Akun';
            $alert['message'] = 'Berhasil menonaktifkan akun';
    
            return view('alertBox',$alert);
        }
    }

    public function restore_akun(){
        if($this->verif_su()){
            $db = $_REQUEST['db'];
            $id = $_REQUEST['id'];
            
            $AddEditDelete = new AddEditDelete();
            
            $AddEditDelete->edit($db,['status_'.$db => 'on'],'id_'.$db,$id);

            $alert['path'] = 'Akun_control/Akun';
            $alert['message'] = 'Berhasil mengaktifkan akun';

            return view('alertBox',$alert);
        }
    }

    public function tambahkan_akun(){
        if($this->verif_su()){
            $liveSearh = new LiveSearch();

            $data['liveSearch'] = [
                'dosbing' => $liveSearh->get_dosbing(),
                'pemlap' => $liveSearh->get_pemlap(),
                'instansi' => $liveSearh->get_instansi(),
            ];  
            $data['required'] = $this->required;  
            return view('su_control/tambahkan_akun', $data);
        }
    }

    public function auth_tambahkan_akun(){
        if($this->verif_su){
            $this->session_form_akun();
            if( $this -> auth_form_akun() ){
                $this->save_tambahkan_akun();

                //penghapusan sesssion
                session()->remove('form_akun_not_valid');
                
                $alert['path'] = 'Akun_control/Akun';
                $alert['message'] = "Sukses menambahkan akun, password auto generated untuk akun telah terkirim di email akun terdaftar.";
                return view('alertBox',$alert);
            }else{
                return redirect()->to(base_url()."/Akun_control/Akun/tambahkan_akun");
            }
        }
    }

    private function save_tambahkan_akun(){
        if($this->verif_su()){
            session()->get();
            $AddEditDelete = new AddEditDelete();
            $db = $_REQUEST['peran_akun'];
            
            //bila pemlap belum ada maka 'null' yg dr cell form akun hrs diganti null yg sebenarnya
            if($_REQUEST['id_pemlap_akun'] == 'null'){
                $_REQUEST['id_pemlap_akun'] = NULL;
            }

            foreach($_REQUEST as $key => $item){
                if($db == 'mhs'){
                    if($key != 'peran_akun'){
                        $data[explode('akun',$key)[0].$db] = $item;
                    }
                }else{
                    if($key != 'peran_akun' && $key != 'id_dosbing_akun' && $key != 'id_pemlap_akun'){
                        $data[$key] = $item;
                    }
                }
            }
            $password = $this->get_captcha(10);
            $data['password_'.$db] = password_hash($password, PASSWORD_DEFAULT);
            $data['acc_by_'.$db] = $_SESSION['loginData']['nama'];
            
            $AddEditDelete->add($db,$data);

            //kirim email
            $nama = $_REQUEST['nama_akun'];
            $nama_admin = $_SESSION['loginData']['nama'];
            $url = base_url();
            $no_unik = $_REQUEST['no_unik_akun'];
            $email = $_REQUEST['email_akun'];
            $pesan = "Hai, $nama <br><br> 
                        Email anda telah didaftarkan ke Sistem KP UWIKA oleh admin atas nama $nama_admin. <br><br> 
                        Anda bisa login ke $url dengan username dan password sebagai berikut : <br>
                        Username : $no_unik atau $email<br>
                        Password : $password<br><br>
                        Harap segera mengganti password default dengan password anda sendiri untuk keamanan akun anda.<br><br>
                        Terima kasih,<br>
                        Sistem KP UWIKA" ;

            $this->send_email("Selamat Datang di Sistem KP UWIKA",$pesan,NULL,$email);
    
        }
    }

    public function edit_akun(){
		if($this->verif_su()){
            $Get = new Get();
            $liveSearh = new LiveSearch();

            $db = $_REQUEST['db'];
            $id = $_REQUEST['id'];
            $data['edit_data'] = $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE);
            $data['edit_data']['db'] = $db;
            

            $data['liveSearch'] = [
                'dosbing' => $liveSearh->get_dosbing(),
                'pemlap' => $liveSearh->get_pemlap(),
                'instansi' => $liveSearh->get_instansi(),
            ];  
            $data['required'] = $this->required;  

            return view('su_control/edit_akun',$data);
        }
    }


    public function auth_edit_akun(){
        //belum diubah
        if($this->verif_su()){
            $this->session_form_akun();
            if( $this -> auth_form_akun() ){
                $this->save_tambahkan_akun();

                //penghapusan sesssion
                session()->remove('form_akun_not_valid');
                
                $alert['path'] = 'Akun_control/Akun';
                $alert['message'] = "Sukses menambahkan akun, password auto generated untuk akun telah terkirim di email akun terdaftar.";
                return view('alertBox',$alert);
            }else{
                return redirect()->to(base_url()."/Akun_control/Akun/tambahkan_akun");
            }
        }
    }
}