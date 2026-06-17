---
author: Nishchal Kush
published: '2014-10-22T16:51:00+10:00'
slug: 2014-10-22-configuring-rancid-on-centos-6-5
tags:
- epel
- yum install
- router
- find
- switch
- cron
- centos
- linux
- configuration
- rancid
- crontab
- yum
- cvs
- svn
title: Configuring RANCID on CentOS 6.5
---
RANCID stands for really awesome new cisco configuration differ<span
style="font-size: xx-small;">\[1\]</span> and polls Cisco devices to get
a copy of the configuration and an inventory of the hardware and commits
the details to a version control system such a CVS or SVN. The version
control is used to maintain a history of the changes, and any changes to
the configuration are reported. There are a number of guides available
for installing RANCID<span
style="font-size: xx-small;">\[2,4,5\]</span>, but I've documented the
steps I took here for my reference.  
  
<span class="underline">Pre-requisites</span>  
You must have and use the EPEL repositories. Note that at the time this
post was made, the current version was version 3.1<span
style="font-size: xx-small;">\[3\]</span>. However, the version
available via EPEL was only 2.3.6.  
  
<span class="underline">Installation</span>  

1.  yum -y update
2.  yum -y upgrade
3.  yum -y install rancid

<span class="underline">Configuration</span>

Edit the /etc/rancid/rancid.conf file to create a list of groups for
your devices to change the LIST\_OF\_GROUPS variable
e.g., LIST\_OF\_GROUPS="routers switches", change the CVSROOT if you are
using SVN i.e., CVSROOT=$BASEDIR/SVN; export CVSROOT and change the RCS
system if changing to SVN i.e., RCSSYS=svn; export RCSSYS

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">vi  /etc/rancid/rancid.conf </span>

Create e-mail aliases for the groups, note that the names should match.
Edit the /etc/aliases file. Ensure that the newaliases command is
execute after the file has been modified

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">vi
    /etc/aliases</span>
2.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">newaliases</span>

The rancid group and users should already be created. The home directory
for the rancid user corresponds with the BASEDIR in the configuration
file viz. /var/rancid. Generate the svn repository for the
configuration, group directories, and the log directories by running the
rancid-cvs script

1.   <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">/usr/bin/rancid-cvs</span>

Add devices to each group to specify their IP address, the make or type,
and their status i.e., up or down. Edit the router.db file in each group
directory. e.g., c7206-core-router:cisco:up

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">vi
    /var/rancid/routers/router.db</span>

Next the login credentials for each node is to be specified in the
.cloginrc. Copy the file from the sample documentation, and edit the
file to provide the login credentials. I prefer to explicitly set the
node address, and user

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">cp
    /usr/share/doc/rancid-2.3.6/cloginrc.sample
    /var/rancid/.cloginrc</span>
2.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">vi /var/rancid/.cloginrc</span>
3.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">chmod
    600 .cloginrc</span>

Configure a user using TACACS or on your Cisco device to only have
privilege to view the  config 

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">username
    rancid privilege 3 secret &lt;SECRET&gt;</span>
2.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">privilege
    exec level 3 show start-config</span>

Change ownership of all files and directories in the rancid users home
directory to the rancud group and user

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">chown
    -R rancid:rancid /var/rancid</span>

Test the clogin as the rancid user

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">su -
    rancid</span>
2.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">/usr/libexec/rancid/clogin
    c7206-core-router</span>

If all goes well, run rancid manually for the first time. This will
generate config files for each define in the group in the config
directory

1.  <span
    style="font-family: Courier New, Courier, monospace; font-size: x-small;">/usr/bin/rancid-run</span>

Schedule rancid and the cleanup by setting up cron jobs as the rancid
user, crontab -e

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">\#
Minute   Hour   Day of Month   Month              Day of Week    
 Command</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">\#
(0-59)   (0-23) (1-31)         (1-12 or Jan-Dec)  (0-6 or Sun-Sat)
/...</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">  
</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">\#
shedule to run rancid every 15 minute</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">\*/15
\* \* \* \* /usr/bin/rancid-run</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">  
</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">\#
schedule to remove rancid log files over 2 days old at 8am</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">0
8 \* \* \* /bin/find /var/rancid/logs -type f -mtime +2 -exec rm {}
\\;</span>

  
<span class="underline">References</span>  

1.  http://www.shrubbery.net/rancid/
2.  http://www.shrubbery.net/rancid/RhysEvans\_overview\_0.3.pdf
3.  ftp://ftp.shrubbery.net/pub/rancid/
4.  http://networklore.com/rancid-getting-started/
5.  http://fakrul.wordpress.com/2013/11/20/rancid-websvn-centos-howto/
