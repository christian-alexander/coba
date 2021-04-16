<?php //var_dump($_SESSION['captcha']); ?>
    <div id="body-login" style="position:fixed;width:100%;height:100%;">
        <div class="container" id='box-login' style="background-color:white;">
            <div id='box-dalam-login'>
                <div class = teks-login>
                    <b><h3>Verifikasi Email</h3></b>
                </div>		
                <div style = 'text-align:center;font-size:14pt;'>
                    Klik link yang kami kirimkan ke email anda <b><?= $_SESSION['email'] ?></b> untuk melanjutkan.
                </div>
                <div style = "text-align:center;margin-top:20px;color:rgba(256,0, 0, 0.7)">
                    Buka link di browser dan perangkat yang sama dengan yang anda gunakan saat ini.
                </div>
                <div class="kirim-lagi-div" id='countdown'>
                    <p>Tidak menerimanya? kirim lagi dalam <b id='timer'> 60 </b> Detik</p>
                </div>
                <div class="div-tombol" id='resend-now' style='display:none;'>
                    <a style="margin-top:10px;color:white;" class = "btn btn-primary tombol" onclick="reload()">Kirim Lagi</a>
                </div>
                <?php
                session()->get();
                ?>
            </div>
        </div>
    </div>

    <!-- loading bar -->
    <div id = 'bg-for-loading'>
        <div id = 'lds-dual-ring'></div>
    </div>

    <script>
        
        function reload(){
            $('#bg-for-loading').css('display','block');
            $('#lds-dual-ring').css('display','inline-block');
            location.reload();
        }
        
        //untuk countdown
        var akhir = new Date().getTime()+60100;
        var x = setInterval(function(){
            var awal = new Date().getTime();
            var rentang = Math.floor((akhir - awal)/1000);

            var timer = document.getElementById('timer');
            timer.innerHTML = rentang ;

            if(rentang < 0){ 
                clearInterval(x);
                document.getElementById('countdown').style.display = 'none';
                document.getElementById('resend-now').style.display = 'block'; 
            }
        },1000);
    </script>