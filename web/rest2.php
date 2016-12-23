<?php

#display output in json format 
header("Content-Type:application/json");
include("database2.php");

if(!empty($_GET['value']))   
{

	$value = $_GET['value'];
	
	#$response stores the value returned from function details in database2.php
	$response = details($value);
	  
	if(empty($response))
	{
		deliver_response(200,"metrics not Found",NULL);
	}
	else
	{
		deliver_response(200,"$value metrics Found",$response);
	}
} 
   
else
{
	deliver_response(400,"No entry Found",NULL);
}

#function for displaying output in json format
function deliver_response($status,$status_message,$i)
{
	global $find1,$find2;
	
	header("HTTP/1.1 $status $status_message");
	$reply['status']=$status;
	$reply['status_message']=$status_message;
	
	$json_response=json_encode($reply);
	echo "$json_response\n";	
	for ($row = 0; $row < $i; $row++)
	{

		$result1[$row] = $find1[$row];
		$result2[$row] = $find2[$row];

		#displays username in json format
		$json_response1=json_encode($result1[$row]);

		#dispalys the selected field
		$json_response2=json_encode($result2[$row]);
		echo "$json_response2\t\t\t$json_response1";
		echo "\n";
	}
	
}

?>
