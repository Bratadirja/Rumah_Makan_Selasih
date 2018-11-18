<!DOCTYPE html_PUBLIC "-//W3C//DTD XHTML 1.0 Trasitional//EN" "/www.w3.ord/TR/xhtm11-trasitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-889-1">
	<title>Login Administrator</title>
	<link href="css/login.css" rel="stylesheet" type="text/css">

	<script type="text/javascript">
		function validasi(form){
			if(form.username.value == ""){
				alert("Anda belum mengisiskan Username");
				form.username.focus();
				return(false);
			}

			if(form.password.value == ""){
				alert("Anda belum mengisikan Password");
				form.password.focus();
				return(false);
			}

			return(true);
		}
	</script>

</head>
<body OnLoad="document.login.username.focus();">
	<div class="main">
		<!-- Header -->
		<div class="header">
			<h2>Sistem Rumah Makan Selasih</h2>
		</div>

		<!-- Middle-->
		<div class="middle">
			<form class="form-login" name="login" method="post" action="cek_login.php" onSubmit="return validasi(this)">
				<img src="images/images_login/img_login_user.png" align="absmiddle" class="img_user">
				<input type="text" name="username" size="29" class="input">
				<br>

				<img src="images/images_login/img_login_pass.png" align="absmiddle" class="img_pass">
				<input type="password" name="password" size="29" class="input">
				<br>

				<input name="submit" type="image" value="submit" src="images/images_login/button_login.png" class="submit" align="absmiddle">
			</form>
		</div>

		<!-- Footer -->
		<div class="footer">
			Copyright &copy; 2018 Developed by Andika Bratadirja.All rights reserved.
		</div>

		<!-- Vertical_effect -->
		<div class="vertical_effect">
			&nbsp;
		</div>
	</div>

</body>
</html>