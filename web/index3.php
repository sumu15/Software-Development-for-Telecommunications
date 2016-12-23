<?php

session_start();

$a=$_SESSION['usr'];
#echo "<br>"; echo "$a";

if (!isset($_SESSION['usr']))
{
		#$a=$_SESSION['usr'];
		#echo "$a";
    #header('Location:login.php');
}

#echo "$t1";

$path=dirname(_FILE_);
$final_path="$path/db.conf";
$handle = fopen($final_path, "r");

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

#connect to mysql database (phpmyadin)
$link0 = mysqli_connect("$host","$username","$password");

    if($link0 === false)
    {

        die("ERROR: . " . mysqli_connect_error());

    }

#create database named "task" if not exists
$sql0 = "CREATE DATABASE if not exists $database";

mysqli_query($link0, $sql0);

mysqli_close($link0);

#connect to the required mysql database, here task   
$link10 = mysqli_connect("$host","$username","$password","$database");

    if($link10 === false)
    {

        die("ERROR: . " . mysqli_connect_error());

    }

$sqlyy="SELECT mail from fish3 where usrname='$a';";
$resulta=mysqli_query($link10,$sqlyy);

$rowa=mysqli_fetch_assoc($resulta);

foreach($rowa as $cvalue)
	{
		$b="$cvalue";
		#echo "<br>";
		#echo $b;
		#echo "<br>";
	}


$sqli="INSERT INTO DEF_THR(REQRESP,REQRESP1,SBR,SBR1,LR,LR1,Emailid) VALUES ('0.1', '0.05', '700', '300', '10', '1', '$b') ON DUPLICATE KEY UPDATE Emailid='$b';";
mysqli_query($link10, $sqli);

?>

<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet">
</head>

<body>

<div class="topcorner" >
<a href=logout.php>LOGOUT</a>
</div>

<div class="topcorner1" >
<a href=index1.php>BACK</a>
</div>

<center>
	<h1 style="font-family:Trebuchet MS;font-size:300%">RubiX</h1>
	<h2 style="font-family:Trebuchet MS;font-size:150%"> Choose the kind of threshold : </h1>
	<h3 style="font-family:Trebuchet MS;font-size:100%;color:black"> DEFAULT </font><br></h2>
	<a href="rrtd.php" style="font-family:Trebuchet MS;font-size:80%;color:black">Request Response time</a><br>
	<a href="sbrd.php" style="font-family:Trebuchet MS;font-size:80%;color:black">Server Bitrate</a><br>
	<a href="lrd.php" style="font-family:Trebuchet MS;font-size:80%;color:black">Lost requests</a>

<br>

<h3><a href="unix.php" style="font-family:Trebuchet MS;font-size:100%;color:black">USER DEFINED</a></h2>

</center>

</body>
</html>
