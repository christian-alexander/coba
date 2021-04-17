<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Get;

class Home extends BaseController
{
    public function index(){
        session()->get();
        $Get = new Get();
        if(isset($_SESSION['loginData'])){
            //utk home su dosbing pemlap
            $joinArray = [
                ['dosbing','dosbing.id_dosbing = mhs.id_dosbing_mhs','left'],
                ['pemlap','pemlap.id_pemlap = mhs.id_pemlap_mhs','left'],
                ['instansi','instansi.id_instansi = mhs.id_instansi_mhs','left'],
                ['status_magang','status_magang.id_mhs = mhs.id_mhs']
            ];
            $select = 'mhs.timestamp_mhs, mhs.id_mhs, mhs.nama_mhs, mhs.no_unik_mhs, IFNULL(dosbing.nama_dosbing,"Tidak Ada") as nama_dosbing, IFNULL(pemlap.nama_pemlap,"Tidak Ada") as nama_pemlap, IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi, status_magang.*';
            
            $db = $_SESSION['loginData']['db'];
            $id = $_SESSION['loginData']['id'];

            if($db == "su"){
                $data['data_db'] = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on']);
            }else if($db == "dosbing" || $db == "pemlap"){
                $data['data_db'] = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on','mhs.id_'.$db.'_mhs' => $id ]);
            }

            //untuk home mhs
            if($_SESSION['loginData']['db'] == "mhs"){
                $data['data_db'] = NULL;
            }

            return view('home',$data);
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
    }
}