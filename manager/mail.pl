use DBI;
use DBD::mysql;
#use strict;
use Mail::Sender;

do "db.conf";

$dsn= "DBI:mysql:$database";
$dbh= DBI->connect("DBI:mysql:$database","$username","$password");

#$dbh1 = $dbh->prepare("SELECT * FROM `DEF_THR`");
#$dbh1->execute();
#@row = $dbh1->fetchrow_array();

$dbh3 = $dbh->prepare("SELECT * FROM `USR_THR`");
$dbh3->execute();
@row3 = $dbh3->fetchrow_array();


#if(@row3==0)
#{
#my $a=1;
#}
#elsif(@row3!=0)
#{
#my $b=1;
#}

#print "\n";
#print @row;
#print "\n";
#print @row;

#if(@row==0)
#{
#print "\n";
#print "Hi";
#}

if(@row3==0)
{
#print "\n";
#print "working";
#print @row3;

$dbh1 = $dbh->prepare("SELECT * FROM `DEF_THR`");
$dbh1->execute();
@row5 = $dbh1->fetchrow_array();

																	$thresholdRRT=$row5[1];
																	#print $thresholdRRT;
																	#print "\n";

																	$thresholdSBR=$row5[4];
																	#print $thresholdSBR;
																	#print "\n";

																	$thresholdLR=$row5[5];
																	#print $thresholdLR;
																	#print "\n";

																	$Emailid=$row5[7];
																	#print "$Emailid";
																	#print "\n";

																	$checkRRT="0";

																	$dbh2 = $dbh->prepare("SELECT * FROM `NEW_IPS`");
																	$dbh2->execute();
																	while(@row1 = $dbh2->fetchrow_array())
																	{
																			#$ip11=$row1[0];
																			$RRT=$row1[1];
																			$SBR=$row1[2];
																			#print $SBR;
																			#print "\n";
																			$LR=$row1[3];

																			if($RRT>$thresholdRRT)
																				{
																						$checkRRT="1";
																						$ip00="$row[0]";
																						#push(@ipRRT,"$row[0]")
																				}

																			if($SBR<$thresholdSBR)
																				{
																						$checkSBR="1";
																						#push(@ipSBR,"$row[0]")
																				}

																			if($LR>$thresholdLR)
																				{
																						$checkLR="1";
																						#push(@ipLR,"$row[0]")
																				}

																	}

																	if($checkRRT=="1")
																	{
																			my $sender = new Mail::Sender {
																									auth => 'LOGIN',
																									authid => 'dipe15@student.bth.se',
																									authpwd => '7%E9v2Da',
																									smtp => 'outlook.office365.com ',
																									port => 587,
																									from => 'dipe15@student.bth.se',
																									to => $Emailid,
																									subject => 'status of request response time',
																									msg =>'Critical Request-Response time - Default',
																									#file => '/home/image/Documents/Endoscopia/default.pdf',
																									#debug => "/home/image/Documents/SendMailDebug.txt",
																									#debug_level => 4,
																									#timeout => 500,
																			};
																					#my $result =  $sender->MailFile({
																					my $result =  $sender->MailMsg({
																					msg => $sender->{msg},
																									#file => $sender->{file},
																					});
				
																					print "$sender->{error_msg}\n>>>End.\n";
																	}

																	if($checkSBR=="1")
																	{
																	my $sender1 = new Mail::Sender {
																							auth => 'LOGIN',
																							authid => 'dipe15@student.bth.se',
																							authpwd => '7%E9v2Da',
																							smtp => 'outlook.office365.com ',
																							port => 587,
																							from => 'dipe15@student.bth.se',
																							to => $Emailid,
																							subject => 'status of server bitrate',
																							msg => 'Critical Server Bit Rate - Default',
																							#file => '/home/image/Documents/Endoscopia/default.pdf',
																							#debug => "/home/image/Documents/SendMailDebug.txt",
																							#debug_level => 4,
																							#timeout => 500,
																			};
																			#my $result =  $sender->MailFile({
																			my $result1 =  $sender1->MailMsg({
																							msg => $sender1->{msg},
																							#file => $sender->{file},
																			});
				
																			print "$sender1->{error_msg}\n>>>End.\n";
				
																	}

																	if($checkLR=="1")
																	{
																	my $sender2 = new Mail::Sender {
																							auth => 'LOGIN',
																							authid => 'dipe15@student.bth.se',
																							authpwd => '7%E9v2Da',
																							smtp => 'outlook.office365.com ',
																							port => 587,
																							from => 'dipe15@student.bth.se',
																							to => $Emailid,
																							subject => 'Status of Lostrequest',
																							msg => 'Critical Lost Request - Default',
																							#file => '/home/image/Documents/Endoscopia/default.pdf',
																							#debug => "/home/image/Documents/SendMailDebug.txt",
																							#debug_level => 4,
																							#timeout => 500,
																			};
																			#my $result =  $sender->MailFile({
																			my $result2 =  $sender2->MailMsg({
																							msg => $sender2->{msg},
																							#file => $sender->{file},
																			});
				
																			print "$sender2->{error_msg}\n>>>End.\n";
																	}
}

if(@row3!=0)
{
#print "\n";
#print "working";
#print @row3;

$dbh1 = $dbh->prepare("SELECT * FROM `USR_THR`");
$dbh1->execute();
@row = $dbh1->fetchrow_array();
																	$thresholdRRT=$row[1];
																	#print $thresholdRRT;
																	#print "\n";

																	$thresholdSBR=$row[4];
																	#print $thresholdSBR;
																	#print "\n";

																	$thresholdLR=$row[5];
																	#print $thresholdLR;
																	#print "\n";

																	$Emailid=$row[7];
																	#print "$Emailid";
																	#print "\n";

																	$checkRRT="0";

																	$dbh2 = $dbh->prepare("SELECT * FROM `NEW_IPS`");
																	$dbh2->execute();
																	while(@row1 = $dbh2->fetchrow_array())
																	{
																			$RRT=$row1[1];
																			$SBR=$row1[2];
																			#print $SBR;
																			$LR=$row1[3];

																			if($RRT>$thresholdRRT)
																				{
																						$checkRRT="1";
																						#push(@ipRRT,"$row[0]")
																				}

																			if($SBR<$thresholdSBR)
																				{
																						$checkSBR="1";
																						#push(@ipSBR,"$row[0]")
																				}

																			if($LR>$thresholdLR)
																				{
																						$checkLR="1";
																						#push(@ipLR,"$row[0]")
																				}

																	}

																	if($checkRRT=="1")
																	{
																			my $sender = new Mail::Sender {
																									auth => 'LOGIN',
																									authid => 'dipe15@student.bth.se',
																									authpwd => '7%E9v2Da',
																									smtp => 'outlook.office365.com ',
																									port => 587,
																									from => 'dipe15@student.bth.se',
																									to => $Emailid,
																									subject => 'status of request response time',
																									msg => 'Critical Request-Response Time - User Defined',
																									#file => '/home/image/Documents/Endoscopia/default.pdf',
																									#debug => "/home/image/Documents/SendMailDebug.txt",
																									#debug_level => 4,
																									#timeout => 500,
																			};
																					#my $result =  $sender->MailFile({
																					my $result =  $sender->MailMsg({
																					msg => $sender->{msg},
																									#file => $sender->{file},
																					});
				
																					print "$sender->{error_msg}\n>>>End.\n";
																	}

																	if($checkSBR=="1")
																	{
																	my $sender1 = new Mail::Sender {
																							auth => 'LOGIN',
																							authid => 'dipe15@student.bth.se',
																							authpwd => '7%E9v2Da',
																							smtp => 'outlook.office365.com ',
																							port => 587,
																							from => 'dipe15@student.bth.se',
																							to => $Emailid,
																							subject => 'status of server bitrate',
																							msg => 'Critical Server Bit Rate - User Defined',
																							#file => '/home/image/Documents/Endoscopia/default.pdf',
																							#debug => "/home/image/Documents/SendMailDebug.txt",
																							#debug_level => 4,
																							#timeout => 500,
																			};
																			#my $result =  $sender->MailFile({
																			my $result1 =  $sender1->MailMsg({
																							msg => $sender1->{msg},
																							#file => $sender->{file},
																			});
				
																			print "$sender1->{error_msg}\n>>>End.\n";
				
																	}

																	if($checkLR=="1")
																	{
																	my $sender2 = new Mail::Sender {
																							auth => 'LOGIN',
																							authid => 'dipe15@student.bth.se',
																							authpwd => '7%E9v2Da',
																							smtp => 'outlook.office365.com ',
																							port => 587,
																							from => 'dipe15@student.bth.se',
																							to => $Emailid,
																							subject => 'Status of Lostrequest',
																							msg => 'Criticl Lost Requests - User Defined',
																							#file => '/home/image/Documents/Endoscopia/default.pdf',
																							#debug => "/home/image/Documents/SendMailDebug.txt",
																							#debug_level => 4,
																							#timeout => 500,
																			};
																			#my $result =  $sender->MailFile({
																			my $result2 =  $sender2->MailMsg({
																							msg => $sender2->{msg},
																							#file => $sender->{file},
																			});
				
																			print "$sender2->{error_msg}\n>>>End.\n";
																	}
}
