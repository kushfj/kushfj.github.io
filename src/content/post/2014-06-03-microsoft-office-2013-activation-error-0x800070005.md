---
author: Nishchal Kush
published: '2014-06-03T10:12:00+10:00'
slug: 2014-06-03-microsoft-office-2013-activation-error-0x800070005
tags:
- activation
- '0x8007005'
- privilege
- registry
- microsoft
- administrator
- office
title: 'Microsoft Office 2013 Activation - Error 0x800070005'
---
I have some customers who do not volume license their Microsoft Product
and need to activate their Microsoft Office products. This particular
customer bought a laptop with Microsoft Office 2013 pre-loaded and
purchased a separate Microsoft Office Home and Business 2013 1PC
License, however when they tried to activate the license by entering in
their product key they kept getting a pop-up error message;  
  
"<span style="font-family: Courier New, Courier, monospace;">We're
sorry, something went wrong and we can't do this for you right now.
Please try again later. ( 0x80070005 )</span>".  
  
The error occurs because the user account does not have appropriate
permissions to modify the registry<span
style="font-size: xx-small;">\[1\]</span>. Thus the activation needs to
be run with Administrator privileges<span
style="font-size: xx-small;">\[2\]</span>. So I right clicked on Word
and selected Run as administrator and it activated automatically.  
  
<span class="underline">References</span>:  
  

1.  http://support.microsoft.com/kb/968003
2.  http://techhstuff.blogspot.com.au/2014/01/office-2013-activation-pop-up-with.html
