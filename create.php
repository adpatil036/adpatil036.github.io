<?php
$username = "root";
$password = "root";
$dbname = "defaultdb";

$txt1 =" connection Initated";
echo "<h2>" . $txt1 . "</h2>";
try
{

$db = new PDO('mysql:host=localhost;dbname=' . $dbname . ';charset=utf8', $username, $password);
$txt1 =" connection Initated @@";
echo "<h2>" . $txt1 . "</h2>";
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(Exception $e)
{
    echo $e->getMessage();
}

$txt1 =" connection succefully";
echo "<h2>" . $txt1 . "</h2>";

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
