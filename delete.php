<?php
require('mycon.php');
$id = $_GET['id'];
if($con){
    $query = mysqli_query($con, "DELETE FROM transactions_tb WHERE acct_number='".$id."'");
    $query2 = mysqli_query($con, "DELETE FROM account_tb WHERE acct_number='".$id."'");
    #DELETE FROM transactions_tb JOIN account_tb USING(acct_number) WHERE acct_number=2000002
    if($query){
    	echo $id." Deleted Successfully";
    } else {
    	echo "Delete Not successful: ". mysqli_error($con);
    }
}
else
{
    echo "Connection not established: ". mysqli_error($con);
}

?>