<?php
session_start();
// Grab User submitted information
$email = $_POST["users_email"];
$pass = $_POST["users_pass"];

// Connect to the database
$con = new mysqli("localhost","root","", 'temp');//or die(mysql_error());
// Make sure we connected successfully
if(!$con)
{
    //die('Connection Failed'.mysql_error());
}

//$e = mysqli("show databases;");
//echo $e;

// Select the database to use
//mysql_select_db("temp",$con) or die(mysql_error());
echo "$email $pass";
$result = $con->query("SELECT name, pwd, acc_no, balance FROM tem WHERE name = '$email' ;");// or die(mysql_error());

$row = $result->fetch_assoc();

if($row["name"]==$email && $row["pwd"]==$pass)
	{	$_SESSION["name"] = $email;
		$_SESSION["acc"] = $row["acc_no"];
		$_SESSION["bal"] = $row["balance"];
    header('location:profile.php');}
else
    echo"Sorry, your credentials are not valid, Please try again.";
?>
