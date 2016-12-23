<?php

session_start();
if (!isset($_SESSION['usr']))
{
    header('Location:login.php');
}

$IP1=htmlspecialchars($_GET['ip']);
//echo $IP1;
$metrics=htmlspecialchars($_GET['metric']);
//echo $metrics;
$IP="$IP1".".rrd";
//echo $IP;
#print "$IP";
#print "$metrics";

 
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

    $link = mysqli_connect("$host","$username","$password","$database");

    if($link === false){

        die("ERROR: . " . mysqli_connect_error());

    }


if($metrics=='Rrt')
{
$a="nanoseconds";
$b="seconds";
}
elseif($metrics=='rate')
{
$a="bytes/nanosecond";
$b="Bps";
}
elseif($metrics=='Lost')
{
$a="lost-requests";
$b="Req/sec";
}


$opts_h = array( "--start", "-1h", "--vertical-label=$a",
		         "DEF:bps1=$IP:$metrics:AVERAGE",
						"LINE1:bps1#FF0000:In traffic\\r",
						"--dynamic-labels","--title=hourly graph",
	  				"--color=BACK#CCCCCC","--color=CANVAS#CCFFFF",    
		    	  "--color=SHADEB#9999CC",
		        "COMMENT:\\n",
		        "GPRINT:bps1:LAST:Last In \: %6.2lf %S $b",
		        "COMMENT:  ", 
			 			"GPRINT:bps1:MAX:Maximum In \: %6.2lf %S $b",
		         "COMMENT:  ",
						"GPRINT:bps1:MIN:Minimum In \: %6.2lf %S $b",
			 			"COMMENT:  ",
						"GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S $b",
		                         
		         
		       );

$ret_h = rrd_graph("hourly.png", $opts_h);

if( $ret_h == 0 )
  {
    $err = rrd_error();
    echo "Create error: $err\n";
  }

$opts_d = array( "--start", "-1d", "--vertical-label=$a",
		         "DEF:bps1=$IP:$metrics:AVERAGE",
						"LINE1:bps1#FF0000:In traffic\\r",
						"--dynamic-labels","--title=One day graph",
	  				"--color=BACK#CCCCCC","--color=CANVAS#CCFFFF",    
		    	  "--color=SHADEB#9999CC",
		        "COMMENT:\\n",
		        "GPRINT:bps1:LAST:Last In \: %6.2lf %S $b",
		        "COMMENT:  ", 
			 			"GPRINT:bps1:MAX:Maximum In \: %6.2lf %S $b",
		         "COMMENT:  ",
						"GPRINT:bps1:MIN:Minimum In \: %6.2lf %S $b",
			 			"COMMENT:  ",
						"GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S $b",
		       );

$ret_d = rrd_graph("day.png", $opts_d);

if( $ret_d == 0 )
  {
    $err = rrd_error();
    echo "Create error: $err\n";
  }

$opts_w = array( "--start", "-1w", "--vertical-label=$a",
		         	"DEF:bps1=$IP:$metrics:AVERAGE",
		         	"LINE1:bps1#FF0000:In traffic\\r",
			 				"--dynamic-labels",
			 				"--title=Week graph",
	  				 	"--color=BACK#CCCCCC",      
		    	 		"--color=CANVAS#CCFFFF",    
		    	 		"--color=SHADEB#9999CC",
		         	"COMMENT:\\n",
		         	"GPRINT:bps1:LAST:Last In \: %6.2lf %S $b",
		         	"COMMENT:  ",
			 				"GPRINT:bps1:MAX:Maximum In \: %6.2lf %S $b",
		         	"COMMENT:  ",
			 				"GPRINT:bps1:MIN:Minimum In \: %6.2lf %S $b",
			 				"COMMENT:  ",
			 				"GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S $b", 
		       );

$ret_w = rrd_graph("week.png", $opts_w); 
	  
$opts_m = array("--start", "-1m", "--vertical-label=$a",
		         	"DEF:bps1=$IP:$metrics:AVERAGE",
		         	"LINE1:bps1#FF0000:In traffic\\r",
			 				"--dynamic-labels",
			 				"--title=monthly graph",
	  		 			"--color=BACK#CCCCCC",      
		    	 		"--color=CANVAS#CCFFFF",    
		    	 		"--color=SHADEB#9999CC",
		         	"COMMENT:\\n",
		         	"GPRINT:bps1:LAST:Last In \: %6.2lf %S $b",
		         	"COMMENT:  ", 
			 				"GPRINT:bps1:MAX:Maximum In \: %6.2lf %S $b",
		         	"COMMENT:  ",
			 				"GPRINT:bps1:MIN:Minimum In \: %6.2lf %S $b",
			 				"COMMENT:  ",
			 				"GPRINT:bps1:AVERAGE:Average In \: %6.2lf %S $b",      
		       );

$ret_m = rrd_graph("month.png", $opts_m);

?>

<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css"> </link>
</head>

<body>

<div class="topcorner" >
<a href=logout.php>LOGOUT</a>
</div>

<center>
<br><img src="hourly.png">
<br><img src="day.png"> 
<br><img src="week.png"> 
<br><img src="month.png"> 
<!--<br><img src="year.png">-->
</center>
</body>

</html>

