---
author: Nishchal Kush
published: '2013-04-04T19:10:00+10:00'
slug: 2013-04-04-centos-6-4-virtualbox-vm-wont-boot-up-after-doing-an-update-upgrade
tags:
- screen
- virtualbox
- gdm
- x11
- update
- centos
- virtual machine
- upgrade
title: CentOS 6.4 VirtualBox VM won't boot up after doing an update/upgrade!!!
---
Often times, I employ a CentOS VirtualBox virtual machine (VM) as a
development, testing and staging environment, I love the flexibility of
virtual environments for testing and development work before moving my
work to production environments.  
  
Recently I ran a yum update and yum upgrade on a CentOS 6.4 VM and
subsequently rebooted it, only to be greeted by a blank screen following
bootup. A quick search of virtual TTY terminals yielded a login
prompt.  
  
Search of the usual logs (/var/log/messages and /var/log/dmesg) did not
yield anything useful, however, the /var/log/Xorg.0.log displayed some
interesting messages. Of particular interest were;  
  
"... (EE) Failed to load module "vboxvideo" (module requirement
mismatch, 0)"  
... (EE) No drivers available."  
Fatal server error:"  
... no screens found"  
  
A bit of Google revealed
"http://www.centos.org/modules/newbb/print.php?form=1&topic\_id=41799&forum=55&order=ASC&start=0"
So I followed suit and backed up the /etc/X11/xorg.conf file and
rebooted :) All is well...
