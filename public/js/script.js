function gantiNNN(){ //pakai function langsung karena perlu dipanggil saat document ready
    if($('#peran_akun').val() == 'dosbing' ){
        $('#teks_no_unik_akun').html('NIDN');
        $('.utkmhs').css("display","none");
        $('.select_utkmhs').prop("disabled", true);
        //selectpicker perlu direfresh setelah diganti statusnya
        $('.selectpicker').selectpicker('refresh');
    }else if($('#peran_akun').val() == 'pemlap'){
        $('#teks_no_unik_akun').html('NIP (Opsional)');
        $('.utkmhs').css("display","none");
        $('.select_utkmhs').prop("disabled", true);
        //selectpicker perlu direfresh setelah diganti statusnya
        $('.selectpicker').selectpicker('refresh');
    }else{
        $('#teks_no_unik_akun').html('NRP');
        $('.utkmhs').css("display","block");
        $('.select_utkmhs').prop("disabled", false);
        //selectpicker perlu direfresh setelah diganti statusnya
        $('.selectpicker').selectpicker('refresh');
    }
}

$('#lihat_pass').click(function(){
    if(this.checked){
        $('#password_akun').attr('type','text');
        $('#konfirmasi_password_akun').attr('type','text');
    }else{
        $('#password_akun').attr('type','password');
        $('#konfirmasi_password_akun').attr('type','password');
    }
    // toggle mungkin berguna, jika ter check maka akan tampil, else no tampil
    //$('.input-box').toggle(this.checked);
    //$('#konfirmasi_password_akun').toggle(this.checked)
});

//fungsi2 verifikasi
function verif_nama(tipe){
    //validasi nama
    var valid = true;
    var nameReg = /^([a-z,A-Z, ])+?$/;
    valid = nameReg.test( $('#nama_'+tipe).val() );
    
    if(valid){
        $('#warning_nama_'+tipe).html('');
        $('#nama_'+tipe).removeClass('wrong');
        $('#nama_'+tipe).addClass('correct');
    }else{
        $('#warning_nama_'+tipe).html(' *Nama Tidak Valid');
        $('#nama_'+tipe).removeClass('correct');
        $('#nama_'+tipe).addClass('wrong');
    }
    
    return valid;
}

function verif_email(tipe){
    //validasi email
    var valid = true;
    var emailValid = true;

    var emailReg = /^([\w\.]+@([\w-]+\.)+[\w-]{2,4})+?$/;
    emailValid = emailReg.test( ($('#email_'+tipe).val()) );    
    
    if( ! emailValid){
        $('#warning_email_'+tipe).html(' *Email Tidak Valid');
        $('#email_'+tipe).removeClass('correct');
        $('#email_'+tipe).addClass('wrong');
        valid = false;
    }else{
        $('#warning_email_'+tipe).html('');
        $('#email_'+tipe).removeClass('wrong');
        $('#email_'+tipe).addClass('correct');
    }
	return valid;
}

function verif_no(tipe,isPemlap = false){
    //verif no
    //karena ada perbedaan antara akun dan instansi, maka di tipe sertakan wa_akun atau fax_instansi atau telepon_instansi
    //ispemlap default false, tujuan utk memeriksa no unik pemlap
    var valid = true;
    
    var noReg = /^([0-9]{8,20})$/;
    var noRegPemlap = /^([0-9]{0,20})$/;
	
    if(isPemlap){
        valid = noRegPemlap.test( $('#no_'+tipe).val() );
    }else{
        valid = noReg.test( $('#no_'+tipe).val() );
    }
    
    if(valid){
        $('#warning_no_'+tipe).html('');
        $('#no_'+tipe).removeClass('wrong');
        $('#no_'+tipe).addClass('correct');
    }else{
        $('#warning_no_'+tipe).html(' *Min 8 Angka');
        $('#no_'+tipe).removeClass('correct');
        $('#no_'+tipe).addClass('wrong');
    }

    return valid;
}

function verif_password(tipe,pass1,pass2 = null){
    //if pass2 null maka dianggap verif typo, if ada value maka verif konfirmasi pass
    var valid = true;
    if(pass2 != null){    
        if(pass1 != pass2 || pass1 == ""){
            $('#warning_konfirmasi_password_'+tipe).html(' *Tidak Cocok');
            $('#konfirmasi_password_'+tipe).removeClass('correct');
            $('#konfirmasi_password_'+tipe).addClass('wrong');	
            valid = false;
        }
    }else{
        var passReg = /^(.{8,})$/;
        valid = passReg.test( $('#password_'+tipe).val() );

        if( ! valid){
            $('#warning_password_'+tipe).html(' *Minimal 8 Karakter');
            $('#password_'+tipe).removeClass('correct');
            $('#password_'+tipe).addClass('wrong');	
        }else{
            $('#warning_password_'+tipe).html('');
            $('#password_'+tipe).removeClass('wrong');
            $('#password_'+tipe).addClass('correct');	
        }
    }
    return valid;
}

//fungsi utama verifikasi
function verif_typo_akun(required){
    var valid = true;
	
    if(required.includes('nama_akun')){if(!verif_nama('akun')){valid = false;};}
    if(required.includes('email_akun')){if(!verif_email('akun')){valid = false;};}
    if(required.includes('no_wa_akun')){if(!verif_no('wa_akun')){valid = false;};}
    if(required.includes('no_unik_akun')){
        if($('#peran_akun').val() != 'pemlap'){
        	if(!verif_no('unik_akun')){valid = false;};
        }else{
            if(!verif_no('unik_akun',true)){valid = false;};
        }
    }
    if(required.includes('password_akun')){
        var pass1 = $('#password_akun').val();
        if(required.includes('konfirmasi_password_akun')){
            var pass2 = $('#konfirmasi_password_akun').val();
            valid_konf = verif_password('akun',pass1,pass2);
        }
        valid_pass = verif_password('akun',pass1);
        if(valid_pass && valid_konf){    
            //nothing karena valid
        }else{
            valid = false;
        }
    }
    return valid;

}