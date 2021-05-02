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
            if($_SESSION['loginData']['db'] != 'su' || $_SESSION['loginData']['db'] != 'mhs'){
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
		//to do
    }

}