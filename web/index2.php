<?php 

session_start();
if (!isset($_SESSION['usr']))
{
    header('Location:login.php');
}

$path = dirname(__FILE__);
$finalpath="$path/db.conf";
$handle = fopen($finalpath, "r");
while (!feof($handle))
         {
             $line = fgets($handle);
 
            $data = explode("'",$line);
 
                if($data[0]=='$host=')
                {
                  $host= $data[1];
                }
                #elseif($data[0]=='port=>')
                #{
                 #$port= $data[1];
                #}
                elseif($data[0]=='$username=')
                {
                 $username= $data[1];
                }
                elseif($data[0]=='$password=')
                {
                 $password= $data[1];
                }
                elseif($data[0]=='$database=')
                {
                 $database= $data[1];
                }
         } 

    $link = mysqli_connect("$host","$username","$password","$database");

    if($link === false){

        die("ERROR: . " . mysqli_connect_error());
    }

?>

<!DOCTYPE html>
<html>

<head>
<link href="style.css" rel="stylesheet">
</head>

<body>
<form action="graph.php" method="GET">

<div class="topcorner" >
<a href=logout.php>LOGOUT</a>
</div>

<div class="topcorner1" >
<a href=index1.php>BACK</a>
</div>

<center><h1 style="font-family:Trebuchet MS;font-size:250%">RubiX</h1></center>
<div style = "position: absolute; right: 250px;top:50px;">

<?php

print "<table align=center border cellpadding=10>"; 
print "<tr>";
print "<th>IP Address</th> ";
print "</tr>";

$data1 = mysqli_query( $link,"SELECT * FROM NEW_IPS") or die(mysqli_error()); 

while ($row = mysqli_fetch_array($data1))
			{
			print "<tr>"; 
			print "<td>'$row[0]'</td>";
			print "<tr>";
			}
print"</table><br><br>";    
?>

<div style = "position: absolute;right:400px;top:80px;">
	<h1 >Enter IP Address</h1>
	<input type="text" name="ip" placeholder="The ip address"><br>
	<input type="radio" name="metric" value="Rrt">Request Response Time<br>
	<input type="radio" name="metric" value="rate">Server Bitrate<br>
	<input type="radio" name="metric" value="Lost">Lost requests<br>
	<input type="submit" name="submit" value="submit">		
</div>
		
</form>
</body>
</html>
