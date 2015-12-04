<?php
	session_start();

	ini_set('display_errors', 'On');

  if(!isset($_SESSION['logged_in_status'])) {
	 	header("Location: signin.php");
	 	exit();
	}

 	require "./db_connect.php";
 	require "./navigation.php";

if(!$mysqli || $mysqli->connect_errno){
 	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}	

 	if(!($stmt = $mysqli->prepare("UPDATE `usr_db` SET `balance`=`balance` - ? WHERE `email_address` = ?"))) {
 		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
 	}

 	if(!($stmt->bind_param("is", $_POST['withdrawal'], $_SESSION['email_address']))) {
 		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
 	}

if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Successful Withdrawal!";	
}

$_SESSION['balance'] = $_SESSION['balance'] - $_POST['withdrawal'];
?>