<?php
$username = "root";
$password = "Sjsu@123";
$dbname = "defaultdb";

$db = new PDO('mysql:host=127.0.0.1;dbname=' . $dbname . ';charset=utf8', $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

extract($_POST);
if(isset($_POST)){

	$fname 		= $_POST['fname'];
	$lname 		= $_POST['lname'];
	$email 			= $_POST['email'];
	$cellphone	    = $_POST['cellphone'];
	$homephone 		= $_POST['homephone'];
    $address    = $_POST['address'];


		$sql = "insert into users (fname,lname,email,cellphone,homephone,address) VALUES (UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?))";
		$stmtinsert = $db->prepare($sql);
		$result = $stmtinsert->execute([$fname,$lname, $email, $cellphone, $homephone, $address]);
		if($result){
			echo '<div style="color:green;"><h3>'.$fname." ".$lname.' : User Successfully saved.</h3></div>';
		}else{
			echo 'There were errors while saving the data.';
		}
}else{
	echo 'No data';
}
?>
