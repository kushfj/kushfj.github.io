---
author: Nishchal Kush
published: '2016-01-19T19:39:00+10:00'
slug: 2016-01-19-error-importing-into-virtualbox
tags:
- ahci
- virtualbox
- vmware
- sata
- vim
- ovf
title: Error importing into Virtualbox
---
Open visualisation format (OVF) is an open standard for packaging and
distributing virtual appliances. Essentially this is meant to ensure
portability of software and virtual machines across different
hypervisors, such as vmware, virtualbox, etc. However, I got an error
when importing an OVF file into virtualbox Version 5.0.12 r104815  
  
"Host resource of type "Other Storage Device (20)" is supported with
SATA AHCI controllers only, line 47."  
  

    Error reading "XXXXXX.ovf": Host resource of type "Other Storage Device (20)" is supported with SATA AHCI controllers only, line 47.


    Result Code: 
    VBOX_E_FILE_ERROR (0x80BB0004)
    Component: 
    ApplianceWrap
    Interface: 
    IAppliance {XXXXXX}

  
Fixed it by following the instructions on the forum<span
style="font-size: xx-small;">\[1\]</span>  

Edited .ovf file in vim.

-   :%s/ElementName/Caption/g
-   :%s/vmware.sata.ahci/AHCI/

Deleted .mf file, else get an error regarding failure to verify manifest

  
Attempted re-import of appliance into VirtualBox 5. Only noticeable
issue was the name defaulted to "vm", which was easily resolved by
double clicking name and entering correct name for the virtual
machine.  
  
**References**:  
  

1.  https://forums.virtualbox.org/viewtopic.php?f=8&t=61624
