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
*/

/*
    PEMANGGILAN SIMPLE TABLE
    view_cell(\App\Libraries\Cells::simple_table,
        [
            'tables' => 
                ['namaTabel1',
                    [
                        ['thead','tbody'],
                        ['thead','tbody'],
                        ['thead','tbody']
                    ]
                ],
                ['namaTabel2',
                    [
                        ['thead','tbody'],
                        ['thead','tbody'],
                        ['thead','tbody']
                    ]
                ]
                
                dst
        ] 
    );

*/


/*
        -----PEMANGGILAN CELLS DATA TABLE -----
    
    view_cell('\App\Libraries\Cells::data_table',
        [
            'config' => 
                [
                    'judul_tabel' => 'judul tabel nya',
                    'id_tabel' => 'id_div_tabel' berguna untuk display block none, adapun display control dilakukan diluar cells, bila diperlukan,
                    'default_display' => 'default display untuk tabel ini, bisa none block dll'
                ]
            'arr_head' =>   
                [
                    ['judul kolom1','boolean'],
                    ['judul_kolom2','boolean'],
                    dst
                ], note: boolean di sini TRUE untuk kolom mutlak ada di phone atau desktop, FALSE bila akan tidak tampil di phone, yg di arr item booleannya juga sama maksudnya
            'head_clickable' => 'judul untuk kolom clickable',
            'arr_item' => 
                [
                    ['~kolom','boolean'],
                    ['~kolom','boolean'],
                    dst
                ], note : ~kolom adalah kolom pada array data
            'arr_clickable' =>
                [
                    [
                        'jenis_icon' => 'jenis_iconnya',
                        'toggle' => 'tulisan ketika dihover',
                        'href' => 'href ketika icon diklik',
                        'class' => class btn, karena tiap class btm punya jquery sendiri2
                        'id' => '~kolom' note : id btn akan diisi secara dinamis, disini bukan diisi id aslinya, tapi diisi ingin gunakan kolom data apa (yang dari array data) sebagai pengisinnya, isikan NULL bila tidak pakai confirm func
                        'confirm_func' => 'nama_function_utk_confirm' note: nanti akan dibuat func jquery sesuai mama disini, isikan null bila tidak perlu confirm
                        'confirm_msg' => "yakin pilih -id ?" note: berikan null bila tidak perlu konfirmasi
                        note lagi : -id nanti akan diagantikan dengan id button
                        
                        'id_clicked' => '~kolom' note : sama,diisi dengan pengisi data dinamis
                        'db_clicked' => nama db yang menjadi objek, bisa '~kolom' atau langsung dinyatakan contohnya 'instansi'
                        note : clicked berguna sebagai penyalur data
                    ],
                    [arr clickable2], dst
                ],
            'is_lama_magang' => boolean true or false,
            'kolom_lama_magang' => '~kolom' kolom mana yang akan dijadikan acuan, note : lama magang harus berformat Angka saja, isi NULL bila tidak pakai
            'data' => arr_data_dari_db, ini yang terpenting agar data dari db bisa ditampilkan
        ]
    );
    note :  yang dimasukkan ke dalam 'data' bisa saja array mentah dari db, ataupun array modifikasi dari db,
            misal di db tidak ada lama magang hanya ada tanggal, maka pastikan untuk
            sudah mengedit array data agar ada data lama magang terlebih dahulu dengan mengoperasikannya di view aslinya
            kemudian buat array baru modifan dari yang asli db. baru array baru itu masukkan di parameter view cell
			
            untuk msg konfirm an akan mengambil dari id btn, di confirm_msg hadus pakai -id

            jenis icon lihat di font google https://fonts.google.com/icons?selected=Material+Icons&icon.query=done

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

    public function simple_table($arrConfig)
    {
        return view('cells/table/simple_table',$arrConfig);
    }

    public function data_table($arrConfig){
        return view('cells/table/data_table',$arrConfig);
    }
}