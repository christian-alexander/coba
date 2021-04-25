<?php

namespace App\Models;

use CodeIgniter\Model;

class AddEditDelete extends Model
{
    //semua data berbentuk ['namakolom' => 'value']
    public function add($table,$data) //data adalah array
    {
        $this->db->table($table)
        ->insert($data);
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