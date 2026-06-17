---
author: Nishchal Kush
published: '2011-10-30T19:04:00+10:00'
slug: 2011-10-30-installing-ossec-on-centos-5-7
tags:
- tar
- centos
- squid
- snort
- ossec
- wget
- ids
- ips
title: Installing OSSEC on Centos 5.7
---
OSSEC is an open source host-based IDS that performs log analysis, and
is able to correlate and analyse logs for a number of Linux (and
Windows, but that is outside the scope of this blog post) servers. The
software architecture of OSSEC and the use of agents, lends OSSEC to
flexible deployment and management <span class="Apple-style-span"
style="font-size: xx-small;">\[1\]</span>.  
  
Set-up the Atomic repository that already has the appropriate OSSEC
packages and install them would be the easiest way. However I have a
strong dislike for the use of the /var partition (most system
administrators, hmm... well at-least I have always, set this up as a
separate partition for ease of management and security reasons) as an
install location, esp. when it has been specified as a "noexec"
partition.  
  
***Please Note**: *  
*Firstly, there are a number of dependencies of some of the set-up
below, such as Apache, PHP, MySQL, but <span class="Apple-style-span"
style="line-height: 23px;">the installation and secure configuration of
these services are beyond the scope of this blog post. Secondly, the
configuration below is only to set-up OSSEC as a monitor and not run it
in IPS, i.e. as an active response alert handler.</span>*  
  
<span class="underline">Installation using the repository</span>  

1.  <span class="Apple-style-span">wget
    https://www.atomicorp.com/installers/atomic -O atomic.sh</span>
2.  <span class="Apple-style-span">. ./atomic.sh</span>
3.  <span class="Apple-style-span">yum -y update</span>
4.  <span class="Apple-style-span">yum -y install ossec-hids
    ossec-hids-server ossec-wui</span>

<span class="Apple-style-span" style="line-height: 23px;"><span
class="underline">Installation using the tar ball source</span></span>

<span class="Apple-style-span" style="line-height: 23px;">Download,
compile and install the source</span>

<span class="Apple-style-span" style="line-height: 23px;">wget
http://www.ossec.net/files/ossec-hids-2.6.tar.gz</span>

<span class="Apple-style-span" style="line-height: 23px;">tar zxvf
ossec-hids-2.6.tar.gz</span>

<span class="Apple-style-span" style="line-height: 23px;">cd
ossec-hids-2.6/src</span>

<span class="Apple-style-span" style="line-height: 23px;">make
clean</span>

<span class="Apple-style-span" style="line-height: 23px;">make
setdb</span>

<span class="Apple-style-span" style="line-height: 23px;">make
all</span>

<span class="Apple-style-span" style="line-height: 23px;">cd ..</span>

<span class="Apple-style-span"
style="line-height: 23px;">./install.sh</span>

1.  <span class="Apple-style-span" style="line-height: 23px;">en</span>
2.  <span class="Apple-style-span"
    style="line-height: 23px;">local</span>
3.  <span class="Apple-style-span"
    style="line-height: 23px;">/opt/ossec</span>
4.  <span class="Apple-style-span" style="line-height: 23px;">y</span>
5.  <span class="Apple-style-span"
    style="line-height: 23px;">user@domain</span>
6.  <span class="Apple-style-span"
    style="line-height: 23px;">mx.domain</span>
7.  <span class="Apple-style-span" style="line-height: 23px;">y</span>
8.  <span class="Apple-style-span" style="line-height: 23px;">y</span>
9.  <span class="Apple-style-span" style="line-height: 23px;">n</span>

<span class="Apple-style-span" style="line-height: 23px;">Setup mysql DB
for logging</span>

<span class="Apple-style-span" style="line-height: 23px;">Grant access
to database</span>

1.  <span class="Apple-style-span" style="line-height: 23px;">mysql -u
    root -p</span>
2.  <span class="Apple-style-span" style="line-height: 23px;">grant
    INSERT,SELECT,UPDATE,CREATE,DELETE,EXECUTE on ossec.\* to
    ossecuser@localhost;</span>
3.  <span class="Apple-style-span" style="line-height: 23px;">set
    password for ossecuser@localhost=PASSWORD('<span
    class="Apple-style-span"
    style="font-size: x-small;">PASSWD</span>');</span>
4.  <span class="Apple-style-span"
    style="line-height: 23px;">quit;</span>

<span class="Apple-style-span" style="line-height: 23px;">Create
database and tables</span>

1.  <span class="Apple-style-span" style="line-height: 23px;">mysqladmin
    -u root -p create ossec</span>
2.  <span class="Apple-style-span" style="line-height: 23px;">mysql -u
    root -p ossec &lt; src/os\_dbd/mysql.schema</span>

<span class="Apple-style-span" style="line-height: 23px;">Edit the
/opt/ossec/etc/ossec.conf file</span>

1.  <span class="Apple-style-span" style="line-height: 23px;">Check the
    wiki to setup logging to the database and syslog <span
    class="Apple-style-span"
    style="font-size: xx-small;">\[2\]</span></span>

<span class="Apple-style-span" style="line-height: 23px;">Install the
Web User Interface, you will need Apache and php</span>

<span class="Apple-style-span" style="line-height: 23px;">Again, the
installation and secure configuration of Apache is beyond the scope of
this blog post. </span>

<span class="Apple-style-span" style="line-height: 23px;">wget
http://www.ossec.net/files/ui/ossec-wui-0.3.tar.gz</span>

<span class="Apple-style-span" style="line-height: 23px;">tar
zxvf </span><span class="Apple-style-span"
style="line-height: 23px;">ossec-wui-0.3.tar.gz</span>

<span class="Apple-style-span" style="line-height: 23px;">mkdir -p
/var/www/html/ossec-wui</span>

<span class="Apple-style-span" style="line-height: 23px;">cp -rf
./ossec-wui-0.3/\* /var/www/html/ossec-wui/</span>

<span class="Apple-style-span" style="line-height: 23px;">cd
/var/www/html/ossec-wui/</span>

<span class="Apple-style-span"
style="line-height: 23px;">./setup.sh</span>

<span class="Apple-style-span" style="line-height: 23px;">Edit the
ossec\_conf.php to point to the ossec installation completed in the
previous stage</span>

1.  <span class="Apple-style-span"
    style="line-height: 23px;">$ossec\_dir="/opt/ossec";</span>

<span class="Apple-style-span" style="line-height: 23px;">Start the
OSSEC services</span>

1.  <span class="Apple-style-span"
    style="line-height: 23px;">/opt/ossec/bin/ossec-control enable
    database</span>
2.  <span class="Apple-style-span"
    style="line-height: 23px;">/opt/ossec/bin/ossec-control
    enable client-syslog</span>
3.  <span class="Apple-style-span"
    style="line-height: 23px;">/opt/</span><span
    class="Apple-style-span"
    style="line-height: 23px;">ossec/bin/ossec-control start</span>

<!-- -->

<span class="Apple-style-span" style="line-height: 23px;"><span
class="underline">Possible Errors</span>:</span>

<span class="Apple-style-span" style="line-height: 23px;">When executing
OSSEC-WUI you may get a page that displays. </span><span
class="Apple-style-span" style="line-height: 23px;">"Unable to access
OSSEC directory". </span><span class="Apple-style-span"
style="line-height: 23px;">Ensure that the user that your Apache web
server runs as, e.g. httpd or apache is added to the ossec group</span>

1.  <span class="Apple-style-span" style="line-height: 23px;">usermod -a
    -G ossec apache.</span>

<span class="Apple-style-span" style="line-height: 23px;">"Unable to
retrieve alerts". Ensure that you web server is able to open the alerts
file. This issue is two fold, firstly ensure that the web server has
permissions to open the file and secondly that the fopen command is
enabled in PHP.</span>

1.  <span class="Apple-style-span" style="line-height: 23px;">safe\_mode
    Off</span>
2.  <span class="Apple-style-span"
    style="line-height: 23px;">safe\_mode\_gid On</span>

<span class="Apple-style-span" style="line-height: 23px;">These two are
no so much error, but warning that will be annoy your syslog server, but
depend on your PHP configuration.</span>

<span class="Apple-style-span" style="line-height: 23px;">PHP Warning:
 shell\_exec() has been disabled for security reasons - This is because
of a uname -a query in the
/var/www/html/ossec-wui/lib/os\_lib\_agent.php script;</span>

1.  <span class="Apple-style-span"
    style="line-height: 23px;">//$agent\_list\[$agent\_count\]{'os'} =
    \`uname -a\`;</span>
2.  <span class="Apple-style-span"
    style="line-height: 23px;">$agent\_list\[$agent\_count\]{'os'} =
    "Linux";</span>

<span class="Apple-style-span" style="line-height: 23px;">PHP Warning:
 fseek() expects parameter 3 to be long - This may be a simple
programming error in the
/var/www/html/ossec-wui/lib/os\_lib\_alerts.php</span>

1.  <span class="Apple-style-span"
    style="line-height: 23px;">//fseek($fp, $seek\_place,
    "SEEK\_SET");</span>
2.  <span class="Apple-style-span" style="line-height: 23px;">fseek($fp,
    $seek\_place );</span>

<!-- -->

<span class="Apple-style-span" style="line-height: 23px;"><span
class="underline">References</span>:</span>

1.  <span class="Apple-style-span"
    style="line-height: 23px;"><http://en.wikipedia.org/wiki/OSSEC></span>
2.  <http://www.ossec.net/wiki>
