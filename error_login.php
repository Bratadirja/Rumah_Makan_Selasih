<?php
	
	$error_login = "Maaf, Anda Salah Mengisikan Username & Password Login Administrator";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Administrator</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div class="main" style="width: 560px;">
		<div class="error_login">
			<img src="images/images_login/img_login_lock.png" width="30" height="31" align="absmiddle" class="img_lock">
			<?php
				echo "$error_login";
			?>
			<br>
			<center>
				<a href="index.php" class="clickhere">ULANG LAGI !</a>	
			</center>

		</div>	

		<div class="vertical_effect">
			&nbsp;
		</div>	
	</div>
</body>
</html>