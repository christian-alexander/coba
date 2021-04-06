<?php

namespace App\Models;

use CodeIgniter\Model;

class AddEditDelete extends Model
{
    public function add($table,$data)
    {
        $this->db->table($table)
        ->insert($data);
    }

    public function edit($table, $data, $namaKolom, $value)
    {
        $this->db->table($table)
        ->set($data)->where($namaKolom,$value)
        ->update();
    }

    public function hapus($table,$namaKolom, $value) //nama delete ketumpuk dengan built in CI4
    {
        $this->db->table($table)
        ->delete([$namaKolom => $value]);
    }
}