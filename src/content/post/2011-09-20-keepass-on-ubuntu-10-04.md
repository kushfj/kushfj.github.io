---
author: Nishchal Kush
published: '2011-09-20T01:17:00+10:00'
slug: 2011-09-20-keepass-on-ubuntu-10-04
tags:
- mono
- apt-get
- ubuntu
- install
- linux
- keepass
- password
- unzip
- apt-key
title: KeePass on Ubuntu 10.04
---
KeePass is a very popular password management software. One of my client
uses this for their systems and I was given a copy of their database.
Since I mostly use linux when I am working, I needed a way to get this
working on Ubuntu 10.04. Instructions are widely available, but again
for my benefit, I have documented them here as step-by-step guide for
myself. At the time of this blog post the 2.x version of KeePass was
2.16  
  
Firstly install Mono. For more details refer to the Badger ports
website<span style="font-size: xx-small;">\[1\]</span>.  

Edit the /etc/apt/sources.list file

Add the lines

-   *\# For mono 2.6 -&gt; needed by KeePass*
-   *deb http://badgerports.org lucid main*

cd /etc/apt

sudo wget http://badgerports.org/directhex.ppa.asc

sudo apt-key add directhex.ppa.asc

sudo apt-get update

sudo apt-get install mono mono-devel

mono --version

-   *\# Confirm the mono version is &gt;= 2.6*

Download and install the KeePass from the KeePass website<span
style="font-size: xx-small;">\[2\]</span>.  

1.  sudo mkdir -p /opt/KeePass2
2.  cd /opt/KeePass2
3.  wget http://downloads.sourceforge.net/keepass/KeePass-2.16.zip
4.  sudo unzip KeePass-2.16.zip

Execute the KeePass application  

1.  mono /opt/KeePass2/KeePass.exe &

There does appear to be a lot of debug information (am assuming its
debug information) written to the terminal, but these should be safe to
ignore.  
  
<span class="underline">References</span>:  

1.  http://badgerports.org
2.  http://keepass.info
