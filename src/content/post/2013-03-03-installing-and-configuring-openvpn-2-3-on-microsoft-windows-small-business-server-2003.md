---
author: Nishchal Kush
published: '2013-03-03T16:08:00+10:00'
slug: 2013-03-03-installing-and-configuring-openvpn-2-3-on-microsoft-windows-small-business-server-2003
tags:
- sbs
- install
- openvpn
- configuration
- keys
- vpn
- microsoft
title: Installing and Configuring OpenVPN 2.3 on Microsoft Windows Small Business Server 2003
---
My previous posts
(http://nkush.blogspot.com.au/2012/08/installing-openvpn-22-on-centos-63-64bit.html
and
http://nkush.blogspot.com.au/2011/10/installing-openvpn-22-on-centos-57.html)
have been on installing OpenVPN on Linux.  
  
This post is slightly different as it installs and configures OpenVPN on
a Microsoft Windows Small Business Server (SBS). The SBS installation is
also different from the previous write-ups since this configuration uses
Ethernet bridging instead of tunneling.  
  
Although SBS comes with Layer2 Tunneling Protocol (L2TP) and
Point-to-point Tunelling Protocol (PPTP) for Virtual Private Network
(VPN), some users may want to use an Secure Sockets Layer (SSL) based
VPN such as OpenVPN. The default installation location, i.e. C:\\Program
Files\\OpenVPN\\ is used in the instructions below  
  
<span class="underline">Installation:</span>  

Before downloading and installing OpenVPN, the server needs to have IP
forwarding enabled. This is trivial in \*nix based systems, but requires
a hack in the Windows registry. Edit the parameters and set
IPEnableRouter to 1

1.  HKLM\\SYSTEM\\CurrentControlSet\\Services\\Tcpip\\Parameters\\IPEnableRouter
2.  Reboot the server to ensure the changes made above take effect

Download and install the OpenVPN application<span
style="font-size: xx-small;">\[1\]</span>
from http://openvpn.net/index.php/open-source/downloads.html

Open a command prompt and change to the default installation directory

1.  Start&gt; Run&gt; cmd
2.  cd C:\\Program Files\\OpenVPN

Ensure that the path C:\\Program Files\\OpenVPN\\bin\\ is added to the
system environment PATH

1.  set PATH=%PATH%;C:\\Program Files\\OpenVPN\\bin\\

Copy the file C:\\Program Files\\OpenVPN\\easy-rsa\\vars.bat.sample
to C:\\Program Files\\OpenVPN\\easy-rsa\\vars.bat

1.  cd C:\\Program Files\\OpenVPN\\easy-rsa\\
2.  copy vars.bat.sample vars.bat **OR** run the init-config.bat script

Edit the file (edit) and change the following

Since key lengths less than 2048 are not recommended<span
style="font-size: xx-small;">\[2\]</span>, change the key size to be
4096

1.  set KEY\_SIZE=4096

Configure the following

1.  KEY\_COUNTRY
2.  KEY\_PROVINCE
3.  KEY\_CITY
4.  KEY\_ORG
5.  KEY\_EMAIL
6.  KEY\_CN
7.  KEY\_NAME
8.  KEY\_OU
9.  PKCS11\_MODULE\_PATH
10. PKCS11\_PIN

Setup environment variables by executing the vars.bat script

Initialise the keys directory and empty the keys database and serial
number by executing clean-all.bat. WARNING: this will delete any
existing keys

Create certificate for the certificate authority (CA), this will
generate the certificate signing request, the CA certificate (ca.crt)
and CA key (ca.key).

1.  build-ca.bat

Create the Diffie Hellman files. These files are used for the key
exchange to ensure the confidentiality over an insecure channel. Based
on the length of the key used (KEY\_SIZE) it may take a while

1.  build-dh.bat

Create the server certificate and key and commit them

1.  build-key-server.bat <span
    style="font-family: Courier New, Courier, monospace;">&lt;SERVER-NAME&gt;</span>

Create user machine certificates and keys and commit them (one for each
user/machine)

1.  build-key.bat <span
    style="font-family: 'Courier New', Courier, monospace;">&lt;USER-MACHINE&gt;</span>
2.  ***Note**: when generating individual user/machine certificate and
    keys ensure that the common names are unique and for maintenance
    reasons, its easier if you match the user/machine and the common
    name*

Copy the server configuration file to the configuration directory

1.  cd C:\\Program Files\\OpenVPN\\sample-config
2.  copy server.ovpn ..\\config\\

Edit the server config file. You may use the full path of the
certificates and keys, or copy them into the same directory as your
configuration file.

cd  C:\\Program Files\\OpenVPN\\config

edit server.ovpn

1.  port 1194
2.  proto udp
3.  dev tap
4.  dev-node MyTap
5.  6.  ca ca.crt
7.  cert &lt;<span
    style="font-family: Courier New, Courier, monospace;">SERVER-NAME</span>&gt;.crt
8.  key &lt;<span
    style="font-family: Courier New, Courier, monospace;">SERVER-NAME</span>&gt;.key
9.  dh dh&lt;<span
    style="font-family: Courier New, Courier, monospace;">KEY\_SIZE</span>&gt;.pem
10. ifconfig-pool-persist ipp.txt
11. server-bridge 10.8.0.4 255.255.255.0 10.8.0.50 10.8.0.100
12. push "route &lt;<span
    style="font-family: Courier New, Courier, monospace;">LAN-NETWORK</span>&gt;
    &lt;<span
    style="font-family: Courier New, Courier, monospace;">LAN-NETMASK</span>&gt;"
13. keepalive 10 120
14. comp-lzo
15. max-clients 5
16. status openvpn-status.log
17. log-append  openvpn.log
18. verb 3
19. mute 5

Change the TAP adapter 

1.  Rename to suit the configured name above, in the case of this
    example "MyTap"
2.  Set a static IPv4 address of 10.8.0.4 (or whatever is specified in
    14.11 in the server-bridge setting

Start the OpenVPN service and check the logs for any errors

<span class="underline">Routing changes</span>:

1.  You may also need to make routing changes. Depending on your router
    the settings may differ, but the basic requirement is to add a
    static route to the VPN tunnel network, i.e. 10.8.0.0/24 to the
    OpenVPN server.
2.  If the server does not have a WAN IP address and is located behind a
    router performing NAT, then port forwarding rules should be
    implemeneted to port formward traffic on UDP port 1194 to the VPN
    server.

<span class="underline">Client Configuration</span>:  
  

1.  client
2.  dev tap
3.  proto udp
4.  remote &lt;<span
    style="font-family: Courier New, Courier, monospace;">SERVER-WAN</span>&gt;
    1194
5.  resolv-retry infinite
6.  nobind
7.  persist-key
8.  persist-tun
9.  ca ca.crt
10. cert &lt;<span
    style="font-family: Courier New, Courier, monospace;">USER-MACHINE</span>&gt;.crt
11. key &lt;<span
    style="font-family: Courier New, Courier, monospace;">USER-MACHINE</span>&gt;.key
12. comp-lzo
13. verb 3
14. route-method exe
15. route-delay 5

***Note**: SBS running as the Domain Controller (DC) only allows
Terminal Services to run in Administration mode, i.e. only two
concurrent Remote Desktop Protocol (RDP) sessions, and one
local console session. It does not run in Application mode, which allows
additional licenses to be installed*

  

<span class="underline">References:</span>

1.  http://openvpn.net/index.php/open-source/downloads.html
2.  http://csrc.nist.gov/publications/nistpubs/800-131A/sp800-131A.pdf
