---
author: Nishchal Kush
published: '2014-09-25T15:12:00+10:00'
slug: 2014-09-25-patching-bash-shellshock-on-apple-mac-os-x-10-9-5
tags:
- update
- shellshock
- mac os x
- xcode
- Mac
- software update
- upgrade
- bash
- shell shock
- shell
title: Patching Bash "shellshock" on Apple Mac OS X 10.9.5
---
Given the recent bash vulnerability disclosure<span
style="font-size: xx-small;">\[1\]</span> most linux distributions have
released patches. Unfortunately Apple still expected users to compile
their patches into bash. If you were using Homebrew or Macport you were
in better standing and simply had to create symlinks to the patched
executables. I've documented the steps I had to take on my Mac
desktop.  
  
<span class="underline">Compile</span>  

1.  mkdir bash
2.  cd bash/
3.  wget http://opensource.apple.com/tarballs/bash/bash-92.tar.gz
4.  tar zxvf bash-92.tar.gz
5.  cd bash-92
6.  cd bash-3.2/
7.  curl https://ftp.gnu.org/pub/gnu/bash/bash-3.2-patches/bash32-052 |
    patch -p0
8.  curl https://ftp.gnu.org/pub/gnu/bash/bash-3.2-patches/bash32-053 |
    patch -p0
9.  curl https://ftp.gnu.org/pub/gnu/bash/bash-3.2-patches/bash32-054 |
    patch -p0
10. cd ..
11. xcodebuild

<span class="underline">Verify</span>

1.  /bin/bash --version
2.  ~/bash/bash-92/build/Release/bash --version

<span class="underline">Install</span>

1.  <s>sudo mv /bin/bash /bin/bash.vulnerable</s> sudo cp /bin/bash
    /bin/bash.vulnerable
2.  <s>sudo mv /bin/sh /bin/sh.vulnerable</s> sudo cp /bin/sh
    /bin/sh.vulnerable
3.  sudo chmod 0000 /bin/bash.vulnerable
4.  sudo chmod 0000 /bin/sh.vulnerable
5.  sudo cp ~/bash/bash-92/build/Release/bash /bin/
6.  sudo cp ~/bash/bash-92/build/Release/sh /bin/
7.  /bin/bash --version

  

<span class="underline">References</span>:  

1.  https://www.us-cert.gov/ncas/current-activity/2014/09/24/Bourne-Again-Shell-Bash-Remote-Code-Execution-Vulnerability
2.  http://www.theregister.co.uk/2014/09/24/bash\_shell\_vuln/
3.  https://securityblog.redhat.com/2014/09/24/bash-specially-crafted-environment-variables-code-injection-attack/
4.  https://access.redhat.com/articles/1200223
5.  http://alblue.bandlem.com/2014/09/bash-remote-vulnerability.html
6.  http://support.apple.com/kb/HT1222
7.  http://lists.gnu.org/archive/html/bug-bash/2014-09/msg00085.html
8.  http://lists.gnu.org/archive/html/bug-bash/2014-09/msg00228.html
9.  http://lists.gnu.org/archive/html/bug-bash/2014-09/msg00282.html
