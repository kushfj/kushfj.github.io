---
author: Nishchal Kush
published: '2011-10-31T15:43:00+10:00'
slug: 2011-10-31-installing-openvpn-2-2-on-centos-5-7
tags:
- centos
- install
- openvpn
- server
- wget
- vpn
- yum
title: Installing OpenVPN 2.2 on Centos 5.7
---
OpenVPN is an SSL based VPN. There are other VPN solutions such as
IPsec, etc. but OpenVPN provides a cost effective alternative. I like
OpenVPN as it support two-way authentication, i.e. both the client and
server authenticate using certificates. To install OpeVPN on CentOS we
need a number of cryptographic libraries. The simplest way is to use the
DAG/RPMForge repository.  
  
Set-up the RPMForge repository <span class="Apple-style-span"
style="font-family: inherit; font-size: xx-small;">\[1\]</span>, as
this contains the packages necessary for the installation and the
instructions are provided below. The instructions below are just to
document this specific installation and therefore this blog post is not
to be misinterpreted as a best practises guide. The instructions are
adapted from the OpenVPN website <span class="Apple-style-span"
style="font-size: xx-small;">\[2\], </span><span
class="Apple-style-span" style="font-family: inherit;">but this blog
post is intended more as a quick and dirty guide to getting OpenVPN
running on CentOS 5.7. Additionally the </span>set-up<span
class="Apple-style-span" style="font-family: inherit;"> and
configuration of the client is considered beyond the scope of this blog
post.</span>  
  

Install packages

1.  rpm -Uhv
    http://apt.sw.be/redhat/el5/en/i386/rpmforge/RPMS/rpmforge-release-0.3.6-1.el5.rf.i386.rpm
2.  yum -y update
3.  yum -y openvpn

Set-up configuration files

1.  cd /etc/openvpn/
2.  cp /usr/share/doc/openvpn-2.2.0/sample-config-files/server.conf .
3.  mkdir -p /etc/openvpn/easy-rsa/keys
4.  cd /etc/openvpn/easy-rsa
5.  cp -rf /usr/share/doc/openvpn-2.2.0/easy-rsa/2.0/\* .
6.  chmod o+x,g+x
    clean-all, build-\* vars whichopensslcnf pkitool inherit-inter
    list-crl revoke-full sign-req

Edit the PKI configuration

<span class="Apple-style-span"
style="color: #242424; line-height: 22px;"><span
class="Apple-style-span" style="font-family: inherit;">vi
/etc/openvpn/easy-rsa/vars</span></span>

1.  <span class="Apple-style-span"
    style="color: #242424; line-height: 22px;">Also consider setting the
    key length using KEY\_SIZE variable, 1024 is the default 2048 is
    better, but slows down the TLS, but I am paranoid and use 4096 bit
    keys</span>
2.  <span class="Apple-style-span"
    style="color: #242424; line-height: 22px;">Set the country
    (KEY\_COUNTRY), state (KEY\_PROVINCE), locality (KEY\_CITY),
    organisation name (KEY\_ORG), and support email (KEY\_EMAIL)</span>

Set-up the PKI infrastructure. This involves make a certificate
authority and then generate the server certificate and any client
machine certificates

Create the certificate authority

1.  . ./vars
2.  ./clean-all
3.  ./build-ca
4.  The CA key and certificate should not be in the keys directory
    inside the easy-rsa directory.

Create certificate for the server

1.  ./build-key-server <span class="Apple-style-span"
    style="font-size: x-small;">NAME\_OF\_SERVER</span>
2.  Answer the questions and commit the certificate into the database

Create the Diffie Hellman files

1.  These files are used for the actual key exchange to ensure the
    confidentiality over an insecure channel, aka the Internet. Based on
    the length of the key used (KEY\_SIZE) it may take a while.
2.  ./build-dh

Create the certificate for each client

1.  When doing this for clients, I generate one for each device a client
    may use, that way if a device is stolen or goes missing, I only have
    to revoke a single certificate and the others keep working as they
    do. Not sure if this a good approach, but its definitely my quick
    and dirty (lazy) approach.
2.  ./build-key <span class="Apple-style-span"
    style="font-size: x-small;">LAPTOP</span>
3.  ./build-key <span class="Apple-style-span"
    style="font-size: x-small;">HOME-DESKTOP</span>
4.  ./build-key <span class="Apple-style-span"
    style="font-size: x-small;">PDA</span>

Edit the server configuration file 

vi /etc/openvpn/server.conf

Check/change

1.  local
2.  proto
3.  dev
4.  port
5.  ca
6.  cert
7.  key
8.  dh
9.  max-clients
10. user
11. group
12. log-append
13. verb

Start everything

1.  /etc/rc.d/init/openvpn start
2.  chkconfig --level 235 openvpn on

<span class="underline">Possible Errors</span>:  

1.  If the OpenVPN server fails to start, ensure that logging is
    enabled, i.e. refer to log-append in the configuration file and
    examine the log. A common error is that OpenVPN fails to open
    certain files, check that the paths to these files are specified
    correctly.

<span class="underline">References</span>:

1.  <http://dag.wieers.com/rpm/FAQ.php>
2.  <http://openvpn.net/howto.html>
