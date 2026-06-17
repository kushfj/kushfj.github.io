---
author: Kush, Nishchal
date: '2019-04-25T09:17:03+10:00'
draft: true
tags:
- kush
- notes
- jcsc
- ctf
- incident response
- volatility
- pcap
title: 'JCSC Incident Response - Brisbane CTF'
---

# Introduction

I was fortunate enough to attend a JCSC Incident Response training sessions today in Brisbane. Even more fortunate since Yaleman allowed me to join his team. The incident response scenario was that of responding to an incident for the Wind in case of no daylight (WIND) corporation where an information security incident appears to have occurred and a wind turbine has stopped operating. 

We were provided some artefacts to perform analysis on and submit responses to to get points for the CTF. I had never used volatility, so the exercise provides an excellent opportunity to learn to use volatility.

# Preparation

Instructions previous provided, suggested the use of FireEye's Flare VM and the SANs SIFT Workstation. However in hind-sight neither of these may be required since a majority of the analysis can be performed using volatility and Wireshark and a few additional utilities. The required tools for the walk-through are listed below:

  * 7zip
  * capinfos
  * grep
  * md5
  * strings
  * volatility
  * wireshark

Although I had used a Microsoft Windows 10 machine during the CTF. This walkthough has been performed on a Apple Mac OS X host.  

Since volatility plugins may take a bit of time to complete, where possible we have output the results into a file so that we can reference them later without having to execute the volatility plugin again.

# Prelude

<i>The Wind In-case of No Daylight Corporation (WIND Corp) need your help! A critical application supporting their wind turbines has ceased to function, causing the turbines to lock and stop producing electricity. WIND Corp are already suffering reputational damage as customers lose power.

As the head of IT Security, you have been tasked to lead an investigation and remediate the situation. There are suspicions that this is no accident and that someone or something is intentionally causing this business destroying disruption.

WIND Corp's IT department have detected the use of an unauthorised device on an
operator's workstation. They have provided you with the memory dump from the
workstation and network traffic captured on the company's main router.</i>

## How to download artefacts

  * Download https://bne-ir.jcsc.gov.au/files/artefacts.7z
  * Password to decrypt archive: 25jrk50H4JZRpEk0J8tv
  * Archive MD5 hash: a7d39d8fbe8b3c5ed4f7a8f42e65787c

# CTF 

Download the artefacts.7z file, verify the MD5 hash to confirm the integrity of the downloaded file and extract the contents of the archive using the password provided.

```
$ md5 artefacts.7z 
MD5 (artefacts.7z) = a7d39d8fbe8b3c5ed4f7a8f42e65787c
$ 7z e artefacts.7z 

7-Zip [64] 16.02 : Copyright (c) 1999-2016 Igor Pavlov : 2016-05-21
p7zip Version 16.02 (locale=utf8,Utf16=on,HugeFiles=on,64 bits,4 CPUs x64)

Scanning the drive for archives:
1 file, 1158207637 bytes (1105 MiB)

Extracting archive: artefacts.7z
--
Path = artefacts.7z
Type = 7z
Physical Size = 1158207637
Headers Size = 245
Method = LZMA2:24 7zAES
Solid = -
Blocks = 2

    
Enter password (will not be echoed):
```

## Part 1

**What is the MD5 hash of the provided memory dump?**

We can compute the MD5 hash of the file. A number of utilities are available
for this. We can use the md5 utility provided with Mac OS X located in /sbin/.
Given the size of the memory dump, this may take a few minutes to compute.

```
$ md5 memdump.raw 
MD5 (memdump.raw) = 81926e158040e7926e485f7150173795
```

The flag value is *81926e158040e7926e485f7150173795*



**When was the memory dump captured (in UTC)?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS*

We can use volatility to get information from the captured memory image. The
`imageinfo` plugin provides information to help identify the operating system,
service packs, hardware architecture as well as time the image sample was
collected.

```
$ vol.py -f memdump.raw imageinfo
Volatility Foundation Volatility Framework 2.5
INFO    : volatility.debug    : Determining profile based on KDBG search...

          Suggested Profile(s) : Win7SP0x64, Win7SP1x64, Win2008R2SP0x64, Win2008R2SP1x64
                     AS Layer1 : AMD64PagedMemory (Kernel AS)
                     AS Layer2 : FileAddressSpace (/Users/nkush/Documents/CTF/memdump.raw)
                      PAE type : No PAE
                           DTB : 0x187000L
                          KDBG : 0xf80002a31120L
          Number of Processors : 1
     Image Type (Service Pack) : 1
                KPCR for CPU 0 : 0xfffff80002a33000L
             KUSER_SHARED_DATA : 0xfffff78000000000L
           Image date and time : 2019-03-08 04:22:41 UTC+0000
     Image local date and time : 2019-03-08 15:22:41 +1100
```

The image date and time can be submitted as *2019-03-08 04:22:41*.



**What is the MD5 hash of the provided packet capture?**

```
$ md5 packetcapture.pcap 
MD5 (packetcapture.pcap) = 192a40bf7b227f279476245f6adef553
```



**What is the average packet rate per second?**

*FLAG FORMAT: Rounded_Number*

Although during the competition, yaleman computed this manually by getting the total number of packets (307731) and the duration of the capture (5277) which results in approximately 58 packets per second (pps) using Wireshark, there are other options. The `capinfos` utility is able to parse packet capture (PCAP) files and report statistical information. The output shows the average packet rate. The same information may be obtained from Wireshark using Statistics >> IPv4 Statistics >> All Addresses, and then using the rate in milliseconds and converting it to seconds.  

```
$ capinfos packetcapture.pcap 
File name:           packetcapture.pcap
File type:           Wireshark/tcpdump/... - pcap
File encapsulation:  Ethernet
File timestamp precision:  microseconds (6)
Packet size limit:   file hdr: 262144 bytes
Number of packets:   307 k
File size:           272 MB
Data size:           267 MB
Capture duration:    5276.994714 seconds
First packet time:   2019-03-08 12:56:18.838121
Last packet time:    2019-03-08 14:24:15.832835
Data byte rate:      50 kBps
Data bit rate:       405 kbps
Average packet size: 869.13 bytes
Average packet rate: 58 packets/s
SHA256:              e87fe8f95d131afc773f67c284541534a6fb3a7a03cbd3617d900dc28394b513
RIPEMD160:           f257655e63a791d3d0a32a18f20773191672263a
SHA1:                5bcfa0f1950bf3e98682b4fed5cd16981de9fed8
Strict time order:   True
Number of interfaces in file: 1
Interface #0 info:
                     Encapsulation = Ethernet (1 - ether)
                     Capture length = 262144
                     Time precision = microseconds (6)
                     Time ticks per second = 1000000
                     Number of stat entries = 0
                     Number of packets = 307731
```

The average packet rate is *58* packets per second, based on the output `Average packet rate: 58 packets/s`





## Part 2

<i>[Interview with Elliot who is a WIND turbine operator]

IT SECURITY: You've done our mandatory IT security training right?
ELLIOT: ... um, yes?
IT SECURITY: So you know it is against our policy to use non-approved devices at work?
ELLIOT: ...
IT SECURITY: ...


Elliot later admitted that at the recent renewable energy conference held in
Adelaide he got some free merchandise - one of which, a fancy USB key, he tried
out at work.</i>

**What is the serial number of this device?**

To examine the details of the USB devices plugged into the host, we can review the relevant registry keys, specifically as appropriate sub keys under `HKLM\SYSTEM\CurrentControlSet\Enum\USBSTOR`. We can use the `printkey` plugin to query the subkeys. First we need to get the address for the hive. This is acheived using the hivelist plugin.

```
$ vol.py -f memdump.raw --profile=Win7SP1x64 hivelist
Volatility Foundation Volatility Framework 2.5
Virtual            Physical           Name
------------------ ------------------ ----
0xfffff8a00000d0b0 0x00000000a97fe0b0 [no name]
0xfffff8a000024010 0x00000000a9776010 \REGISTRY\MACHINE\SYSTEM
0xfffff8a00004f010 0x00000000a96e1010 \REGISTRY\MACHINE\HARDWARE
0xfffff8a0001e5010 0x0000000086ac5010 \Device\HarddiskVolume1\Boot\BCD
0xfffff8a00024c010 0x00000000a94a3010 \SystemRoot\System32\Config\SOFTWARE
0xfffff8a000c4b010 0x00000000a4e14010 \??\C:\Windows\ServiceProfiles\LocalService\NTUSER.DAT
0xfffff8a00206d010 0x000000007b5a9010 \??\C:\Users\EAnderson\ntuser.dat
0xfffff8a002084010 0x000000007b993010 \??\C:\Users\EAnderson\AppData\Local\Microsoft\Windows\UsrClass.dat
0xfffff8a0020cd010 0x000000007a05d010 \??\C:\System Volume Information\Syscache.hve
0xfffff8a00482f010 0x00000000a81f0010 \SystemRoot\System32\Config\DEFAULT
0xfffff8a004938010 0x0000000092df4010 \SystemRoot\System32\Config\SECURITY
0xfffff8a008f30010 0x00000000a6ae2010 \SystemRoot\System32\Config\SAM
0xfffff8a008f4c010 0x00000000a58ff010 \??\C:\Windows\ServiceProfiles\NetworkService\NTUSER.DAT
0xfffff8a009cde010 0x00000000b7642010 \??\C:\Users\SonnyBoy\ntuser.dat
0xfffff8a00c97e410 0x0000000001939410 \??\C:\Users\SonnyBoy\AppData\Local\Microsoft\Windows\UsrClass.dat
0xfffff8a0112bc410 0x000000009e1ca410 \??\C:\Windows\AppCompat\Programs\Amcache.hve
```

Now that we have the virtual address of the SYSTEM registry, we can use this to query the key values. 

```
$ vol.py -f memdump.raw --profile=Win7SP0x64 printkey -o 0xfffff8a000024010 -K "ControlSet001\Enum\USBSTOR"
Volatility Foundation Volatility Framework 2.5
Legend: (S) = Stable   (V) = Volatile

----------------------------
Registry: \REGISTRY\MACHINE\SYSTEM
Key name: USBSTOR (S)
Last updated: 2019-03-08 03:01:32 UTC+0000

Subkeys:
  (S) Disk&Ven_VBTM&Prod_Store_'n'_Go&Rev_1.04

Values:
```

Once we have determined the single USB drive sub-key we get the serial number as another sub-key. 

```
$ vol.py -f memdump.raw --profile=Win7SP0x64 printkey -o 0xfffff8a000024010 -K "ControlSet001\Enum\USBSTOR\Disk&Ven_VBTM&Prod_Store_'n'_Go&Rev_1.04"
Volatility Foundation Volatility Framework 2.5
Legend: (S) = Stable   (V) = Volatile

----------------------------
Registry: \REGISTRY\MACHINE\SYSTEM
Key name: Disk&Ven_VBTM&Prod_Store_'n'_Go&Rev_1.04 (S)
Last updated: 2019-03-08 03:01:32 UTC+0000

Subkeys:
  (S) 08F0B550E0F29A32&0

Values:
```

Fortunately, there are additional plugins available to provide the desired results. Refer to https://github.com/kevthehermit/volatility_plugins/tree/master/usbstor. The plugin can be downloaded anywhere on the system that the volatility script has access to, but we save this in the plugins directory.

```
$ vol.py -f memdump.raw --plugins=./plugins/ --profile=Win7SP1x64 usbstor
Volatility Foundation Volatility Framework 2.5
Reading the USBSTOR Please Wait
Found USB Drive: 08F0B550E0F29A32&0
	Serial Number:	08F0B550E0F29A32&0
	Vendor:	VBTM
	Product:	Store_'n'_Go
	Revision:	1.04
	ClassGUID:	Store_'n'_Go

	ContainerID:	{219ec5df-142f-552f-be1b-fa44c0191019}
	Mounted Volume:	Unknown
	Drive Letter:	Unknown
	Friendly Name:	VBTM Store 'n' Go USB Device
	USB Name:	Unknown
	Device Last Connected:	2019-03-08 03:01:32 UTC+0000

	Class:	DiskDrive
	Service:	disk
	DeviceDesc:	@disk.inf,%disk_devdesc%;Disk drive
	Capabilities:	16
	Mfg:	@disk.inf,%genmanufacturer%;(Standard disk drives)
	ConfigFlags:	0
	Driver:	{4d36e967-e325-11ce-bfc1-08002be10318}\0001
	Compatible IDs:
		USBSTOR\Disk
		USBSTOR\RAW
		
		
	HardwareID:
		USBSTOR\DiskVBTM____Store_'n'_Go____1.04
		USBSTOR\DiskVBTM____Store_'n'_Go____
		USBSTOR\DiskVBTM____
		USBSTOR\VBTM____Store_'n'_Go____1
		VBTM____Store_'n'_Go____1
		USBSTOR\GenDisk
		GenDisk
		
		
Windows Portable Devices
```

The serial number identified is *08F0B550E0F29A32&0*



*Elliot also admitted that the device already had something on it. Curiosity got the better of him and he opened it.*

**What was the name of this file?**

*FLAG FORMAT: filename.extension*

We can use the `filescan` plugin to get a list of files in the memory image.
Since we know that the file is located on a USB drive, and from observing that
the local system files appear to be on the drive HarddiskVolume2, we infer that the files
will be located on HarddiskVolume3 or greater. We redirect the output of the
`filescan` plugin to a file to make is easier to search and manipulate.

```
$ vol.py -f memdump.raw --profile=Win7SP1x64 filescan | tee filescan.txt

<snip>

$ grep -v Volume2 filescan.txt | grep Harddisk
0x000000011ce4cdc0     16      0 R--rwd \Device\HarddiskVolume3\Internal Contact List.docx
0x000000011d990d00      2      1 R--rwd \Device\HarddiskVolume3\
0x000000011daf89f0      2      1 R--rwd \Device\HarddiskVolume3\
0x000000011e237c10      1      1 R--rw- \Device\HarddiskVolume3\
0x000000011e52ef20      2      1 R--rwd \Device\HarddiskVolume3\HPSCANS
0x000000011e8732c0      2      1 RW-r-- \Device\HarddiskVolume1\$Extend\$RmMetadata\$TxfLog\$TxfLog.blf
0x000000011e8742c0     33      0 RW-rwd \Device\HarddiskVolume1\$Directory
0x000000011e8f4260      2      1 RW-r-- \Device\HarddiskVolume1\$Extend\$RmMetadata\$TxfLog\$TxfLogContainer00000000000000000001
0x000000011e8f62c0      2      1 RW-r-- \Device\HarddiskVolume1\$Extend\$RmMetadata\$TxfLog\$TxfLogContainer00000000000000000002
0x000000011e90d2c0      1      1 RW-rwd \Device\clfs\Device\HarddiskVolume1\$Extend\$RmMetadata\$TxfLog\$TxfLog
0x000000011e9112c0      2      1 RWDrwd \Device\clfs\Device\HarddiskVolume1\$Extend\$RmMetadata\$TxfLog\$TxfLog
0x000000011e91a2c0      1      0 RW-rwd \Device\HarddiskVolume1\$Directory
0x000000011e9202c0     18      0 RW-rwd \Device\HarddiskVolume1\$Directory
0x000000011e9232c0      1      1 RW---- \Device\HarddiskVolume1\Boot\BCD
0x000000011e941f20      1      1 RW---- \Device\HarddiskVolume1\Boot\BCD.LOG
0x000000011ed09cd0      4      0 RW-rwd \Device\HarddiskVolume1\$MftMirr
0x000000011f06ab00      2      1 RWDrwd \Device\clfs\Device\HarddiskVolume1\$Extend\$RmMetadata\$TxfLog\$TxfLog
0x000000011f06c2a0     13      0 RW-rwd \Device\HarddiskVolume1\$LogFile
0x000000011f06d8c0     25      0 RW-rwd \Device\HarddiskVolume1\$Mft
0x000000011f06e730      4      0 RW-rwd \Device\HarddiskVolume1\$BitMap
0x000000011f06ed10      4      0 RW-rwd \Device\HarddiskVolume1\$Directory
0x000000011f073b20     18      0 RW-rwd \Device\HarddiskVolume1\$Mft
0x000000011f3ba4d0      2      1 R--rwd \Device\HarddiskVolume3\HPSCANS
```

The likely candidate is *Internal Contact List.docx*



**When was this file opened (in UTC)?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS*

It is highly likely that given the file extension of docx the file is a Microft Word document, and is opened using Microsoft Word. Running Microsoft Word generally instantiates a process using winword.exe as the process image name. We can utilise the `pstree` plugin to get a list of processes in a tree format. Again we can redirect the output to a file to make is easier to search.

```
$ vol.py -f memdump.raw --profile=Win7SP1x64 pstree | tee pstree.txt

<snip>

$ grep -i word -C 5 pstree.txt 
 0xfffffa80036cd040:System                              4      0     83    690 2019-03-08 01:49:56 UTC+0000
. 0xfffffa80048bb560:smss.exe                         228      4      2     35 2019-03-08 01:49:56 UTC+0000
 0xfffffa8004f87b00:explorer.exe                      832   1888     38   1027 2019-03-08 01:50:19 UTC+0000
. 0xfffffa8004cf6810:filezilla.exe                   3084    832      7    231 2019-03-08 02:59:54 UTC+0000
. 0xfffffa80069028b0:putty.exe                       3092    832      1     80 2019-03-08 02:58:50 UTC+0000
. 0xfffffa8003f263e0:WINWORD.EXE                     1572    832     20    877 2019-03-08 03:02:41 UTC+0000
.. 0xfffffa80041511e0:FoxitProxyServ                 4768   1572      1     55 2019-03-08 03:02:42 UTC+0000
. 0xfffffa8006751690:OUTLOOK.EXE                      308    832     29   1273 2019-03-08 02:57:15 UTC+0000
. 0xfffffa8006959b00:EXCEL.EXE                       3792    832     16    711 2019-03-08 02:58:22 UTC+0000
.. 0xfffffa8006fb8060:FIRSTRUN.EXE                   4056   3792      0 ------ 2019-03-08 02:58:27 UTC+0000
. 0xfffffa8005332b00:Everything.exe                  1832    832      7    172 2019-03-08 01:50:20 UTC+0000
```

We can see that a single instance was instantiated at *2019-03-08 03:02:41*



**What company did the author of the file belong to (according to the file's metadata)?**

*FLAG FORMAT: Company_name* 

We attempted to get a copy of the file using the dumpfile plugin for volatility, but were unsuccessful. This may be an indicator that the file was deleted.

```
$ vol.py -f memdump.raw --profile=Win7SP1x64 dumpfiles -Q 0x000000011ce4cdc0 -D dumpdir
Volatility Foundation Volatility Framework 2.5
DataSectionObject 0x11ce4cdc0   None   \Device\HarddiskVolume3\Internal Contact List.docx
$ file ./dumpdir/file.None.0xfffffa8006794950.dat 
./dumpdir/file.None.0xfffffa8006794950.dat: empty
```

Next we attempt to dumpfiles related to the winword.exe process, and then only examine files which are not empty and not executable and attempt to run the strings utility over them to find any string, but do not have much luck

```
$ vol.py -f memdump.raw --profile=Win7SP1x64 dumpfiles -p 1572 -D dumpdir
$ cd dumpdir
$ strings `file file.1572.0xffff* | grep -v -i -E 'empty|executable' | cut -d ':' -f 1`
bjbj[
.
 J;
(}\-
QyI@
ms]_
@c])h
9M4W=
X-C

Ch,"
V%W/7
k>\lc`
theme/theme/_rels/themeManager.xml.rels
6?$Q
K(M&$R(.1
[Content_Types].xmlPK
_rels/.relsPK
theme/theme/themeManager.xmlPK
theme/theme/theme1.xmlPK
theme/theme/_rels/themeManager.xml.relsPK
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<a:clrMap xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" bg1="lt1" tx1="dk1" bg2="lt2" tx2="dk2" accent1="accent1" accent2="accent2" accent3="accent3" accent4="accent4" accent5="accent5" accent6="accent6" hlink="hlink" folHlink="folHlink"/>PK
[Content_Types].xml 
w(z0
AEAn
>'y[
[Content_Types].xmlPK
C:\Users\EAnderson\AppData\Roaming\Microsoft\Templates\Normal.dotm 
bjbj[
Anderson, Elliot
^eCl0
pa *
/13+R&
zt)@FI
#^;o
iB6:
gd$e.
gd$e.
```



*We know Elliot admitted to opening the file, but as a professional Incident Responder we should confirm this.*

**What is the Security Identifier (SID) of the account that opened the file?**

```
$ vol.py -f memdump.raw getsids -p 1572
Volatility Foundation Volatility Framework 2.5
WINWORD.EXE (1572): S-1-5-21-3760583606-2817717872-3306295709-2146 (EAnderson)
WINWORD.EXE (1572): S-1-5-21-3760583606-2817717872-3306295709-513 (Domain Users)
WINWORD.EXE (1572): S-1-1-0 (Everyone)
WINWORD.EXE (1572): S-1-5-32-545 (Users)
WINWORD.EXE (1572): S-1-5-32-544 (Administrators)
WINWORD.EXE (1572): S-1-5-4 (Interactive)
WINWORD.EXE (1572): S-1-2-1 (Console Logon (Users who are logged onto the physical console))
WINWORD.EXE (1572): S-1-5-11 (Authenticated Users)
WINWORD.EXE (1572): S-1-5-15 (This Organization)
WINWORD.EXE (1572): S-1-5-5-0-125249 (Logon Session)
WINWORD.EXE (1572): S-1-2-0 (Local (Users with the ability to log in locally))
WINWORD.EXE (1572): S-1-5-21-3760583606-2817717872-3306295709-1994
WINWORD.EXE (1572): S-1-5-21-3760583606-2817717872-3306295709-512 (Domain Admins)
WINWORD.EXE (1572): S-1-5-21-3760583606-2817717872-3306295709-572
WINWORD.EXE (1572): S-1-16-12288 (High Mandatory Level)
```

The SID for the Elliot Anderson account is *S-1-5-21-3760583606-2817717872-3306295709-2146*.



<i>Continuation of interview]

ELLIOT: Sorry I won't do it again. Did you need anything else?
IT SECURITY: Just a few more questions. Firstly, what was in the file?
ELLIOT: Nothing interesting. I was just curious so I took a peek.
IT SECURITY: Anything weird happen?
ELLIOT: Define weird.
IT SECURITY: um... don't worry. What else did you do?
ELLIOT: Oh.. I'm heading on a holiday soon, looking forward to some R&R!
IT SECURITY: ... grumbles ...


Completely unrelated and distracting to the crisis at hand, Elliot verbosely informs you that he is heading over to Sydney and was checking out the weather - around about the time he plugged in the device.</i>

**What was the forecast for Sydney?**

*FLAG FORMAT: The forecast (two words)*

It's easiest to use Wireshark for the analysis of the packet capture (PCAP) artefact as it integrates some useful functionality to trace and filter data.  Using the filter `http.response.code == 200 ) && (data-text-lines contains Sydney)` we can filter only successful HTTP responses and HTML pages which contain the term Sydney. The first packet returned is frame number 18344, we can copy the line based text data as printable text and create a HTML document and search for the forecast, or we can manually parse the HTML within Wireshark and find the forecast.

The forecast for Sydney was *Mostly sunny.*





*Elliot recalled that he had to say yes to 'lots of popups' to actually see the file's contents.*

**What was the 'reason' given in the the very last popup to entice Elliot to accept?**

*FLAG FORMAT: A_single_word* 





*Looks like this dodgy file, let's call it malware, gets triggered (and repeatedly) due to a script which doesn't look familiar to any of the system admins.* 

**What is the MD5 hash of this script?**

*FLAG FORMAT: MD5*





<i>Crisis team reconvenes into the war room for the 38th time today]

CRISIS HEAD: What's the update?
IT SECURITY: Looks like an operator's machine was compromised.
DIRECTOR OF OPERATIONS: Is this linked to the turbine's failing?
IT SECURITY: Too early to tell, the team needs time to investigate. We have started... (gets cut off)
CRISIS HEAD: It's probably related! Take an action item to inform the bosses. You got that?
NOTETAKER: ... reading back notes ... new action item, inform leadership that turbine failure due to compromised operator's workstation.
IT SECURITY: Whoa wait a sec...


Usually the firewall is enabled but now it's not! This doesn't match our Standard Operating Environment (SOE) for those hosts!

The bad guy or 'actor' must have done it!</i>

**When was the firewall disabled (in UTC)?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS*





*More weirdness! The actor created an account - possibly as a backdoor.*

**What is the username and password for this account.**

*FLAG FORMAT: username:password*





*The actor then downloaded yet another tool. A quick assessment reveals it's likely used to assist in native remote controlling of the host!*

**What was the full path this tool was saved to disk?**

*FLAG FORMAT: C:\full\path\to\tool.extension*





<i>Threat intelligence hasn't come back to you but the bosses want to know what that tool does now.

... analysis montage... zoom...enhance ...

Oh, this is a publicly known tool, some nice reporting available too!</i>

**What is the abbreviated name that this tool is publicly known as?**

*FLAG FORMAT: Abbreviated_name*





<i>Hours later, shops are closed, air conditioning automatically off, 40 degrees and rising in office]

IT SECURITY: Oh no...
CRISIS HEAD: ... magically appears ... what 'oh no', what is it, tell me.
IT SECURITY: The compromise isn't isolated to just the operator's workstation.
CRISIS HEAD: Okay, so what now?
IT SECURITY: ...
CRISIS HEAD: Hang on, are... are you crying?
IT SECURITY: I want to go home.

Leveraging the publicly known tool identified earlier, the actor remotely authenticated to the host via RDP.</i>

**When did this happen?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS*





**What is the machine name of the computer used by the actor to initiate the RDP?**





*RDP inception! The actor then RDP'd to the Domain Controller.*

**When did this happen?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS*





<i>The next day]

NETWORK ADMIN: Good morning!
IT SECURITY: Hey, how'd did the review of the firewall logs go?
NETWORK ADMIN: ... Shows findings ...
IT SECURITY: ... pointing ... I thought that was blocked?
NETWORK ADMIN: We actioned a ticket to open that up again for the dev team to test their new app.
IT SECURITY: ... raise fist in anger ...


Now on the Domain Controller, the actor began reconnaissance activities.</i>

**What was the IP address of the Domain Controller?**

*FLAG FORMAT: IP_address*





*The actor performed network reconnaissance, searching for a particular device.*

**What command did the actor leveraged to do this reconnaissance?** Do not include any arguments that may have been used.

*FLAG FORMAT: command*





*Target located.*

**What was the sole IP address that responded to this reconnaissance?**

*FLAG FORMAT: IP_addresss* 





*The results of the actors reconnaissance activities were compressed into a single file, ready for exfiltration.*

**When was this file created?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS*





**How many domain accounts are provisioned? The actor knows... probably.**

*FLAG FORMAT: Number* 





<i>Writing up investigation report]

IT SECURITY: Hmm looking good but needs more Hex.
IT SECURITY: Where can I get more Hex.
IT SECURITY: Oh yeah, haven't really looked at the malware or the C2 server in depth yet.
IT SECURITY: But if I go down this rabbit hole I may never get out.
IT SECURITY: ...
IT SECURITY: Why am I talking to myself?</i>

**What packer type was used on the malware (ignoring versioning)?**

*FLAG FORMAT: packer_type* 





**When was the malware built/compiled?**

*FLAG FORMAT: YYYY-MM-DD HH:MM:SS* 





**What was the language used to develop the malware (prior to compilation)?**





**What password is required to communicate with the Command and Control (C2) server?**

*FLAG FORMAT: password* 





**What Organisation Unit (OU) was set in the SSL certificate that was installed on the C2 server (during the incident timeframe)?**

*FLAG FORMAT: Organisation Unit* 





<i>[Crisis team meeting to go through investigation. Turbines still non-operational]

CRISIS HEAD: Thanks for this report, greatly appreciated!
IT SECURITY: No problems.
CRISIS HEAD: What are you up to now?
DIRECTOR OF OPERATIONS: Can you take a look at this. You might be better placed to remediate the turbine.
IT SECURITY: I'm not sure, I'm not familiar with how the turbine operates. Where are the engineers?
DIRECTOR OF OPERATIONS: There is only one engineer with the required expertises. She is flying over now.
IT SECURITY: How long?
DIRECTOR OF OPERATIONS: 30 to 40 hours. She lives in the US.
IT SECURITY: ...</i>

**What is the MD5 hash of the WIND Corp logo?**





**What is the initial status of the turbine the actor targeted?**

*FLAG FORMAT: Status:Number:Number* 





*You have been given permission to interface with the turbine's HMI.*

* **Can you get the turbine back up and running?**

*FLAG FORMAT: formatting has be correct, ascii string, single line, NO spaces*





<i>[Driving home, singing Backstreet Boys]

IT SECURITY: You are.. my fire...
IT SECURITY: The one... desire... DESIRE!
... phone rings, heart skips, pulls over, answers phone ...
IT SECURITY: Hello
WIND CORP CEO: Hi, I just wanted to personally thank you for getting the company back up and running.
IT SECURITY: Um your welcome, um happy to be of assistance.
WIND CORP CEO: I need a favour, we did take a bit of a hit reputationally. Board wants us to announce to the public who did this to us.
IT SECURITY: ... closes eyes ...
WIND CORP CEO: Can you find out who did this to us?
IT SECURITY: We looked at everything, the only thing we didn't do was actively interact with the attacker's infrastructure. Not sure if that's a good idea or even if it's legal.
WIND CORP CEO: That's not a problem. I AUTHORISE you to interact with that server and find out who did this to us.
... thinking of meme - that's not how this works, that's not how any of this works ...

As above, you are authorised to interact with C2, not to hack or bruteforce it
please :)</i>

* **Who is responsible for the attack against WIND corp?**

*FLAG FORMAT: The actor responsible* 
