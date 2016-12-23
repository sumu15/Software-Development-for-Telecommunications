#! /usr/bin/perl

use strict;
use warnings;
use File::fgets;
use Data::Dumper;
use DBI;
use DBD::mysql;
use Net::SSH::Perl;
use Net::SCP::Expect;

my $host;
my $database;
my $username;
my $password;
my $ip;
my $usr1;
my $pwd1;
my $x;
my $y;
my $r;

my $file="db.conf";

use File::Open qw(fopen);

my $fh = fopen $file;

while (my $row = <$fh>) 
{
	my @data = split /[='';]/,$row;
	#print "@data";

		if($data[0] eq '$host')
    {		
		$host="$data[2]";
    }
		if($data[0] eq '$username')
    {		
		$username="$data[2]";
    }
		if($data[0] eq '$password')
    {		
		$password="$data[2]";
    }
		if($data[0] eq '$database')
    {		
		$database="$data[2]";
    }
		if($data[0] eq '$ip')
    {		
		$ip="$data[2]";
    }
		if($data[0] eq '$usr1')
    {		
		$usr1="$data[2]";
    }
		if($data[0] eq '$pwd1')
    {		
		$pwd1="$data[2]";
    }
}

#print $pwd1;
my $dsn = "DBI:mysql:host=$host";
my $dbh = DBI->connect($dsn,"$username","$password") or die "Could not connect to ".$host.": ". $DBI::errstr ."\n";

#my $dbh = DBI->connect("DBI:mysql:database=$database;host=$host","$username", "$password",{'RaiseError' => 1});
#my $dbh = DBI->connect("DBI:mysql:host=$host","$username", "$password",{'RaiseError' => 1}) or die "Could not connect to ".$host.": ". $DBI::errstr ."\n";
$dbh->do("Create database if not exists $database") or die "Could not create the: ".$database." error: ". $dbh->errstr ."\n";
$dbh->disconnect();

$dsn = "DBI:mysql:database=$database;host=$host";
$dbh = DBI->connect($dsn, "$username", "$password",{'RaiseError' => 1}) or die "Could not connect to ".$database.": ". $DBI::errstr ."\n";

my $sql = 'SELECT *FROM STREAMS WHERE id = 0';
my $sth = $dbh->prepare($sql);
$sth->execute();
while (my @row = $sth->fetchrow_array) {
   $x=$row[1];  
   $y=$row[2];
}

#print $x;
#print $y;

my $ssh = Net::SSH::Perl->new("$ip");
$ssh->login("$usr1","$pwd1");
if ($ssh)
{
print "ssh created\n";
}

$ssh->cmd("rm -r nagios1.cap");
$ssh->cmd("rm -r nagiosout2.pcap");
$ssh->cmd("rm -r nagiostext1.txt");
$ssh->cmd("sudo capdump -i eth2 -tcp -P 80 -p 50000 01::$x 01::$y -o nagios1.cap");
$ssh->cmd("cap2pcap -o nagiosout2.pcap nagios1.cap"); 
$ssh->cmd("tshark -r nagiosout2.pcap -T fields -e http.request.method -e http.response.code -e tcp.len -e tcp.seq -e tcp.ack -e frame.time_epoch -e tcp.srcport -e tcp.dstport -e ip.src -e ip.dst -e frame.len | sort | uniq -c  > nagiostext1.txt");

$r="$usr1"."@"."$ip";
#print "$r";
system ("sshpass -p $pwd1 scp $r:/root/nagiostext1.txt .");
