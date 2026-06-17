---
author: Nishchal Kush
published: '2012-08-08T23:37:00+10:00'
slug: 2012-08-08-installing-openvpn-2-2-on-centos-6-3-64bit
tags:
- centos
- yum install
- install
- openvpn
- server
- wget
- rpm
- repoforge
- rpmforge
- yum
title: Installing OpenVPN 2.2 on CentOS 6.3 64bit
---
This post is just an update of a previous post that used CentOS 5.7 and
OpenVPN 2.2
(<http://nkush.blogspot.com.au/2011/10/installing-openvpn-22-on-centos-57.html>).
The basic instructions are the same, however this post uses some newer
packages which may have been relocated to new URLs. Again this blog and
the posts are mostly for my own reference and not intended as
step-by-step instuctions for other systems/network administrators  
  
Install RPMForge or RepoForge as it's now known<span
style="font-size: xx-small;">\[1\]</span>  

1.  wget
    http://pkgs.repoforge.org/rpmforge-release/rpmforge-release-0.5.2-2.el6.rf.x86\_64.rpm
2.  rpm -ivh rpmforge-release-0.5.2-2.el6.rf.x86\_64.rpm
3.  yum update

Install and set-up the OpenVPN Server<span
style="font-size: xx-small;">\[2\]</span>  

1.  yum -y install openvpn 
2.  cd /etc/openvpn/
3.  cp /usr/share/doc/openvpn-\*/sample-config-files/server.conf .
4.  mkdir -p /etc/openvpn/easy-rsa/keys
5.  cd /etc/openvpn/easy-rsa
6.  cp -rf /usr/share/doc/openvpn-2.2.0/easy-rsa/2.0/\* .
7.  chmod o+x,g+x
    clean-all, build-\* vars whichopensslcnf pkitool inherit-inter
    list-crl revoke-full sign-req

 Set-up the OpenVPN Server environment, keys and certificates  

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
3.  <span class="Apple-style-span"
    style="color: #242424; line-height: 22px;">I used 
    PKCS11\_MODULE\_PATH=/ and a random PIN value</span>

<span class="Apple-style-span"
style="color: #242424; line-height: 22px;">Create a link to the openssl
config file as openssl.cnf</span>

1.  <span class="Apple-style-span"
    style="color: #242424; line-height: 22px;">ln -s
    /etc/openvpn/easy-rsa/openssl-1.0.0.cnf </span><span
    class="Apple-style-span"
    style="color: #242424; line-height: 22px;">/etc/openvpn/easy-rsa/openssl.cnf</span><span
    class="Apple-style-span"
    style="color: #242424; line-height: 22px;">  </span> 

Create certificate for the server

1.  ./build-key-server <span class="Apple-style-span"
    style="font-size: xx-small;">NAME\_OF\_SERVER</span>
2.  Answer the questions and commit the certificate into the database

Create the Diffie Hellman files

1.  These files are used for the actual key exchange to ensure the
    confidentiality over an insecure channel. Based on the length of the
    key used (KEY\_SIZE) it may take a while.
2.  ./build-dh

Create the certificate for each client

1.  ./build-key <span class="Apple-style-span"
    style="font-size: xx-small;">CLIENT</span>

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

Future post may include instructions on configuration of client as well
as set-up of firewall rules for specific topologies (time permitting)  
  
<span class="underline">References</span>  

1.  http://wiki.centos.org/AdditionalResources/Repositories/RPMForge/\#head-f0c3ecee3dbb407e4eed79a56ec0ae92d1398e01
2.  http://nkush.blogspot.com.au/2011/10/installing-openvpn-22-on-centos-57.htm
