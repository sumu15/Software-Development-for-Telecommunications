#!/usr/bin/perl

use Data::Dumper;
use DBI;
use DBD::mysql;
use RRD::Simple ();
do "db.conf";
$dsn= "DBI:mysql:$database";
$dbh= DBI->connect("DBI:mysql:$database","$username","$password");

# Create an interface object
 my $rrd = RRD::Simple->new( file => "$req_dest_ip.rrd");
 
 # Create a new RRD file with 3 data sources called
 # bytesIn, bytesOut and faultsPerSec.
unless (-e "$req_dest_ip.rrd"){ 
$rrd->create("$req_dest_ip.rrd",
             Rrt => "GAUGE",
	    rate => "GAUGE",
	    Lost => "COUNTER"
         );

}

my $req;
my $req_tcp_seg_len;
my $req_epoch_time;
my $req_seq_no;
my $req_ack_no;
my $req_src_ip;
my $req_dest_ip;
my $req_src_port_no;
my $req_dest_port_no;
my $req_frame_size;
my %tcp_req;
my %tcp_rsp;
my %duration;
my %frame_len_per_server;
my %not_found_server_rsp;
my %regexp;
$regexp{float} = qr/\d+\.\d+/;
$regexp{num} = qr/\d+/;
$regexp{ip_addr} = qr/\d+\.\d+\.\d+\.\d+/;


open(log1,'nagiostext1.txt');						#Opening the file in Read Mode
open(log2,'>out.txt');
#open(log3,'>Avg_frame_length.txt');
#open(log4,'>Resp_found_ne_200.txt');

while(<log1>)
{
	#         						req	     			tcp_seg_len	     	seq_no            ack_no         epoch_time			src_port           dest_port           src_ip	             dest_ip			frame_size
	if(/\d\s+(GET|2\d\d|3\d\d|4\d\d|5\d\d)\s+($regexp{num})\s+($regexp{num})\s+($regexp{num})\s+($regexp{float})\s+($regexp{num})\s+($regexp{num})\s+($regexp{ip_addr})\s+($regexp{ip_addr})\s+($regexp{num})\s+/)
		{
				# For Debug
				#print log2 "TCP_REQS:$1\t$2\t$3\t$4\t$5\t$6\t$7\t$8\t$9\t$10\n";
				
				$req = $1;
				$req_tcp_seg_len = $2;
				$req_seq_no = $3;
				$req_ack_no = $4;
				$req_epoch_time = $5;
				$req_src_port_no = $6;
				$req_dest_port_no = $7;
				$req_src_ip = $8;
				$req_dest_ip = $9;
				$req_frame_size = $10;
				
				if ($req eq "GET") {
					$tcp_req{$req_epoch_time}{$req_src_ip}{$req_dest_ip}{$req_tcp_seg_len}{$req_seq_no}{$req_ack_no}{$req_src_port_no}{$req_dest_port_no}{$req_frame_size} = $req;
				}
				else {
					$tcp_rsp{$req_epoch_time}{$req_src_ip}{$req_dest_ip}{$req_tcp_seg_len}{$req_seq_no}{$req_ack_no}{$req_src_port_no}{$req_dest_port_no}{$req_frame_size} = $req;
				}	
				
		}
}



	foreach my $epoch_time ( sort {$a <=> $b} keys %tcp_req) { 
		foreach my $src_ip (keys %{$tcp_req{$epoch_time}}) {
			foreach my $dest_ip (keys %{$tcp_req{$epoch_time}{$src_ip}}) {
				foreach my $seg_len (keys %{$tcp_req{$epoch_time}{$src_ip}{$dest_ip}}) {
					foreach my $seq_no (keys %{$tcp_req{$epoch_time}{$src_ip}{$dest_ip}{$seg_len}}) {
						foreach my $ack_no (keys %{$tcp_req{$epoch_time}{$src_ip}{$dest_ip}{$seg_len}{$seq_no}}) {
							foreach my $src_port_no (keys %{$tcp_req{$epoch_time}{$src_ip}{$dest_ip}{$seg_len}{$seq_no}{$ack_no}}) {
								foreach my $dest_port_no (keys %{$tcp_req{$epoch_time}{$src_ip}{$dest_ip}{$seg_len}{$seq_no}{$ack_no}{$src_port_no}}) {
								foreach my $frame_len (keys %{$tcp_req{$epoch_time}{$src_ip}{$dest_ip}{$seg_len}{$seq_no}{$ack_no}{$src_port_no}{$dest_port_no}}) {
						
									foreach my $epoch_time_rsp ( sort {$a <=> $b} keys %tcp_rsp) {
										foreach my $src_ip_rsp (keys %{$tcp_rsp{$epoch_time_rsp}}) {
											foreach my $dest_ip_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}}) {
												foreach my $seg_len_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}}) {
													foreach my $seq_no_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}{$seg_len_rsp}}) {
														foreach my $ack_no_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}{$seg_len_rsp}{$seq_no_rsp}}) {
															foreach my $src_port_no_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}{$seg_len_rsp}{$seq_no_rsp}{$ack_no_rsp}}) {
																foreach my $dest_port_no_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}{$seg_len_rsp}{$seq_no_rsp}{$ack_no_rsp}{$src_port_no_rsp}}) {
																	foreach my $frame_len_rsp (keys %{$tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}{$seg_len_rsp}{$seq_no_rsp}{$ack_no_rsp}{$src_port_no_rsp}{$dest_port_no_rsp}}) {
																		
																		$rsp_type = $tcp_rsp{$epoch_time_rsp}{$src_ip_rsp}{$dest_ip_rsp}{$seg_len_rsp}{$seq_no_rsp}{$ack_no_rsp}{$src_port_no_rsp}{$dest_port_no_rsp}{$frame_len_rsp};
																		$req_type = $tcp_req{$epoch_time}{$src_ip}{$dest_ip}{$seg_len}{$seq_no}{$ack_no}{$src_port_no}{$dest_port_no}{$frame_len};
																		
																		#print log2 "REQ:$req_type\tepoch_time:$epoch_time\tsrc_ip:$src_ip\tdest_ip:$dest_ip\tseg_len:$seg_len\tseq_no:$seq_no\tack_no:$ack_no\tsrc_port_no:$src_port_no\tdest_port_no:$dest_port_no\n";
																		#print log2 "RSP:$rsp_type\tepoch_time:$epoch_time_rsp\tsrc_ip:$src_ip_rsp\tdest_ip:$dest_ip_rsp\tseg_len:$seg_len_rsp\tseq_no:$seq_no_rsp\tack_no:$ack_no_rsp\tsrc_port_no:$src_port_no_rsp\tdest_port_no:$dest_port_no_rsp\n";
																																				
																		if ( ( $rsp_type eq "200" ) && ( $src_ip == $dest_ip_rsp ) && ( $dest_ip == $src_ip_rsp ) && ( $seq_no + $seg_len == $ack_no_rsp ) && ( $src_port_no == $dest_port_no_rsp ) && ( $dest_port_no == $src_port_no_rsp ) ) {
														
																		# For Debug
																		print log2 "REQ:$req_type\tepoch_time:$epoch_time\tsrc_ip:$src_ip\tdest_ip:$dest_ip\tseg_len:$seg_len\tseq_no:$seq_no\tack_no:$ack_no\tsrc_port_no:$src_port_no\tdest_port_no:$dest_port_no\n";
																		print log2 "RSP:$rsp_type\tepoch_time:$epoch_time_rsp\tsrc_ip:$src_ip_rsp\tdest_ip:$dest_ip_rsp\tseg_len:$seg_len_rsp\tseq_no:$seq_no_rsp\tack_no:$ack_no_rsp\tsrc_port_no:$src_port_no_rsp\tdest_port_no:$dest_port_no_rsp\n";
																		$duration{$epoch_time}{$epoch_time_rsp}{$dest_ip} = $epoch_time_rsp - $epoch_time;
																		print log2 "RSP epoch_time:$epoch_time_rsp\tREQ epoch_time:$epoch_time\tDuration:$duration{$epoch_time}{$epoch_time_rsp}{$dest_ip}\n\n";
																		$found_rsp = 1;
																	
																		$frame_len_per_server{$epoch_time_rsp}{$dest_ip}{$src_port_no} = $frame_len_rsp;
																		#print log3 "src_port_no:$src_port_no\tdest_ip:$dest_ip\tframe_len:$frame_len\n";
										 
																		}
																		elsif ( ( $rsp_type ne "200" ) && ( $src_ip == $dest_ip_rsp ) && ( $dest_ip == $src_ip_rsp ) && ( $seq_no + $seg_len == $ack_no_rsp ) && ( $src_port_no == $dest_port_no_rsp ) && ( $dest_port_no == $src_port_no_rsp ) ) {
																		print log2 "REQ:$req_type\tepoch_time:$epoch_time\tsrc_ip:$src_ip\tdest_ip:$dest_ip\tseg_len:$seg_len\tseq_no:$seq_no\tack_no:$ack_no\tsrc_port_no:$src_port_no\tdest_port_no:$dest_port_no\n";
																		print log2 "RSP:$rsp_type\tepoch_time:$epoch_time_rsp\tsrc_ip:$src_ip_rsp\tdest_ip:$dest_ip_rsp\tseg_len:$seg_len_rsp\tseq_no:$seq_no_rsp\tack_no:$ack_no_rsp\tsrc_port_no:$src_port_no_rsp\tdest_port_no:$dest_port_no_rsp\n";
																		$found_rsp = 1;		

																		$frame_len_per_server{$epoch_time_rsp}{$dest_ip}{$src_port_no} = $frame_len_rsp;
																		#print log3 "src_port_no:$src_port_no\tdest_ip:$dest_ip\tframe_len:$frame_len\n";
										 
																		}
																	}
																}
															}
														}		
													}
												}
											}
										}
									}
								
							
								}
								# For Debug
								#print log4 "Could not find response for REQ at $epoch_time\n\n" if ( $found_rsp == 0 ); 
								
								if ($found_rsp == 0) { $not_found_server_rsp{$dest_ip}++; }
								$found_rsp = 0;
								
								}
							}
						}
					}
				}
			}
		}
	}


# Bit Rate Calculation
my $total_frame_len = 0;
my %rsp_epoch_times;
my %bit_rate_per_server;
my %tot_frame_len_per_server;
my @rsp_epoch_times_per_server;

foreach my $server_epoch_time ( sort {$a <=> $b} keys %frame_len_per_server) {
	foreach my $server_src_ip (keys %{$frame_len_per_server{$server_epoch_time}}) { 
		foreach my $server_src_port_no (keys %{$frame_len_per_server{$server_epoch_time}{$server_src_ip}}) { 
			
				$tot_frame_len_per_server{$server_src_ip} = $tot_frame_len_per_server{$server_src_ip} + $frame_len_per_server{$server_epoch_time}{$server_src_ip}{$server_src_port_no};
				$rsp_epoch_times{$server_epoch_time} = $server_src_ip;
				
				# For Debug
				#print log3 "\nserver:$server_src_ip\tcurrent_frame_len:$frame_len_per_server{$server_epoch_time}{$server_src_ip}{$server_src_port_no}\ttotal_frame_len:$tot_frame_len_per_server{$server_src_ip}\n";		
										
		}	
	}	
}

while ((my $server, my $tot_frame_len) = each %tot_frame_len_per_server) {

	foreach my $server_rsp_epoch_time ( keys %rsp_epoch_times) {
		if ( $server eq $rsp_epoch_times{$server_rsp_epoch_time} ) {
			
			#For Debug
			#print log3 "server:$server\tepoch_time:$rsp_epoch_times{$server_rsp_epoch_time}\n";
			push (@rsp_epoch_times_per_server,$server_rsp_epoch_time);
		}
	}
	
	my @sorted_rsp_epoch_times_per_server = sort @rsp_epoch_times_per_server;
	
	#For Debug 
	#print log3 "\nrsp_epoch_times_per_server:@rsp_epoch_times_per_server\n";
	#print log3 "sorted_rsp_epoch_times_per_server:@sorted_rsp_epoch_times_per_server\n";
	
	my $least_epoch_time = $sorted_rsp_epoch_times_per_server[0]; my $max_epoch_time = $sorted_rsp_epoch_times_per_server[$#sorted_rsp_epoch_times_per_server];
	if ($max_epoch_time != $least_epoch_time) { $bit_rate_per_server{$server} = $tot_frame_len/($max_epoch_time - $least_epoch_time); }
	elsif ($max_epoch_time == $least_epoch_time) { $bit_rate_per_server{$server} = $tot_frame_len/$max_epoch_time; }
	
	# For Debug
	print log2 "\nServer:$server\ttot_frame_len:$tot_frame_len\tleast_epoch_time:$least_epoch_time\tmax_epoch_time:$max_epoch_time\tbit_rate_per_server:$bit_rate_per_server{$server}\n\n";

#push(@result1, "$server", "$max_epoch_time-$least_epoch_time", "$bit_rate_per_server{$server}");
	
	foreach my $src_epoch_time ( sort {$a <=> $b} keys %duration) {
		foreach my $desp_epoch_time (keys %{$duration{$src_epoch_time}}) { 
			foreach my $dest_server (keys %{$duration{$src_epoch_time}{$desp_epoch_time}}) { 
				if ( $server eq $dest_server ) {


while ((my $not_found_server, my $no_of_lost_rsps) = each %not_found_server_rsp) {

							if ($server eq $not_found_server) {
		
							# For Debug
							#print "hi\n";
							system("perl test.pl $duration{$src_epoch_time}{$desp_epoch_time}{$dest_server} $bit_rate_per_server{$server} $no_of_lost_rsps $server");
							}

						} 
					
# For Debug
print log2 "Server:$server\tRSP epoch_time:$desp_epoch_time\tREQ epoch_time:$src_epoch_time\tDuration:$duration{$src_epoch_time}{$desp_epoch_time}{$dest_server}\n";

system("perl test.pl $duration{$src_epoch_time}{$desp_epoch_time}{$dest_server} $bit_rate_per_server{$server} 0 $server");

#if(!$dest_server ~~ @result){
#print "lol";
#push(@result, "$dest_server", "$duration{$src_epoch_time}{$desp_epoch_time}{$dest_server}", "$bit_rate_per_server{$server}");
												#}
#else{
#print "desti $dest_server.\n";
push(@result, "$dest_server", "$duration{$src_epoch_time}{$desp_epoch_time}{$dest_server}", "$bit_rate_per_server{$server}");
#}

#print "@result\n";
#----------------------------------------------------------------------
				
				}
			}
		}
	}
	
	undef @sorted_rsp_epoch_times_per_server; undef @rsp_epoch_times_per_server;
	$least_epoch_time = undef; $max_epoch_time = undef;
          
}



for ($m=0;$m<scalar(@result);$m=$m+3){
$dest_ip1=$result[$m];
$duration1=$result[$m+1];
$rate=$result[$m+2];
#print"$duration1 \n";
#----------------------------------------------------------------
my $sth1 = $dbh->prepare("SELECT DESTIP FROM NEW_IPS WHERE DESTIP='$dest_ip1'");
$sth1->execute();
$COUNT1= $sth1->rows;
if($COUNT1==0){
$dbh1 = "INSERT INTO NEW_IPS (DESTIP,REQRESP,BITRATE,LOSTREQ ) VALUES ('$dest_ip1','$duration1','$rate',0)" ;
$db = $dbh->prepare($dbh1);
$db -> execute();
}
else {
my $sth2 = $dbh->prepare("UPDATE NEW_IPS
                        SET REQRESP ='$duration1' 
                        WHERE DESTIP='$dest_ip1'");
$sth2->execute();
}
} 


# Response Not Found
while ((my $not_found_server, my $no_of_lost_rsps) = each %not_found_server_rsp) {
	print log2 "server:$not_found_server\tlost_rsps:$no_of_lost_rsps\n";
 #$dbh1 = $dbh->do("INSERT INTO NEW_IPS (DESTIP,REQRESP,BITRATE,LOSTREQ ) VALUES ('$dest_ip1',$duration1','$rate',0) ON DUPLICATE KEY UPDATE REQRESP= '$duration1',BITRATE=1,LOSTREQ=1 ") ;
my $sth = $dbh->prepare("SELECT * FROM NEW_IPS WHERE DESTIP='$not_found_server'");
$sth->execute();
$COUNT= $sth->rows;

#print "Number of rows found : $COUNT \n ";

if ($COUNT==0){
$dbh2 = $dbh->do("INSERT INTO NEW_IPS (DESTIP,REQRESP,BITRATE,LOSTREQ ) VALUES ('$not_found_server','0','0',$no_of_lost_rsps)") ;
#system("perl test.pl '0' '0' $no_of_lost_rsps $not_found_server");
}

else {

my $sth = $dbh->prepare("UPDATE NEW_IPS
                        SET LOSTREQ ='$no_of_lost_rsps' 
                        WHERE DESTIP='$not_found_server'");
$sth->execute();
system("perl test.pl '0' '0' $no_of_lost_rsps $not_found_server");
}        
     
}

#system("perl newf.pl");
system("perl mail.pl");
#system("perl ssh_scp.pl");

