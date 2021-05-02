<?php
namespace App\Controllers\TPPI;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;

class Form extends BaseController
{
    private function verif_form_tppi(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            if($_SESSION['loginData']['db'] == 'su' || $_SESSION['loginData']['db'] == 'mhs'){
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
    
    private function verif_mhs(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            if($_SESSION['loginData']['db'] == 'mhs'){
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
    
	public function auth_form_tppi(){
        //ternyata bila selectnya tadi null gaakan ke post datanya, yowes ilang dianggap gaada inputan tsb
        //jadi id_instansi_tppi, id_pemlap_tppi bisa hilangmuncul, begitu jg dgn session data_id_tppi
        if($this->verif_form_tppi()){
			$akun_valid = TRUE;
            $instansi_valid = TRUE;

            //utk simpan id pemlap dan instansi tppi, bila ada
            $this->buat_session_form('data_id_tppi','tppi');


            if( ! isset($_REQUEST['id_pemlap_tppi']) ){
                $dobel_akun = $this->auth_dobel_akun();
                $email_dobel = $dobel_akun[0];
                $no_unik_dobel = $dobel_akun[1];

                if( ! $email_dobel && ! $no_unik_dobel){
					$akun_valid = TRUE;

                    //penghapusan sesssion info dobel dari yang sebelumnya
                    if(isset($_SESSION['form_akun_not_valid'])){
                        session()->remove('form_akun_not_valid');
                    }
                }else{
                    $akun_valid = FALSE;

                    if( $email_dobel !== FALSE &&  $no_unik_dobel !== FALSE){
                        $_SESSION['form_akun_not_valid'] = ['email_akun','no_unik_akun'];
                    }else if( $email_dobel !== FALSE){
                        $_SESSION['form_akun_not_valid'] = ['email_akun'];
                    }else{
                        $_SESSION['form_akun_not_valid'] = ['no_unik_akun'];
                    }
                }
            }

            if( ! isset($_REQUEST['id_instansi_tppi'] ) ){
                $dobel_instansi = $this->auth_dobel_instansi();
                $email_dobel = $dobel_instansi[0];
                $no_telepon_dobel = $dobel_instansi[1];
                $no_fax_dobel = $dobel_instansi[2];

                if( ! $email_dobel && ! $no_telepon_dobel && ! $no_fax_dobel){
                    $instansi_valid = TRUE;
    
                    //penghapusan sesssion info dobel dari yang sebelumnya
                    if(isset($_SESSION['form_instansi_not_valid'])){
                        session()->remove('form_instansi_not_valid');
                    }
                }else{
                    $instansi_valid = FALSE;
					
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
                }
            }

            //path redirect utk su atau mhs
            //path utk alertbox sukses, redirect utk balik bila dobel data
            session()->get();
            if($_SESSION['loginData']['db'] == 'mhs'){$path = 'Home';$redirect = base_url().'/Home';}
            else{$path = "#";$redirect='#';} //blm dibuat, path utk su
            
			if($akun_valid && $instansi_valid){
                if($_SESSION['loginData']['db'] == 'mhs'){
                    $this->save_form_tppi();
                }else{
                    $this->save_edit_form_tppi();
                }
				
                //penghapusan session data_form_akun
                $this->buat_session_form('data_form_akun','akun',TRUE);
            
                //penghapusan session data_form_instansi
                $this->buat_session_form('data_form_instansi','instansi',TRUE);

                //penghapusan session data_id_tppi
                $this->buat_session_form('data_id_tppi','tppi',TRUE);

                $alert['path'] = $path;
                $alert['message'] = "Sukses mengajukan. Hubungi TU untuk di acc.";
                return view('alertBox',$alert);
            }else{
				return redirect()->to($redirect);
            }

        }
    }

    private function save_form_tppi(){
        if($this->verif_mhs()){
            $Get = new Get();
            $AddEditDelete = new AddEditDelete();
            session()->get();
            $data = [];
            //mendapatkan data id2 tppi
            if(isset($_SESSION['data_id_tppi'])){
                foreach($_SESSION['data_id_tppi'] as $key => $item){
                    $data[$key] = $item;
                }
                //lah kan hilang muncul id nya? kalo cuma ada id_pemlap_tppi saja?
                //jgn khawatir karena default value id2 di db adalah null
            }
            //utk id_mhs dan id_dosbing
            $id_mhs = $_SESSION['loginData']['id'];
            $data['id_mhs_tppi'] = $id_mhs;
            $id_dosbing = $Get->get('mhs',NULL,'id_dosbing_mhs',['id_mhs' => $id_mhs],TRUE)['id_dosbing_mhs'];
            $data['id_dosbing_tppi'] = $id_dosbing;
            

            //utk data tppi pemlap
            if(isset($_SESSION['data_form_akun'])){
                foreach($_SESSION['data_form_akun'] as $key => $item){
                    if($key != 'peran_akun' && $key != 'no_unik_akun'){
                        $key = str_replace('akun','pemlap_tppi',$key);
                        $data[$key] = $item;
                    }else if($key == 'no_unik_akun'){
                        $key = str_replace('akun','pemlap_tppi',$key);
                        if($item != ''){$data[$key] = $item;}
                    }
                }
            }else{
                $id_pemlap = $data['id_pemlap_tppi'];
                $data_pemlap = $Get->get('pemlap',NULL,'nama_pemlap,email_pemlap,no_unik_pemlap,no_wa_pemlap',['id_pemlap' => $id_pemlap],TRUE); 
                $data['nama_pemlap_tppi'] = $data_pemlap['nama_pemlap'];
                $data['no_unik_pemlap_tppi'] = $data_pemlap['no_unik_pemlap'];
                $data['no_wa_pemlap_tppi'] = $data_pemlap['no_wa_pemlap'];
                $data['email_pemlap_tppi'] = $data_pemlap['email_pemlap'];
            }
            if(isset($_SESSION['dats_id_tppi']['id_instansi_tppi'])){
                $data['id_instansi_pemlap_tppi'] = $data['id_instansi_tppi'];
            }
			
            //utk data instansi tppi
            if(isset($_SESSION['data_form_instansi'])){
                foreach($_SESSION['data_form_instansi'] as $key => $item){
                    $key = $key.'_tppi';
                    $data[$key] = $item;
                }
            }else{
                $id_instansi = $data['id_instansi_tppi'];
                $data_instansi = $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE);
                $data['nama_instansi_tppi'] = $data_instansi['nama_instansi'];
                $data['alamat_instansi_tppi'] = $data_instansi['alamat_instansi'];
                $data['no_telepon_instansi_tppi'] = $data_instansi['no_telepon_instansi'];
                $data['no_fax_instansi_tppi'] = $data_instansi['no_fax_instansi'];
                $data['email_instansi_tppi'] = $data_instansi['email_instansi'];
            }
            

            //oke beres sekarang tinggal insert deh
            $AddEditDelete->add('tppi',$data);
        }
	}

}