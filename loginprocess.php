<?php session_start();
require('mycon.php');

$email = $_POST['email'];
$pwd = $_POST['pwd'];

if(!empty($email) AND !empty($pwd)){
	if($con){
		$query = mysqli_query($con, "SELECT user_id, firstname, lastname, email, password FROM user_tb
										WHERE email='$email' AND password='$pwd'");
		$result = mysqli_num_rows($query);
		if($result > 0){
			$r = mysqli_fetch_array($query);
			$user_id = $r['user_id'];
			$fname = $r['firstname'];
			$lname = $r['lastname'];
			$email2 = $r['email']; #used for #query2
			$pwd2 = $r['password']; #used for $query2

			$_SESSION['user_id'] = $user_id;
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;
			$_SESSION['email'] = $email2;

			#performs this second query if the user already has a bank account with the bank
			// $query2 = mysqli_query($con, "SELECT user_id, firstname, lastname, email, acct_number, password FROM account_tb
			// 	 	 						JOIN user_tb USING(user_id) WHERE email='$email2' AND password='$pwd2'");
			// $result1 = mysqli_num_rows($query2);

			// if($result1 >= 0){
			// 	while($r2 = mysqli_fetch_all($query2)){
			// 		echo json_encode($r2);
			// 		#user account info
			// 		$acct_number1 = $r2[0][4]; #stores the first acount number of the user
			// 		$acct_number2 = $r2[1][4]; #stores the second acount number of the user
			// 		$acct_number3 = $r2[2][4]; #stores the third acount number of the user
			// 		#user personal info
			// 		// $id = $rr[0][0]; #user_id
			// 		// $fname = $r2[0][1]; #firstname
			// 		// $lname = $r2[0][2]; #lastname

			// 		// echo $_SESSION['acct_id'];
			// 		echo $_SESSION['acct_no1'] = $acct_number1;
			// 		echo $_SESSION['acct_no2'] = $acct_number2;
			// 		echo $_SESSION['acct_no3'] = $acct_number3;
			// 	}
			// }
			header("Location: dashboard1.php");
		} else {
			echo "ERROR: Incorrect Login Details, please enter the correct details".mysqli_error($con);
			// echo $_SESSION['email'];
			// echo $email2;
			// echo $pwd;
			include "login.php";
		}
	} else {
		echo "not connected";
	}
}
?>
