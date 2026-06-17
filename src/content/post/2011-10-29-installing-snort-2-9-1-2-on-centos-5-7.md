---
author: Nishchal Kush
published: '2011-10-29T21:11:00+10:00'
slug: 2011-10-29-installing-snort-2-9-1-2-on-centos-5-7
tags:
- mysql
- centos
- install
- pcre
- libdnet
- snort
- libpcap
- repository
- daq
- yum
- barnyard
title: Installing Snort 2.9.1.2 on CentOS 5.7
---
CentOS 5.7 uses an older version of libpcap (0.9.4), but Snort's Data
Acquisition Library (daq) needs a newer version of libpcap (&gt;=1.0.0).
The latter is not an issue with the CentOS 6.0. Vishesh Kumar <span
class="Apple-style-span" style="font-size: xx-small;">\[1\]</span>
provides an excellent instructions to getting Snort 2.9 to run on RHEL 5
(<http://www.linuxmantra.com/2010/10/install-snort-29-on-rhel-5.html>).
The purpose of this post is not to duplicate his efforts, but to extend
it slightly to include instructions for a complete Snort set-up.  

1.  libpcap - http://www.tcpdump.org/release/libpcap-1.1.1.tar.gz <span
    class="Apple-style-span" style="font-size: xx-small;">\[3\]</span>
2.  daq : http://www.snort.org/downloads/1221 <span
    class="Apple-style-span" style="font-size: xx-small;">\[2\]</span>
3.  snort : http://www.snort.org/downloads/1207 <span
    class="Apple-style-span" style="font-size: xx-small;">\[2\]</span>

Download and install the libraries and software as per the instructions
below;  

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Enable the Extra
Packaged for Enterprise Linux (EPEL) repository to enable the
installation of additional packages not available under the standard
repositories</span></span></span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">rpm
    -Uvh http://download.fedora.redhat.com/pub/epel/5/i386/epel-release-5-4.noarch.rpm</span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    update</span></span></span>
3.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    upgrade</span></span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">I<span
class="Apple-style-span" style="font-family: inherit;">nstall
developments to compile the libraries and source code, and additional
libraries and header files that are required later
on</span></span></span>

1.  <span class="Apple-style-span"
    style="color: #111111; font-family: inherit;"><span
    class="Apple-style-span" style="line-height: 18px;"><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;">yum -y groupinstall
    'Development Tools'</span></span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-align: -webkit-auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-align: -webkit-auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    install pcre-devel</span></span></span></span>
3.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-align: -webkit-auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    install libdnet-devel</span></span></span>
4.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    install zlib-devel</span></span></span>
5.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    install mysql mysql-server mysql-devel
    mysql-bench</span></span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">Download, compile
and install libpcap</span></span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;"><span
    class="Apple-style-span"
    style="color: black; line-height: normal;">wget
    http://www.tcpdump.org/release/libpcap-1.1.1.tar.gz</span></span></span>
2.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;"><span
    class="Apple-style-span"
    style="color: black; line-height: normal;">cd </span></span></span>libpcap-1.1.1
3.  ./configure --prefix=/usr
4.  make && make install

<span class="Apple-style-span" style="font-family: inherit;">Download,
compile and install daq</span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span"
    style="font-family: inherit;">wget <http://www.snort.org/downloads/1221> -O
    daq-0.6.2.tar.gz</span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span"
    style="font-family: inherit;">cd daq-0.6.2</span></span></span>
3.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span"
    style="font-family: inherit;">./configure</span></span></span>
4.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">make && make
    install</span></span></span>

<span class="Apple-style-span"
style="color: #111111; font-family: inherit;"><span
class="Apple-style-span" style="line-height: 18px;">Download, compile
and install snort</span></span>

1.  <span class="Apple-style-span"
    style="color: #111111; font-family: inherit;"><span
    class="Apple-style-span" style="line-height: 18px;"><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;">wget <http://www.snort.org/downloads/1207> -O
    snort-2.9.1.2.tar.gz</span></span></span></span>
2.  <span class="Apple-style-span" style="font-family: inherit;"><span
    class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;"><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;">cd </span></span></span></span><span
    class="Apple-style-span"
    style="color: #111111; line-height: 18px;">snort-2.9.1.2</span></span>
3.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-align: -webkit-auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">./configure
    --with-mysql</span></span></span>
4.  <span class="Apple-style-span" style="font-family: inherit;"><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-align: -webkit-auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;">make
    && </span></span><span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">make
    instal</span></span><span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">l</span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">Download, compile
and install Barnyard2</span></span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">wget
    --no-check-certificate
    https://github.com/firnsy/barnyard2/tarball/master
    -O firnsy-barnyard2-405761e.tar.gz</span></span>
2.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">tar
    zxvf firnsy-barnyard2-405761e.tar.gz</span></span>
3.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span"
    style="line-height: 18px;">cd firnsy-barnyard2-405761e</span></span>
4.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span"
    style="line-height: 18px;">./autogen.sh</span></span>
5.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">./configure
    --with-mysql</span></span>
6.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">make && make
    install</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">Create the snort
database on the mysql enginer</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">mysqladmin -u root
-p create snort</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">mysql -u root -p -D
snort &lt; schemas/create\_mysql</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">mysql -u root
-p</span></span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">GRANT
    CREATE,INSERT ON root.\* TO snort@localhost IDENTIFIED BY *'<span
    class="Apple-style-span"
    style="font-size: x-small;">PASSWORD</span>'*;</span></span>
2.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">GRANT
    CREATE,INSERT,SELECT,DELETE,UPDATE ON snort.\* TO snort@localhost
    IDENTIFIED BY *'<span class="Apple-style-span"
    style="font-size: x-small;">PASSWORD</span>'*;</span></span>

<span class="Apple-style-span"
style="color: #111111; line-height: 18px;">To get the
current registered user rules, you need to sign up and obtain an
Oinkcode. The Oinkcode will be used for downloading the rules and used
with pulledpork.</span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">Sign in or
    request an account from <https://www.snort.org/login></span></span>
2.  <span class="Apple-style-span" style="color: #111111;">Get your
    oinkcode after signing in
    from </span><https://www.snort.org/account/oinkcode>
3.  cd etc
4.  wget http://www.snort.org/reg-rules/snortrules-snapshot-*<span
    class="Apple-style-span"
    style="font-size: x-small;"></span>*.tar.gz/<span
    class="Apple-style-span"
    style="font-size: x-small;">*OINKCODE*</span> -O
    snortrules-snapshot-<span class="Apple-style-span"
    style="font-size: x-small;">*LATEST*</span>.tar.gz
5.  tar zxvf snortrules-snapshot-<span class="Apple-style-span"
    style="font-size: x-small;">*LATEST*</span>.tar.gz

<span class="Apple-style-span"
style="color: #111111; line-height: 18px;">Setup the configuration and
rules files for snort</span>

1.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">mkdir -p
    /etc/snort</span>
2.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">mv -f etc/\* .</span>
3.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">rmdir etc/</span>
4.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">mv </span>snortrules-snapshot-<span
    class="Apple-style-span"
    style="font-size: x-small;">*LATEST*</span>.tar.gz ../../
5.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">rm -f
    Makefile </span><span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">Makefile.am </span><span
    class="Apple-style-span"
    style="color: #111111; line-height: 18px;">Makefile.in</span>
6.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">cp -rf \*
    /etc/snort/</span>

<span class="Apple-style-span"
style="color: #111111; line-height: 18px;">Edit the snort
configuration</span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">vi
/etc/snort/snort.conf</span></span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">ipvar HOME\_NET
    *<span class="Apple-style-span"
    style="font-size: x-small;"></span>*</span></span>
2.  var RULE\_PATH rules<span class="Apple-style-span"
    style="color: #111111; line-height: 18px;"></span>
3.  var SO\_RULE\_PATH so\_rules<span class="Apple-style-span"
    style="color: #111111; line-height: 18px;"></span>
4.  var PREPROC\_RULE\_PATH preproc\_rules<span class="Apple-style-span"
    style="color: #111111; line-height: 18px;"></span>
5.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">output database: log,
    mysql, user=snort password=*<span class="Apple-style-span"
    style="font-size: x-small;">PASSWORD</span>* dbname=snort
    host=localhost</span>
6.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">output
    alert\_syslog: LOG\_LOCAL6 LOG\_ALERT</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">Edit the syslog.conf
file to log alerts to separate file and restart the syslog
daemon</span></span>

1.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">Include the line in
    syslog.conf "local6.\*        /var/log/snort/alerts.log"</span>
2.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span"
    style="line-height: 18px;">/etc/rc.d/init.d/syslog
    restart</span></span>

<span class="Apple-style-span"
style="color: #111111; line-height: 18px;">Test the snort installation,
and set-up environment to run snort if all OK</span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">snort -c
    /etc/snort/snort.conf -T</span></span>
2.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">useradd -G snort
    snort -s /bin/false</span></span>
3.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">chown -R
    root:snort /var/log/snort</span></span>
4.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">chmod -R g+w
    /var/log/snort</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">Configure barnyard
<span class="Apple-style-span"
style="font-size: xx-small;">\[4\]</span></span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">mkdir -p
/var/log/barnyard2</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">chmod 666
/var/log/barnyard2</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">touch
/var/log/snort/barnyard2.waldo</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">cp
etc/barnyard2.conf /etc/snort/</span></span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">Edit the
/etc/snort/barnyard2.conf</span></span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span" style="line-height: 18px;">output database:
    log, mysql, user=snort password=*<span class="Apple-style-span"
    style="font-size: x-small;"></span>* dbname=snort
    host=localhost</span></span>
2.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">config hostname:  
    localhost</span>
3.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">config interface:
     eth0</span>

<span class="Apple-style-span" style="color: #111111;"><span
class="Apple-style-span" style="line-height: 18px;">You can get snort to
start automatically, but writing a customer script to start/stop/restart
the daemon or simply kicking it off to start up when the machine boots.
Edit the rc.local file and out the following in</span></span>

1.  <span class="Apple-style-span" style="color: #111111;"><span
    class="Apple-style-span"
    style="line-height: 18px;">/usr/local/bin/snort -D -u snort -g snort
    -c /etc/snort/snort.conf -i eth0</span></span>
2.  <span class="Apple-style-span"
    style="color: #111111; line-height: 18px;">/usr/local/bin/barnyard2
    -c /etc/snort/barnyard2.conf -d /var/log/snort -f snort.log -w
    /var/log/snort/barnyard2.waldo -D</span>

<span class="underline">Common Errors:</span>  

ERROR: parser.c(5261) Could not stat dynamic module path
"/usr/local/lib/snort\_dynamicrules": No such file or directory.  
Fatal Error, Quitting..

1.  mkdir -p /usr/local/lib/snort\_dynamicrules
2.  cp /etc/snort/so\_rules/precompiled/*<span class="Apple-style-span"
    style="font-size: x-small;">DIST</span>*/i386/2.9.0.0/\*
    /usr/local/lib/snort\_dynamicrules/

ERROR: /etc/snort/rules/web-misc.rules(555) Cannot use the fast\_pattern
content modifier for a lone http cookie/http raw uri /http raw header
/http raw cookie /status code / status msg /http method buffer
content.  
Fatal Error, Quitting..

1.  The fast\_pattern option cannot be used with the http\_method
    string. Edit the web-misc.rules file and remove it from the snort
    rule. Do a search for <span class="Apple-style-span"
    style="font-family: inherit;">"<span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-size: small; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;">2010-0388</span></span>"
    and remove the alert option fast\_pattern from the alert
    rule</span>.

ERROR: /etc/snort/snort.conf(244) =&gt; 'compress\_depth' and
'decompress\_depth' should be set to max in the default policy to enable
'unlimited\_decompress'  
Fatal Error, Quitting..

1.  Edit the /etc/snort/snort.conf file and set the http\_inspect
    compress\_depth and decompress\_depth to 65535 from 20480.

ERROR: ByteExtract variable 'bugtraq' in rule \[3:13897\] is used before
it is defined

1.  Ensure that the shared libraries copied above using "cp
    /etc/snort/so\_rules/precompiled/*<span class="Apple-style-span"
    style="font-size: x-small;">DIST</span>*/i386/2.9.0.0/\*
    /usr/local/lib/snort\_dynamicrules/" are for the correct
    distribution
2.  Ensure that the rules being used are for the version of snort being
    used.

***Please** **note:** *  

1.  *These instruction are for 32bit hardware, for 64bit machines you
    will need to select appropriate 64bit RPM packages or configure and
    compile with appropriate compiler switches. These are considered
    beyond the scope of this post.*
2.  *All instructions are executed with root privileges.*

<span class="underline">References</span>:  

1.  <http://www.linuxmantra.com/2010/10/install-snort-29-on-rhel-5.html>
2.  <http://www.snort.org/snort-downloads?>
3.  <http://www.tcpdump.org/#latest-release>
4.  <http://www.snort.org/assets/145/Install_Snort_2.8.6_on_CentOS_5.5.pdf>
