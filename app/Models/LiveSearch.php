<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class LiveSearch extends Model{
    public function get_instansi(){
        return  $this->db->table('instansi')
        ->getWhere(['status_instansi'=>'on'])->getResultArray();
        
    }

    public function get_dosbing(){
        return $this->db->table('dosbing')
        ->join('instansi','instansi.id_instansi = dosbing.id_instansi_dosbing')
        ->getWhere(['status_dosbing'=>'on'])->getResultArray();
    }

    public function get_pemlap(){
        return $this->db->table('pemlap')
        ->join('instansi','instansi.id_instansi = pemlap.id_instansi_pemlap')
        ->getWhere(['status_pemlap'=>'on'])->getResultArray();
    }
}
