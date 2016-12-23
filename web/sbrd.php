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

if($link === false)
{
	die("ERROR: . " . mysqli_connect_error());
}


$connection=mysqli_connect("$host","$username","$password","$database");
   
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>

<html>

<head>
<link href="style.css" rel="stylesheet">
</head>

<div class="topcorner" >
<a href=logout.php>LOGOUT</a>
</div>

<div class="topcorner1" >
<a href=index1.php>BACK</a>
</div>

<br>
<center>
<h1 style="font-family:Trebuchet MS;font-size:250%">BITRATE</h1>
</center>

<?php

function update_clients()
{
    mysql_query( "UPDATE NEW_IPS SET ID = ID + 1 LIMIT 1" );
}

$result = mysqli_query($connection,"SELECT * FROM NEW_IPS");

echo "<center>
			<table border='1'>
			<p><thead class='header_row'>
			<th>DESTIP </th>
			<th>BITRATE</th>
			</thead>";

while($row = mysqli_fetch_array($result))
{
		if ($row["BITRATE"] > 700)
    {
      $color_class = 'green';
    }
    elseif ($row["BITRATE"] > 300 and $row["BITRATE"] <= 700)
    {
     $color_class = 'orange';
    }
     else
     {$color_class = 'red';
     }

    echo "<tr class={$color_class}>";
    echo "<td>" . $row['DESTIP'] . "</td>";
    echo "<td>" . $row['BITRATE'] . "</td>";
    echo "</tr>";
}
echo "</table> </center>";       
?>

<html>

<body>

<div class="left">
<h2 style="font-family:Trebuchet MS;font-size:100%;">-Green indicates normal</h2>
<h2 style="font-family:Trebuchet MS;font-size:100%">-Orange indicates warning</h2>
<h2 style="font-family:Trebuchet MS;font-size:100%">-Red indicates critical</h2>
</div>

<div class="right">
	<h1 style="font-family:Trebuchet MS;font-size:90%">DEFAULT THRESHOLD VALUES</h1>

	<h2 style="font-family:Trebuchet MS;font-size:90%;">
		<p> GREEN: Greater Than 700 MBps </p>
	</h2>
	
	<h2 style="font-family:Trebuchet MS;font-size:90%;">
		<p> ORANGE: In Between 300 MBps  - 700 MBps </p>
	</h2>

	<h2 style="font-family:Trebuchet MS;font-size:90%;">
		<p> RED: Less Than 300 MBps </p>
	</h2>
	
</div>

</body>
</html>






