<?php

namespace App\Models;

use CodeIgniter\Model;

class AddEditDelete extends Model
{
    //semua data berbentuk ['namakolom' => 'value']
    public function add($table,$data,$insert_id = FALSE) //data adalah array
    {
        $db = $this->db;
        
        $db->table($table)->insert($data);

        if($insert_id){
            return $db->insertID();
        }
    }

    public function edit($table, $data, $namaKolom, $value) //data adalah array
    {
        $this->db->table($table)
        ->where($namaKolom,$value)
        ->update($data);
    }

    public function hapus($table,$namaKolom, $value) //nama delete ketumpuk dengan built in CI4
    {
        $this->db->table($table)
        ->delete([$namaKolom => $value]);
    }
}