use RRD::Simple ();

 # Create an interface object
 my $rrd = RRD::Simple->new( file => "$ARGV[3].rrd" );
sleep(1);
#printf"hello\n";
print "------.$ARGV[0]\n";
print "------.$ARGV[1]\n";
print "------.$ARGV[2]\n";
print "------.$ARGV[3]\n";

$rrd->update(Rrt => $ARGV[0],
	rate => $ARGV[1],
	Lost => $ARGV[2]
	);
#my $info = $rrd->info(".rrd");


					#my %rtn = $rrd->graph(destination => "/var/www/html",
					#periods => [qw(hour week month)],           
					#title => "Network Interface eth0",
					#sources => [qw(Rrt rate Lost)],
					#vertical_label => "Bytes/Faults",
					#interlaced => ""
					#);
#use List::Util qw( min max );
#use Statistics::Lite qw( :all );
#print=$duration;

#my @data = $info;
#print min(@data),"\n";
#print max(@data),"\n";
#print stddev(@data),"\n";
#print mean(@data),"\n";


#print "my value: ".$_;
#sleep(1);

