---
author: Nishchal Kush
date: '2018-05-14T12:56:13+10:00'
tags:
- arm
- cross compile
- pi
- libpcap
- pcap
- c
- programming
title: Cross compile libpcap for Arm
---

This has been tested on Ubuntu 16.04.1 Desktop (64-bit), and assumes that arm-linux-gnuabi-gcc has already been installed, e.g. ```sudo apt-get install -y gcc-arm-linux-gnueabi```

1. Download the latest libpcap source tar ball from [http://www.tcpdump.org/#latest-releases], e.g. libpcap-1.8.1.tar.gz
* tar zxvf libpcap-1.8.1.tar.gz
* apt-get install flex bison byacc
* export CC = arm-linux-gnueabi-gcc
* ./configure --host=arm-linux --with-pcap=linux
* make

Once the library has been compiled, it may be linked to other code, using the -L gcc flag and the location of the library. e.g. ```-lpcap -L/home/nkush/development/libpcap-1.8.1```

