---
author: Nishchal Kush
published: '2012-07-25T21:08:00+10:00'
slug: 2012-07-25-how-to-install-springer-lecture-notes-in-computer-science-lncs-style-for-miktek-on-windows-7
tags:
- llncs2e.zip
- rebuild
- miktek
- llncs.cls
- llncs2e
- LaTeX
- tex
- Rebuild FNDB
- LLNCS
- splncs
- filename database
title: How to install Springer Lecture Notes in Computer Science (LNCS) style for MiKTeK on Windows 7
---
Following on from my previous post... I had the same issue when working
on my Microsoft Windows desktop at home, i.e. got the following error "!
LaTeX Error: File \`llncs.cls' not found.". So had to download the
"llncs2e.zip" file yet again from
"<http://www.springer.com/computer/lncs?SGWID=0-164-6-793341-0/>"  

1.  Dowload and extract llncs2e.zip
2.  Create a directory called splncs in C:\\Program Files\\MiKTeX
    2.?\\bibtex\\bst
3.  Move the extracted file splncs.bst, splncs\_srt.bst, and
    splncs03.bst into the new directory C:\\Program Files\\MiKTeX
    2.9\\bibtex\\bst\\splncs
4.  Move the extracted directory ?? into C:\\Program Files\\MiKTeX
    2.9\\tex\\latex
5.  Rebuild the filename database by Miktek - Maintenance - Settings,
    and click on the "Refresh FNDB" button (this may take a while
    depending on your computer)
