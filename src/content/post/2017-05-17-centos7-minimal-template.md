---
date: '2018-05-17T13:15:27+10:00'
draft: true
title: Centos7 Minimal Template
---

Minimal install of CentOS 7 a virtualbox image using 1024MB of RAM, and 8GB VDI hard disk. Boot up VM and configure interface connected to NAT to come up using `dhclient enp0s3`. Run initial update `yum -y update`. Shutdown VM and take base snapshot.

Because [predictable naming|https://access.redhat.com/documentation/en-us/red_hat_enterprise_linux/6/html/deployment_guide/appe-consistent_network_device_naming] shits me right off, rename the interfaces to the old style.

  * Edit the `/etc/default/grub` file and add `net.ifnames=0` to the `GRUB_CMDLINE_LINUX` variable.
  * Generate a new Grub config by running `grub2-mkconfig -o * /boot/grub2/grub.cfg`

WARNING: Do not reboot the VM, else you will need to kill the dhclient and stop the network.services and pull out the virtual cables to stop the flood to output to stdout. Some of us, found out the hard way.

  * Generate a persistence file in the following format `vi /etc/udev/rules.d/70-persistent-net.rules`, replace the EUI hardware address 00:00:00:00:00:00 with the actual hardware adddress and the name eth0 to whatever you like:

```
SUBSYSTEM=="net", ACTION=="add", DRIVERS=="?", ATTR{address}=="00:00:00:00:00:00", ATTR{type}=="1", KERNEL=="eth*", NAME="eth0"
```
