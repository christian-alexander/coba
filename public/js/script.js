function gantiNNN(){ //pakai function langsung karena perlu dipanggil saat document ready
    if($('#peran_akun').val() == 'dosbing' ){
        $('#teks_no_unik_akun').html('NIDN');
        $('.utkmhs').css("display","none");
    }else if($('#peran_akun').val() == 'pemlap'){
        $('#teks_no_unik_akun').html('NIP(Opsional)');
        $('.utkmhs').css("display","none");
    }else{
        $('#teks_no_unik_akun').html('NRP');
        $('.utkmhs').css("display","block");
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
    if($('#nama_'+tipe).val() == ''){
        $('#warning_nama_'+tipe).html(' *Wajib');
        $('#nama_'+tipe).removeClass('correct');
        $('#nama_'+tipe).addClass('wrong');
        valid = false;
    }else{
        $('#warning_nama_'+tipe).html('');
        var namaValid = true;
        for(var i=0 ; i < $('#nama_'+tipe).val().length ; i++){
            if(! isNaN($('#nama_'+tipe).val()[i]) && $('#nama_'+tipe).val()[i] != ' '){
                $('#warning_nama_'+tipe).html(' *Tidak Boleh Angka');
                $('#nama_'+tipe).removeClass('correct');
                $('#nama_'+tipe).addClass('wrong');
                valid = false;
                var namaValid = false;
                break;
            }
        }
        if(namaValid){
            $('#nama_'+tipe).removeClass('wrong');
            $('#nama_'+tipe).addClass('correct');
        }
    }
    return valid;
}

function verif_email(tipe){
    //validasi email
    var valid = true;
    var emailValid = true;
    if($('#email_'+tipe).val() == ''){
        emailValid = false;
    }else if($("#email_"+tipe).val().indexOf('@') > 0){
        var emailArr = $('#email_'+tipe).val().split('@');
        if(emailArr[0] == ''){
            emailValid = false;
        }else if(emailArr[1] == ''){
            emailValid = false;
        }else{
            if(emailArr[1].indexOf('.') > 0){
                var emailArr2 = emailArr[1].split('.');
                if(emailArr2[0] == '' || emailArr2[1] == ''){
                    emailValid = false;
                }else{
                    emailValid = true;
                }
            }else{
                emailValid = false;
            }
        }
    }else{
        emailValid = false;
    }
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
	if($('#no_'+tipe).val() == ''){
        if( ! isPemlap){
            $('#warning_no_'+tipe).html(' *Wajib');
            $('#no_'+tipe).removeClass('correct');
            $('#no_'+tipe).addClass('wrong');
        	valid = false;
        }
    }else if(isNaN($('#no_'+tipe).val())){
        $('#warning_no_'+tipe).html(' *Harus Angka');
        $('#no_'+tipe).removeClass('correct');
        $('#no_'+tipe).addClass('wrong');
        valid = false;
    }else{
        $('#warning_no_'+tipe).html('');
        $('#no_'+tipe).removeClass('wrong');
        $('#no_'+tipe).addClass('correct');
    }
    return valid;
}

function verif_password(tipe,pass1,pass2 = null){
    //if pass2 null maka dianggap verif typo, if ada value maka verif konfirmasi pass
    var valid = true;
    if(pass2 != null){    
        if($('#konfirmasi_password_'+tipe).val() == ''){
            $('#warning_konfirmasi_password_'+tipe).html(' *Wajib');
            $('#konfirmasi_password_'+tipe).removeClass('correct');
            $('#konfirmasi_password_'+tipe).addClass('wrong');	
            valid = false;
        }else if(pass1 != pass2){
            $('#warning_konfirmasi_password_'+tipe).html(' *Tidak Cocok');
            $('#konfirmasi_password_'+tipe).removeClass('correct');
            $('#konfirmasi_password_'+tipe).addClass('wrong');	
            valid = false;
        }else{
            $('#warning_konfirmasi_password_'+tipe).html('');
            $('#konfirmasi_password_'+tipe).removeClass('wrong');
            $('#konfirmasi_password_'+tipe).addClass('correct');	
        }
    }else{
        if($('#password_'+tipe).val() == ''){
            $('#warning_password_'+tipe).html(' *Wajib');
            $('#password_'+tipe).removeClass('correct');
            $('#password_'+tipe).addClass('wrong');	
            valid = false;
        }else if(pass1.length < 8){
            $('#warning_password_'+tipe).html(' *Minimal 8 Karakter');
            $('#password_'+tipe).removeClass('correct');
            $('#password_'+tipe).addClass('wrong');	
            valid = false;
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
	
    if(required.includes('nama_akun')){valid = verif_nama('akun');}
    if(required.includes('email_akun')){valid = verif_email('akun');}
    if(required.includes('no_wa_akun')){valid = verif_no('wa_akun');}
    if(required.includes('no_unik_akun')){
        if($('#peran_akun') != 'pemlap'){
        	valid = verif_no('unik_akun');
        }else{
            valid = verif_no('unik_akun',true);
        }
    }
    if(required.includes('password_akun')){
        var pass1 = $('#password_akun').val();
        if(required.includes('konfirmasi_password_akun')){
            var pass2 = $('#konfirmasi_password_akun').val();
            valid_konf = verif_password('akun',pass1,pass2);
        }
        valid_pass = verif_password('akun',pass1);
    }
    if(valid_pass && valid_konf){    
        return true;
    }else{
        return false;
    }
}

function verif_dobel_data_akun(for_auth,required ,edit_data = null){
    // edit_data[0] = email_logged_user, edit_data[1] = no_unik_logged_user
    // akan me return required untuk verif typo
    // bila ada email atau no unik tak valid maka akan dikurangi dari required, karena hitungannya sudah dicek

    var valid_email = true;
    var valid_no_unik = true;
    for(var i = 0 ; i < for_auth.length ; i++){
        if(edit_data != null){
            if($("#email_akun").val() == for_auth[i][0] && $("#email_akun").val() != edit_data[0]){
                valid_email = false;
            }

            if($("#no_unik_akun").val() == for_auth[i][1] && $("#no_unik").val() != edit_data[1]){
                valid_no_unik = false;
            }
        }else{
            if($("#email_akun").val() == for_auth[i][0]){
                valid_email = false;
            }
            if($("#no_unik_akun").val() == for_auth[i][1]){
                valid_no_unik = false;
            }
        }
    }
    if( ! valid_email && ! valid_no_unik){
        $("#warning_no_unik_akun").html(' *Gunakan Lainnya');
        $('#no_unik_akun').removeClass('correct');
        $('#no_unik_akun').addClass('wrong');	

        $("#warning_email_akun").html(' *Gunakan Lainnya');
        $('#email_akun').removeClass('correct');
        $('#email_akun').addClass('wrong');
        for(var i = 0 ; i < required.length ; i++){
            if(required[i] == 'no_unik_akun' || required[i] == 'email_akun'){
                required.splice(i,1);
            }
        }
    }else if( ! valid_email){
        $("#warning_email_akun").html(' *Gunakan Lainnya');
        $('#email_akun').removeClass('correct');
        $('#email_akun').addClass('wrong');	
        for(var i = 0 ; i < required.length ; i++){
            if(required[i] == 'email_akun'){
                required.splice(i,1);
            }
        }
    }else if( ! valid_no_unik){
        $("#warning_no_unik_akun").html(' *Gunakan Lainnya');
        $('#no_unik_akun').removeClass('correct');
        $('#no_unik_akun').addClass('wrong');

        for(var i = 0 ; i < required.length ; i++){
            if(required[i] == 'no_unik_akun'){
                required.splice(i,1);
            }
        }
    }else{
        $("#warning_email_akun").html('');
        $('#email_akun').removeClass('wrong');
        $('#email_akun').addClass('correct');	

        $("#warning_no_unik_akun").html('');
        $('#no_unik_akun').removeClass('wrong');
        $('#no_unik_akun').addClass('correct');	
    }
    return required;
}

