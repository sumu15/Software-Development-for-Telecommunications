<?php
session_start();

?>

<html>
<link rel="stylesheet" href="style.css" type="text/css"> </link>

<body> 

<form action="uploadpost.php" method="post" name="frmUpload" enctype="multipart/form-data"> 

<div style="border:10px solid teal;width=150;height=100;background-color:azure;" align="center">
<h1 style="text-align:center;color:teal;">
UPLOAD A .CSV FILE TO IMPORT
</h1>
</div>
		
<br>
<br>		
	<table border=10 width=800 bgcolor= "bisque" align=center cellpadding=10px cellspacing=5px class="boldtable">

		<tr>
		<td><input type="file" name="file" id="file" /> </td>
		<td><input type="submit" name="btnUpload" value="IMPORT" /> </td>
		</tr>

	</table>

</form> 

</form>
</body>
</html>
