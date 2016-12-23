<?php
session_start();

    $filename = $_FILES['file']['name'];
		#echo $filename; echo "<br>";
    $filedata = $_FILES['file']['tmp_name'];
		#echo $filedata; echo "<br>";
    $filesize = $_FILES['file']['size'];
		#echo $filesize; echo "<br>";

include "upload.php";

$errmsg = '';
if (isset($_POST['btnUpload']))
{
        $url = "http://localhost/web/upload.php"; // e.g. http://localhost/myuploader/upload.php // request URL
    
								if ($filedata != '')
								{
										#echo "hi"; echo "<br>";
										$headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
										$postfields = array("filedata" => "@$filedata", "filename" => $filename);
										$ch = curl_init();
										$options = array(
												CURLOPT_URL => $url,
												CURLOPT_HEADER => true,
												CURLOPT_POST => 1,
												CURLOPT_HTTPHEADER => $headers,
												CURLOPT_POSTFIELDS => $postfields,
												CURLOPT_INFILESIZE => $filesize,
												CURLOPT_RETURNTRANSFER => true
										); // cURL options
										curl_setopt_array($ch, $options);
										curl_exec($ch);
															if(!curl_errno($ch))
															{
																	#echo "hihi";
																	$info = curl_getinfo($ch);
																	#echo"hi5";
																	if ($info['http_code'] == 200)
																	{
																			#echo "hi5";
																			echo "HTTP STATUS ".$info['http_code']; echo "<br>";
																			$errmsg = "File uploaded successfully";
																			echo $errmsg; echo "<br>";
																			#header("location:uploadform.php");
																	}
															}

															else
															{
																	$errmsg = curl_error($ch);
																	echo $errmsg; echo "<br>";
															}
										curl_close($ch);
									}

else
    {
        $errmsg = "Please select the file";
				echo $errmsg; echo "<br>";
    }
}

?>
<html>
<a href="uploadform.php">EXIT</a>
</html>

