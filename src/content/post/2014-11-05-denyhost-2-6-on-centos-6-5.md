---
author: Nishchal Kush
published: '2014-11-05T20:51:00+10:00'
slug: 2014-11-05-denyhost-2-6-on-centos-6-5
tags:
- epel
- yum install
- daemon
- blockhosts
- hosts.allow
- fail2ban
- ssh
- tcpwrapper
- iptables
- hosts.deny
- chkconfig
- denyhosts
- yum
title: Denyhost 2.6 on CentOS 6.5
---
Denyhosts is another utility similar to fail2ban. It parses log files to
identify potential attacks against SSH services. A clear advantage that
Denyhosts has over fail2ban is the synchronisation mechanism since
version 2.0<span style="font-size: xx-small;">\[1\]</span>. Denyhosts
permits communication with a central server to exchange information
about denied hosts by other Denyhosts daemons. However unlike fail2ban,
it does not modify any firewall (iptables) rules, instead it relies on
tcpwrapper and the hosts.deny file to block ssh access. Fail2ban also
offers the advantage of monitoring other services and logs, whereas
Denyhosts is specific to SSH. There are other utilities which use
tcpwrapper such which can handle additional services<span
style="font-size: xx-small;">\[2\]</span>.  
  
To install Denyhost using yum, ensure that the EPEL repository is
installed and enabled (refer to old post<span
style="font-size: xx-small;">\[3\]</span> albeit an older version).  
  
<span class="underline">Installation and configuration</span>  
  

1.  vi /etc/hosts.allow     *\# whitelist any trusted hosts and/or
    networks*
2.  yum install denyhosts     *\# install the denyhosts package*
3.  vi /etc/denyhosts.conf     *\# change to suit, the file is well
    documented*
4.  chkconfig denyhosts --level 2345 on     *\# set runlevels to start
    daemon on*
5.  service denyhosts start    *\# manually start the daemon*
6.  tail /var/log/denyhosts    *\# confirm daemon started successfully*

  
<span class="underline">References:</span>  
  

1.  http://denyhosts.sourceforge.net/
2.  http://www.aczoom.com/blockhosts/
3.  http://nkush.blogspot.com.au/2011/10/installing-snort-2912-on-centos-57.html

I wrote a small (single use) script to generate a set of iptables rules
from the tcpwrapper hosts.deny file to drop traffic from denied hosts.

  

  

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">for
A in \`egrep -v '^\#' /etc/hosts.deny | tr -d '\\t' | tr -d 'ALL:' |
grep '\[0-9\]'\`</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">do</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;"> 
      echo "/sbin/iptables -I -s $A -j DROP"</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">done</span>
