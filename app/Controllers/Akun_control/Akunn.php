<?php
namespace App\Controllers\Akun_control;
use App\Controllers\BaseController;
use App\Models\Get;


class Akun extends BaseController
{
    public function index(){
        session()->get();
        if(isset($_SESSION['loginData'])){
            if($_SESSION['loginData']['db'] == 'su'){
                $Get = new Get();
                
                //akan dilakukan 2 kali pengulangan untuk data mhs yang ada pemlap dan tidak
                //untuk halaman home su dosbing dan pemlap

                //pengulangan pertama
                
                $joined_mhs = [
                    ['instansi','instansi.id_instansi = mhs.id_instansi_mhs'],
                    ['dosbing','dosbing.id_dosbing = mhs.id_dosbing_mhs'],
                    ['pemlap','pemlap.id_pemlap = mhs.id_pemlap_mhs']
                ];
                $select = 'mhs.*,dosbing.nama_dosbing,instansi.nama_instansi';
                $data['mhs']     = $Get->get('mhs',$joined_mhs,$select);

                //pengulangan kedua
                $mhs = $Get->get('mhs');
                foreach($mhs as $item){
                    if($item['id_pemlap_mhs'] == NULL){
                        array_push($data['mhs'],$item);
                    }
                }

                
                $data['dosbing'] = $Get->get('dosbing',[['instansi','instansi.id_instansi = dosbing.id_instansi_dosbing']],'dosbing.*,instansi.nama_instansi');
                $data['pemlap']  = $Get->get('pemlap',[['instansi','instansi.id_instansi = pemlap.id_instansi_pemlap']],'pemlap.*,instansi.nama_instansi');
        
                return view("su_control/daftar_akun",$data);
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}