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
                
                $joined_mhs = [
                    ['instansi','instansi.id_instansi = mhs.id_instansi_mhs','left'],
                    ['dosbing','dosbing.id_dosbing = mhs.id_dosbing_mhs','left'],
                    ['pemlap','mhs.id_pemlap_mhs = pemlap.id_pemlap','left']
                ];
                $select_mhs = 'mhs.timestamp_mhs,mhs.id_mhs,mhs.nama_mhs,mhs.email_mhs,mhs.no_unik_mhs,mhs.no_wa_mhs,mhs.acc_by_mhs,IFNULL(dosbing.nama_dosbing,"Tidak Ada") as nama_dosbing,IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi,IFNULL(pemlap.nama_pemlap,"Tidak Ada") as nama_pemlap';
                $data['mhs_on']     = $Get->get('mhs',$joined_mhs,$select_mhs,['status_mhs' => 'on']);
                $data['mhs_off']     = $Get->get('mhs',$joined_mhs,$select_mhs,['status_mhs' => 'off']);

                $joined_dosbing = [['instansi','instansi.id_instansi = dosbing.id_instansi_dosbing','left']];
                $select_dosbing = 'dosbing.timestamp_dosbing,dosbing.id_dosbing,dosbing.nama_dosbing,dosbing.email_dosbing,dosbing.no_unik_dosbing,dosbing.no_wa_dosbing,dosbing.acc_by_dosbing,IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi';
                $data['dosbing_on'] = $Get->get('dosbing',$joined_dosbing,$select_dosbing,['status_dosbing' => 'on']);
                $data['dosbing_off'] = $Get->get('dosbing',$joined_dosbing,$select_dosbing,['status_dosbing' => 'off']);
                
                $joined_pemlap = [['instansi','instansi.id_instansi = pemlap.id_instansi_pemlap','left']];
                $select_pemlap = 'pemlap.timestamp_pemlap,pemlap.id_pemlap,pemlap.nama_pemlap,pemlap.email_pemlap,pemlap.no_unik_pemlap,pemlap.no_wa_pemlap,pemlap.acc_by_pemlap,IFNULL(instansi.nama_instansi,"Tidak Ada") as nama_instansi';
                $data['pemlap_on']  = $Get->get('pemlap',$joined_pemlap,$select_pemlap,['status_pemlap' => 'on']);
                $data['pemlap_off']  = $Get->get('pemlap',$joined_pemlap,$select_pemlap,['status_pemlap' => 'off']);
        
                return view("su_control/daftar_akun",$data);
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}