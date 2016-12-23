<?php

session_start();

?>
<html>
<link rel="stylesheet" href="style.css" type="text/css"> </link>
			
<body>		
<form action="streams.php" method="post">

<div style="border:10px solid teal;width=150;height=100;background-color:azure;" align="center">
<h1 style="text-align:center;color:teal;">
LOGIN
</h1>
</div>

<br>
<br>			
	
<table border=10 width=500 bgcolor= "bisque" align=center cellpadding=10px cellspacing=5px class="boldtable">
					
	<tr>
	<td>USERNAME</td> <td><input type="text" name="usr"> </td>
	</tr>
					
	<tr>
	<td>PASSWORD</td> <td><input type="password" name="pwd"></td>
	</tr>
					
	<tr>
	<td> <input type="submit" value="submit" name="submit"> </td>
	<td> <input type="reset" value="reset">
	</tr>


</table>
</form>		
</body>

</html>
