<?php session_start();
	$user_id = $_SESSION['user_id'];

    require("mycon.php");
    $query_get = mysqli_query($con, "SELECT * FROM user_tb where user_id = $user_id");
    $query_get_account = mysqli_query($con,"SELECT acct_number, acct_type FROM account_tb JOIN account_type_tb USING(acct_type_id) WHERE user_id=$user_id");

    $r = mysqli_fetch_assoc($query_get);
if(isset($_POST['update'])){
	$fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $pnumber = $_POST['pnumber'];
    $gender = $_POST['gender'];

    $file = "uploads/".$_FILES['pix']['name'];
    $fileType = $_FILES['pix']['type'];
    $fileSize = $_FILES['pix']['size'];
    $temp = $_FILES['pix']['tmp_name'];
    // $passport = $_POST['passport'];

    if($con){
        if($fileSize <= 500000){
            // if($fileType == "jpg" || "png" || "jpeg"){
            //     echo "Sorry, only JPG, JPEG and PNG passport photographs are allowed";
            // } else {
                $query = mysqli_query($con, "UPDATE user_tb SET firstname = '$fname', lastname = '$lname', email = '$email',
                												password = '$password', date_of_birth = '$dob', phone_number = '$pnumber',
                												gender = '$gender', passport = '$file' WHERE user_id = $user_id");
                move_uploaded_file($temp, $file);
                if($query){
                	// $msg = "Profile update successful";
                	echo "Profile update successful";
                } else {
                	// $msg = "Update failed, kindly contact our customer care".mysqli_error($con);
                	echo "Update failed, kindly contact our customer care".mysqli_error($con);
                }
                include "login.html";
            // }
        } else {
            echo "Sorry, your passport is too large";
        }
    } else {
        die("connection failed:".mysqli_error($con));
    }
}
#DELETE ACCOUNT SECTION
else if(isset($_POST['deleteAcct'])){
	$id = $_GET[1];
	echo $id;
}
    // // $data = json_decode(file_get_contents('php://input'), true);
    // // $resp = array();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Profile Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php
		include 'links.php';
	?>
</head>
<body>
	<header>
    	<?php
          include "headers.php";
      ?>
   </header>
	<main class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="text-center display-4">MY PROFILE</div>
			</div>
		</div>
		<hr />
		<div class="row">
			<!-- <div class="col-md-3"></div> -->
			<div class="col-md-6">
				<!-- <div><?php #if(isset($msg)){ echo $msg; } ?></div> -->
				<form class="form" action="myProfile.php" method="POST" enctype="multipart/form-data">
					<h5 class="text-center">PERSONAL INFORMATION</h5>
					<label class="mr-sm-2 font-weight-bold">Firstname</label>
					<input type="text" name="fname" class="form-control" value="<?php echo $r['firstname']; ?>" placeholder="Firstname" />
					<label class="mr-sm-2 font-weight-bold">Lastname</label>
					<input type="text" name="lname" class="form-control" value="<?php echo $r['lastname']; ?>" placeholder="Lastname" />
					<label class="mr-sm-2 font-weight-bold">Date of Birth</label>
					<input type="date" name="dob" class="form-control" value="<?php echo $r['date_of_birth']; ?>" placeholder="Date" />
					<label class="mr-sm-2 font-weight-bold">Gender</label> <br />
					<!-- <input type="radio" name="gender" value="male" /> Male
					<input type="radio" name="gender" value="female" /> Female <br /> -->
					<select name="gender" class="form-control">
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>

					<h5 class="text-center">CONTACT INFORMATION</h5>
					<label class="mr-sm-2 font-weight-bold">Phone Number</label>
					<input type="text" name="pnumber" class="form-control" value="<?php echo $r['phone_number']; ?>" placeholder="Phone Number" />
					<label class="mr-sm-2 font-weight-bold">Email</label>
					<input type="email" name="email" class="form-control" value="<?php echo $r['email']; ?>" placeholder="E-mail" /> <br />

					<h5 class="text-center">OTHERS</h5>
					<label class="mr-sm-2 font-weight-bold">Password</label>
					<input type="password" name="password" class="pwd form-control mb-2" value="<?php echo $r['password']; ?>" placeholder="Password" />
					<!-- <input type="checkbox" class="shwPwd" name=""> Show Password -->
					<label class="mr-sm-2 font-weight-bold">Choose Passport</label>
					<input class="form-control" type="file" name="pix" /><br />
					<input type="submit" value="Update Profile" name="update" class="btn btn-primary btn-block">
				</form>
			</div>
			<div class="col-md-6">
				<h5 class="text-center">ACCOUNT(S)</h5>
				<table class="table table-borderles">
					<thead>
						<tr>
							<th>Account</th>
							<th>Account Number</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($r = mysqli_fetch_array($query_get_account)){
							// echo json_encode($r);
							echo "
								<tr>
									<td>".$r[1]."</td>
									<td>".$r[0]."</td>
									<td>"."<a name='deleteAcct' onClick=\"javascript: return confirm('Are you sure you want to delete your ".$r[1]." account?');\" href='delete.php?id=".$r[0]." '><i class='fa fa-trash text-dark'></i></a>"."</td>
								</tr>
							";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
	<footer></footer>

</body>
</html>