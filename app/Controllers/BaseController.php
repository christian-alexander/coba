<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Config\SMTPConfig;
use App\Models\Get;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}
	
	/*
	|
	| FUNGSI FUNGSI YANG BANYAK DIGUNAKAN
	|
	*/
	
	protected function matching($objek,$arrDatabase)
	{
		// method untuk mencari kesamaan dengan data di database, dengan memungkinkan pencarian beberapa tabel sekaligus
		// $objek adalah yang ingin dicari dalam database, gabole array
		// struktur $arrDatabase adalah [data_yang_dari_model_get,namaKolom,namaDB] di setiap itemnya
		// arr database yg di dump kesini harus bentuk array besar, walaupun db yg utk pencarian cuma 1
		// contoh : $arrDatabase = array([$data_dari_db,'kolom','nama db']);
		// returning arr kecocokan id dan db atau FALSE. bila ditemukan satu saja cocok akan stop searching
		// karena ngereturn id jgn lupa untuk select id jg saat mendapatkan data dari model Get
		
		$lanjutScan = TRUE;
        foreach($arrDatabase as $subArr){ //utk setiap tabel
            if($lanjutScan){
				$namaKolom = $subArr[1];
				$tipe = $subArr[2];
				if($subArr[0] != NULL){ //jika null berarti di get tidak ditemukan, dan di sini tidak akan diproses
					foreach($subArr[0] as $item){ //utk setiap data di tabel tsb
						if($item[$namaKolom] == $objek){
							$idCocok = $item["id_$tipe"];
							$lanjutScan = FALSE;
							break;
						}else{
							$lanjutScan = TRUE;
						}   
					
					}
				}
            }else{
                break;
            }
        }	

		if($lanjutScan){
			return FALSE;
		}else{
			$arr = [
				'id'   => $idCocok,
				'db' => $tipe
			]; 
			return $arr;
		}
	}

	protected function send_email($subject,$pesan,$attachment = NULL,$penerima,$cc = NULL, $bcc = NULL){
        //attachment,cc,bcc harus berupa array
		//kirim ke email
        $SMTPConfig = new SMTPConfig();
        $mail = $SMTPConfig->getSMTPConfig();
        $mail->addAddress($penerima);
        $mail->Subject = $subject ;
        $mail->Body    = $pesan;
        //untuk attachment
		if($attachment != NULL){
			foreach($attachment as $item){
				$mail->addAttachment($item);
			}
		}
		//untuk cc bcc
		if($cc != NULL){
			foreach($cc as $item){
				$mail->addCC($item);
			}
		}
		if($bcc != NULL){
			foreach($bcc as $item){
				$mail->addBCC($item);
			}
		}

		//send
		$mail->Send();
        
	}

	protected function get_captcha($length){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$size = strlen( $chars );
		$str = '';
		for ( $i = 0; $i <$length; $i++){
			$str .= $chars[ rand(0, $size - 1)];
	
		}
		return $str;
	}

	//				METHOD METHOD YANG BERHUBUNGAN DENGAN SESSION
	//             ------------------------------------------------

	protected function session_verif_link($email = NULL, $captcha = NULL){
		//membuat atau menghapus session data terkait link verif, terkait penggantian password
		if($email != NULL && $captcha != NULL){
            session()->set('captcha',$captcha);
            session()->set('email', $email);
			session()->set('captcha_start', time());
			
		}else{
			session()->remove('email');
			session()->remove('captcha');
			session()->remove('captcha_start');
		}
	}



	protected function buat_session($nama_session, $data = NULL){
		// global bisa untuk menciptakan session apa saja, bila data null maka dianggap
		// harus destroy session sebelumnya, nama session wajib isi
		// data boleh array
		session()->get();
		if($data !== NULL){
			$_SESSION[$nama_session] = $data;
		}else{
			session()->remove($nama_session);
		}
	}

	protected function buat_session_form($nama_session,$jenis_form,$destroy_session = FALSE){
		//memasukkan data dari form ke dalam session
		//khusus untuk pengambilan data dari form, mau apapun form itu
		//setiap form mempunyai ciri khas name, jenis form isi dengan 'akun' atau 'instansi' atau ciri khas form lainnya bila ada
		//karena mengambil dari request, nama session wajib, 
		//bedanya dgn method buat_session ada di requestnya
		session()->get();
		if($destroy_session){
			session()->remove($nama_session);
		}else{
			if(isset($_SESSION[$nama_session])){
				session()->remove($nama_session);
			}
			foreach($_REQUEST as $key => $item){
				if(strpos($key,$jenis_form) !== FALSE){
					//perlakuan khusus utk data password dari form akun
					if($_REQUEST[$key] == "password_akun"){
						$_SESSION[$nama_session][$key] = password_hash($item,PASSWORD_DEFAULT);
					}else{
						$_SESSION[$nama_session][$key] = $item;
					}
				}
			}
		}
	}

	
	//  		FUNGSI AUTH FORM AKUN 
	//   --------------------------------------------

	protected function auth_dobel_akun($is_edit = FALSE){
		//fungai utk mencari kedobelan data, bila email awal dan no unik awal diisi 
        //berarti auth dobel utk edit form, return array email no unik dobel
		//harus dipanggil setelah ada submittan form akun

        
        // menyimpan data submittan form ke dalam session agar tidak hilang
        if(isset($_REQUEST)){
			$this->buat_session_form('data_form_akun','akun');	

			session()->get();
			$Get = new Get();
			$email = $_SESSION['data_form_akun']['email_akun'];
			$no_unik = $_SESSION['data_form_akun']['no_unik_akun']; 	
			
			$dosbing    = $Get->get('dosbing'   ,NULL,'id_dosbing   ,email_dosbing   ,no_unik_dosbing   ',['status_dosbing' => 'on']);
			$pemlap     = $Get->get('pemlap'    ,NULL,'id_pemlap    ,email_pemlap    ,no_unik_pemlap    ',['status_pemlap'  => 'on']);
			$mhs        = $Get->get('mhs'       ,NULL,'id_mhs       ,email_mhs       ,no_unik_mhs       ',['status_mhs'     => 'on']);
			$sg_mhs     = $Get->get('sg_mhs'    ,NULL,'id_sg_mhs    ,email_sg_mhs    ,no_unik_sg_mhs    ');
			$sg_dosbing = $Get->get('sg_dosbing',NULL,'id_sg_dosbing,email_sg_dosbing,no_unik_sg_dosbing');			
			
			$arrDatabaseEmail  = array([$dosbing,'email_dosbing'  ,'dosbing'],[$pemlap,'email_pemlap'  ,'pemlap'],[$mhs,'email_mhs'  ,'mhs'],[$sg_dosbing,'email_sg_dosbing'  ,'sg_dosbing'],[$sg_mhs,'email_sg_mhs'  ,'sg_mhs']);
			$arrDatabaseNoUnik = array([$dosbing,'no_unik_dosbing','dosbing'],[$pemlap,'no_unik_pemlap','pemlap'],[$mhs,'no_unik_mhs','mhs'],[$sg_dosbing,'no_unik_sg_dosbing','sg_dosbing'],[$sg_mhs,'no_unik_sg_mhs','sg_mhs']);
			
			$email_dobel   = $this->matching($email,$arrDatabaseEmail);
			$no_unik_dobel = $this->matching($no_unik,$arrDatabaseNoUnik);
	
			if($is_edit){
				$db = $_SESSION['edit_data']['db'];
				//kalau ternyata yg sama adalah datanya dia ndiri maka harusnya valid ga dihitung dobwl
				if($email_dobel !== FALSE){
					if($_SESSION['edit_data']['id_'.$db] == $email_dobel['id']){
						$email_dobel = FALSE;
					}
				}
				if($no_unik_dobel !== FALSE){
					if($_SESSION['edit_data']['id_'.$db] == $no_unik_dobel['id']){
						$no_unik_dobel = FALSE;
					}
				}
			}	
			
			return array($email_dobel, $no_unik_dobel);
		}else{
			throw new \Exception("method ini harus dipanggil sesudah ada submittan form");
		}
    }


	//  		FUNGSI AUTH FORM INSTANSI
	//   --------------------------------------------

	protected function auth_dobel_instansi($is_edit = FALSE){
		//fungai utk mencari kedobelan data, bila email awal dan no unik awal diisi 
        //berarti auth dobel utk edit form, return array email no telepom dan no fax
		//harus dipanggil setelah ada submittan form akun

        
        // menyimpan data submittan form ke dalam session agar tidak hilang
        if(isset($_REQUEST)){
			$this->buat_session_form('data_form_instansi','instansi');	

			session()->get();
			$Get = new Get();
			$email = $_SESSION['data_form_instansi']['email_instansi'];
			$no_telepon = $_SESSION['data_form_instansi']['no_telepon_instansi']; 	
			$no_fax = $_SESSION['data_form_instansi']['no_fax_instansi']; 	
			
			$arrInstansi = $Get->get('instansi',NULL,'id_instansi,email_instansi,no_telepon_instansi,no_fax_instansi');			
			
			$arrDatabaseEmail  = array([$arrInstansi,'email_instansi' ,'instansi']);
			$arrDatabaseNoTelepon  = array([$arrInstansi,'no_telepon_instansi' ,'instansi']);
			$arrDatabaseNoFax  = array([$arrInstansi,'no_fax_instansi' ,'instansi']);


			$email_dobel   = $this->matching($email,$arrDatabaseEmail);
			$no_telepon_dobel   = $this->matching($no_telepon,$arrDatabaseNoTelepon);
			$no_fax_dobel   = $this->matching($no_fax,$arrDatabaseNoFax);
	
			if($is_edit){
				//kalau ternyata yg sama adalah datanya dia ndiri maka harusnya valid ga dihitung dobwl
				if($email_dobel !== FALSE){
					if($_SESSION['edit_data']['id_instansi'] == $email_dobel['id']){
						$email_dobel = FALSE;
					}
				}
				if($no_telepon_dobel !== FALSE){
					if($_SESSION['edit_data']['id_instansi'] == $no_telepon_dobel['id']){
						$no_telepon_dobel = FALSE;
					}
				}
				if($no_fax_dobel !== FALSE){
					if($_SESSION['edit_data']['id_instansi'] == $no_fax_dobel['id']){
						$no_fax_dobel = FALSE;
					}
				}
			}	
			
			return array($email_dobel, $no_telepon_dobel, $no_fax_dobel);
		}else{
			throw new \Exception("method ini harus dipanggil sesudah ada submittan form");
		}
    }


}
