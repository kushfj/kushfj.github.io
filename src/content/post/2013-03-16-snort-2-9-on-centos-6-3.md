---
author: Nishchal Kush
published: '2013-03-16T18:03:00+10:00'
slug: 2013-03-16-snort-2-9-on-centos-6-3
tags: []
title: Snort 2.9 on CentOS 6.3
---
Snort is a signature based network intrusion detection system (NIDS)
which has become a defacto standard for NIDS. In addition to being used
as a NIDS, Snort may also be used as a simple network traffic packet
sniffer or logger.  
  
A number of Snort dynamic preprocessors are available which enables the
development of rules to attack detection.  
  
Snort is an open source product and available for most popular network
operating systems. Snort rules are also available commercially from
Sourcefire.  
  
The following instruction detail the installation of Snort 2.9.4 on a
CentOS 6.3 64bit host. The installation instructions include the
installation of Snort rules available to registered Snort users, as well
as third party rules available from EmergingThreats.  
  
<span class="underline">Installation</span>:  

Install dependencies

1.  yum -y update 
2.  yum -y install gcc flex bison wget make
3.  yum -y install zlib zlib-devel
4.  yum -y install libpcap libpcap-devel
5.  yum -y install pcre pcre-devel
6.  rpm -Uvh
    http://dl.fedoraproject.org/pub/epel/6/x86\_64/epel-release-6-8.noarch.rpm
    *\#(or rpm -Uvh
    http://download.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm
    for 32 bit machines)* 
7.  yum -y update
8.  yum -y install libdnet libdnet-devel

Download and install DAQ

1.  cd /root/
2.  wget http://www.snort.org/downloads/2216 -O daq-2.0.0.tar.gz
3.  tar zxvf daq-2.0.0.tar.gz
4.  cd daq-2.0.0
5.  ./configure
6.  make
7.  make install

Download and install Snort

1.  wget http://www.snort.org/downloads/2225 -O snort-2.9.4.1.tar.gz
2.  tar zxvf snort-2.9.4.1.tar.gz
3.  cd snort-2.9.4.1
4.  ./configure --enable-sourcefire
5.  make
6.  make install

Download and install Snort Rules

1.  mkdir -p /etc/snort/rules
2.  mkdir -p /var/log/snort 
3.  cd /etc/snort
4.  Manually download the rules file to /etc/snort/ (*You need to be
    signed in to get the registered user rules*). In this case it was
    snortrules-snapshot-2940.tar.gz
5.  tar zxvf snortrules-snapshot-2940.tar.gz
6.  mv ./etc/\* /etc/snort/
7.  rmdir /etc/snort/etc

*OPTIONAL*: Download and install Emerging Threats rules

1.  wget
    http://rules.emergingthreats.net/open/snort-2.9.0/emerging.rules.tar.gz
    -O emerging.rules.tar.gz
2.  tar zxvf emerging.rules.tar.gz

Create Snort accounts

1.  groupadd snort
2.  useradd snort -g snort -d /var/log/snort -s /sbin/nologin -m
3.  chown -R snort:snort /etc/snort
4.  chown -R snort:snort /var/log/snort 

Edit the Snort configuration file

vi /etc/snort/snort.conf

1.  ipvar HOME\_NET x.x.x.x/x/
2.  ipvar EXTERNAL\_NET !$HOME\_NET
3.  var RULE\_PATH rules
4.  var SO\_RULE\_PATH so\_rules
5.  var PREPROC\_RULE\_PATH preproc\_rules
6.  var WHITE\_LIST\_PATH rules
7.  var BLACK\_LIST\_PATH rules** **
8.  <span style="font-size: x-small;">*OPTIONAL*</span>: include
    $RULES\_PATH/emerging.conf**  
    **

Test the Snort installation

1.  snort -u snort -g snort -c /etc/snort/snort.conf -T
2.  If all goes well you should see this

<span style="font-size: x-small;"><span
style="font-family: &quot;Courier New&quot;,Courier,monospace;">Snort
successfully validated the configuration!  
Snort exiting</span></span>  
  
I plan to have a subsequent blog post to record instructions for
installing and configuring barnyard, oinkmaster and BASE. Instructions
in a previous post using an older version of Snort and CentOS can be
found at
<http://nkush.blogspot.com.au/2011/10/installing-snort-2912-on-centos-57.html>  
  
<span class="underline">References</span>  

1.  http://fedoraproject.org/wiki/EPEL
2.  http://snort.org/docs
3.  http://nkush.blogspot.com.au/2011/10/installing-snort-2912-on-centos-57.html

<span class="underline">Common Errors</span>:  

ERROR: /etc/snort/snort.conf(253) Could not stat dynamic module path
"/usr/local/lib/snort\_dynamicrules": No such file or directory.

1.  mkdir -p /usr/local/lib/snort\_dynamicrules

ERROR: /etc/snort/snort.conf(511) =&gt; Unable to open address file
/etc/snort/rules/white\_list.rules, Error: No such file or directory

1.   touch /etc/snort/rules/white\_list.rules

ERROR: /etc/snort/snort.conf(511) =&gt; Unable to open address file
/etc/snort/rules/black\_list.rules, Error: No such file or directory

1.  touch /etc/snort/rules/black\_list.rules
