---
author: Nishchal Kush
published: '2011-09-21T12:28:00+10:00'
slug: 2011-09-21-cisco-console-from-ubuntu-10-04
tags:
- ubuntu
- '9600'
- console
- serial
- linux
- minicom
- cisco
title: Cisco console from Ubuntu 10.04
---
It's pretty easy to set-up Cisco serial console connectivity on Ubuntu
10.04. The usual way is to use *minicom*. The serial ports usually
called COM1-4 usually have the following address range;  

1.  COM1 - 3E8
2.  COM2 - 2F8
3.  COM3 - 3E8
4.  COM4 - 2E8

To complete the setup first determine the address used for COM1 (or
whichever serial port you wish to use) on your machine  query the kernel
buffer ring using the *dmesg* command, then install and configure the
*minicom*, modem emulation tool.  

1.  sudo dmesg | grep tty
2.  sudo apt-get install minicom
3.  sudo minicom -s *\# Configure the terminal to use 9600-8-N-1 and
    save as dfl*
4.  sudo minicom

  
<span class="underline">References:</span>  

1.  https://help.ubuntu.com/community/CiscoConsole
2.  http://useopensource.blogspot.com/2007/01/using-cisco-console-in-linux.html
