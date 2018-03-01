<?php
session_start();
?>


<! DOCTYPE html>

<link rel="stylesheet" type="text/css" href="apply.css">
<div class="row1">

<row1>
<p class="input">
Money Transfer
</p>
</row1>

<div class="row2">

<row2>


<p class="input3">
Account Number<sup><font color="red">*</font></sup>

<input type="text" id = "val1" name="accountno">
<br><br><br>
IFSC Code<sup><font color="red">*</font></sup>
<input type="text" id="val2" name="ifsccode">
<br><br><br>
Amount<sup><font color="red">*</font></sup>
<input type="text" id="val3" name="amount">
<br><br><br>
<button type=button onclick=val()>SEND</button>
  
</p>

<script type="text/javascript" >
function val() {
	var acc = document.getElementById("val1").value;
	var ifsc = document.getElementById("val2").value;	
	var amt = document.getElementById("val3").value;
	
	alert("remaining balance : " + (<?php echo $_SESSION["bal"]?> - amt));
	
	
}
</script>
</row2>


	

</html>

