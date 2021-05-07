<?php
namespace App\Controllers\TPPI;
use App\Controllers\BaseController;
use App\Models\Get;
use App\Models\AddEditDelete;

class Template extends BaseController
{
    public function form_template(){
        if($this->filter_user(['su'])){
			$Get = new Get();
            $data['template'] = $Get->get('template_izin',NULL,NULL,['id_template_izin' => 1],TRUE);
            return view('tppi/form_template_izin',$data);
        }
    }

    public function save_new_template(){
        if($this->filter_user(['su'])){
            $AddEditDelete = new AddEditDelete();

            $data = [
                'subjek_email_template_izin' => $_REQUEST['subjek_email'],
                'isi_email_template_izin' => $_REQUEST['isi_email']
            ];

            $AddEditDelete->edit('template_izin',$data,'id_template_izin',1);

            $alertBox['path'] = 'TPPI/Template/form_template';
            $alertBox['message'] = 'Berhasil mengubah template';
            return view('alertBox',$alertBox);
        }
    }
}