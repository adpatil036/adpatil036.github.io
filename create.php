<?php
$username = "phpmyadmin";
$password = "Password@12345";
$dbname = "defaultdb";
try {

	$db = new PDO('mysql:host=127.0.0.1;dbname=' . $dbname . ';charset=utf8', $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$txt1 = " connection succefully for db";
	echo "<h2>" . $txt1 . "</h2>";
} catch (Exception $e) {
	echo $e->getMessage();
}

extract($_POST);
if (isset($_POST)) {

	$fname 		= $_POST['fname'];
	$lname 		= $_POST['lname'];
	$email 			= $_POST['email'];
	$cellphone	    = $_POST['cellphone'];
	$homephone 		= $_POST['homephone'];
	$address    = $_POST['address'];


	$sql = "insert into users (fname,lname,email,cellphone,homephone,address) VALUES (UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?))";
	$stmtinsert = $db->prepare($sql);
	$result = $stmtinsert->execute([$fname, $lname, $email, $cellphone, $homephone, $address]);
	if ($result) {
		echo '<div style="color:green;"><h3>' . $fname . " " . $lname . ' : User Successfully saved.</h3></div>';
	} else {
		echo 'There were errors while saving the data.';
	}
} else {
	echo 'No data';
}
