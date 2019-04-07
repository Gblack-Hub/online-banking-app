<?php session_start();
if(isset($_POST['acct_type'])){
	$con = mysqli_connect("localhost","root","","bank_db");
	#variables
	$date = date("d-M-Y"); #acct creation date
	$acct_type = $_POST['acct_type']; #acct type
	$user_id = $_SESSION['user_id']; #current user id
	// echo "User_id: ".$user_id;
	// $acct_no = mt_rand(10000,99999); #new account number

	if(!empty($acct_type)){
		#check first, if acct_type already exist;
		$check_acct = mysqli_query($con, "SELECT * FROM account_tb WHERE acct_type_id='$acct_type' AND user_id='$user_id' ");
		$check_acct_result = mysqli_num_rows($check_acct);
		if($check_acct_result > 0){
			#replaces acct_type_id with their names
			if($acct_type == 1){
				$acct_type_name = "savings";
			} else if($acct_type == 2){
				$acct_type_name = "current";
			} else if($acct_type == 3){
				$acct_type_name = "domiciliary";
			}
			echo "You already have a ".$acct_type_name." account, please open another account type";
		} else {
			#if the account doesn't exist, create a new account...
			$query = mysqli_query($con, "INSERT into account_tb (acct_type_id,acct_status,acct_balance,opening_date,user_id)
									  VALUES ('$acct_type','active',1000,current_date(),'$user_id')"); //inserts acct info to generate acct_id

			if($query){
				$fetch_id = mysqli_query($con, "SELECT acct_number FROM account_tb WHERE user_id='$user_id'");
				$fetch_id_result = mysqli_num_rows($fetch_id);
				if($fetch_id_result > 0){
					while ($r = mysqli_fetch_assoc($fetch_id)){
						// $fetched_id = $r['acct_id']; #fetches the newly generated acct_id for use
						$_SESSION['acct_no'] = $r['acct_number'];
						$acct_no = $_SESSION['acct_no'];
						// $_SESSION['acct_no'] = $fetched_acct_no;
						// $acct_id = $_SESSION['acct_id']; #saves the new acct_id into variable $acct_id

					}
					#inserts acct_id with transactions info
					$query_create_trans = mysqli_query($con, "INSERT into transactions_tb (trans_by, debit, credit, balance, trans_date, acct_number) VALUES ('$user_id','',1000,1000,current_date(),'$acct_no')");
					if($query AND $query_create_trans){
						echo "Account creation was successfull";
					} else {
						echo "ERROR: Account Details not successfully created, please contact our customer care ".mysqli_error($con);
					}
				}

			}
		}

	} else {
		echo mysqli_error($con);
	}

}

?>
