<?php
session_start();
?>



<!DOCTYPE html>

<link rel="stylesheet" text="text/css" href="profile.css">
<html>



<div class="logout">



<a href="login.html"><button type=button onclick="login.html">LOGOUT</button></a>
</logout>


<div class="profile">

<profile>
<img src="profile.png"> 
<h1><?php echo $_SESSION["name"];?></h1>


<p class="id">Employee ID: <?php echo $_SESSION["acc"];?> </p>
</profile>


<div class="form">

<form>


<a href="apply.php"><button type=button >SEND MONEY </button></a>

<button type=button onclick=val()>CHECK BALANCE </button>
</form>





</html>


<script type="text/javascript" >
	function val() {
		alert("<?php echo $_SESSION["bal"];?>");
	}
</script>
