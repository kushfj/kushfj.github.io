---
author: Nishchal Kush
published: '2011-10-17T10:30:00+10:00'
slug: 2011-10-17-apacite-on-mac-os-x-with-texlive
tags:
- documentclass
- texlive-bibtex-extra
- apple
- bibliographystyle
- macports
- LaTeX
- book
- texlive-latex-extra
- abstract
- apacite
title: APAcite on Mac OS X with texlive
---
While compiling a LaTeX document, a blank template of my PhD thesis to
be exact, when I got the following error "! LaTeX Error: File
\`apacite.sty' not found." Again a quick search for Mac ports indicated
that the texlive-bibtex-extra package was required. It was quickly
installed using;  
  
sudo port install texlive-bibtex-extra  
  
Subsequent compile yielded more errors, this time it was "! Undefined
control sequence. \\abstract". This was solved using the
texlive-latex-extra package, installed using;  
  
sudo port install texlive-latex-extra  
  
  
Then adding the following to define the abstract in the book
documentclass;  
  
% Define abstract in book documentclass  
\\pagestyle{empty}  
\\newenvironment{abstract}%  
{  
  \\onehalfspacing%  
  \\null  
  \\vfill  
  \\chapter\*{\\centering Abstract}%  
  \\addcontentsline{toc}{chapter}{Abstract}  
}%  
{\\vfill\\null}  
  
% Start the actual abstract  
\\begin{abstract}  
\\end{abstract}  
  
More errors resulted "! Use of \\@year@ doesn't match its definition." I
had to add "\\bibliographystyle{apacite}" to the bibligraphy page, and
all was well once again.  
  
<span class="underline">References</span>:  

1.  https://trac.macports.org/wiki/TeXLivePackages
2.  http://www.cs.utexas.edu/~witchel/errorclasses.html
