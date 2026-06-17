---
author: Nishchal Kush
published: '2011-10-25T14:03:00+10:00'
slug: 2011-10-25-apacite-on-mac-os-x-lion-with-texlive
tags:
- texlive-bibtex-extra
- error
- lion
- macbook pro
- macports
title: APAcite on Mac OS X (Lion) with texlive
---
I had to recently rebuild my Mac Book Pro (gasp!), and decided to
upgrade to Lion.  The whole process was relatively painless. Files were
copied back from backups, and updated from my SVN repositories, however
I had troubles installing the appropriate Mac port package for the
APACite classes.  
  
sudo port install texlive-bibtex-extra  
  
The latter yielded errors, which were logged in  
  
/opt/local/var/macports/logs/\_opt\_local\_var\_macports\_sources\_rsync.macports.org\_release\_tarballs\_ports\_perl\_p5-text-bibtex/p5.12-text-bibtex/main.log  
  
Since the dependency p5.12-text-bibtex could not be installed,
examination of the log file provided the following clues; error: 'main'
must return 'int'  
  
The same error was reported for;  
  

1.  /opt/local//var/macports/build/\_opt\_local\_var\_macports\_sources\_rsync.macports.org\_release\_tarballs\_ports\_perl\_p5-text-bibtex/p5.12-text-bibtex/work/Text-BibTeX-0.60/btparse/tests/namebug.c
2.  /opt/local//var/macports/build/\_opt\_local\_var\_macports\_sources\_rsync.macports.org\_release\_tarballs\_ports\_perl\_p5-text-bibtex/p5.12-text-bibtex/work/Text-BibTeX-0.60/btparse/tests/tex\_test.c

  
A quick rename of void to int enabled the package to be installed
without further issues.
