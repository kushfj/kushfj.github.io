---
author: Kush, Nishchal
date: '2020-02-21T20:48:33+10:00'
tags:
- ctf
- awsn
- awsn cadet
title: AWSN Cadet CTF
---

# Introduction

I was fortunate enough at attend an Australian Women in Security Networ (AWSN) session. Following the session there was a beginner level capture the flag (CTF) hosted off `http://149.28.182.32:8000`. These are my notes from the CTF. Additional things to note are, firstly, that for the Web challenges, challenge 4 is called flag5, and challenge 5 references flag4. Secondly, the submission for the Cryptography password challenge expects the flag in the format flag{flag_value}. Finally, the notes below **contain spoilers, and actual flags submitted**.

# Governance, Risk and Compliance(GRC)

## Make Bank! (and secure it) - 100 pts.

Hint: Which PCI DSS (Payment Card Industry Data Security Standard) requirement details compliant disk encryption standards? The flag format is #.#.#

  * https://www.google.com/search?channel=crow2&client=firefox-b-d&q=pci+dss+disk+encryption
  * PCI Requirement 3.4.1 - Use of Disk Encryption
  * Submitted: 3.4.1

## Not Bees - 100 pts.

Hint: What standard does the Australian Government ISM (Information Security Manual) recommend for developing web applications?

  * Submitted: OWASP

# Stenography

## Hidden in plain sight - 10 pts.

Hint: FatCat.jpg

  * Checked exif data - found nothing
  * Extracted strings - found flag.txt
  * Asked for assistance and Teej provided the hint that sometimes there are files which can contain other files, assumed it was some sort of archive
  * Renamed the file .7z and used 7zip to extracted flag.txt
  * Submitted: flag{h1dd3n_z1p_arch1v3}

# Packet Analysis

## The Cattening - 10 pts.

Hint: Download Wireshark (https://www.wireshark.org/), 

  * Opened packet capture file `PacketCATure.pcapng`
  * Reviewed conversation statistics (Statistics -> Conversations -> IPv4), found conversation between 192.168.1.11 and 192.168.1.21
  * Applied conversation as filter (ip.addr==192.168.1.11 && ip.addr==192.168.1.21), found HTTP get requests, mostly with 404 responses
  * Updated the filter to check for successful HTTP response, ((ip.addr==192.168.1.11 && ip.addr==192.168.1.21) && (http.response.code == 200)), found request URI http://192.168.1.11/0auh462tdk1ja51hd/ctfcat.jpg
  * Used Wiresharks built in object export feature to extract all HTTP objects and saved ctfcat.jpg
  * Reviewed the downloaded image
  * Submitted: flag{CTFCat_approves_this_pic}

## Blood in the water - 10 pts.

Hint: download Wireshark (https://www.wireshark.org/)

  * Opened packet capture file `Login_Capture.pcapng`
  * Reviewed conversation statistics (Statistics -> Conversations -> IPv4), took an interest in the conversation with extended duration towards the end of the capture and applied it as a filer (ip.addr==192.168.10.12 && ip.addr==192.168.100.23)
  * Saw HTTP get request for what appeared to be the logon page, so filtered for all HTTP POST requests in the conversation ((ip.addr==192.168.10.12 && ip.addr==192.168.100.23) && (http.request.method == "POST")), found 4 packets
  * Manually reviewed the conversation to check the form data, the usernames and passwords contained the term fakeuser, except for one, which had credentials as supermegaawesomeuser and password123
  * Submitted: flag{password123}

# Cryptography

## Decaying Bakers Dozen 10 pts.

Hint: Cipher text: ZbyqlYbnsf, Format of flag is flag{flagtext}

  * Used `https://www.boxentriq.com` to attempt to identify the cipher, but decided to try a ROT13, i.e. Ceasar cipher with key of 13
  * Submitted: flag{MoldyLoafs}

## Et tu, hacker?  10 pts.

Hint: Encrypted text: Hipqqts_lxiw_rnqtg_spvvtgh, Format of flag: flag{flagText}

  * Surely they wouldn'd use the same cipher twice, i discounted Ceaser and attempt to brute force as a monoalphabetic substitution cipher
  * Got stuck and asked for help, Jess suggested a Wikipedia search for the challenge name to see if any cipher names were listed, she meant Ceasar!
  * Used boxentriq found key = 15, found stabbed with cyber daggers
  * Submitted: flag{Stabbed_with_cyber_daggers}

## Passwords 10 pts.

Hint: An infamous hacker has given you a challenge to crack their encrypted password: 726ad07bc398372b56a52e3de8693679. They were tricked into giving it away in 2005 and now, after changing it, want to ensure its secure.

  * The hash looked like N MD5, so submitted to crackstation, found as hunter1
  * Submitted: flah{hunter1}

# Web Application

## 1 - Clever Name - 10 pts.

Hint: Link: http://149.28.182.32/ Flag will be in the following format: flag{flagtext}

  * Navigated to site at http://149.28.182.32/
  * Viewed page source view-source:http://149.28.182.32/
  * Submitted: flag{49ff06b7f8308567c05d11789bcdfce3}

## 2 - Directives - 10 pts.

Hint: Link: http://149.28.182.32/ Hint: Look where robots are told where not to go.  Flag will be in the following format: flag{flagtext}

  * Navigated to site, then added robots.txt as file to get 
  * Submitted: flag{5ba36c59528a23ef681f4b6ac075a59b}

## 3 - Divisive - 10 pts.

Hint: Chocolate chip or oatmeal + raisin?  Link: http://149.28.182.32/flag3 Flag will be in the following format: flag{flagtext}

  * Naviagated to the page
  * Text on the page stated `To get the flag you need to be an 'admin' but you are just a 'user' at the moment`
  * Realised the chocolate chop or oatmeal were references to cookies
  * Used Firefox Cookie Quick Manager extensiont to exit the value of the usertype cookie
  * Changed value of usertype from user to admin
  * Reloaded the page
  * Submitted: flag{15304bcd6350f0143d8a2b30027393b6}

## 4 - Silly SQLi - 10 pts.

Hint: Link: http://149.28.182.32/flag5 Flag will be in the following format: flag{flagtext}

  * Attempted manual SQL injection, username as admin, and password as xx' OR 1 = '1' -- x
  * Submitted: flag{c6e7c99838881e4db32561804a32e7d4} 

## 5 - Final Boss - 10 pts.

Hint: Link: http://149.28.182.32/flag4 Final boss challenge - no hints.  Flag will be in the following format: flag{flagtext}

  * Navigated to page and found location of flag in page text, this usually means file includion or directory traversal
  * Manually reviewed page source, found http://149.28.182.32/flag4/showimage.php?file=cat.jpg
  * Attempted http://149.28.182.32/flag4/showimage.php?file=/../../../../../etc/flag4.jpg, found flag image
  * Submitted: flag{db990109b423a8607765c68097ee9fcd}
