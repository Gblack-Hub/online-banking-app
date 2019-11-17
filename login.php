<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
    include 'links.php';
	?>
    <style type="text/css">
    	body {
    		background: url("images/bg1.jpg");
			color: #fff;
			margin-top: 22vh;
    	}
    </style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
			<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
				<div id="login_div">
					<form action="loginprocess.php" method="POST">
						<h1 class="text-center p-2 text-white"><span class="text-success">USER</span>LOGIN</h1>
						<div class="form-group">
							<input type="email" name="email" class="form-control mb-4" placeholder="Email" required />
						</div>
						<div class="form-group">
							<input type="password" name="pwd" id="pwd" class="form-control" placeholder="Password" required />
							<input type="checkbox" class="shwPwd" name="" /> Show Password
						</div>
						<div class="form-group text-center mb-0">
							<input type="submit" value="Login" name="" class="btn btn-primary btn-block" />
						</div>
					</form>
					<center>
						<a class="text-white" href="signup.php" style="float:left;">Sign Up</a>
						<a class="text-white" style="float:right;" href="#">Forgot Password?</a>
					</center>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
		</div>
	</div>
	<script type="text/javascript" src="../bootstrap/js/jquery-3.2.1.js"></script>
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
	<script>
		$('.shwPwd').click(function(){
			// alert(this.type);
			var x = document.getElementById("pwd");
			alert(x);
			if(x.type ==='password'){
				x.type = 'text';
			}
			else{
				x.type = 'password';
			}
		})
	</script>
	<script type="text/javascript" src="../bootstrap/js/popper.js"></script>

	<!-- <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> -->
</body>
</html>
