
===========================================
!!            Read Me        !!
============================================

This tool monitors the HTTP traffic.
It contains of folders agent, manager, manual and web.

This document consists of the system requirements, steps to run the tool.
					
=======================
System Requirements
=======================

1.	Operating system :Ubuntu 14.04.

2. 	RAM: 1GB or more, Hard Disk: minimum 40 GB, Processor: 32 bit or 64 bit.

3.	Internet Access

4.	Perl and CPAN modules must be installed before running the back-end script along with rrd modules.

5.	Mysql database is required to store data related to the IP addresses of the servers, and the performance metrics associated with them. The metrics are accessed through PHPMyadmin in the front-end. 

6.	Apache Server must also be installed.

7.	Detailed steps regarding installation of required modules are mentioned in instatallation document in the manual folder.


==================================
Installation Instructions:
==================================
1. This tool is presented in .tar.gz format.

2. Unzip this file in a desired location.

3. Change the "db.conf" file as per the requirements of the user for database access through PHPMyadmin.

3. Copy "web" folder to /var/www/html/ as follows:
   
    	 cp -r "present directory"/ ~/var/www/html/

5. Similarly. copy all the contents of the manager folder into the "web" folder in /var/www/html/

6. Run "main2" file in terminal as "perl main2.pl" 

NOTE:  The locations where all files "manager, web are copied must have permissions.

       To have permissions, login as root in terminal and database using "sudo" as admin" and use chmod 777 "folder name"
   
       Change the configuration files according to the requirements.

=========================================
Front End Access Instructions:
=========================================

1. Open a browser.

2. Enter "http://localhost/web/index.php" as URL.

3. Register for the tool & Log into the web interface using the username and password used during registration.

4. Once you login, a database named "nagios" is automatically created.

5. The user can now view the performanc metrics concerned with HTTP traffic :- Request-Rresponse Time, Server Bit-Rate, Lost Requests.

6. The user can refer the User Documentation given in the manual for further instructions for front end access.