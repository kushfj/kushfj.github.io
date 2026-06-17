---
author: Nishchal Kush
published: '2011-10-26T17:04:00+10:00'
slug: 2011-10-26-gnu-screen
tags:
- centos
- bash
- gnu screen
title: Gnu Screen
---
Running some experiment on a VM server I rapidly ran out of patience
having to wait for commands to run, and/or switching back and forth
using Ctrl+Z, bg, and fg. My thoughts went back to Nick Black who had
introduced me to Gnu Screen several years back, alas I has forgotten the
short-cuts, Thankfully Google and the man page came to the rescue.  
  
Since the VM server was a CentOS 6.0 box, with minimal install, I had to
install Gnu Screen using;  
  

1.  yum -y install screen

Here's a summary of the shortcuts that may be useful;

-   Ctrl+A, c : create a new screen
-   Ctrl+A, A : set a name for the screen instead of the default shell
    name (bash)
-   Ctrl+A, " : lists the screens available
-   Ctrl+A, n : toggle to next screen
-   Ctrl+A, p : toggle to previous screen

<span class="underline">References:</span>

1.  http://www.gnu.org/s/screen/
