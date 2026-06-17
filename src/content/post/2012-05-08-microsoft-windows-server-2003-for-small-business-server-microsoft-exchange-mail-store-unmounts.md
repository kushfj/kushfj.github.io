---
author: Nishchal Kush
published: '2012-05-08T09:59:00+10:00'
slug: 2012-05-08-microsoft-windows-server-2003-for-small-business-server-microsoft-exchange-mail-store-unmounts
tags:
- unmount
- sbs
- mailstore
- mapi
- exchange server
- mount
- microsoft
title: Microsoft Windows Server 2003 for Small Business Server Microsoft Exchange Mail Store unmounts
---
At 08:59hrs this morning I got a call from a customer who was unable to
receive e-mail. Logging into their server I discovered that there were
indeed messages stuck in the Local Delivery queue. I checked the
Application event logs and found the following event log  
  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
Type:<span class="Apple-tab-span" style="white-space: pre;">
</span>Error</span>  
  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
Source:<span class="Apple-tab-span" style="white-space: pre;">
</span>MSExchangeSA</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
Category:<span class="Apple-tab-span" style="white-space: pre;">
</span>MAPI Session </span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
ID:<span class="Apple-tab-span" style="white-space: pre;">
</span>9175</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Date:<span
class="Apple-tab-span" style="white-space: pre;">
</span>8/05/2012</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Time:<span
class="Apple-tab-span" style="white-space: pre;"> </span>9:12:31
AM</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">User:<span
class="Apple-tab-span" style="white-space: pre;"> </span>N/A</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Computer:<span
class="Apple-tab-span" style="white-space: pre;">
</span>\*\*\*DELETED\*\*\*</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Description:</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">The
MAPI call 'OpenMsgStore' failed with the following error: </span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">The
attempt to log on to the Microsoft Exchange Server computer has
failed.</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">The
MAPI provider failed.</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Microsoft
Exchange Server Information Store</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">ID
no: 8004011d-0512-00000000 </span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">  
</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">For
more information, click
http://www.microsoft.com/contentredirect.asp.</span>  
  
Further investigation led to an un-mounted mail store.It was relatively
easy to re-mount the store, however the support link
at http://support.microsoft.com/kb/896143 leads me to think it may not
be so easy all the time. After getting the service back up and running,
I re-visited the logs to find that the event started at approximately
23:22hrs last night, and was preceded by the following message;  
  
  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
Type:<span class="Apple-tab-span" style="white-space: pre;">
</span>Error</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
Source:<span class="Apple-tab-span" style="white-space: pre;">
</span>MSExchangeSA</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
Category:<span class="Apple-tab-span" style="white-space: pre;">
</span>Monitoring </span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Event
ID:<span class="Apple-tab-span" style="white-space: pre;">
</span>1005</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Date:<span
class="Apple-tab-span" style="white-space: pre;">
</span>7/05/2012</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Time:<span
class="Apple-tab-span" style="white-space: pre;"> </span>11:22:24
PM</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">User:<span
class="Apple-tab-span" style="white-space: pre;"> </span>N/A</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Computer:<span
class="Apple-tab-span" style="white-space: pre;">
</span>\*\*\*DELETED\*\*\*</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Description:</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Unexpected
error &lt;&lt;0xc1050000 - The attempt to log on to the Microsoft
Exchange Server computer has failed. The MAPI provider failed. Microsoft
Exchange Server Information Store ID no: 8004011d-0512-00000000&gt;&gt;
occurred. </span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">  
</span>  
<span
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">For
more information, click
http://www.microsoft.com/contentredirect.asp.</span>  

  

  
The support link at http://support.microsoft.com/kb/888179 did not
provide much assistance in resolving the issue permanently, but I did
check the allocated space and size of the mail store and the available
space on disk and they were all OK.
