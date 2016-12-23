<?php

session_start();

#if (!isset($_SESSION['usr']))
#{
    #header('Location:test.php');
#}

if (!isset($_SESSION['usr']))
{
    header('Location:login.php');
}


$st1=$_POST['str1'];
$st2=$_POST['str2'];
#$st3=$_POST['d3'];
#echo $st1;

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

#connect to the database(phpmyadmin)
$link0 = mysqli_connect("$host", "$username", "$password");

    if($link0 === false)
    {

        die("ERROR: . " . mysqli_connect_error());

    }

#connect to the database nagios
$link10 = mysqli_connect("$host", "$username", "$password", "$database");

    if($link10 === false)
    {

        die("ERROR: . " . mysqli_connect_error());

    }


$sql55="INSERT INTO STREAMS(STR1, STR2) values($st1,$st2) ON DUPLICATE KEY UPDATE STR1 = $st1, STR2 = $st2";
mysqli_query($link10, $sql55);



?>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css"> </link>
</head>

<body>

<div class="topcorner" >
<a href=logout.php>LOGOUT</a>
</div>

<br> <br>
<div>
<center><h1 style="font-family:Trebuchet MS ;font-size:250%">RubiX</h1></center>
</div>

<br><h1 style="font-family:Trebuchet MS"> <center>Click to view the SERVER METRICS</center></h1>
<a href="index2.php"><center><font color=black><input type="submit" name="view" color="black" value="view"/>
</font></center></a>

<h1 style="font-family:Trebuchet MS"> <center>Click to view the THRESHOLDS</center></h1>
<a href="index3.php"><center><font color=black><input type="submit" name="view" value="view"></font></center></a>

<h1 style="font-family:Trebuchet MS"> <center>Click to view the REST API</center></h1>
<a href="details.php"><center><font color=black><input type="submit" name="view" value="view"></font></center></a>

</body>
</html>
