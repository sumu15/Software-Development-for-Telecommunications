<?php

session_start();

$_SESSION['usr']=$_POST['usr'];

$t1=$_POST['usr'];
$t2=$_POST['pwd'];

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

#connect to the database task 

$conn = mysqli_connect("$host","$username","$password",$database);
mysqli_select_db("$database",$conn);

if($conn === false)
    {

        die("ERROR: . " . mysqli_connect_error());

    }

$sql="SELECT passwd,aes_decrypt(passwd,'dummy') from fish3 where usrname='$t1'";
$result=mysqli_query($conn,$sql);

#if(!$result){
    #echo "<script>alert('Login Fail');</script>";
#}

$num_rows=mysqli_affected_rows($conn);

$row=mysqli_fetch_assoc($result);

foreach($row as $cname=>$cvalue)
	{
		$a[]="$cvalue";
	}

#if entered password and decrypted password are equal, select all details from table, assign original password to $z
	if($a[1]==$t2 && $num_rows==1)
	{
		$z=$t2;
		$x=$t1;
		#echo "$t1";
		#echo "$z";
		echo "<script>alert('Login Succesful');</script>";
	}
	
	else
	{
		$z=$t2;
		#echo "$z";
		echo "<script>alert('Login Failed');</script>";
		header('location:logout.php');
	}

#$d3=$t1;
#echo $d3;
?>
<html>
<link rel="stylesheet" href="style.css" type="text/css"> </link>

<body>
<form action="index1.php" method="post">

<div style="border:10px solid teal;width=150;height=100;background-color:azure;" align="center">
<h1 style="text-align:center;color:teal;">
ENTER ANY TWO STREAMS OUT OF 70, 71, 72, 73
</h1>
</div>
		
<br>
<br>			
		
	<table border=10 width=800 bgcolor= "bisque" align=center cellpadding=10px cellspacing=5px class="boldtable">

		<tr>
		<td> ENTER STREAM 1 </td> <td><input type="text" name="str1"> </td>
		</tr>
				
		<tr>
		<td> ENTER STREAM 2</td> <td> <input type="text" name="str2"> </td>
		</tr>
					

		<tr>
		<td> <input type="submit" value="submit" name="submit1"></td>
		<td><input type="reset" value="reset"> </td>
		</tr>

		<tr>
		<td> Proceed, if no stream changes are neeeded</td> <td><a href="index1.php">Proceed</a></td>
		</tr>
		

		</table>

</form>
</body>
</html>
