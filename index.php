<?php

if( ( !isset($_COOKIE["user"]) && !isset($_COOKIE["type"]) )  || ( empty($_COOKIE["user"]) && empty($_COOKIE["type"])))
{
setcookie("user","", time() + (21600), "/"); // 86400 = 1 day, 21600=6hours
setcookie("type","", time() + (21600), "/"); // 86400 = 1 day, 21600=6hours
}
elseif( ( $_COOKIE["user"] <> "" ) && ( $_COOKIE["type"] <> "" ) )
header("Location: ".$_COOKIE["type"]."/profile.php");
?>
<?php
require_once 'conn.php';
	$loginErr=$unameErr="";
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
global $validate;
$validate=1;
$nameErr = $emailErr = $mobileErr = $branchErr = $yearErr = $passwordErr = $loginErr="";
		
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["uname"]) && $_POST['uname']!=""){
		 $name = test_input($_POST["uname"]);
		 // check if name only contains letters and whitespace
		 if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		   $unameErr = "Only letters and white space allowed"; 
		 }
		
		try{

		//Select data from table
		$sql="select * from users where User_Name='".$_POST["uname"]."' and password='".$_POST["password"]."';";
		$result = mysqli_query($conn,$sql);

		if(mysqli_num_rows($result)>0) {
			//transfer the control of page
			$row=mysqli_fetch_assoc($result);
			$sql = "UPDATE users SET Status=1 WHERE binary User_Name='".$_POST["uname"]."';";
			mysqli_query($conn,$sql);
			if($row["Type"] == "admin")	//user is admin
				{
				setcookie("user",(string) $_POST["uname"], time() + (86400), "/"); // 86400 = 1 day
				setcookie("type",(string) $row["Type"], time() + (86400), "/"); // 86400 = 1 day
				setcookie("uid", (int) $row["uid"], time() + (86400), "/");
				header('Location: admin/home.php');
				}
			elseif($row["Type"] == "teacher"){					//user is teacher
				setcookie("user",(string) $_POST["uname"], time() + (86400), "/"); // 86400 = 1 day
				setcookie("type",(string) $row["Type"], time() + (86400), "/"); // 86400 = 1 day
				setcookie("uid", (string) $row["uid"], time() + (86400), "/");
				header('Location: teacher/home.php');
				}
			elseif($row["Type"] == "student"){					//user is student
				setcookie("user",(string) $_POST["uname"], time() + (86400), "/");
				setcookie("type",(string) $row["Type"], time() + (86400), "/");
				setcookie("uid", (string) $row["uid"], time() + (86400), "/");
			header('Location: student/home.php');
				}
				

		}
	else{ header("location: login_failed.php"); 
	}
}
		catch(Exception $e){}

	}//end isset post name if condition
elseif(isset($_POST['name']) && $_POST['name']!="")
{
			$email = test_input($_POST["email"]);
			 // check if e-mail address is well-formed
			 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			   $emailErr = "Invalid email format";
				$validate=0;
			 }
			 $name = test_input($_POST["name"]);
			 // check if name only contains letters and whitespace
			 if(strlen($name)<5){
			 $nameErr="Name is too small";$validate=0;} elseif (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			   $nameErr = "Only letters and white space allowed"; 	 
			   $validate=0;
			}
			$mob_no= test_input($_POST["mobile"]);
				//check mobile no length 10 and only of number type
			if(!preg_match("/^[0-9]*$/",$mob_no)) {
				$mobileErr = "Invalid mobile number";
				$validate=0;
			}elseif(strlen($mob_no)!=10){
				$mobileErr="Number too small it must be of 10 digits";
				$validate=0;
				}
			$password1 = test_input($_POST["password1"]);
			$password2 = test_input($_POST["password2"]);
			if(strlen($password1) < 7){
			$passwordErr="Password is too small";
			$validate=0;
			}
			elseif($password1 != $password2){
				$passwordErr = "Passwords does not matched.";
				$validate=0;
			}			
			
	if($validate)
	{
	$sql="Select uid from users where User_Name='$name' or Email='$email' or Mob_no='$mob_no'";
	if(mysqli_num_rows(mysqli_query($conn,$sql))>0)
	{	$loginErr="Given values are already registered try different one";}
	else{
	$sql="Insert into users(User_Name,Email,Mob_no,Password) values('".$_POST["name"]."','".$_POST["email"]."','".$_POST["mobile"]."','".$_POST['password1']."')";
	mysqli_query($conn,$sql);
	header("Location: index.php#myLoginModal");
			}
		}
	}// end of sign up if
}
	?>
<html>
	<head>
		
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component2.css" />
		<script src="js/modernizr-2.6.2.min.js"></script>
<style>
.login_panel{
display:block;
position:fixed;
width:200px;
height:200px;
left:40%;
top:40%;
</style>


	</head>
	<body style="background: #ffffff url('logo.png') no-repeat center top;">
	
		
		<div class="container">
			
			<div class="component">
			
				<button class="cn-button" id="cn-button">Menu</button>
				<div class="cn-wrapper" id="cn-wrapper">
					<ul>
						<li><a data-toggle="modal" data-target="#myLoginModal"><span>Home</span></a></li>
						<li><a data-toggle="modal" data-target="#myLoginModal"><span>Downloads</span></a></li>
						<li><a data-toggle="modal" data-target="#myLoginModal"><span>Feedback</span></a></li>
						<li data-toggle="modal" data-target="#myLoginModal"><a href="#"><span >Login</span></a></li>
						<li data-toggle="modal" data-target="#mySignupModal"><a href="#"><span>Sign Up</span></a></li>
						
						<li><a href='contact.html'><span>Contact</span></a></li>
						<li><a href="#"><span>About us</span></a></li>
					 </ul>
				</div>
				
			</div>
			<script src="js/polyfills.js"></script>
		<script src="js/demo2.js"></script>
			
			<script src="My bootstrap/jQuery/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="My bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <link href="My bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	 <link href="My bootstrap/css/bootstrap-3.3.5.min.css" rel="stylesheet" type="text/css" />
		
		<div class="modal fade" id="myLoginModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        <div class="modal-body">
          <form id="login" name='login' method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<center>
				
				<p>*<input type="text" name="uname" value="" placeholder="Username" required></p><span class='error'><?php echo $unameErr; ?></span>
				<p>*<input type="password" name="password" value="" placeholder="Password" required></p>
				<p><span class='error'><?php echo $loginErr; ?></span></p>
				<a href = "forgotpassword.php">Forget Password</a>
				<p class="submit"><input type="submit" name="commit" value="Login"></p>
				</center>
		</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
		<div class="modal fade" id="mySignupModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">signup</h4>
		  
        </div>
        <div class="modal-body">
          <form id="signup" method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
             <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center">Sign Up</h3>
                </div>
	<br><center>
	<p><input type="text" name="name"  maxlength="32" title="Name must be at least of 6 characters and should be less than 32 characters" placeholder="Username" required></p><span class='error' name='nameerror'><?php echo $nameErr; ?></span>
				<p><input type="text" name="email" placeholder="Email" required></p><span class='error'><?php echo $emailErr; ?></span>
				<p><input type="text" name="mobile" type="number" placeholder="Moblie Number" maxlength="10" title="Enter valid 10 digit mobile number" required></p><span class='error'><?php echo $mobileErr; ?></span>

				<p><input type="password" name="password1" placeholder="Password" title="It must be at least of 8 Characters" required></p>
				<p><input type="password" name="password2" placeholder="Re-Enter password" title="It must be at least of 8 Characters required"></p>
				<span class='error'><?php echo $passwordErr; ?></span>
				<p class="submit"><input type="submit" name="commit" value="Register your self"></p><span class='error'><?php echo $loginErr; ?></span>
		</center>	
		</div>
	</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
		
	</body>
</html>
