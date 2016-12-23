<?php

session_start();


#fetch variables from db.conf

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

#create table named details
$sql00 = "CREATE TABLE if not exists fish3(id INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT, name CHAR(30) NOT NULL, usrname CHAR(30) NOT NULL, passwd VARCHAR(50), mail CHAR(30) NOT NULL)";

$sql11 = "CREATE TABLE IF NOT EXISTS `NEW_IPS` (`DESTIP` varchar(18) NOT NULL,`REQRESP` float NOT NULL,`BITRATE` float DEFAULT NULL,`LOSTREQ` mediumint(9) DEFAULT NULL, PRIMARY KEY (`DESTIP`), UNIQUE KEY `DESTIP` (`DESTIP`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sql22 = "CREATE TABLE IF NOT EXISTS `STREAMS` (id INT(4) NOT NULL PRIMARY KEY, `STR1` INT NOT NULL,`STR2` INT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sql33="CREATE TABLE IF NOT EXISTS `DEF_THR` (id INT(4) NOT NULL PRIMARY KEY,`REQRESP` VARCHAR(225) NOT NULL,`REQRESP1` VARCHAR(225) NOT NULL,`SBR` VARCHAR(225) NOT NULL,`SBR1` VARCHAR(225) NOT NULL,`LR` VARCHAR(225) NOT NULL,`LR1` VARCHAR(225) NOT NULL,`Emailid` VARCHAR(50) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$sql88="CREATE TABLE IF NOT EXISTS `USR_THR` (id INT(4) NOT NULL PRIMARY KEY,`REQRESP` VARCHAR(225) NOT NULL,`REQRESP1` VARCHAR(225) NOT NULL,`SBR` VARCHAR(225) NOT NULL,`SBR1` VARCHAR(225) NOT NULL,`LR` VARCHAR(225) NOT NULL,`LR1` VARCHAR(225) NOT NULL,`Emailid` VARCHAR(50) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$sql99="CREATE TABLE IF NOT EXISTS `CSV_TBL` (`DESTIP` varchar(18) NOT NULL,`REQRESP` float NOT NULL,`BITRATE` float DEFAULT NULL,`LOSTREQ` mediumint(9) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;"; 

echo  " " . mysqli_error($link10);

mysqli_query($link10, $sql00);
mysqli_query($link10, $sql11);
mysqli_query($link10, $sql22);
mysqli_query($link10, $sql33);
mysqli_query($link10, $sql88);
mysqli_query($link10, $sql99);

#$sqli="INSERT INTO DEF_THR(REQRESP,REQRESP1,SBR,SBR1,LR,LR1,Emailid) VALUES ('0.1', '0.05', '700', '300', '10', '1', '$f4');";

#get variables from html tags
$f1=$_POST['nm'];
$f2=$_POST['usr'];
$f3=$_POST['pwd'];
$f4=$_POST['mail'];

#echo $f4;
#$sqli="INSERT INTO DEF_THR(REQRESP,REQRESP1,SBR,SBR1,LR,LR1,Emailid) VALUES ('0.1', '0.05', '700', '300', '10', '1', '$f4');";
#mysqli_query($link10, $sqli);
#echo "$f2";

if(isset($_POST['submit']))
{

#insert into database the values entered, password is encrypted using aes_encrypt

#$sqli="INSERT INTO DEF_THR(REQRESP,REQRESP1,SBR,SBR1,LR,LR1,Emailid) VALUES ('0.1', '0.05', '700', '300', '10', '1', '$f4');";
#mysqli_query($link10, $sqli);

$sql="INSERT INTO fish3(name, usrname, passwd, mail) values('$f1','$f2', aes_encrypt('$f3','dummy'), '$f4')"; 
mysqli_query($link10, $sql);
$y=mysqli_affected_rows($link10);
				
	if(!$y)
	die(myqli_error());
	else 	
	{
	echo "<script>alert('Registration Successful');</script>";
	#header("location:login.php");
	echo "<script>alert('Click on Already a user ? Login ');</script>";
	}
	
mysqli_close($link10);
			    	
}

?>

<html>
<link rel="stylesheet" href="style.css" type="text/css"> </link>

<body>
<form method="post">

<div style="border:10px solid teal;width=150;height=100;background-color:azure;" align="center">
<h1 style="text-align:center;color:teal;">
REGISTER
</h1>
</div>
		
<br>
<br>			
		
	<table border=10 width=800 bgcolor= "bisque" align=center cellpadding=10px cellspacing=5px class="boldtable">

	<!--The fields in the registration form displayed in the form of table!-->

		<tr>
		<td> ENTER FULL NAME </td> <td><input type="text" name="nm"> </td>
		</tr>
				
		<tr>
		<td> ENTER USERNAME</td> <td> <input type="text" name="usr"> </td>
		</tr>
					
		<tr>
		<td> ENTER PASSWORD </td> <td><input type="password" name="pwd"> </td>
		</tr>

		<tr>
		<td> ENTER E-MAIL </td> <td><input type="text" name="mail"> </td>
		</tr>

		<tr>
		<td> <input type="submit" value="submit" name="submit"> 
		<input type="reset" value="reset"> </td>
		<td> <a href="login.php"> Already a user ? Login </a> </td>
		</tr>

		</table>

</form>
</body>
</html>
