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
	
	protected function matching($objek,$arrDatabase,$multiData = TRUE,$multiTabel = FALSE,$isPassword = FALSE)
	{
		// method untuk mencari kesamaan dengan data di database, dengan pencarian beberapa tabel sekaligus
		// akan membentuk array 4 dimensi, lapisan 1 utk multitabel, lapisan 2 untuk tempat namaKolom yang dibandingkan dan arr itu sendiri,lapisan 3 untuk tiap item di sebuah tabel, lapisan 4 untuk associative arr hasil dari get untuk sebuah item tunggal
		// $objek adalah yang ingin dicari dalam database
		// struktur $arrDatabase adalah [data_yang_dari_model_get,namaKolom,namaDB] di setiap itemnya
		// default $multiTabel = FALSE, bila FALSE $arrDatabase akan diubah dulu jadi array 
		// default $multiData = TRUE, harus di FALSE bila keluaran dari model Get adalah single (bukan array)
		// isPassword default = FALSE, bila TRUE akan mode bandingkan password
		// returning arr kecocokan id atau FALSE. bila ditemukan satu saja cocok akan stop searching
		if( ! $multiData){
			$arrDatabase = array(array($arrDatabase[0]),$arrDatabase[1],$arrDatabase[2]);
		}

		if( ! $multiTabel){
			$arrDatabase = array($arrDatabase);
		}
		
		$lanjutScan = TRUE;
        foreach($arrDatabase as $subArr){ //utk setiap tabel
            if($lanjutScan){
				$namaKolom = $subArr[1];
				$tipe = $subArr[2];
				if($subArr[0] != NULL){ //jika null berarti di get tidak ditemukan, dan di sini tidak akan diproses
					foreach($subArr[0] as $item){ //utk setiap data di tabel tsb
						if($isPassword){
							if(password_verify($objek,$item[$namaKolom])){
								$idCocok = $item["id_$tipe"];
								$namaCocok = $item["nama_$tipe"];
								$emailCocok = $item["email_$tipe"];
								$noUnikCocok = $item["no_unik_$tipe"];
								$lanjutScan = FALSE;
								break;
							}else{
								$lanjutScan = TRUE;
							}   
						}else{
							if($item[$namaKolom] == $objek){
								$idCocok = $item["id_$tipe"];
								$namaCocok = $item["nama_$tipe"];
								$emailCocok = $item["email_$tipe"];
								$noUnikCocok = $item["no_unik_$tipe"];
								$lanjutScan = FALSE;
								break;
							}else{
								$lanjutScan = TRUE;
							}   
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
				'nama' => $namaCocok,
				'email' => $emailCocok,
				'no_unik' => $noUnikCocok,
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

	protected function data_for_auth(){
		//untuk mengeluarkan data sebagai pengecekan data dobel di js
		$Get = new Get();
		$data = array();
		

		$dosbing = $Get->get('dosbing',NULL,'email_dosbing,no_unik_dosbing',['status_dosbing' => 'on']);
		$pemlap = $Get->get('pemlap',NULL,'email_pemlap,no_unik_pemlap',['status_pemlap' => 'on']);
		$mhs = 	$Get->get('mhs',NULL,'email_mhs,no_unik_mhs',['status_mhs' => 'on']);
		$sg_mhs = $Get->get('sg_mhs',NULL,'email_sg_mhs,no_unik_sg_mhs');
		$sg_dosbing = $Get->get('sg_dosbing',NULL,'email_sg_dosbing,no_unik_sg_dosbing');			

		if($dosbing != NULL){array_push($data,$dosbing);}
		if($pemlap != NULL){array_push($data,$pemlap);}
		if($mhs != NULL){array_push($data,$mhs);}
		if($sg_mhs != NULL){array_push($data,$sg_mhs);}
		if($sg_dosbing != NULL){array_push($data,$sg_dosbing);}
		

		return $data;
	}
}
