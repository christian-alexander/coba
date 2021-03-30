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
        $username = $_REQUEST[LOGIN_NAMING['username']['name/id']];
        $password = $_REQUEST[LOGIN_NAMING['password']['name/id']];
        
        $arrSU = $Get->get('su');
        $arrDosbing = $Get->get('dosbing',NULL,NULL,['status_dosbing' => 'on']);
        $arrPemlap = $Get->get('pemlap',NULL,NULL,['status_pemlap' => 'on']);
        $arrMhs = $Get->get('mhs',NULL,NULL,['status_mhs' => 'on']);
        $arrDatabaseEmail = array([$arrSU,'email_su','su'],[$arrDosbing,'email_dosbing','dosbing'],[$arrPemlap,'email_pemlap','pemlap'],[$arrMhs,'email_mhs','mhs']);
        $arrDatabaseNoUnik = array([$arrSU,'no_unik_su','su'],[$arrDosbing,'no_unik_dosbing','dosbing'],[$arrPemlap,'no_unik_pemlap','pemlap'],[$arrMhs,'no_unik_mhs','mhs']);
        
        $email_cocok = $this->matching($username,$arrDatabaseEmail,TRUE,TRUE);
        $no_unik_cocok = $this->matching($username,$arrDatabaseNoUnik,TRUE,TRUE);

        if( ! $email_cocok && ! $no_unik_cocok){
            $message = "Akun tidak terdaftar atau telah non-aktif";
            $path = '';
        }else{
            if($email_cocok){
                
                $db = $email_cocok['db'];
                $passDatabase = $Get->get($db,NULL,NULL,["email_$db" => $username],TRUE);
                $password_cocok = $this->matching($password,[$passDatabase,"password_$db",$db],FALSE,FALSE,TRUE);
                
                $idUser = $email_cocok['id'];
                $namaUser = $email_cocok['nama'];
                $emailUser = $email_cocok['email'];
                $noUnikUser = $email_cocok['no_unik'];
                $dbUser = $email_cocok['db'];
            
            }else if($no_unik_cocok){
                
                $db = $no_unik_cocok['db'];
                $passDatabase = $Get->get($db,NULL,NULL,["no_unik_$db" => $username],TRUE);
                $password_cocok = $this->matching($password,[$passDatabase,"password_$db",$db],FALSE,FALSE,TRUE);
            
                $idUser = $no_unik_cocok['id'];
                $namaUser = $no_unik_cocok['nama'];
                $emailUser = $no_unik_cocok['email'];
                $noUnikUser = $no_unik_cocok['no_unik'];
                $dbUser = $no_unik_cocok['db'];
            }

            //password salah or betul
            if(! $password_cocok){
                $message = "Password tidak cocok";
                $path = '';
            }else{
                $message = "Berhasil login";
                $path = 'Pages/Home';
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