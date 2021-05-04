<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\LiveSearch;

class Home extends BaseController
{
    public function index(){
        if($this->filter_user(['su','dosbing','pemlap','mhs'])){
            session()->get();
            $Get = new Get();
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
                $required_akun = 
                    [
                        ['nama_akun','email_akun','no_unik_akun','no_wa_akun','peran_akun'],
                        ['block','block','block','block','none']
                    ];
                $required_instansi = 
                    [
                        ['nama_instansi','no_telepon_instansi','email_instansi','no_fax_instansi','alamat_instansi'],
                        ['block','block','block','block','block']
                    ];
        
                //ambil semua data di tabel tppi
                $data_tppi = $Get->get('tppi');
                
                $id = $_SESSION['loginData']['id'];
                $tppi_si_mhs = [];
                if($data_tppi !== NULL){
                    foreach($data_tppi as $item){
                        if($item['id_mhs_tppi'] == $id){
                            array_push($tppi_si_mhs,$item);
                        }
                    }
                }
                
                //rangkaian if else utk tentukan apakah sudah ada yg ter acc blm
                $is_accepted = FALSE;
                $wait = FALSE;
                if(count($tppi_si_mhs) != 0){
                    //kalau ada data maka..
                    foreach($tppi_si_mhs as $item){
                        if($item['acc_kampus_tppi'] == 'disetujui' && $item['acc_pemlap_tppi'] == 'disetujui'){
                            //kalau sudah disetujui semua berarti tampilkan home mhs yg sbenarnya
                            $is_accepted = TRUE;
                            break;
                        }else if($item['acc_kampus_tppi'] == "diajukan" || $item['acc_pemlap_tppi'] == "diajukan") {
                            $wait = TRUE;
                            break;
                        }
                    }
                }else{
                    //kalau tidak ada data maka tampilkan form isian
                    $is_accepted = FALSE;
                }
                //rangkaian if else berakhir


                if($is_accepted){
                    //logic utk tampilkan data yang diperlukan utk home sebenarnya
                    $data['is_accepted'] = TRUE;
                    $data['wait'] = FALSE;
                }else if($wait){
                    $data['is_accepted'] = FALSE;
                    $data['wait'] = TRUE;                    
                    $data['tppi_si_mhs'] = $tppi_si_mhs;
                }else{
                    //logic untuk tampilkan data yang diperlukan utk form isian
                    $liveSearch = new LiveSearch();

                    $data['liveSearch'] = [
                        'pemlap' => $liveSearch->get_pemlap(),
                        'instansi' => $liveSearch->get_instansi()
                    ];  
                    $data['tppi_si_mhs'] = $tppi_si_mhs;
                    $data['is_accepted'] = FALSE;
                    $data['wait'] = FALSE;
                    $data['required_akun'] = $required_akun;
                    $data['required_instansi'] = $required_instansi;

                }
            }

            return view('home',$data);
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
    }
}