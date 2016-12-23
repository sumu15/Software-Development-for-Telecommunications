<?php

session_start();

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

$uploadpath = "/var/www/html/web/";

#echo $filedata;
$file_target=$uploadpath.$filename;

if ($filedata != '' && $filename != '')
{
	copy($filedata,$file_target);

	$deleterecords = "TRUNCATE TABLE CSV_TBL"; //empty the table of its current records
	mysqli_query($link10, $deleterecords);

}

#echo "<br>";

	#$file1=$_FILES['file']['tmp_name'];
	#echo $file1; echo "<br>";
	$handle1=fopen($file_target,"r");
	#echo $handle1; echo "<br>";

		while(($fileop=fgetcsv($handle1,1000,","))!==false)
		{
		
			$ip=$fileop[0];
			#echo $ip;	
			$rrt=$fileop[1];
			#echo $rrt;
			$br=$fileop[2];
			#echo $br;
			$lsr=$fileop[3];
			#echo $lsr;
			#echo "<br>";
		
		$sql100="INSERT INTO CSV_TBL(DESTIP,REQRESP,BITRATE,LOSTREQ) VALUES('$ip','$rrt','$br','$lsr');";
		$r=mysqli_query($link10, $sql100);	

		#header("location:uploadform.php");	

		}

?>
