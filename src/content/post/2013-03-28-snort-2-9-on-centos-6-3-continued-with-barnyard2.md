---
author: Nishchal Kush
published: '2013-03-28T18:39:00+10:00'
slug: 2013-03-28-snort-2-9-on-centos-6-3-continued-with-barnyard2
tags:
- waldo
- mysql
- unified2
- centos
- snort
- barnyard2
- configuration
- barnyard
title: Snort 2.9 on CentOS 6.3 (continued) with Barnyard2
---
This is a continuation of the post on installing Snort 2.9 on CentOS 6.4
(http://nkush.blogspot.com.au/2013/03/snort-29-on-centos-63.html). This
post installs Barnyard2 on the host.  
  
Barnyard is an output system for Snort. If effectively allows better
snort performance by enabling Snort to produce binary output which is
then processed by Barnyard.  
  
Barnyard processes the binary Snort output files (unified2 binary) and
stores the processed data into a database back-end, for example MySQL.
The advantage of using Barnyard instead of the database output from
Snort is that Barnyard is able to "cache" the data in case the database
is unavailable.  
  
Barnyard is able to be executed in three modes, this example employs the
continual mode with bookmarking. A bookmark (waldo) file is employed to
keep track of the progress of Barnyard processing. In case of Barnyard
failure, it can resume where it left off based on the bookmark file.  
  
<span class="underline">Installation</span>:  
  

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Install and
configure MySQL</span></span></span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">yum -y
    install mysql mysql-server mysql-devel
    mysql-bench</span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">service
    mysqld start</span></span></span>
3.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span"
    style="font-family: inherit;">/usr/bin/mysql\_secure\_installation
    </span></span></span>

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Download and
install Barnyard2</span></span></span> from
<http://securixlive.com/barnyard2/download.php>

1.  wget http://securixlive.com/download/barnyard2/barnyard2-1.9.tar.gz
2.  tar zxvf barnyard2-1.9.tar.gz
3.  cd barnyard2-1.9
4.  ./configure --with-mysql --with-mysql-libraries=/usr/lib64/mysql/
5.  make
6.  make install

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Configure
Barnyard to process Snort output</span></span></span>

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Change Snort
config to output to the unified file format</span></span></span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">output
    unified2: filename merged.log, limit 128, mpls\_event\_types,
    vlan\_event\_types </span></span></span>

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Change the
Barnyard config </span></span></span><span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span"
style="font-family: inherit;">(</span></span></span><span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;"><span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span"
style="font-family: inherit;">/usr/local/etc/barnyard2.conf</span></span></span>)</span></span></span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    logdir: /var/log/barnyard2</span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    hostname:    localhost</span></span></span>
3.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    interface:    <span
    class="underline">*ethX*</span></span></span></span>
4.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    daemon</span></span></span>
5.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    set\_gid:<span class="underline">*nnnn*</span></span></span></span>
6.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    set\_uid:<span class="underline">*nnnn*</span></span></span></span>
7.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    show\_year</span></span></span>
8.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config umask:
    066</span></span></span>
9.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">config
    waldo\_file: /var/log/snort/barnyard2.waldo</span></span></span>
10. <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">input
    unified2</span></span></span>
11. <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">output
    database: log, mysql, user=snort password=<span
    class="underline">*password*</span> dbname=barnyard2 host=localhost
    </span></span></span>

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Create the MySQL
database for Barnyard</span></span></span>

1.  mysqladmin -u root -p create barnyard2
2.  mysql -u root -p -D barnyard2 &lt; ./schemas/create\_mysql

Grant privileges to database

1.  mysql -u root -p
2.  GRANT ALL PRIVILEGES ON barnyard2.\* TO snort@localhost WITH GRANT
    OPTION;
3.  SET PASSWORD FOR snort@localhost=PASSWORD('*password*');

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Prepare
Barnyard2</span></span></span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">touch
    </span></span></span><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span"
    style="font-family: inherit;">/var/log/snort/barnyard2.waldo</span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">chown -R
    snort:snort </span></span></span><span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span"
    style="font-family: inherit;">/var/log/snort</span></span></span>

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">Run Barnyard then
Snort</span></span></span>

1.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">barnyard2 -c
    /usr/local/etc/barnyard2.conf -d /var/log/snort/ -w
    /var/log/snort/barnyard2.waldo -f merged.log -u snort -g snort
    -D</span></span></span>
2.  <span
    style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
    style="color: #111111; line-height: 18px;"><span
    class="Apple-style-span" style="font-family: inherit;">snort -c
    /etc/snort/snort.conf -i eth4 -u snort -g snort
    -D</span></span></span>

  
If all goes well then you should see events being logged into your event
table in the barnyard2 database.  
  
<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;"><span
class="underline">Errors</span>:</span></span></span>  

<span
style="-webkit-border-horizontal-spacing: 0px; -webkit-border-vertical-spacing: 0px; -webkit-text-decorations-in-effect: none; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px; border-collapse: separate; color: black; font-style: normal; font-variant: normal; letter-spacing: normal; line-height: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px;"><span
style="color: #111111; line-height: 18px;"><span
class="Apple-style-span" style="font-family: inherit;">ERROR: unable to
find mysqlclient library (libmysqlclient.\*)</span></span></span>

1.  ./configure --with-mysql-libraries=/usr/lib64/mysql/

ERROR: Unable to open directory '' (No such  
 file or directory)  
ERROR: Unable to find the next spool file!

1.   Ensure that the waldo file is specified (by the -w option included
    as a command line argument or in the config file)

WARNING: Can't extract timestamp extension from 'alert'using base ''

1.  Ensure that the unified2 file is specified (by the -f option
    included as a command line argument or in the config file)

FATAL ERROR: Absdir is not a subset of the logdir

1.   Ensure that the logdir is configured in the Barnyard configuration
    file

FATAL ERROR: database: mysql\_error: Can't connect to local MySQL server
through socket '/var/lib/mysql/mysql.sock' (2)

1.  Ensure that the MySQL service/daemon is running
