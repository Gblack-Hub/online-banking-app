<?php session_start();
require ('mycon.php');
	echo $_SESSION['fname'];
	echo $_SESSION['lname'];
	$_SESSION['email'];
	// $_SESSION['acct_no'];
	echo "User Id: ".$_SESSION['user_id'];
	// echo "Acct Id: ".$_SESSION['acct_id'];
    echo "Account Number1: ".$_SESSION['acct_no1'];
    echo "Account Number2: ".$_SESSION['acct_no2'];
	echo "Account Number3: ".$_SESSION['acct_no3'];

	$user_id = $_SESSION['user_id'];
    $acct_no1 = $_SESSION['acct_no1'];
    $acct_no2 = $_SESSION['acct_no2'];
	$acct_no3 = $_SESSION['acct_no3'];
    // $active_acct = $_POST['active_acct'];
    // echo "Active Account: ".$active_acct;
	$fetch = mysqli_query($con,"SELECT acct_type_id, SUM(credit-debit) AS Balance FROM transactions_tb JOIN account_tb USING(acct_number)
                                    WHERE acct_number='$acct_no1' ");
    // SELECT acct_number, acct_type, SUM(credit-debit) AS Balance FROM transactions_tb JOIN account_tb USING(acct_number) WHERE acct_number IN (2001000000, 2001000001, 2001000002)
	$r = mysqli_fetch_array($fetch);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap4/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../assets/fontawesome/css/css/fontawesome-all.min.css">
    <!-- <script src="main.js"></script> -->
    <style type="text/css">
    	body {
    		/*background: url("./images/bg2.jpg");*/
			color: #fff;
    	}
    </style>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
		<a class="navbar-brand" href="#">Gbank</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="#">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="myProfile.php">My Profile</a>
				</li>
                <li class="nav-item">
                    <a class="nav-link" href="accountStatement.php">Account Statement</a>
                </li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Sign Out</a>
				</li>
				<li class="nav-item">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Sign Out</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="logout.php">Sign Out</a>
						<a class="dropdown-item" href="index.html">Sign Up</a>
						<!-- <a class="dropdown-item">Sublink-3</a> -->
					</div>
				</li>
			</ul>
		</div>
    </nav>

    <h2 style="color: black" class="text-center">
    	WELCOME TO YOUR DASHBOARD <br>
    	<?php
    		echo $_SESSION['fname'].' '.$_SESSION['lname'];
    	?>
	</h2>
	<hr>
    <main class="container-fluid" style="color: black">
    	<div class="row">
    		<div class="col-md-4">
    			<h3 class="text-center">OPEN ACCOUNT</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                  Click here to open an account
                </button>
                <!-- The Modal -->
                <div class="modal" id="myModal">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Thanks for Banking with us :)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <!-- Modal body -->
                      <div class="modal-body">
                        <p class="text-center">Which type of account do you wish to open?</p>
                        <form action="acctreg.php" method="POST">
                            <div class="form-group">
                                <select name="acct_type" class="form-control">
                                    <option value="1">Savings</option>
                                    <option value="2">Current</option>
                                    <option value="3">Domiciliary</option>
                                </select>
                            </div>

                      </div>
                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Submit" name="">
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
    		</div>
    		<div class="col-md-4">
    			<h3 class="text-center">MAKE TRANSACTIONS</h3>
                <p class="text-center">ACTIVE ACCOUNT</p>
                <form action="transactions.php" method="POST">
                    <select name="active_acct" class="form-control bg-secondary text-white">
                        <option value="savings">Savings</option>
                        <option value="current">Current</option>
                        <option value="domiciliary">Domiciliary</option>
                    </select>
                    <button type="submit" class="btn">Submit</button>
                </form>
                <hr />
    			<p>Fund my account</p>
    			<form action="transactions.php" method="POST">
    				<input type="number" class="form-control" placeholder="amount" name="deposit">
    				<input type="submit" class="form-control bg-primary text-white" name="">
    			</form>
    			<p>Transfer to other accounts</p>
    			<form action="transactions.php" method="POST">
    				<input type="number" class="form-control" placeholder="amount" name="transfer">
    				<!-- <input type="number" class="form-control"  name="transAcct" placeholder="receipent's account number" value="20132"> -->
    				<input type="number" class="form-control"  name="transAcct" placeholder="receipent's account number" value="2000000">
    				<input type="submit" class="form-control bg-primary text-white" name="">
    			</form>
    			<p>Withdraw from my account</p>
    			<form action="transactions.php" method="POST">
    				<input type="number" class="form-control" placeholder="amount" name="withdraw">
    				<input type="submit" class="form-control bg-primary text-white" name="">
    			</form>
       		</div>
    		<div class="col-md-4">
    			<h3 class="text-center">ACCOUNT INFORMATION</h3>
    			<p>Account Balance</p><h2 class="bg-success p-3" style="border-radius: 5px;"><?php echo "$".$r['Balance']; ?></h2>
    		</div>
    	</div>
    </main>

	<script type="text/javascript" src="../assets/bootstrap4/css/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="../assets/bootstrap4/css/popper.min.js"></script>
	<script type="text/javascript" src="../assets/bootstrap4/js/bootstrap.js"></script>
</body>
</html>
