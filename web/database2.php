<?php

session_start();

$t1=$_POST['a'];

global $find1,$find2;
echo $value;
function details($value)
{
	global $i,$find1,$find2;	

#fetch values from db.conf
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

	
#Create connection
$conn = mysql_connect($host,$username,$password,$database);

#Check connection
if (!$conn) 
{
die("Connection failed: " . mysql_connect_error());
}	
       
#echo "Connected successfully<br>";

mysql_select_db("$database",$conn);
$result = mysql_query("SELECT DESTIP,$value from NEW_IPS",$conn);
	
$i=0;

while($row = mysql_fetch_assoc($result)) 
{
	$find1[$i]=$row[$value];
	$find2[$i]=$row['DESTIP'];
	#echo $find[$i];
	#echo $find2[$i];
	$i++;
	#echo "\n";
	
}

return($i);

}
	
?>
