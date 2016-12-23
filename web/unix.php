<?php
session_start();

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

$connection=mysqli_connect("$host","$username","$password","$database");
   
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function update_clients()
{
mysql_query( "UPDATE NEW_IPS SET ID = ID + 1 LIMIT 1" );
}

$sql="CREATE TABLE IF NOT EXISTS `USR_THR` (
id INT(4) NOT NULL PRIMARY KEY,
`REQRESP` VARCHAR(225) NOT NULL,`REQRESP1` VARCHAR(225) NOT NULL,
`SBR` VARCHAR(225) NOT NULL,`SBR1` VARCHAR(225) NOT NULL,
`LR` VARCHAR(225) NOT NULL,`LR1` VARCHAR(225) NOT NULL,
`Emailid` VARCHAR(50) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1";

mysqli_query($connection,$sql);

?>
<!DOCTYPE html>
<html>

<head>
<link href="style.css" rel="stylesheet">
</head>

<body>
<form method ="GET" ACTION="">

<div class="topcorner" >
<a href=logout.php>LOGOUT</a>
</div>

<div class="topcorner1" >
<a href=index1.php>BACK</a>
</div>

<br>
<center>
	<table border=1>

				<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">REQUEST RESPONSE TIME (in nsec)</h1></td>
						<td>
<input type="text" placeholder="upper limit" name="thresholdRTT"><br>
<input type="text" placeholder="lower limit" name="thresholdRTT1"><br>
</tr></td>


<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">SERVER BITRATE (in MBps)</h1></td>
						<td>
<input type="text" placeholder="upper limit" name="thresholdSBR"><br>
<input type="text" placeholder="lower limit" name="thresholdSBR1"><br>
</tr></td>


<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">LOST REQUESTS (in Req/sec)</h1></td>
						<td>
<input type="text" placeholder="upper limit" name="thresholdLR"><br>
<input type="text" placeholder="lower limit" name="thresholdLR1"><br>
</tr></td>

<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">E-MAIL ID</h1></td>
							<td>
<input type="text" name="Emailid"> <br>
</td></tr>

<tr><td><input type="submit" value="submit"></td></tr>

<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">GREEN INDICATES NORMAL</h1></td>
							<td><div class="color-box" style="background-color: green"></div></td>
					</tr>

					<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">ORANGE INDICATES WARNING</h1></td>
							<td><div class="color-box" style="background-color: orange"></div></td>
					</tr>

					<tr><td><h1 style="font-family:Trebuchet MS;font-size:80%">RED INDICATES CRITICAL</h1></td>
							<td><div class="color-box" style="background-color: #8C1C1C"></div></td>
					</tr>

</table>
</center>

<?php

#$sql2=mysqli_query($connection,"INSERT INTO `USR_THR` (id,REQRESP,REQRESP1,SBR,SBR1,LR,LR1,Emailid) VALUES ('1','1','1','1','1','1','6','1') #");    

$result = mysqli_query($connection,"SELECT * FROM NEW_IPS ");

#$result1 = mysqli_query($connection,"SELECT * FROM remo");

if(isset($_GET["thresholdRTT"]) && isset($_GET["thresholdRTT1"]))
{
	$thresholdRTT = preg_replace('#(^A-Za-z)#i','',$_GET["thresholdRTT"]);
	$thresholdRTT1 = preg_replace('#(^A-Za-z)#i','',$_GET["thresholdRTT1"]);
}
if(isset($_GET["thresholdSBR"]) && isset($_GET["thresholdSBR1"]))
{
	$thresholdSBR = preg_replace('#(^A-Za-z)#i','',$_GET["thresholdSBR"]);
	$thresholdSBR1 = preg_replace('#(^A-Za-z)#i','',$_GET["thresholdSBR1"]);
}
if(isset($_GET["thresholdLR"]) && isset($_GET["thresholdLR1"]))
{
	$thresholdLR = preg_replace('#(^A-Za-z)#i','',$_GET["thresholdLR"]);
	$thresholdLR1 = preg_replace('#(^A-Za-z)#i','',$_GET["thresholdLR1"]);
}

$Emailid=htmlspecialchars($_GET['Emailid']);
#echo "EMAIL: $Emailid";

if($thresholdRRT||$thresholdSBR||$thresholdLR) 
{
$sql2="INSERT INTO USR_THR(REQRESP,REQRESP1,SBR,SBR1,LR,LR1,Emailid) VALUES ('$thresholdRTT', '$thresholdRTT1', '$thresholdSBR', '$thresholdSBR1', '$thresholdLR', '$thresholdLR1', '$Emailid') ON DUPLICATE KEY UPDATE REQRESP='$thresholdRTT', REQRESP1='$thresholdRTT1', SBR='$thresholdSBR', SBR1='$thresholdSBR1', LR='$thresholdLR', LR1='$thresholdLR1',Emailid='$Emailid';";

#$sql3 =  "UPDATE USR_THR SET REQRESP='$thresholdRTT',REQRESP1='$thresholdRTT1',SBR='$thresholdSBR',SBR1='$thresholdSBR1',LR='$thresholdLR',LR1='$thresholdLR1',Emailid='$Emailid' WHERE id=1";

mysqli_query($connection,$sql2);
	}  


echo "<table border='1' style='float:left;margin:30px'>
<thead>
<th>DESTIP </th>
<th>Request-Response Time </th>
</thead>";

$row1 = mysqli_fetch_array($result1);
while($row = mysqli_fetch_array($result))
{

if ($row["REQRESP"] > 0 and $row["REQRESP"] < $thresholdRTT1)
{
$color_class = 'green';
}
   
elseif ($row["REQRESP"] >= $thresholdRTT1 and $row["REQRESP"] < $thresholdRTT )
{
$color_class = 'orange';
}
    #elseif ($row["REQRESP"] < $thresholdRTT)
     #{
     # $color_class = 'green';
      #}
else
{
$color_class = 'red';
}
    echo "<tr class={$color_class}>";
    echo "<td>" . $row['DESTIP'] . "</td>";
    echo "<td>" . $row['REQRESP'] . "</td>";
    echo "</tr>";

}
echo "</table>"; 

$result = mysqli_query($connection,"SELECT * FROM NEW_IPS");
#$result1 = mysqli_query($connection,"SELECT * FROM remo");
#$row1 = mysqli_fetch_array($result1);
echo "<table border='1' style='float:left;margin:30px'>
<thead>
<th>DESTIP </th>
<th>Bit rate </th>

</thead>";

while($row = mysqli_fetch_array($result))
{

if ($row["BITRATE"] > $thresholdSBR)
{
$color_class = 'green';
}
elseif ($row["BITRATE"] > $thresholdSBR1 and $row["BITRATE"] <= $thresholdSBR) #and $row["BITRATE"] > $thresholdSBR1 )
{ 
$color_class = 'orange';
}
  #elseif ($row["BITRATE"] < $thresholdSBR)
	#{
   #$color_class = 'green';
	#}
else
{
$color_class = 'red';
}
		 echo "<tr class={$color_class}>"; 
		  echo "<td>" . $row['DESTIP'] . "</td>";
		  echo "<td>" . $row['BITRATE'] . "</td>";
		  echo "</tr>";
	}
echo "</table>"; 

echo "<table border='1' style='float:left;margin:30px'>
<thead>
<th>DESTIP </th>
<th>Lost Requests </th>
</thead>";

$result = mysqli_query($connection,"SELECT * FROM NEW_IPS ");
#$result1 = mysqli_query($connection,"SELECT * FROM remo");

#$row1 = mysqli_fetch_array($result1);
while($row = mysqli_fetch_array($result))
{

		if ($row["LOSTREQ"] < $thresholdLR1)
     {
      $color_class = 'green';
     }
    elseif ($row["LOSTREQ"] >= $thresholdLR1 and $row["LOSTREQ"] < $thresholdLR)
    {
     $color_class = 'orange';
    }
     else
     {
     $color_class = 'red';
     }
    echo "<tr class={$color_class}>";
   
    echo "<td>" . $row['DESTIP'] . "</td>";
    echo "<td>" . $row['LOSTREQ'] . "</td>";
    echo "</tr>";
}
echo "</table>"; 

?>





