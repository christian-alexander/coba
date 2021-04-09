<?php namespace App\Libraries;

/*
    ------------  CARA PEMANGGILAN CELLS FORM ---------------
    view_cell('\App\Libraries\Cells::form_akun',
    [
        'config' => ['form_title' => '(judul form)', 'form_action' => "(form ini mau dibawa kemana ketika submit)",'show_password' => TRUE/FALSE (pake see password atau ga), 'use_box' => TRUE / FALSE (box include with form) ],
        'required' => [
            ['nama_akun','email_akun'],
            ['display1','display2']
        ];
        'peran_display' => ['relative','none','relative'], 
        'button' => [
            ['button_type' => 'btn-success', 'button_text' => '(teks dalam btn)'],
            ['button_type' => 'btn-danger', 'button_text' => '(teks dalam btn)', 'button_action' => "(lokasi bila btn di-klik, tidak diperlukan bila btn default form)"]
        ], (button type menggunakan tipe2 button BootStrap4)
        'live_search' => ['instansi' => $instansi,'dosbing' => $dosbing] ini hanya meneruskan data yang dari controller
        'for_auth' => array_for_auth yang dari BaseController
        'is_edit_form => boolean, is edit form atau tidak
    ]
); 
- config adalah berisi array lagi form_title dan form_action, dan kondisi perlu checkbox lihat pass or no (default FALSE)
    bila value di config di kosongi dianggap tidak pakai, bila pakai bool nya di set TRUE, untuk form_title dan form_action bila tidak diisi dianggap tidak apa2 selama use_box FALSE atau tidak dinyatakan
- required adalah array lagi apa saja yang diperlukan dari FORM_AKUN_NAMING yang tersedia
- display adalah array numerik berisi display default dari masing2 required
- peran display, opsional, diperlukan bila terdapat seleksi peran, valuenya display dari dosbing, pemlap, dan mhs scr berurutan
- button adalah array sederet button yang diperlukan, berisi array lagi (numerik) dan array lagi (assoc) yang berisi button_type, button_text, dan button_action, bila ada, default action null untuk mendeteksi button default untuk form tsb
- live_search adalah array untuk memasukkan komponen data live search, yang sebelumnya didapat dari controllernya
   live search naming selalu paten yaitu dosbing,pemlap,dan instansi, jangan gunakan nama yang lain
- for_auth untuk mengecek ada dobelan data atau tidak di database
*/


class Cells
{
    public function look_ur_email()
    {
        return view('cells/verif_link/look_ur_email');
    }

    public function form_akun($arrConfig)
    {
        return view('cells/forms/akun',$arrConfig);
    }

    
    public function nav_su($selected_nav_item)
    {
        return view('cells/nav/nav_su',$selected_nav_item);
    }

    
    public function nav_dosbing($selected_nav_item)
    {
        return view('cells/nav/nav_dosbing',$selected_nav_item);
    }
    
    public function nav_pemlap($selected_nav_item)
    {
        return view('cells/nav/nav_pemlap',$selected_nav_item);
    }
    
    public function nav_mhs($selected_nav_item)
    {
        return view('cells/nav/nav_mhs',$selected_nav_item);
    }
}