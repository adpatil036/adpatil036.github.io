<?php
$username = "root";
$password = "root";
$dbname = "defaultdb";

$db = new PDO('mysql:host=127.0.0.1;dbname=' . $dbname . ';charset=utf8', $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


extract($_POST);
if(isset($_POST)){

$txt1 = "Connection successfully";
echo "<h2>" . $txt1 . "</h2>";

	$fname 		= $_POST['firstName'];
	$lname 		= $_POST['lastName'];
	$email 			= $_POST['email'];
	$cellphone	    = $_POST['cellphone'];
	$homephone 		= $_POST['homephone'];
    $address    = $_POST['address'];


		$sql = "insert into user (fname,lname,email,cellphone,homephone,address) VALUES (UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?))";
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
