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
            //akan dilakukan 2 kali pengulangan untuk data_db yang ada pemlap dan tidak
            //untuk halaman home su dosbing dan pemlap
            
            //pengulangan pertama
            $joinArray = [
                ['dosbing','dosbing.id_dosbing = mhs.id_dosbing_mhs'],
                ['pemlap','pemlap.id_pemlap = mhs.id_pemlap_mhs'],
                ['instansi','instansi.id_instansi = mhs.id_instansi_mhs'],
                ['status_magang','status_magang.id_mhs = mhs.id_mhs']
            ];
            $select = 'mhs.timestamp_mhs, mhs.id_mhs, mhs.nama_mhs, mhs.no_unik_mhs, mhs.id_pemlap_mhs, dosbing.nama_dosbing, pemlap.nama_pemlap, instansi.nama_instansi, status_magang.*';
            if($_SESSION['loginData']['db'] == "su"){
                $data['data_db'] = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on']);
            }else if($_SESSION['loginData']['db'] == "dosbing"){
                $data['data_db'] = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on','mhs.id_dosbing_mhs' => $_SESSION['loginData']['id'] ]);
            }else if($_SESSION['loginData']['db'] == "pemlap"){
                $data['data_db'] = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on','mhs.id_pemlap_mhs' => $_SESSION['loginData']['id'] ]);
            }

            //pengulangan kedua untuk yang pemlapnya null
            $joinArray = [
                ['dosbing','dosbing.id_dosbing = mhs.id_dosbing_mhs'],
                ['instansi','instansi.id_instansi = mhs.id_instansi_mhs'],
                ['status_magang','status_magang.id_mhs = mhs.id_mhs']
            ];
            $select = 'mhs.timestamp_mhs, mhs.id_mhs, mhs.nama_mhs, mhs.no_unik_mhs, mhs.id_pemlap_mhs,dosbing.nama_dosbing, instansi.nama_instansi,status_magang.*';
            if($_SESSION['loginData']['db'] == "su"){
                $array = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on']);
                //mencari yang tidak tidak punya pemlap untuk kemudian ditambahkan
                foreach($array as $item){
                    if($item['id_pemlap_mhs'] == NULL){
                        array_push($data['data_db'],$item);
                    }
                }
            }else if($_SESSION['loginData']['db'] == "dosbing"){
                $array = $Get->get('mhs',$joinArray,$select,['mhs.status_mhs' => 'on','mhs.id_dosbing_mhs' => $_SESSION['loginData']['id'] ]);
                //mencari yang tidak punya pemlap untuk kemudian ditambahkan
                foreach($array as $item){
                    if($item['id_pemlap_mhs'] == NULL){
                        array_push($data['data_db'],$item);
                    }
                }
            }else if($_SESSION['loginData']['db'] == "pemlap"){
                //none kan gaada pemlapnya emang
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