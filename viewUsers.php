<?php
extract($_POST);
$query = "select fname,lname,email,cellphone,homephone,address from users;";

$username = "phpmyadmin";
$password = "Password@12345";
$dbname = "defaultdb";
try {

    $db = new PDO('mysql:host=127.0.0.1;dbname=' . $dbname . ';charset=utf8', $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $e->getMessage();
}
$getData = $db->prepare($query);
$getData->execute();
$usersRow = $getData->fetchAll();
if (count($usersRow) > 0) {
    foreach ($usersRow as $user) {
        echo $user['fname'] .  '<br />';
    }
} else {
    echo 'No data';
}
