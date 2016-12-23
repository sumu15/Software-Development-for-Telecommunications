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

$string = file_get_contents($file_target);
#echo $string;
$jsonRS = json_decode ($string,true);
#echo "<br>";
#echo "<br>";
#echo "hi";
#echo "<br>";
#echo $jsonRS;
if (is_array($jsonRS) || is_object($jsonRS)) {
		
			foreach ($jsonRS as $rs) {
			
								$a=$rs["DESTIP"];
								#echo $a; echo "<br>";
								$b=$rs["REQRESP"];
								$c=$rs["BITRATE"];
								$d=$rs["LOSTREQ"];

								$sql100="INSERT INTO CSV_TBL(DESTIP,REQRESP,BITRATE,LOSTREQ) VALUES('$a','$b','$c','$d');";
								$r=mysqli_query($link10, $sql100);
		  #echo stripslashes($rs["DESTIP"])." ";
		  #echo stripslashes($rs["REQRESP"])." ";
		  #echo stripslashes($rs["BITRATE"])." ";
			#echo stripslashes($rs["LOSTREQ"])."<br>";
		}
}
?>
