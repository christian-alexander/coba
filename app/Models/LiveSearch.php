<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class LiveSearch extends Model{
    public function get_instansi(){
        return  $this->db->table('instansi')
        ->select('id_instansi,nama_instansi,alamat_instansi')
        ->getWhere(['status_instansi'=>'on'])->getResultArray();
        
    }

    public function get_dosbing(){
        return $this->db->table('dosbing')
        ->select('id_dosbing,nama_dosbing')
        ->getWhere(['status_dosbing'=>'on'])->getResultArray();
    }

    public function get_pemlap(){
        return $this->db->table('pemlap')
        ->join('instansi','instansi.id_instansi = pemlap.id_instansi_pemlap')
        ->select('instansi.nama_instansi,pemlap.id_pemlap,pemlap.nama_pemlap')
        ->getWhere(['status_pemlap'=>'on'])->getResultArray();
    }
}
