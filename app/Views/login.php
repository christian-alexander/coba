<!DOCTYPE html>
<head>
    <title><?= TITLE ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <!-- komponen bootstrap -->
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<!-- css lokal -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body id="body-login">
	<div class="container" id='box-login'>
		<div class = teks-login>
			<b><h3><?= TITLE ?></h3></b>
		</div>			
		<form method = "POST" action = "<?= base_url() ?>/Login/auth_login">
			<div id='box-dalam-login'><?php
                foreach(LOGIN_NAMING as $item){ ?>
                    <div>
                        <?= $item['input_text'] ?>
                        <p>
                            <input type = "<?= $item['input_type'] ?>" value ="<?= $item['inside_box'] ?>" 
                            class = "inside-box-login form-control"
							id = "<?= $item['name/id'] ?>"
                            name = "<?= $item['name/id'] ?>"
                            onfocus="if(this.value == '<?= $item['inside_box'] ?>'){this.value = '';}"
                            onblur="if (this.value == '') {this.value = '<?= $item['inside_box'] ?>';}">
                        </p>
                    </div><?php
                } ?>
        		<!-- checkbox lihat password -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="lihat_pass">
                    <label class="custom-control-label" for="lihat_pass">Perlihatkan Password</label>
                </div>
                <a href= "<?= base_url() ?>/Password_manager/Password_recovery" style="color:blue">Lupa Password?</a>		
				
				<div style='margin-top:2em;'>
					<table class='table'>
						<tr>
							<td style='text-align:left;' class='login-table'>
								<a class = "btn btn-success btn-signup tombol-login" style="color: white;" href="<?= base_url() ?>/Signup/Signup">Sign Up</a>
							</td>
							<td style='text-align:right;' class='login-table'>
								<input type = "submit" class = "btn btn-success btn-submit tombol-login" value = "Login">
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</div>


	<!-- jquery -->
	<script src="jquery-3.6.0/jquery-3.6.0.min.js"></script>
	<!-- bootstrap bundle suda dengan popper -->
	<script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js"></script>
	<script src = "<?= base_url()?>/js/script.js"></script>
</body>