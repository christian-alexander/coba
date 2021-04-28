<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\LiveSearch;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function auth_login()
    {
        $Get = new Get();
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password_akun'];
        
        $arrSU      = $Get->get('su'     , NULL , ' id_su      , email_su      , no_unik_su      '                              );
        $arrDosbing = $Get->get('dosbing', NULL , ' id_dosbing , email_dosbing , no_unik_dosbing ' , ['status_dosbing' => 'on'] );
        $arrPemlap  = $Get->get('pemlap' , NULL , ' id_pemlap  , email_pemlap  , no_unik_pemlap  ' , ['status_pemlap'  => 'on'] );
        $arrMhs     = $Get->get('mhs'    , NULL , ' id_mhs     , email_mhs     , no_unik_mhs     ' , ['status_mhs'     => 'on'] );
        
        $arrDatabaseEmail  = array([$arrSU,'email_su'  ,'su'],[$arrDosbing,'email_dosbing'  ,'dosbing'],[$arrPemlap,'email_pemlap'  ,'pemlap'],[$arrMhs,'email_mhs'  ,'mhs']);
        $arrDatabaseNoUnik = array([$arrSU,'no_unik_su','su'],[$arrDosbing,'no_unik_dosbing','dosbing'],[$arrPemlap,'no_unik_pemlap','pemlap'],[$arrMhs,'no_unik_mhs','mhs']);
        
        $email_cocok   = $this->matching($username,$arrDatabaseEmail);
        $no_unik_cocok = $this->matching($username,$arrDatabaseNoUnik);

        if( ! $email_cocok && ! $no_unik_cocok){
            $message = "Akun tidak terdaftar atau telah non-aktif";
            $path = '';
        }else{
            if($email_cocok){
                
                $db = $email_cocok['db'];
                $dataDB = $Get->get($db,NULL,NULL,["email_$db" => $username],TRUE);
                $password_cocok = password_verify($password,$dataDB['password_'.$db]);

                $idUser = $dataDB['id_'.$db];
                $namaUser = $dataDB['nama_'.$db];
                $emailUser = $dataDB['email_'.$db];
                $noUnikUser = $dataDB['no_unik_'.$db];
                $dbUser = $db;
            
            }else if($no_unik_cocok){
                
                $db = $no_unik_cocok['db'];
                $dataDB = $Get->get($db,NULL,NULL,["no_unik_$db" => $username],TRUE);
                $password_cocok = password_verify($password,$dataDB['password_'.$db]);

                $idUser = $dataDB['id_'.$db];
                $namaUser = $dataDB['nama_'.$db];
                $emailUser = $dataDB['email_'.$db];
                $noUnikUser = $dataDB['no_unik_'.$db];
                $dbUser = $db;
            }

            //password salah or betul
            if(! $password_cocok){
                $message = "Password tidak cocok";
                $path = '';
            }else{
                $message = "Berhasil login";
                $path = 'Home';
                $ses_data = [
                    'id' => $idUser,
                    'nama' => $namaUser,
                    'email' => $emailUser,
                    'no_unik' => $noUnikUser,
                    'db' => $dbUser,
                    'logged' => TRUE
                ];
                session()->set('loginData',$ses_data);
            }
        }
		
        $alert['message'] = $message;
        $alert['path']    = $path;
        return view('alertBox', $alert);
    }

    public function logout()
	{
        session()->destroy();
        return redirect()->to(base_url());
	}
}