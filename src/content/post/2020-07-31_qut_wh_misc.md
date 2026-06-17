---
author: Kush, Nishchal
date: '2020-07-31T18:44:59+10:00'
draft: true
tags:
- kush
- notes
- ctf
- qut
- whitehats
- zsteg
- flac
- foremost
- 7z
- strings
- hexdump
title: QUT Whitehats CTF Misc Challenges
---

# Misc Challenges

This blog page is for the Misc challenges on the CTF page and is likely to be updated as the new challenges are added to the CTF.


**WARNING**: Like all my CTF notes, this contains spoilers.

## Chuck Norris - 30pts

It's Chuck Norris

flag syntax: flag{insertflaghere}

  * Downloaded the `chuck.pcap` file from `https://ctf.qutwhitehats.club/files/06159f05f2fec53ca602559bf422cd30/chuck.pcap?token=eyJ1c2VyX2lkIjoxMCwidGVhbV9pZCI6bnVsbCwiZmlsZV9pZCI6Mn0.XosP0g.C-a6_prdNYuWZMKwJ_KZHrF7UE4`
  * Opened the file in wireshark
  * Manually reviewed the conversations, Statistics -> Conversations
  * Noticed single conversation with internal host `10.0.85.10`, all other conversations were to external hosts, i.e. not the reversed ranged
  * Applied as filter `ip.addr==10.0.75.102 && ip.addr==10.0.85.10`
  * Manually reviewed the HTTP response data
  * Found: Hey this is a flag FLAG-GehFMsqCeNvof5szVpB2Dmjx
  * Submitted: flag{FLAG-GehFMsqCeNvof5szVpB2Dmjx}

## Mr_Elliot - 100pts

Bonsoir Elliot

flag syntax: flag{insertflaghere}

  * Downloaded the PNG file `Elliot.png` from `https://ctf.qutwhitehats.club/files/8b01c40aafdb9ebb3808cb8e747c9750/Elliot.png?token=eyJ1c2VyX2lkIjoxMCwidGVhbV9pZCI6bnVsbCwiZmlsZV9pZCI6M30.XosSMQ.7HNmt7YddLkJEmpoS7J0I-cgBgA`
  * Did strings on the PNG, noticed that multiple IHDR string existed, should only be one
  * Performed manual internet search to identify ways of splitting PNG files. Found pngsplit and manually split the PNG file repeatedly. Then used pnginfo command to review the files, noticed that the penultimate file had a different resolution, viz. 96x96 as opposed to 72x72 like the others.
  * Manually reviewed the file and found a string at the bottom of one of the files, zoomed in and sumitted as a flag
  * Submitted: `flag{c0NtRoL_1s_@n_1llus!on}`.

## ProSupport - 75pts

Sometimes it feels like I spend my whole life on hold. Oh well, at-least its a groovy tune!

flag syntax: flag{insertflaghere}

Helpdesk.flac 

  * Downloaded the Helpdesk.flac file
  * `md5sum Helpdesk.flac`
```
4e95776e4ba942ec281171c851a95411 *Helpdesk.flac
```
  * `file Helpdesk.flac`
```Helpdesk.flac: FLAC audio bitstream data, 16 bit, stereo, 44.1 kHz, 8118768 samples
```
  * Got information on the file `exiftool Helpdesk.flac`
```
ExifTool Version Number         : 12.01
File Name                       : Helpdesk.flac
Directory                       : .
File Size                       : 13 MB
File Modification Date/Time     : 2020:07:31 09:46:05-04:00
File Access Date/Time           : 2020:07:31 09:46:04-04:00
File Inode Change Date/Time     : 2020:08:01 08:13:51-04:00
File Permissions                : rw-rw-rw-
File Type                       : FLAC
File Type Extension             : flac
MIME Type                       : audio/flac
Block Size Min                  : 4096
Block Size Max                  : 4096
Frame Size Min                  : 17
Frame Size Max                  : 8309
Sample Rate                     : 44100
Channels                        : 2
Bits Per Sample                 : 16
Total Samples                   : 8118768
MD5 Signature                   : f7d707c0e6e6d9c50857393465210984
Vendor                          : reference libFLAC 1.2.1 20070917
Duration                        : 0:03:04
  * Checked file information using `mediainfo Helpdesk.flac`
```
General
Complete name                            : Helpdesk.flac
Format                                   : FLAC
Format/Info                              : Free Lossless Audio Codec
File size                                : 13.4 MiB
Duration                                 : 3 min 4 s
Overall bit rate mode                    : Variable
Overall bit rate                         : 610 kb/s

Audio
Format                                   : FLAC
Format/Info                              : Free Lossless Audio Codec
Duration                                 : 3 min 4 s
Bit rate mode                            : Variable
Bit rate                                 : 610 kb/s
Channel(s)                               : 2 channels
Channel layout                           : L R
Sampling rate                            : 44.1 kHz
Bit depth                                : 16 bits
Compression mode                         : Lossless
Stream size                              : 13.4 MiB (100%)
Writing library                          : libFLAC 1.2.1 (UTC 2007-09-17)


```
  * Listened to the audio using VLC and it sounded a bit funny, so opened it in Audacity and noticed that the sereo wave form for left and right were significantly different
  * The multi-view spectral view of the tracks did not reveal anything useful either (Track title -> Multi-view)
  * Split the stereo track into separate left and right and listened to them separately, still nothing (Track title -> Split Stereo Track)
  * Played the audio in reverse in Audacity (Effect -> Reverse) and still not having much luck.
  * Slowed the audio down by 0.5x and started hearing what may be morse code but the beeps are too far apart to be any sort of message
  * Skipped this for a bit
  * Returned to the problem after solving Stegosaurus (refer below) on Linux machine
  * Opened the file in sonic visualiser, and could not see anything in the spectrum panes I opened for each as well as both channels, there may be something but its not clear in the image
  * Ran `binwalk --dd=".*" Helpdesk.flac` to extract everything
```
DECIMAL       HEXADECIMAL     DESCRIPTION
--------------------------------------------------------------------------------
8961279       0x88BCFF        XAR archive, version: -25845, header size: 58387, TOC compressed: 6454254597000145862, TOC uncompressed: 1244076631885681927

ls -las
total 13716
    0 drwxr-xr-x 1 user user       74 Jul 31 09:50 .
    0 drwxr-xr-x 1 user user       60 Jul 31 09:46 ..
13716 -rw-rw-rw- 1 user user 14044939 Jul 31 09:46 Helpdesk.flac
    0 drwxr-xr-x 1 user user       12 Jul 31 09:50 _Helpdesk.flac.extracted

cd _Helpdesk.flac.extracted/
ls -las
total 4968
   0 drwxr-xr-x 1 user user      12 Jul 31 09:50 .
   0 drwxr-xr-x 1 user user      74 Jul 31 09:50 ..
4968 -rw-r--r-- 1 user user 5083660 Jul 31 09:50 88BCFF

file 88BCFF 
88BCFF: xar archive, header size 58387 version 39691, compressed TOC: 6454254597000145862,
```
  * Attempted to use 7zip (`7z` command) to extract the archive but it failed, its likely the file is not an xar archive.
  * Read up on the format of the xar archive, and found that `xar!` marks the start of file, followed by 2-byte size of header of file, and 2-byte version number which should be version 1, i.e. 0x00 0x01, but in this case the decima 39691 is returned.
  * Attempted to use `foremost` to carve the file, but was unable to get any files from it.
  * Attempted to manually examine the file as a `hexdump` as well as running `strings` over it, but was unsuccessful in identifing anything meaningful.
  * Revisited the clue and noticed that is says "at-least", perhaps this is a reference to LSB use to store information.
  * Read up on the file format for flac files - https://xiph.org/flac/format.html

## Mission - 75pts

Good day WHITEHATS operative, your mission should you choose to accept it is to uncover the flag.

flag syntax: flag{insertflaghere}

  * Checked on Discord to see if there were any other clues for this - apparently its plain text stego because "Dear_Leader(El-Presidente) Today at 12:27
@kush, for mission like all the stego ones it’s what’s you don’t see that’s important.... Everything needed to solve it is in that lump of text."
  * Came across `https://www.seecret.net/reveal.html` and submitted the clue, got Anybody want a peanut?
  * Chucked text into Cyberchef and used Text Encoding Brute Force, looking through I could see that US-ASCII (7-bit) (20127) revealed a flag, but did not appear cleanly, i.e. hs (at symbols) 
  * Copied the text into notepad and performed a find and replace of @ symbol with nothing, got flag{hidden_in_plain_sight}
  * Submitted: flag{hidden_in_plain_sight}


## Stegosaurus - 75pts

My favorite type of dinosaur is the Stegosaurus, they are so cool!

flag syntax: flag{insertflaghere}

Stegosaurus.png

  * Downloaded `Stegosaurus.png`
  * `md5sum Stegosaurus.png`
```
06d2e028a01437246044bca802b239a9 *Stegosaurus.png
```
  * `file Stegosaurus.png`
```
Stegosaurus.png: PNG image data, 1219 x 802, 8-bit/color RGBA, non-interlaced
```
  * `exiftool Stegosaurus.png`
```
ExifTool Version Number         : 12.03
File Name                       : Stegosaurus.png
Directory                       : .
File Size                       : 980 kB
File Modification Date/Time     : 2020:07:31 19:48:20+10:00
File Access Date/Time           : 2020:07:31 19:48:20+10:00
File Creation Date/Time         : 2020:07:31 19:48:16+10:00
File Permissions                : rw-rw-rw-
File Type                       : PNG
File Type Extension             : png
MIME Type                       : image/png
Image Width                     : 1219
Image Height                    : 802
Bit Depth                       : 8
Color Type                      : RGB with Alpha
Compression                     : Deflate/Inflate
Filter                          : Adaptive
Interlace                       : Noninterlaced
Image Size                      : 1219x802
Megapixels                      : 0.978
```
  * Downloaded `stegsolv` from `http://www.caesum.com/handbook/Stegsolve.jar`
  * `java -jar Stegsolve.jar`
  * Manually checked file format in Analyse menu but didnt have much luck
  * Switched over to Linux machine to be able to use native tools
  * zsteg Stegosaurus.png
```
b1,bgr,lsb,xy       .. <wbStego size=56, ext="\x00fl", data="ag{not_tha"..., even=false>
```
  * Appears to be a partial flag, possibly something like `flag{not_that`...
  * `zsteg -c bgr -l 0 --lsb -o xy -s all -n 6 -v Stegosaurus.png`
```
b1,bgr,lsb,xy       .. <wbStego size=56, ext="\x00fl", data="ag{not_tha"..., even=false>
    00000000: 38 00 00 00 66 6c 61 67  7b 6e 6f 74 5f 74 68 61  |8...flag{not_tha|
    00000010: 74 5f 6b 69 6e 64 5f 6f  66 5f 73 74 65 67 6f 7d  |t_kind_of_stego}|
    00000020: 00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
```
  * Submitted: `flag{not_that_kind_of_stego}`


## Ransom_Note - 100pts

We have?your precious?WHITEHATS?President,?if you?ever?want to?see?him?again?you?must?have a?big?think?and?decipher?the flag!

flag syntax: flag{insertflaghere}

  * Copied text into CyberChef and tried to use Text Encoding Brute Force, but did not get anything useful
  * Thought it might be a ceasar cipher, and tried usual ROT13 and ROT47, but did not get anything useful

## Notorius_Delays - 150pts

Seems that I am still on hold, tunes more COMPLEX but the premise remains EXACTLY the same as before. 

flag syntax: flag{insertflaghere}

More_hold_music.wav

  * Downloaded the wave file
  * `file More_hold_music.wav`
```
More_hold_music.wav: RIFF (little-endian) data, WAVE audio, Microsoft PCM, 16 bit, stereo 44100 Hz
```
  * `exiftool More_hold_music.wav`
```
ExifTool Version Number         : 12.01
File Name                       : More_hold_music.wav
Directory                       : .
File Size                       : 27 MB
File Modification Date/Time     : 2020:07:31 09:56:08-04:00
File Access Date/Time           : 2020:07:31 09:56:07-04:00
File Inode Change Date/Time     : 2020:07:31 09:56:17-04:00
File Permissions                : rw-rw-rw-
File Type                       : WAV
File Type Extension             : wav
MIME Type                       : audio/x-wav
Encoding                        : Microsoft PCM
Num Channels                    : 2
Sample Rate                     : 44100
Avg Bytes Per Sec               : 176400
Bits Per Sample                 : 16
Duration                        : 0:02:40
```
  * Performed a binwalk extraction `binwalk --dd=".*" More_hold_music.wav`
```
DECIMAL       HEXADECIMAL     DESCRIPTION
--------------------------------------------------------------------------------
4210004       0x403D54        MySQL MISAM index file Version 4
14069268      0xD6AE14        MySQL ISAM compressed data file Version 4
23939520      0x16D49C0       MySQL ISAM compressed data file Version 2
25581401      0x1865759       MySQL MISAM index file Version 2
```
  * 

