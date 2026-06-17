---
author: Nishchal Kush
published: '2016-08-04T23:15:00+10:00'
slug: 2016-08-04-pcap-or-it-didnt-happen
tags:
- log
- pcap
- tcpdump
- centos
- linux
- network traffic
- chown
- '&'
- mkdir
- nohup
- chmod
title: PCAP or it didn't happen
---
"PCAP or it didn't happen" is a good network security philosophy. The
primary idea being to capture network traffic for analysis. In a
non-corporate environment where a CentOS-based Linux host has been used
as a dual homed firewall (refer to the lame ASCII art network diagram
below), tcpdump was used for continuous traffic capture.  
```
  _( )______     ________     +-----+     _( )__
 ( Internet )---/ Router \----| F/W |----( DMZ  )
(____________)  \________/    +-----+   (________)
```  
Firstly, we create a location to save the pcap files. Next, since
contemporary version of tcpdump are baked with the -Z switch which
causes tcpdump to drop into a less privileges account (tcpdump in the
case of this particular version of CentOS) we change ownership and
permissions to the location, and change permissions to allow the tcpdump
user and group to have full read and write permission.  
  
We then execute the tcpdump command to dump traffic on the interface
connected to the router (-i eth1) without resolving names (-n), only
slightly verbose output (-v), capturing the full frame, i.e. snap length
of 0 (-s 0), with a maximum file size of 512MB (-C 512), limit the
number of files to keep to 10 (-W 10) and write to the file
/var/log/traffic/capture.pcap (-w /var/log/traffic/capture.pcap).  
  
Since the login was an interactive one, we employ the nohup command to
prevent hang-up, i.e redirect input and output from stdin and stdout,
and the & operator to  detach the command from the current terminal and
send it into the background.  

1.  mkdir -p /var/log/traffic
2.  chown -R tcpdump:tcpdump /var/log/traffic
3.  chmod -R 775 /var/log/traffic
4.   nohup /usr/sbin/tcpdump -i eth1 -n -v -s 0 -C 512 -W 10 -w
    /var/log/traffic/capture.pcap &

Finally to ensure that the command is executed if the server is rebooted
after any hardware maintenance, we can copy the command in step 4 above
into the /etc/rc.d/rc.local file without the preceding nohup. We now
should have a series of pcap files, totaling up to 5GB of network
traffic, depending on requirements and available resources the
parameters can be tweaked to suit the number and size of files
required.
