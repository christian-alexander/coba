<?php
namespace App\Controllers\TPPI;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;
use App\Models\LiveSearch;


class Data extends BaseController
{

    private $required_akun = 
        [
            ['nama_akun','email_akun','no_unik_akun','no_wa_akun','peran_akun'],
            ['block','block','block','block','none']
        ];
    private $required_instansi = 
        [
            ['nama_instansi','no_telepon_instansi','email_instansi','no_fax_instansi','alamat_instansi'],
            ['block','block','block','block','block']
        ];

    public function daftar_pengajuan(){
        if($this->filter_user(['su'])){
            $Get = new Get();
            $join = [
                ['mhs','mhs.id_mhs = tppi.id_mhs_tppi'],
                ['dosbing','dosbing.id_dosbing = tppi.id_dosbing_tppi']
            ];
            $select = 'tppi.*,mhs.nama_mhs,mhs.no_unik_mhs,dosbing.nama_dosbing';
            $data['data_tppi'] = $Get->get('tppi',$join,$select,['acc_kampus_tppi' => 'diajukan']);
            return view('tppi/daftar_pengajuan',$data);
        }
    }

    public function detail_pengajuan(){
        if($this->filter_user(['su'])){
            session()->get();
            if(isset($_SESSION['edit_data'])){
                $id_tppi = $_SESSION['edit_data']['id_tppi'];
            }else{
                $id_tppi = $_REQUEST['id'];
            }
            $Get = new Get();
            $liveSearch = new LiveSearch();

            $join = [
                ['mhs','mhs.id_mhs = tppi.id_mhs_tppi'],
                ['dosbing','dosbing.id_dosbing = tppi.id_dosbing_tppi']
            ];
            $select = 'tppi.id_tppi,tppi.id_instansi_tppi,tppi.id_pemlap_tppi,mhs.nama_mhs,mhs.no_unik_mhs,dosbing.nama_dosbing';
            
            //perlu dipisah2 karena utk proses transform key ke nama_akun dan nama_instansi akan foreach semua result, bila disatukan jdi kacau
            $edit_data = $Get->get('tppi',$join,$select,['id_tppi' => $id_tppi],TRUE); 
            $edit_data_akun = $Get->get('tppi',NULL,'nama_pemlap_tppi,email_pemlap_tppi,no_unik_pemlap_tppi,no_wa_pemlap_tppi',['id_tppi' => $id_tppi],TRUE); 
            $edit_data_instansi = $Get->get('tppi',NULL,'nama_instansi_tppi,alamat_instansi_tppi,email_instansi_tppi,no_telepon_instansi_tppi,no_fax_instansi_tppi',['id_tppi' => $id_tppi],TRUE); 
            
            //data id_instansi_tppi dan id_pemlap_tppi
            $data['edit_data']['id_instansi_tppi'] = $edit_data['id_instansi_tppi'];
            $data['edit_data']['id_pemlap_tppi'] = $edit_data['id_pemlap_tppi'];
            $data['edit_data']['id_tppi'] = $edit_data['id_tppi'];
            $data['edit_data']['db'] = 'tppi';
            //3 dibawah ini gapenting gaada hubungannya dengan edit cuma untuk info saja bagian frontend utk user
            $data['edit_data']['nama_mhs'] = $edit_data['nama_mhs'];
            $data['edit_data']['nrp'] = $edit_data['no_unik_mhs'];
            $data['edit_data']['nama_dosbing'] = $edit_data['nama_dosbing'];
            
            //foreach untuk mengganti key nama_pemlap,nama_dosbing menjadi seragam nama_akun dsb
            foreach($edit_data_akun as $key => $item){
                foreach($this->required_akun[0] as $req_item){
                    $needed = explode("akun",$req_item)[0];
                    if(strpos($key,$needed) !== FALSE){
                        //menempatkan item yang sesuai di key yang sesuai, new key sudah nama_akun dsb
                        $new_key = $needed."akun";
                        $data['edit_data'][$new_key] = $item;
                        break; 
                    }
                }
            }
            //foreach untuk mengganti key nama_instansi_tppi jadi nama_instansi dst
            foreach($edit_data_instansi as $key => $item){
                $new_key = explode("_tppi",$key)[0];
                $data['edit_data'][$new_key] = $item;
            }
            //session edit data
            $this->buat_session('edit_data',$data['edit_data']);

            //live search
            $data['liveSearch'] = [
                'pemlap' => $liveSearch->get_pemlap(),
                'instansi' => $liveSearch->get_instansi()
            ]; 

            //data required
            $data['required_akun'] = $this->required_akun;
            $data['required_instansi'] = $this->required_instansi;

            return view('tppi/detail_pengajuan',$data);
        }
    }
}