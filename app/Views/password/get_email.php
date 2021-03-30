<form method = "post" action = "<?= base_url() ?>/Password_manager/Password_recovery/auth">
    <input type = "text" style = "display:none;" id= "email" name = "email" value="">
    <button id = "klik" style ="display:none"></button>
</form>
<script>
    var email = prompt("Masukkan email anda yang terdaftar di sistem untuk mereset password")
    if(email == null || email == ""){
        window.location = '<?= base_url() ?>';
    }else{
        document.getElementById('email').value = email;
        document.getElementById('klik').click();
    }
</script>