<?php session_start();
require('mycon.php');

$date = date("d-M-Y"); #acct creation date
$user_id = $_SESSION['user_id']; #stores the user_id of the current user
$acct_no = $_SESSION['acct_no1']; #User account id
// $active_acct = $_POST['active_acct'];

#DEPOSIT SECTION
if(isset($_POST['deposit'])){
	$deposit = $_POST['deposit'];
	#gets balance from transactions_tb for update per transaction;
	$query_bal = mysqli_query($con, "SELECT SUM(credit-debit) AS Balance from transactions_tb where acct_number=$acct_no");
	$query_bal_res = mysqli_fetch_assoc($query_bal);
	$balance = $query_bal_res['Balance'] + $deposit;
	#gets sender's balance from account_tb for update per transaction;
	$query_get_bal = mysqli_query($con, "SELECT acct_balance FROM account_tb WHERE acct_number = $acct_no ");
	$query_get_bal_result = mysqli_fetch_assoc($query_get_bal);
	$acct_balance = $query_get_bal_result['acct_balance'];
	#performs insert into transactions_tb
	$query_deposit = mysqli_query($con, "INSERT INTO transactions_tb (trans_by,debit,credit,balance,trans_date,acct_number)
											VALUES ('$user_id',' ','$deposit','$balance',current_date(),'$acct_no')");
	// echo $active_acct;
	// $query_trans_info = mysqli_query($con,"INSERT into transactionsinfo_tb
	// 										(info_type,info_amount,info_by,info_from,info_to,info_date,info_time) VALUES
	// 										('deposit','$deposit','you','','your account',current_date(),'6:43pm')");
	if($query_deposit){
		$upd_status = false;
		$update_bal = $acct_balance + $deposit;
		$query_update_balance = mysqli_query($con, "UPDATE account_tb SET acct_balance = $update_bal WHERE acct_number = $acct_no");
		if($query_update_balance){$upd_status = true;} else {echo "balance update not successful".mysqli_error($con);}
		echo $deposit." deposited successfully";
		// header ('location: dashboard1.php');
		// print "<script>alert('$deposit deposited successfully')</script>";
		// echo "<script>alert('$deposit deposited successfully')</script>";
	} else {
		echo "Deposit Not successful";
		echo mysqli_error($con);
	}
}
#TRANSFER SECTION
else if(isset($_POST['transfer'])){
	$transfer = $_POST['transfer'];
	$transAcct = $_POST['transAcct'];

	if(!empty($transfer)){
		$query_get_sender_acct = mysqli_query($con, "SELECT debit, credit, SUM(credit-debit) AS Balance, acct_number FROM transactions_tb JOIN account_tb USING(acct_number) WHERE acct_number= $acct_no ");
															//query fetches the balance and account number of the sender
		$r = mysqli_fetch_assoc($query_get_sender_acct);
		// echo json_encode($r);
		$senderBalance = $r['Balance']; #fetches balance of the sender
		$senderAcctNo = $r['acct_number'];
		if($transAcct == $senderAcctNo){
			echo "You cannot transfer to your own account, please use the deposit section";
		} else {
			$query_verify_dest_acct = mysqli_query($con, "SELECT acct_number, user_id FROM account_tb WHERE acct_number='$transAcct' ");
															#query checks if destiation account exists and gets its user_id
			$query_verify_dest_acct_result = mysqli_num_rows($query_verify_dest_acct);
			if($query_verify_dest_acct_result > 0){
				$ree = mysqli_fetch_assoc($query_verify_dest_acct);
				$dest_user_id = $ree['user_id'];
				if($senderBalance < $transfer){ #checks if the sender's acct balance is enough
					echo "Insufficient Balance";
				} else {
					$query_bal = mysqli_query($con, "SELECT user_id, SUM(credit-debit) AS Balance from account_tb JOIN transactions_tb USING(acct_number) WHERE acct_number=$senderAcctNo");
					$query_bal_res = mysqli_fetch_assoc($query_bal);
					$debit_balance = $query_bal_res['Balance'] - $transfer;
					#gets balance from account_tb for update per transaction;
					$query_get_bal = mysqli_query($con, "SELECT acct_number, acct_balance FROM account_tb WHERE acct_number IN($acct_no, $transAcct)");
					$query_get_bal_result = mysqli_fetch_all($query_get_bal);

					$acct_balance_user = $query_get_bal_result[0][1]; #sender's account fetched
					$acct_balance_receiver = $query_get_bal_result[1][1]; #receiver's account fetched
					#debit the sender with $transfer and update balance to $debit_balance
					$query_insert_debit = mysqli_query($con, "INSERT into transactions_tb (trans_by, debit, credit, balance, trans_date, acct_number) VALUES ('$user_id','$transfer','','$debit_balance',current_date(),'$acct_no')");

					$query_dest_bal = mysqli_query($con, "SELECT user_id, SUM(credit-debit) AS Balance from account_tb JOIN transactions_tb USING(acct_number) WHERE acct_number=$transAcct");
					$query_dest_bal_res = mysqli_fetch_assoc($query_dest_bal);
					$dest_debit_balance = $query_dest_bal_res['Balance'] + $transfer;
					#credits the receiver
					$query_insert_credit = mysqli_query($con, "INSERT into transactions_tb (trans_by, debit, credit, balance, trans_date, acct_number) VALUES ('$user_id','','$transfer','$dest_debit_balance',current_date(),'$transAcct')");

					if($query_insert_debit AND $query_insert_credit){
						if($query_get_bal){
							$upd_status = false;
							$update_bal = $acct_balance_user - $transfer;
							$update_bal2 = $acct_balance_receiver + $transfer;
							#updates the sender's account
							$query_update_balance = mysqli_query($con, "UPDATE account_tb SET acct_balance = $update_bal
																			WHERE acct_number = $acct_no");
							#updates the receiver's account
							$query_update_balance2 = mysqli_query($con, "UPDATE account_tb SET acct_balance = $update_bal2
																			WHERE acct_number = $transAcct");
							if($query_update_balance & $query_update_balance2)
								{$upd_status = true;} else {echo "balance update not successful".mysqli_error($con);}
						}
						echo $transfer." Sent successfully!";
					} else {
						echo "ERROR: Transfer Not Successful!";
						echo mysqli_error($con);
					}
				}
			} else {
				echo "Destination account does not exist, please check the account number again";
			}
		}
	} else {
		echo "Please enter amount to transfer!";
	}
}
#WITHDRAWAL SECTION
else if(isset($_POST['withdraw'])){
	$withdraw = $_POST['withdraw'];

	if(!empty($withdraw)){
		$query_get_sender_acct = mysqli_query($con, "SELECT debit, credit, SUM(credit-debit) AS Balance FROM transactions_tb
														WHERE acct_number=$acct_no "); #fetches the user's acct balance
		$r = mysqli_fetch_array($query_get_sender_acct);
		$userBalance = $r['Balance'];
		if($userBalance < $withdraw){ #checks if the users have enough balance to withdraw
			echo "Insufficient Fund";
		} else {
			#gets sender's balance from account_tb for update per transaction;
			$query_get_bal = mysqli_query($con, "SELECT acct_balance FROM account_tb WHERE acct_number = $acct_no ");
			$query_get_bal_result = mysqli_fetch_assoc($query_get_bal);
			$acct_balance = $query_get_bal_result['acct_balance'];

			$query_bal = mysqli_query($con, "SELECT user_id, SUM(credit-debit) AS Balance from account_tb JOIN transactions_tb USING(acct_number) WHERE acct_number=$acct_no");
				$query_bal_res = mysqli_fetch_assoc($query_bal);
				$debit_balance = $query_bal_res['Balance'] - $withdraw;
			$query_withdraw = mysqli_query($con, "INSERT INTO transactions_tb (trans_by, debit, credit, balance, trans_date, acct_number)
													VALUES ('$user_id','$withdraw','','$debit_balance',current_date(),'$acct_no')");
													#adds amount to debit
			if($query_withdraw){
				$upd_status = false;
				$update_bal = $acct_balance - $withdraw;
				$query_update_balance = mysqli_query($con, "UPDATE account_tb SET acct_balance = $update_bal
																WHERE acct_number = $acct_no");
				if($query_update_balance){$upd_status = true;} else {echo "balance update not successful".mysqli_error($con);}
				echo "You have successfully withdrawn ".$withdraw;
			} else {
				echo "ERROR: Transaction not conpleted ". mysqli_error($con);
			}
		}
	} else {
		echo "Enter an amount to withdraw";
	}
}
#ACCOUNT BALANCE SECTION
else if(isset($_POST['acctBalance'])){
	$query_acct_balance = mysqli_query($con,"SELECT SUM(credit-debit) AS Balance FROM transactions_tb WHERE acct_number=$acct_no");
											 #fetches new debit amount for use
	$r = mysqli_fetch_array($query_acct_balance);
		$accountBalance = $r[0]['Balance']; #fetches balance of the user
		echo "Your Account Balance is: ".$accountBalance;
}
?>