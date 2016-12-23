<?php

session_start();

$t1=$_POST['a'];

if(isset($_POST['submit']))
{
	header("location:http://localhost/web/rest2.php/?value=$t1");	
}
?>

<html>
<link rel="stylesheet" href="style.css" type="text/css"> </link>
<form method="post">
<center>
		
<div style="border:10px solid teal;width=10;height=80;background-color:azure;" align="center">
<h1 style="text-align:center;color:teal;">Choose Any One Field To View The Corresponding Details</h1>		
</div>

<br> <br>
		
<table border=10 width=500 heigth=400 bgcolor= "bisque" align=center cellpadding=10px cellspacing=5px class="boldtable">


		<tr><td>
		<input type="radio" name="a" value="REQRESP">REQUEST-RESPONSE TIME
		</td></tr>

		<tr><td>
		<input type="radio" name="a" value="BITRATE">SERVER BIT RATE
		</td></tr>

		<tr><td>
		<input type="radio" name="a" value="LOSTREQ">LOST REQUESTS
		</td></tr>

		<tr><td>
		Click to import data in .csv format <a href="uploadform.php">Click</a>
		</td></tr>	

	<tr><td>
		Click to import data in .json format <a href="jsonform.php">Click</a>
		</td></tr>	
				
		
		<tr>
		<td><input type="submit" value="submit" name="submit">
		    <input type="reset" value="reset">
		</td>
		</tr>
</table>

</center>

</form>
</body>
<html>
