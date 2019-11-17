<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
    	include 'links.php';
	?>
	<style type="text/css">
		body {
			background: url("images/bg1.jpg");
		color: #fff;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
			<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 py-auto">
				<div id="signup_div">
					<h1 class="text-center p-2 text-white"><span class="text-danger">USER</span>SIGNUP</h1>
					<form action="signupprocess.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<input type="text" name="fname" class="form-control" placeholder="Firstname" required>
						</div>
						<div class="form-group">
							<input type="text" name="lname" class="form-control" placeholder="Lastname">
						</div>
						<div class="form-group">
							<input type="email" name="email" class="form-control" placeholder="E-mail" required>
						</div>
						<div class="form-group">
							<input type="password" name="password" id="pwd" class="form-control" placeholder="Password" required>
							<input type="checkbox" class="shwPwd" name=""> Show Password
						</div>
						<div class="form-group">
							<input type="date" name="dob" class="form-control" placeholder="Date" required>
						</div>
						<div class="form-group">
							<input type="text" name="pnumber" class="form-control" placeholder="Phone Number" required>
						</div>
						<div class="form-group-inline">
							<label>Gender</label>
							<input type="radio" name="gender" value="male" checked> Male
							<input type="radio" name="gender" value="female"> Female
						</div>
						<div class="form-group">
							<label>Choose Passport</label>
							<div><small>file name must not be more than 15 characters long</small></div>
							<label class="form-control" style="cursor: pointer;">Choose file
								<input class="d-none" type="file" name="pix">
							</label>
						</div>
						<div class="form-group text-center">
							<input type="submit" value="Sign Up" class="btn btn-primary btn-block">
						</div>
					</form>
					<center>Already a member? <a href="login.php" class="btn bg-secondary text-white">Log In</a>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
		</div>
	</div>
	<script type="text/javascript" src="../bootstrap/js/jquery-3.2.1.js"></script>
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
	<script>
		$('.shwPwd').click(function(){
			var x = document.getElementById("pwd");
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
