---
author: Nishchal Kush
published: '2012-10-22T13:37:00+10:00'
slug: 2012-10-22-latex-error-file-algorithm2e-sty-not-found
tags:
- pseudocode
- algorithms
- texlive
- mac os x
- macbook pro
- pdflatex
- macports
- LaTeX
- tex
- texlive-science
title: '! LaTeX Error: File `algorithm2e.sty'' not found.'
---
During yet another LaTeX project on my MacBook, I added some algorithms
to my paper. After checking a couple of examples online, and discussing
with a colleage I decided to go with algorithm2e over others such as
algorithm, algorithmic, algorithmicx, program and pseudocode<span
style="font-size: xx-small;">\[1\].</span>  
  
However I got the following error "**! LaTeX Error: File
\`algorithm2e.sty' not found.**" Since I am using macport, to resolve
this I needed to install the texlive-science package by executing **sudo
port install texlive-science,** and all was good again.  
  
<span class="underline">References</span>:  
  

1.  http://en.wikibooks.org/wiki/LaTeX/Algorithms\_and\_Pseudocode
