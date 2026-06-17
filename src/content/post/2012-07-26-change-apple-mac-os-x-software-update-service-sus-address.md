---
author: Nishchal Kush
published: '2012-07-26T15:01:00+10:00'
slug: 2012-07-26-change-apple-mac-os-x-software-update-service-sus-address
tags:
- software update service
- sucatalog
- apple
- CatalogURL
- mac os x
- software update
- sus
title: Change Apple Mac OS X Software Update Service (SUS) address
---
Apple IU Software Update service allows uses to keep their Mac OS X
machines updated with the latest software updates and security patched.
In some controlled environments, the update servers are specified in the
user profile. Sometimes there may be delays in the server updates, or
problems with the local update server and users may desire to connect to
Apple's services directly. Here's are some instructions that users may
find useful. Please note that to make configuration changes you will
need Administrative privileges on your Mac.  
  
Users should also note that where a URL for the update catalog is not
specified, network administrators may have implemented transparent
update redirection by manipulating DNS entries on a local server for
URLs such as; http://swscan.apple.com, http://swquery.apple.com,
http://swdownload.apple.com, http://swcdn.apple.com  
  
<span class="underline">Check the SUS server settings</span>  
To check you current SUS settings, issue the following command from a
terminal;  

1.  /usr/libexec/PlistBuddy -c Print
    /Library/Preferences/com.apple.SoftwareUpdate.plist
2.  /usr/libexec/PlistBuddy -c Print
    ~/Library/Preferences/com.apple.SoftwareUpdate.plist

The above commands would produce an output similar to the following;

  

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">Dict
{</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  LastAttemptSystemVersion = 10.7.2 (11C74)</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  LastRecommendedUpdatesAvailable = 0</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  RecommendedUpdates = Array {</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  }</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  CatalogURL = http://***XXX.XXX.XXX.XX***:8088/index.sucatalog</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  LastResultCode = 2</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  ScheduleFrequency = 1</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  LastUpdatesAvailable = 0</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  LastAttemptDate = Thu Jul 26 10:37:51 EST 2012</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;"> 
  LastSuccessfulDate = Thu Jul 26 10:37:51 EST 2012</span>

<span class="Apple-style-span"
style="font-family: 'Courier New', Courier, monospace; font-size: x-small;">}</span>

  

<span class="underline">Change the SUS server settings back to Apple's
default</span>  
Delete the CatalogURL entry by issuing the following command to force
the IU software update to connect to Apple's URL  
  

1.  defaults delete /Library/Preferences/com.apple.SoftwareUpdate
    CatalogURL

  
<span class="underline">To change the SUS server</span>  
To change the SUS server to any other value issue the following command
from a terminal;  

1.  defaults write com.apple.SoftwareUpdate CatalogURL
    'http://***SERVER:PORT***/index.sucatalog'

<span class="underline">References</span>  

1.  http://support.apple.com/kb/HT3923
