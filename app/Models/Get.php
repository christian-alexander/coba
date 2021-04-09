<?php

namespace App\Models;

use CodeIgniter\Model;

class Get extends Model
{
    public function get($table, $joinArray = NULL, $select = NULL , $condition = NULL ,$single = FALSE)
    {
        // $condition formatnya ['namaKolom' => 'value'], untuk generate getWhere
        // $joinArray formatnya ['joinTable','joinTable.id = mainTable.id'] di setiap item, 
        // multi item allowed di joinArray untuk beberapa join sekaligus, ['tabel1','tabel2']
        // select untuk seleksi, dalam bentuk string, contoh = 'akun.nama_akun, dosbing.nama_dosbing'
        // akan me return dalam bentuk array bila single === False, default FALSE
        
        // NOTE : walaupun single false teteap harus memanggil nama kolom nya, single disini maksudnya single row, nah kan di dalam row adal bbrpa kolom
        $builder = $this->db->table($table);
        
        if($joinArray !== NULL){
            $joined = $builder;
            foreach($joinArray as $item){
                $joined = $joined->join($item[0],$item[1]);
            }
        }else{
            $joined = $builder;
        }

        if($select != NULL){
            $selected = $joined->select($select);
        }else{
            $selected = $joined;
        }

        if($condition !== NULL){
            $dataset = $selected->getWhere($condition);
        }else if($condition === NULL){
            $dataset = $selected->get();
        }

        if(count($dataset->getResultArray()) != 0){
            if($single){
                return $dataset->getResultArray()[0];
            }else{
                return $dataset->getResultArray();
            }
        }else{
            return NULL;
        }
    }
}

