---
author: Nishchal Kush
published: '2012-07-24T13:14:00+10:00'
slug: 2012-07-24-springer-lecture-notes-in-computer-science-lncs-style
tags:
- bst
- llncs2e
- bibtex
- LNCS
- texhash
- Makefile
- LLNCS
- texmf
- conference
- make
- Springer
- pdflatex
- macports
- LaTeX
- splncs
- texmf-texlive-dist
title: Springer Lecture Notes in Computer Science (LNCS) style
---
<span style="font-family: inherit;">When working on a recent paper for a
conference, I was required to produce it using the Spring Lecture Notes
in Computer Science (LNCS) style. Being naive, I assumed TeX would
automatically download the required package... unfortunately I got the
following error "LaTeX Error: File \`llncs.cls' not found." So I had to
install the class manually. Here are the instructions for installing it
on Mac OS X for latex from macport.</span>  

1.  Download the <span
    style="font-family: 'Courier New', Courier, monospace;">llncs2e.zip</span>
    package from the Springer website \[1\]
2.  Unzip the file into the tex-live distribution location for macport,
    i.e. <span
    style="font-family: 'Courier New', Courier, monospace;">/opt/local/share/texmf-texlive-dist/tex/latex</span>
3.  Rebuild the ls-R databases using TeX by executing <span
    style="font-family: 'Courier New', Courier, monospace;">sudo
    texhash</span>
4.  <span style="font-family: inherit;">To get the bibliography style
    setup, change directory by using </span><span
    style="font-family: 'Courier New', Courier, monospace;">cd /opt/local/share/texmf-texlive-dist/bibtex/bst</span>
5.  Make a directory to hold the style <span
    style="font-family: 'Courier New', Courier, monospace;">sudo mkdir
    splncs; cd splncs</span>
6.  Either copy or link the files <span
    style="font-family: 'Courier New', Courier, monospace;">sudo ln -s
    ../../../tex/latex/llncs2e/\*.bst .</span>

<span class="underline">TexLive</span>  
<span style="font-family: inherit;">If you are using a variant of
TexLive such as MacTex, then you can copy the style files (\*.bst) into
"</span><span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace;">/usr/local/texlive/2012/texmf-dist/bibtex/bst/splncs</span><span
style="font-family: inherit;">" and the tex files into "</span><span
class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace;">/usr/local/texlive/2012/texmf-dist/tex/latex/llncs</span><span
style="font-family: inherit;">" and finally to update the ls-R database
use "</span><span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace;">sudo
/usr/local/texlive/2012/bin/x86\_64-darwin/texhash</span><span
style="font-family: inherit;">"</span>  
<span style="font-family: inherit;">  
</span>  
<span style="font-family: inherit;"><span
class="underline">Makefile</span></span>  
My Makefile now run without issues. Here's a copy of my <span
style="font-family: 'Courier New', Courier, monospace;">Makefile</span>  
  

    PROJ=paper


    OS := $(shell uname -s)

    .PHONY: all pdf clean read 

    all: pdf

    pdf: $(PROJ).tex
     pdflatex $(PROJ)
     bibtex $(PROJ)
     pdflatex $(PROJ)
     pdflatex $(PROJ)

    diff: $(PROJ)-original.tex
     latexdiff $(PROJ)-original.tex $(PROJ).tex > $(PROJ)-diff.tex
     pdflatex $(PROJ)-diff
     bibtex $(PROJ)-diff
     pdflatex $(PROJ)-diff
     pdflatex $(PROJ)-diff

    readdiff:
    ifeq ($(OS), windows32)
     start ${PROJ}-diff.pdf
    endif
    ifeq ($(OS), Darwin)
     open -a /Applications/Preview.app/Contents/MacOS/Preview ${PROJ}-diff.pdf
    endif
    ifeq ($(OS), Linux)
     acroread ${PROJ}-diff.pdf
    endif

    read:
    ifeq ($(OS), windows32)
     start ${PROJ}.pdf
    endif
    ifeq ($(OS), Darwin)
     open -a /Applications/Preview.app/Contents/MacOS/Preview ${PROJ}.pdf
    endif
    ifeq ($(OS), Linux)
     acroread ${PROJ}.pdf
    endif

    clean:
     rm -f ${PROJ}.ps ${PROJ}.pdf ${PROJ}.log ${PROJ}.aux ${PROJ}.out ${PROJ}.dvi ${PROJ}.bbl ${PROJ}.blg ${PROJ}.toc 

    cleandiff:
     rm -f ${PROJ}-diff.ps ${PROJ}-diff.pdf ${PROJ}-diff.log ${PROJ}-diff.aux ${PROJ}-diff.out ${PROJ}-diff.dvi ${PROJ}-diff.bbl ${PROJ}-diff.blg ${PROJ}-diff.toc 

<span class="underline">References</span>  

1.  http://www.springer.com/computer/lncs/lncs+authors?SGWID=0-40209-0-0-0
