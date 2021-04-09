<?php
namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use App\Models\Get;

class Profil extends BaseController
{
    public function index(){
        $Get = new Get();
        session()->get();
        $db = $_SESSION['loginData']['db'];
        $id = $_SESSION['loginData']['id'];


        if($db == "dosbing"){
            $dataDosbing = [
                'nama_tabel' => 'Data Dosen',
                'db'         => 'dosbing',
                'data'       => $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE)
            ];

            $id_instansi = $dataDosbing['data']['id_instansi_dosbing'];

            $dataInstansi = [
                'nama_tabel' => 'Data Instansi',
                'db'         => 'instansi',
                'data'       => $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE)
            ];

            $data['tables'] = [$dataDosbing,$dataInstansi];
        
        
        }else if($db == "pemlap"){
            $dataPemlap = [
                'nama_tabel' => 'Data Pembimbing',
                'db'         => 'pemlap',
                'data'       => $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE)
            ];

            $id_instansi = $dataPemlap['data']['id_instansi_pemlap'];

            $dataInstansi = [
                'nama_tabel' => 'Data Instansi',
                'db'         => 'instansi',
                'data'       => $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE)
            ];

            $data['tables'] = [$dataPemlap,$dataInstansi];
        
        
        }else if($db == "mhs"){
            $dataMhs = [
                'nama_tabel' => 'Data Mahasiswa',
                'db'         => 'mhs',
                'data'       => $Get->get($db,NULL,NULL,['id_'.$db => $id],TRUE)
            ];

            $id_dosbing = $dataMhs['data']['id_dosbing_mhs'];
            $id_pemlap = $dataMhs['data']['id_pemlap_mhs'];
            $id_instansi = $dataMhs['data']['id_instansi_mhs'];

            $dataDosbing = [
                'nama_tabel' => 'Dosen Pembimbing',
                'db'         => 'dosbing',
                'data'       => $Get->get('dosbing',NULL,NULL,['id_dosbing' => $id_dosbing],TRUE)
            ];

            $dataInstansi = [
                'nama_tabel' => 'Data Instansi',
                'db'         => 'instansi',
                'data'       => $Get->get('instansi',NULL,NULL,['id_instansi' => $id_instansi],TRUE)
            ];

            if($id_pemlap == NULL){
                $data['tables'] = [$dataMhs,$dataDosbing,$dataInstansi];
            }else{
                $dataPemlap = [
                    'nama_tabel' => 'Pembimbing Lapangan',
                    'db'         => 'pemlap',
                    'data'       => $Get->get('pemlap',NULL,NULL,['id_pemlap' => $id_pemlap],TRUE)
                ];

                $data['tables'] = [$dataMhs,$dataDosbing,$dataPemlap,$dataInstansi];
            }
            
        }

        return view('pages/profil/lihat_profil',$data);
    }
}