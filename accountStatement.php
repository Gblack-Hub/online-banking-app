<?php session_start();
	require('mycon.php');
	$user_id = $_SESSION['user_id'];
   // $acct_no1 = $_SESSION['acct_no1'];

    if(isset($_SESSION['acct_no1'])){
		// echo $ans['acct_number'];
    	$query_get_acct = mysqli_query($con, "SELECT acct_number, acct_type FROM account_tb JOIN account_type_tb USING(acct_type_id) WHERE user_id=$user_id");
    	$result_get_acct = mysqli_num_rows($query_get_acct);

    	#trying to get all current user's account and loop through it in the select area

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Account Statement</title>
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
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="text-center text-white display-4">ACCOUNT STATEMENT</div>
			</div>
		</div>
		<div class="text-center h5 mt-2"></div>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6 mb-4">
				<form action="accountStatement.php" method="POST">
				<?php
					if($result_get_acct >= 0){
						echo "<select class='form-control' id='acct_select'>";
			    		while($ans = mysqli_fetch_assoc($query_get_acct)){
					    	echo "<option value=".$ans['acct_number'].">".$ans['acct_type']."</option>";
					    	$acct_number_select = $ans['acct_number'];
						}
						echo "</select>";
			    	}

					echo "<button type='submit' name='acct_selected' id='acct_selected' class='btn btn-block'>Submit</button>";
				?>
				</form>
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="row">
			<table border="1" class="table table-responsive-sm table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th>SN</th>
						<th>MADE BY</th>
						<th>DEBITS</th>
						<th>CREDITS</th>
						<th>BALANCE</th>
						<th>DATE</th>
					</tr>
				</thead>
				<tbody>
					<?php
    				#displays the selected account's statement
					$query = mysqli_query($con, "SELECT * FROM transactions_tb t join user_tb u on (t.trans_by = u.user_id) WHERE acct_number=$acct_number_select");
					$no = 0;
						while ($r = mysqli_fetch_array($query)) {
							$no++;
							echo "
								<tr>
									<td>".$no."</td>
									<td>".$r['firstname']." ".$r['lastname']."</td>
									<td>".$r['debit']."</td>
									<td>".$r['credit']."</td>
									<td>".$r['balance']."</td>
									<td>".$r['trans_date']."</td>
								</tr>
							";
						}
						} else {
							include 'links.php';
							include "headers.php";
					    	echo "<div class='alert alert-warning text-center
					    	'>
										<span>Sorry, You have no account with our bank, click <a href='dashboard1.php'>here</a> to open an account</span>
									</div>".mysqli_error($con);
					    }
					?>
				</tbody>
			</table>
		</div>
		<div>
			<div class="text-center">
				<button class="btn">Print this statement</button>
			</div>
		</div>
	</main>
	<footer>

	</footer>

</body>
</html>
<!-- <?php
	// echo "
	// 	<script language='javascript'>
	// 		document.getElementById('acct_selected').onclick = function(){
	// 			// alert(acct_select.value);
	// 			acct_select_display.innerHTML = acct_select.value;
	// 		}
	// 	</script>
	// ";
?> -->