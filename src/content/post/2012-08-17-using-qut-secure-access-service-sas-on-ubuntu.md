---
author: Nishchal Kush
published: '2012-08-17T19:02:00+10:00'
slug: 2012-08-17-using-qut-secure-access-service-sas-on-ubuntu
tags: []
title: Using QUT Secure Access Service (SAS) on Ubuntu
---
QUT SAS allows QUT students and staff remote access to QUT resources
securely. Unix and Unix-like operating systems such as Linux are not
supported. The instruction on the QUT ITServices are pretty clear \[1\].
But I have duplicated some of it here for my reference. I tested the
configuration on Ubuntu.  
  
**Install VPNC**

1.  sudo apt-get install vpnc

**Download or create the configuration file**  
The configuration file can be specified on the command line when
executing vpnc, or /etc/vpnc/default.conf and /etc/vpnc.conf will be
used. If you only using a single VPNC connection, then save the
configuration file as /etc/vpnc.conf  
Sample configuration file /etc/vpnc.conf. A sample configuration file is
provided below. If you do not have a configuration and simple execute
vpnc, you can still establish a connection by supplying the correct
input at the prompts.  

1.  https://secure.qut.edu.au/itservices/qut/qutservices/qutnetwork/qutsas/off-campus.conf
2.  Edit the configuration file to suit your credentials

**Connecting and disconnection**  
Connecting is done by executing the vpnc command. You can explicity
specify the configuration file to use at the command line. If no
configuration files are specified and the default configuration files
(/etc/vpnc.conf and /etc/vpnc/default.conf) are unavailable, then the
application will prompt for input.  

1.  /usr/sbin/vpnc <span
    style="font-size: x-small;">/home/users/kush/qut-sas.conf</span>
    *\#(connect)*
2.  /usr/sbin/vpnc-disconnect *\#(disconnect)*

**Sample configuration file**  
<span
style="font-family: &quot;Courier New&quot;,Courier,monospace;">IPSec
gateway sas.qut.edu.au</span>  
<span
style="font-family: &quot;Courier New&quot;,Courier,monospace;">IPSec ID
qut</span>  
<span
style="font-family: &quot;Courier New&quot;,Courier,monospace;">IPSec
secret qutaccess</span>  

\# student number  
Xauth username nXXXXXXX  
\# password

<span
style="font-family: &quot;Courier New&quot;,Courier,monospace;">Xauth
password XXXXXXXX </span>  
  
<span class="underline">Reference</span>:  

1.  https://secure.qut.edu.au/itservices/qut/qutservices/qutnetwork/qutsas/
