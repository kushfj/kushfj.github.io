---
author: Nishchal Kush
published: '2011-09-21T14:11:00+10:00'
slug: 2011-09-21-evernote-and-nix-nevernote-on-ubuntu-10-04
tags:
- ubuntu
- linux
- sudo
- apt-get-repository
- evernote
- apt-get install
- nevernote
title: Evernote and Nix/NeverNote on Ubuntu 10.04
---
Evernote is a great tool. I absolutely love it. The only con, is that
it's nto available natively for Linux. So I have to run it under the
Windows Emulator or *wine.* The installation is fairly simple.  

1.  wget
    http://evernote.s3.amazonaws.com/win4/public/Evernote\_4.5.0.5229.exe
2.  wine Evernote\_4.5.0.5229.exe

Obviously not running natively there is a slight performance lag. This
may be attributed to my 5 year old laptop. Although it's still usable,
the slow synchronization soon becomes tiresome. Fortunately there is a
Linux native client called NeverNote<span
style="font-size: xx-small;">\[2\]</span>.  

1.  sudo add-apt-repository ppa:vincent-c/nevernote
2.  sudo apt-get update
3.  sudo apt-get install nevernote
4.  nixnote

NixNote is a bit ugly, but functional. Definitely faster than running
Evernote in emulation.  The feature that I like best is that you are
able to encrypt the NixNote database using AES when you shutdown. This
is a definite plus in my books.  
  
Therefore, if you can live with the degraded performance, then Evernote
will do, but if you need to work faster, want that extra bit of
security, and an ugly interface does not bother you, then give NixNote
(aka NeverNote) a try.  
  
<span class="underline">References</span>:  

1.  http://www.howtogeek.com/howto/35661/how-to-install-evernote-4.0-in-ubuntu-using-wine/
2.  http://www.techdrivein.com/2011/06/nevernote-open-source-evernote-clone.html
