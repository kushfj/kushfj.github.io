---
author: Nishchal Kush
published: '2012-05-07T16:37:00+10:00'
slug: 2012-05-07-i-had-to-do-some-maintenance-work-on-a-linux-based-server
tags:
- clamav
- mysql
- security
- secure
- fail2ban
- firewall
- bind
- centos
- iptables
- linux
- monitoring
- rkhunter
- ips
title: I had to do some maintenance work on a Linux based server
---
I had to do some maintenance work on a Linux based server. It was mainly
just archiving some files around and updating packages and
configurations. However, as part of the maintenance I took the
opportunity to put in some simple technical security controls in place
and documented some of them here for my reference.  
  
**MySQL Database**  
<span style="font-family: inherit;">There was a MySQL server running
that was only needed for the local host, but a "netstat -ltn" indicated
that it was not bound to any specific IP, i.e. listening on 0.0.0.0, so
I bound it to the localhost IP of 127.0.0.1 by editing the /etc/my.cnf
file using the entry bind-address=127.0.0.1</span>  


    vi /etc/my.cnf
    bind-address=127.0.0.1

**RKHunter Rootkit Anti-malware**  
I installed the new version of rkhunter and modified the configuration
file to suit.  


    yum install rkhunter
    vi /etc/rkhunter.conf
    PKGMGR=RPM
    ENABLE_TESTS="all"
    DISABLE_TESTS="none"
    SCAN_MODE_DEV=THOROUGH 
    rkhunter --propupd --update --check --sk -l
    vi /etc/rkhunter.conf
    ALLOWHIDDENDIR=
    ALLOWDEVFILE=

<span style="font-family: inherit;">**IPTables Firewall**</span>  
Strangely enough there was no firewall configured on the host, so I
quickly knocked up an script and saved it. Here's a snippet of the
script that simply resets the rules, sets the default policies to drop
and allows all local communications. There are additional parts that
allow specific traffic through, but I have not put this up here to
obscure the services and IP addresses being used.  


    #!/bin/bash

    #
    # Global script variables
    #

    # Commands
    IPTABLES=/sbin/iptables

    # Network interfaces and addresses
    LOOP_IFACE=lo
    LAN=192.168.100.0/24
    LAN_ADDR=192.168.100.201
    LAN_IFACE=eth0

    # Port numbers
    NAMED_PORT=53
    NETFLOW_PORT=9996
    NTP_PORT=123
    PRIV_PORTS=1:1024
    SMB_PORTS=137:139
    SSHD_PORT=4022
    UNPRIV_PORTS=1025:65535


    #
    # Manage kernel parameters
    #

    echo 1 > /proc/sys/net/ipv4/tcp_syncookies
    echo 1 > /proc/sys/net/ipv4/conf/all/rp_filter
    echo 1 > /proc/sys/net/ipv4/conf/all/log_martians
    echo 0 > /proc/sys/net/ipv4/conf/all/send_redirects
    echo 0 > /proc/sys/net/ipv4/conf/all/accept_source_route
    echo 0 > /proc/sys/net/ipv4/conf/all/accept_redirects
    echo 1 > /proc/sys/net/ipv4/icmp_echo_ignore_broadcasts
    echo 1 > /proc/sys/net/ipv4/ip_forward


    #
    # Configure default table policies
    #

    $IPTABLES -P INPUT DROP
    $IPTABLES -P FORWARD DROP
    $IPTABLES -P OUTPUT DROP


    #
    # Initialise tables - flush rules, remove chains, zero counts
    #

    $IPTABLES -F
    $IPTABLES -F -t mangle
    $IPTABLES -F -t nat

    $IPTABLES -X
    $IPTABLES -X -t mangle
    $IPTABLES -X -t nat

    $IPTABLES -Z


    #
    # Allow all local loopback traffic
    #

    $IPTABLES -A INPUT -i $LOOP_IFACE -j ACCEPT
    $IPTABLES -A OUTPUT -o $LOOP_IFACE -j ACCEPT


    #
    # Allow all traffic that is part of a related or established connection in
    #

    $IPTABLES -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
    $IPTABLES -A OUTPUT -m state --state NEW,ESTABLISHED,RELATED -j ACCEPT


    #
    # Politely reject SMB traffic
    #

    $IPTABLES -A INPUT -i $LAN_IFACE -p tcp --dport $SMB_PORTS -j REJECT
    $IPTABLES -A INPUT -i $LAN_IFACE -p udp --dport $SMB_PORTS -j REJECT


    #
    # Allow icmp pings
    #

    $IPTABLES -A INPUT -i $LAN_IFACE -s $LAN -d $LAN_ADDR -p icmp --icmp-type echo-request -m state --state NEW,ESTABLISHED -j ACCEPT
    $IPTABLES -A OUTPUT -o $LAN_IFACE -s $LAN_ADDR -d $LAN -p icmp --icmp-type echo-reply -m state --state ESTABLISHED,RELATED -j ACCEPT


    #
    # *** DELETED SERVICES SPECIFIC RULES TO IMPLEMENT SECURITY BY OBSCURITY ***

    # 


    #
    # Debugging - log all other traffic *** DO NOT USE IN PRODUCTION ENVIRONMENT ***
    #
    #
    #$IPTABLES -A INPUT -i $LAN_IFACE -j LOG --log-prefix "rc.firewall "
    #

  
  
<span style="font-family: inherit;">**ClamAV Anti-virus**</span>  
<span style="font-family: inherit;">ClamAV is an open source anti-virus
software for Linux. I installed this using the yum package manager and
configured the AV to scan daily, and used freshclam to ensure that the
virus definitions are updated hourly.</span>  

    yum install clamav clamd clamav-db


    vi /etc/cron.hourly/freshclam
    #!/bin/bash
    /usr/bin/freshclam --quiet -l /var/log/clamav/freshclam.log

    vi /etc/cron.daily/clamscan
    #!/bin/bash
    /usr/bin/clamscan -r / --exclude-dir=/proc --quiet --infected --log=/var/log/clamd/clamscan

**Fail2Ban Intrusion Prevention**  
fail2ban is an interesting intrusion prevention system that parses
system logs to dynamically update firewall rules to stop potential
intrusion attempts. It supports several other mechanism, but I was only
interested in the firewall and SSH access  
  


    yum install fail2ban
    vi /etc/ssh/sshd_config
    SyslogFacility LOCAL5
    LogLevel INFO

    vi /etc/syslog.conf
    local5.info                                     /var/log/sshd/sshd.log

    vi /etc/fail2ban/jail.conf
    [ssh-iptables]
    enabled  = true
    filter   = sshd
    action   = iptables[name=SSH, port=ssh, protocol=tcp]
               sendmail-whois[name=SSH, dest=*DELTED*, sender=*DELETED*]
    logpath  = /var/log/sshd/sshd.log
    maxretry = 2

  
**Legal notices**  
The client wanted some legal notices and disclaimers on the host for
various reasons, one of them being to notify employees that their usage
was being monitored. I stuck the disclaimer from their legal department
(it looked pretty generic though) into /etc/issue and created a link
from /etc/issue.net to it.
