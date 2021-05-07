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

    private function change_data_name($db){
        //dari form nama data adalah nama_akun,email_akun, dst
        //maka dari itu ketika proses add atau edit ke db harus diubah
        //ke nama_dosbing atau email_mhs, itulah gunanya method ini
        //selain itu method ini jg mengepaskan apa yg diperlukan di db
        //bila mhs brrti perlu dosbing pemlap, bila dosbing ga brrti ga perlu pemlap
        foreach($_REQUEST as $key => $item){
            if($db == 'mhs'){
                if($key != 'peran_akun'){
                    $data[explode('akun',$key)[0].$db] = $item;
                }
            }else{
                if($key != 'peran_akun' && $key != 'id_dosbing_akun' && $key != 'id_pemlap_akun'){
                    $data[explode('akun',$key)[0].$db] = $item;
                }
            }
        }
        return $data;
    }
    
    public function index(){
        if($this->filter_user(['su'])){
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

    public function delete_restore_akun($tipe){
        if($this->filter_user(['su'])){
            $db = $_REQUEST['db'];
            $id = $_REQUEST['id'];
            
            $AddEditDelete = new AddEditDelete();
    
            if($tipe == "delete"){
                $AddEditDelete->edit($db,['status_'.$db => 'off'],'id_'.$db,$id);
        
                $alert['path'] = 'Akun_control/Akun';
                $alert['message'] = 'Berhasil menonaktifkan akun';
            }else if($tipe == "restore"){
                $AddEditDelete->edit($db,['status_'.$db => 'on'],'id_'.$db,$id);

                $alert['path'] = 'Akun_control/Akun';
                $alert['message'] = 'Berhasil mengaktifkan akun';
    
            } 
            return view('alertBox',$alert);
        }
    }

    public function tambahkan_akun(){
        if($this->filter_user(['su'])){
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
        if($this->filter_user(['su'])){
            $dobel_akun = $this->auth_dobel_akun();
            $email_dobel = $dobel_akun[0];
            $no_unik_dobel = $dobel_akun[1];

            if( ! $email_dobel && ! $no_unik_dobel ){
                $this->save_tambahkan_akun();

                //penghapusan sesssion info dobel dari yang sebelumnya
                if(isset($_SESSION['form_akun_not_valid'])){
                    session()->remove('form_akun_not_valid');
                }
                //penghapusan session data_form_akun
                $this->buat_session_form('data_form_akun','akun',TRUE);
                
                $alert['path'] = 'Akun_control/Akun';
                $alert['message'] = "Sukses menambahkan akun, password auto generated untuk akun telah terkirim di email akun terdaftar.";
                return view('alertBox',$alert);
            }else{
                if( $email_dobel !== FALSE &&  $no_unik_dobel !== FALSE){
                    $_SESSION['form_akun_not_valid'] = ['email_akun','no_unik_akun'];
                }else if( $email_dobel !== FALSE){
                    $_SESSION['form_akun_not_valid'] = ['email_akun'];
                }else{
                    $_SESSION['form_akun_not_valid'] = ['no_unik_akun'];
                }
                return redirect()->to(base_url()."/Akun_control/Akun/tambahkan_akun");
            }
        }
    }

    private function save_tambahkan_akun(){
        session()->get();
        $AddEditDelete = new AddEditDelete();
        $db = $_REQUEST['peran_akun'];
        
        //bila pemlap belum ada maka 'null' yg dr cell form akun hrs diganti null yg sebenarnya
        if(isset($_REQUEST['id_pemlap_akun'])){
            if($_REQUEST['id_pemlap_akun'] == 'null'){
                $_REQUEST['id_pemlap_akun'] = NULL;
            }
        }

        
        $data = $this->change_data_name($db);

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

    public function edit_akun(){
        if($this->filter_user(['su'])){
            session()->get();
            $Get = new Get();
            $liveSearh = new LiveSearch();
			
            if(isset($_SESSION['form_akun_not_valid']) && ! isset($_REQUEST) ){
				$db = $_SESSION['edit_data']['db'];
                $id = $_SESSION['edit_data']['id'];
            }else{
                $db = $_REQUEST['db'];
                $id = $_REQUEST['id'];
            }

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
        if($this->filter_user(['su'])){
            session()->get();
            $dobel_akun = $this->auth_dobel_akun(TRUE);
            $email_dobel = $dobel_akun[0];
            $no_unik_dobel = $dobel_akun[1];

            if( ! $email_dobel && ! $no_unik_dobel ){
                $this->save_edit_akun();

                //penghapusan sesssion info dobel dari yang sebelumnya
                if(isset($_SESSION['form_akun_not_valid'])){
                    session()->remove('form_akun_not_valid');
                }
                //penghapusan session data_form_akun
                $this->buat_session_form('data_form_akun','akun',TRUE);
                
                $alert['path'] = 'Akun_control/Akun';
                $alert['message'] = "Sukses mengedit akun.";
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
                return redirect()->to(base_url()."/Akun_control/Akun/edit_akun");
            }
        }
    }

    private function save_edit_akun(){
        $db = $_SESSION['edit_data']['db'];
        $AddEditDelete = new AddEditDelete();

        // kasus khusus bila terjadi pergantian peran
        if($_REQUEST['peran_akun'] != $db){
            $this->save_edit_peran_changed();
        }else{
            $data = $this->change_data_name($db);
            $AddEditDelete->edit($db,$data,'id_'.$db,$_SESSION['edit_data']['id_'.$db]);
        }
    
    }

    private function save_edit_peran_changed(){
        session()->get();
        $AddEditDelete = new AddEditDelete();
        $db_lama = $_SESSION['edit_data']['db'];
        $db_baru = $_SESSION['data_form_akun']['peran_akun'];

        $data = $this->change_data_name($db_baru);
        $data['acc_by_'.$db_baru] = $_SESSION['loginData']['nama'];
        $data['password_'.$db_baru] = $_SESSION['edit_data']['password_'.$db_lama];
		//if pemlapnya null, di form valunya 'null' harus di set menjadi NULL beneran
        if(isset($data['id_pemlap_mhs'])){
			if($data['id_pemlap_mhs'] == 'null'){
                $data['id_pemlap_mhs'] = NULL;
            }
        }
		
        //hapus data lama
        $AddEditDelete->hapus($db_lama,'id_'.$db_lama,$_SESSION['edit_data']['id_'.$db_lama]);
        //insert data baru
        $AddEditDelete->add($db_baru,$data);
    }
}