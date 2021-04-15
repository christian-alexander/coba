<?php
namespace App\Controllers\Signup;
use App\Controllers\BaseController;
use App\Models\Get;

class Signup_request extends BaseController
{
    public function index(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            if($_SESSION['loginData']['db'] == "su"){
                $Get = new Get();
                $data = [];
                
                $joined = [
                    ['instansi','instansi.id_instansi = sg_mhs.id_instansi_sg_mhs'],
                    ['dosbing','dosbing.id_dosbing = sg_mhs.id_dosbing_sg_mhs']
                ];
                $joined_dosbing = [['instansi','instansi.id_instansi = sg_dosbing.id_instansi_sg_dosbing']];

                $data['data_db'][0] = $Get->get('sg_mhs',$joined,'sg_mhs.*,instansi.nama_instansi,dosbing.nama_dosbing');
                $data['data_db'][1] = $Get->get('sg_dosbing',$joined_dosbing,'sg_dosbing.*,instansi.nama_instansi');
                
                return view('signup/signup_request',$data);
            }else if($_SESSION['loginData']['db'] == "dosbing"){
                session()->get();
                $Get = new Get();
                
                $joined = [
                    ['instansi','instansi.id_instansi = sg_mhs.id_instansi_sg_mhs'],
                    ['dosbing','dosbing.id_dosbing = sg_mhs.id_dosbing_sg_mhs']
                ];
                $joined_dosbing = ['instansi','instansi.id_instansi = sg_dosbing.id_instansi_sg_dosbing'];

                $data['data_db'][0] = $Get->get('sg_mhs',$joined,'sg_mhs.*,instansi.nama_instansi,dosbing.nama_dosbing',['id_dosbing_sg_mhs' => $_SESSION['loginData']['id']]);
                $data['data_db'][1] = $Get->get('sg_dosbing',$joined_dosbing,'sg_dosbing.*,instansi.nama_instansi');

                return view('signup/signup_request',$data);
            
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();    
            }
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}