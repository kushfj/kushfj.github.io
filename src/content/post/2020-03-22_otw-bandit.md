---
author: Kush, Nishchal
date: '2020-03-22T11:35:20+10:00'
tags:
- over the wire
- bandit
- ctf
- wargames
title: 'Over the Wire - Wargames - Bandit'
---

# Introduction

Details about the challenges may be found at `https://overthewire.org/wargames/bandit/`. The game is played over SSH over port 2220 so firewalls may need to be adjusted to allow outbound traffic to connect to the game. The game has 34 levels. The levels are chained, so that to get to the next level you need to complete/finish/beat the previous level.

**WARNING:** These are my own notes and contain actual flags.


# Bandit Level 0 

## Level Goal

The goal of this level is for you to log into the game using SSH. The host to which you need to connect is bandit.labs.overthewire.org, on port 2220. The username is bandit0 and the password is bandit0. Once logged in, go to the Level 1 page to find out how to beat Level 1.

### Commands you may need to solve this level

ssh

### Helpful Reading Material

  * `https://en.wikipedia.org/wiki/Secure_Shell`
  * `https://www.wikihow.com/Use-SSH`

### Walkthrough

  * Used PuTTY to SSH to `bandit.labs.overthewire.org`
  * Used username and password of `bandit0`
```
login as: bandit0
Pre-authentication banner message from server:
| This is a OverTheWire game server. More information on http://www.overthewire
> .org/wargames
|
End of banner message from server
bandit0@bandit.labs.overthewire.org's password:
Linux bandit 4.18.12 x86_64 GNU/Linux

      ,----..            ,----,          .---.
     /   /   \         ,/   .`|         /. ./|
    /   .     :      ,`   .'  :     .--'.  ' ;
   .   /   ;.  \   ;    ;     /    /__./ \ : |
  .   ;   /  ` ; .'___,/    ,' .--'.  '   \' .
  ;   |  ; \ ; | |    :     | /___/ \ |    ' '
  |   :  | ; | ' ;    |.';  ; ;   \  \;      :
  .   |  ' ' ' : `----'  |  |  \   ;  `      |
  '   ;  \; /  |     '   :  ;   .   \    .\  ;
   \   \  ',  /      |   |  '    \   \   ' \ |
    ;   :    /       '   :  |     :   '  |--"
     \   \ .'        ;   |.'       \   \ ;
  www. `---` ver     '---' he       '---" ire.org


Welcome to OverTheWire!

If you find any problems, please report them to Steven or morla on
irc.overthewire.org.

--[ Playing the games ]--

  This machine might hold several wargames.
  If you are playing "somegame", then:

    * USERNAMES are somegame0, somegame1, ...
    * Most LEVELS are stored in /somegame/.
    * PASSWORDS for each level are stored in /etc/somegame_pass/.

  Write-access to homedirectories is disabled. It is advised to create a
  working directory with a hard-to-guess name in /tmp/.  You can use the
  command "mktemp -d" in order to generate a random and hard to guess
  directory in /tmp/.  Read-access to both /tmp/ and /proc/ is disabled
  so that users can not snoop on eachother. Files and directories with
  easily guessable or short names will be periodically deleted!

  Please play nice:

    * don't leave orphan processes running
    * don't leave exploit-files laying around
    * don't annoy other players
    * don't post passwords or spoilers
    * again, DONT POST SPOILERS!
      This includes writeups of your solution on your blog or website!

--[ Tips ]--

  This machine has a 64bit processor and many security-features enabled
  by default, although ASLR has been switched off.  The following
  compiler flags might be interesting:

    -m32                    compile for 32bit
    -fno-stack-protector    disable ProPolice
    -Wl,-z,norelro          disable relro

  In addition, the execstack tool can be used to flag the stack as
  executable on ELF binaries.

  Finally, network-access is limited for most levels by a local
  firewall.

--[ Tools ]--

 For your convenience we have installed a few usefull tools which you can find
 in the following locations:

    * pwndbg (https://github.com/pwndbg/pwndbg) in /usr/local/pwndbg/
    * peda (https://github.com/longld/peda.git) in /usr/local/peda/
    * gdbinit (https://github.com/gdbinit/Gdbinit) in /usr/local/gdbinit/
    * pwntools (https://github.com/Gallopsled/pwntools)
    * radare2 (http://www.radare.org/)
    * checksec.sh (http://www.trapkit.de/tools/checksec.html) in /usr/local/bin/checksec.sh

--[ More information ]--

  For more information regarding individual wargames, visit
  http://www.overthewire.org/wargames/

  For support, questions or comments, contact us through IRC on
  irc.overthewire.org #wargames.

  Enjoy your stay!

bandit0@bandit:~$

```
  * Found: useful tips and tools information
  * Proceeded to Level 1 page


# Bandit Level 0 --> Level 1

## Level Goal

The password for the next level is stored in a file called readme located in the home directory. Use this password to log into bandit1 using SSH. Whenever you find a password for a level, use SSH (on port 2220) to log into that level and continue the game.

## Commands you may need to solve this level

ls, cd, cat, file, du, find

## Walkthrough

```
bandit0@bandit:~$ pwd
/home/bandit0
bandit0@bandit:~$ ls -la
total 24
drwxr-xr-x  2 root    root    4096 Oct 16  2018 .
drwxr-xr-x 41 root    root    4096 Oct 16  2018 ..
-rw-r--r--  1 root    root     220 May 15  2017 .bash_logout
-rw-r--r--  1 root    root    3526 May 15  2017 .bashrc
-rw-r--r--  1 root    root     675 May 15  2017 .profile
-rw-r-----  1 bandit1 bandit0   33 Oct 16  2018 readme
bandit0@bandit:~$ cat readme
boJ9jbbUNNfktd78OOpsqOltutMc3MY1
```


# Bandit Level 1 --> Level 2

## Level Goal

The password for the next level is stored in a file called - located in the home directory

## Commands you may need to solve this level

ls, cd, cat, file, du, find

## Helpful Reading Material

  * `https://www.google.com/search?q=dashed+filename`
  * `http://tldp.org/LDP/abs/html/special-chars.html`

## Walkthrough

```
bandit1@bandit:~$ ls -las
total 24
4 -rw-r-----  1 bandit2 bandit1   33 Oct 16  2018 -
4 drwxr-xr-x  2 root    root    4096 Oct 16  2018 .
4 drwxr-xr-x 41 root    root    4096 Oct 16  2018 ..
4 -rw-r--r--  1 root    root     220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root    root    3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root    root     675 May 15  2017 .profile
bandit1@bandit:~$ cat ./-
CV1DtqXWVFXTvM2F0k09SHz0YwRINYA9
```


# Bandit Level 2 --> Level 3

## Level Goal

The password for the next level is stored in a file called spaces in this filename located in the home directory

## Commands you may need to solve this level

ls, cd, cat, file, du, find

## Helpful Reading Material

  * `https://www.google.com/search?q=spaces+in+filename`

## Walkthough

```
bandit2@bandit:~$ pwd
/home/bandit2
bandit2@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root    root    4096 Oct 16  2018 .
4 drwxr-xr-x 41 root    root    4096 Oct 16  2018 ..
4 -rw-r--r--  1 root    root     220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root    root    3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root    root     675 May 15  2017 .profile
4 -rw-r-----  1 bandit3 bandit2   33 Oct 16  2018 spaces in this filename
bandit2@bandit:~$ cat spaces\ in\ this\ filename
UmHadQclWmgdLOKQ3YNgjWxGoRMb5luK
```

# Bandit Level 3 --> Level 4

## Level Goal

The password for the next level is stored in a hidden file in the inhere directory.

## Commands you may need to solve this level

ls, cd, cat, file, du, find

## Walkthrough

```
bandit3@bandit:~$ pwd
/home/bandit3
bandit3@bandit:~$ ls -las
total 24
4 drwxr-xr-x  3 root root 4096 Oct 16  2018 .
4 drwxr-xr-x 41 root root 4096 Oct 16  2018 ..
4 -rw-r--r--  1 root root  220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root root 3526 May 15  2017 .bashrc
4 drwxr-xr-x  2 root root 4096 Oct 16  2018 inhere
4 -rw-r--r--  1 root root  675 May 15  2017 .profile
bandit3@bandit:~$ cd inhere
bandit3@bandit:~/inhere$ ls -las
total 12
4 drwxr-xr-x 2 root    root    4096 Oct 16  2018 .
4 drwxr-xr-x 3 root    root    4096 Oct 16  2018 ..
4 -rw-r----- 1 bandit4 bandit3   33 Oct 16  2018 .hidden
bandit3@bandit:~/inhere$ cat .hidden
pIwrPrtPN36QITSp3EQaw936yaFoFgAB
```

# Bandit Level 4 --> Level 5

## Level Goal

The password for the next level is stored in the only human-readable file in the inhere directory. Tip: if your terminal is messed up, try the “reset” command.

## Commands you may need to solve this level

ls, cd, cat, file, du, find

## Walkthrough

```
bandit4@bandit:~$ pwd
/home/bandit4
bandit4@bandit:~$ ls -las
total 24
4 drwxr-xr-x  3 root root 4096 Oct 16  2018 .
4 drwxr-xr-x 41 root root 4096 Oct 16  2018 ..
4 -rw-r--r--  1 root root  220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root root 3526 May 15  2017 .bashrc
4 drwxr-xr-x  2 root root 4096 Oct 16  2018 inhere
4 -rw-r--r--  1 root root  675 May 15  2017 .profile
bandit4@bandit:~$ cd inhere
bandit4@bandit:~/inhere$ ls -las
total 48
4 drwxr-xr-x 2 root    root    4096 Oct 16  2018 .
4 drwxr-xr-x 3 root    root    4096 Oct 16  2018 ..
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file00
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file01
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file02
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file03
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file04
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file05
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file06
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file07
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file08
4 -rw-r----- 1 bandit5 bandit4   33 Oct 16  2018 -file09
bandit4@bandit:~/inhere$ file ./-file0?
./-file00: data
./-file01: data
./-file02: data
./-file03: data
./-file04: data
./-file05: data
./-file06: data
./-file07: ASCII text
./-file08: data
./-file09: data
bandit4@bandit:~/inhere$ cat ./-file07
koReBOKuIDDepwhWk7jZC0RTdopnAYKh
```


# Bandit Level 5 --> Level 6

## Level Goal

The password for the next level is stored in a file somewhere under the inhere directory and has all of the following properties:

    human-readable
    1033 bytes in size
    not executable

## Commands you may need to solve this level

ls, cd, cat, file, du, find

## Walkthrough

```
bandit5@bandit:~$ pwd
/home/bandit5
bandit5@bandit:~$ ls -las
total 24
4 drwxr-xr-x  3 root root    4096 Oct 16  2018 .
4 drwxr-xr-x 41 root root    4096 Oct 16  2018 ..
4 -rw-r--r--  1 root root     220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root root    3526 May 15  2017 .bashrc
4 drwxr-x--- 22 root bandit5 4096 Oct 16  2018 inhere
4 -rw-r--r--  1 root root     675 May 15  2017 .profile
bandit5@bandit:~$ cd inhere/
bandit5@bandit:~/inhere$ ls -las
total 88
4 drwxr-x--- 22 root bandit5 4096 Oct 16  2018 .
4 drwxr-xr-x  3 root root    4096 Oct 16  2018 ..
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere00
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere01
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere02
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere03
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere04
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere05
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere06
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere07
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere08
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere09
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere10
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere11
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere12
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere13
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere14
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere15
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere16
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere17
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere18
4 drwxr-x---  2 root bandit5 4096 Oct 16  2018 maybehere19
bandit5@bandit:~/inhere$ find . -type f -size 1033c ! -executable -exec file {} \;
./maybehere07/.file2: ASCII text, with very long lines
bandit5@bandit:~/inhere$ cat ./maybehere07/.file2
DXjZPULLxYr17uwoI01bNLQbtFemEgo7
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        bandit5@bandit:~/inhere$
```


# Bandit Level 6 --> Level 7

## Level Goal

The password for the next level is stored somewhere on the server and has all of the following properties:

    owned by user bandit7
    owned by group bandit6
    33 bytes in size

## Commands you may need to solve this level

ls, cd, cat, file, du, find, grep

## Walkthrough

```
bandit6@bandit:~$ pwd
/home/bandit6
bandit6@bandit:~$ ls -las
total 20
4 drwxr-xr-x  2 root root 4096 Oct 16  2018 .
4 drwxr-xr-x 41 root root 4096 Oct 16  2018 ..
4 -rw-r--r--  1 root root  220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root root 3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root root  675 May 15  2017 .profile
bandit6@bandit:~$ find / -type f -size 33c -user bandit7 -group bandit6 2>/dev/null
/var/lib/dpkg/info/bandit7.password
bandit6@bandit:~$ cat /var/lib/dpkg/info/bandit7.password
HKBPTKQnIay4Fw76bEy8PVxKEDQRKTzs
```


# Bandit Level 7 --> Level 8

## Level Goal

The password for the next level is stored in the file data.txt next to the word millionth

## Commands you may need to solve this level

grep, sort, uniq, strings, base64, tr, tar, gzip, bzip2, xxd

## Walkthough

```
bandit7@bandit:~$ pwd
/home/bandit7
bandit7@bandit:~$ ls -las
total 4108
   4 drwxr-xr-x  2 root    root       4096 Oct 16  2018 .
   4 drwxr-xr-x 41 root    root       4096 Oct 16  2018 ..
   4 -rw-r--r--  1 root    root        220 May 15  2017 .bash_logout
   4 -rw-r--r--  1 root    root       3526 May 15  2017 .bashrc
4088 -rw-r-----  1 bandit8 bandit7 4184396 Oct 16  2018 data.txt
   4 -rw-r--r--  1 root    root        675 May 15  2017 .profile
bandit7@bandit:~$ head -3 data.txt
humiliation's   47r0YuNylaQ3k6HqGF5NsPPiGuolDCjn
malarkey's      0huyJeRwvtJaoyRmJjQFsRnQcYG4gDir
prioress        ocudTlq9CbpCw9aByrqGffAuoYvCmLNV
bandit7@bandit:~$ grep millionth data.txt
millionth       cvX2JJa4CFALtqS87jk27qwqGhBM9plV
```


# Bandit Level 8 --> Level 9

## Level Goal

The password for the next level is stored in the file data.txt and is the only line of text that occurs only once

## Commands you may need to solve this level

grep, sort, uniq, strings, base64, tr, tar, gzip, bzip2, xxd

## Helpful Reading Material

  * `https://ryanstutorials.net/linuxtutorial/piping.php`

## Walkthough

```
bandit8@bandit:~$ pwd
/home/bandit8
bandit8@bandit:~$ ls -las
total 56
 4 drwxr-xr-x  2 root    root     4096 Oct 16  2018 .
 4 drwxr-xr-x 41 root    root     4096 Oct 16  2018 ..
 4 -rw-r--r--  1 root    root      220 May 15  2017 .bash_logout
 4 -rw-r--r--  1 root    root     3526 May 15  2017 .bashrc
36 -rw-r-----  1 bandit9 bandit8 33033 Oct 16  2018 data.txt
 4 -rw-r--r--  1 root    root      675 May 15  2017 .profile
bandit8@bandit:~$ sort data.txt | uniq -c | grep '1 '
      1 UsvVyFSfZZWbi6wgC7dAFyFuR6jQQUhR
```


# Bandit Level 9 --> Level 10

## Level Goal

The password for the next level is stored in the file data.txt in one of the few human-readable strings, beginning with several ‘=’ characters.

## Commands you may need to solve this level

grep, sort, uniq, strings, base64, tr, tar, gzip, bzip2, xxd

## Walkthrough

```
bandit9@bandit:~$ pwd
/home/bandit9
bandit9@bandit:~$ ls -las
total 40
 4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
 4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
 4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
 4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
20 -rw-r-----  1 bandit10 bandit9 19379 Oct 16  2018 data.txt
 4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
bandit9@bandit:~$ file data.txt
data.txt: data
bandit9@bandit:~$ strings data.txt | grep '=='
2========== the
========== password
========== isa
========== truKLdjsbJ5g7yyJ2X2R0o3a5HQJFuLk
```


# Bandit Level 10 --> Level 11

## Level Goal

The password for the next level is stored in the file data.txt, which contains base64 encoded data

## Commands you may need to solve this level

grep, sort, uniq, strings, base64, tr, tar, gzip, bzip2, xxd

## Helpful Reading Material

  * `https://en.wikipedia.org/wiki/Base64`

## Walkthough

```
bandit10@bandit:~$ pwd
/home/bandit10
bandit10@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r-----  1 bandit11 bandit10   69 Oct 16  2018 data.txt
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
bandit10@bandit:~$ file data.txt
data.txt: ASCII text
bandit10@bandit:~$ head -3 data.txt
VGhlIHBhc3N3b3JkIGlzIElGdWt3S0dzRlc4TU9xM0lSRnFyeEUxaHhUTkViVVBSCg==
bandit10@bandit:~$ base64 -d < data.txt
The password is IFukwKGsFW8MOq3IRFqrxE1hxTNEbUPR
```

# Bandit Level 11 --> Level 12

## Level Goal

The password for the next level is stored in the file data.txt, where all lowercase (a-z) and uppercase (A-Z) letters have been rotated by 13 positions

## Commands you may need to solve this level

grep, sort, uniq, strings, base64, tr, tar, gzip, bzip2, xxd

## Helpful Reading Material

  * `https://en.wikipedia.org/wiki/Rot13`

## Walkthrough

  * Search for ROT13 command line implementation
  * Found: `https://stackoverflow.com/questions/5442436/using-rot13-and-tr-command-for-having-an-encrypted-email-address`

```
bandit11@bandit:~$ pwd
/home/bandit11
bandit11@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r-----  1 bandit12 bandit11   49 Oct 16  2018 data.txt
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
bandit11@bandit:~$ file data.txt
data.txt: ASCII text
bandit11@bandit:~$ cat data.txt
Gur cnffjbeq vf 5Gr8L4qetPEsPk8htqjhRK8XSP6x2RHh
bandit11@bandit:~$ cat data.txt | tr 'A-Za-z' 'N-ZA-Mn-za-m'
The password is 5Te8Y4drgCRfCx8ugdwuEX8KFC6k2EUu
```


# Bandit Level 12 --> Level 13

## Level Goal

The password for the next level is stored in the file data.txt, which is a hexdump of a file that has been repeatedly compressed. For this level it may be useful to create a directory under /tmp in which you can work using mkdir. For example: mkdir /tmp/myname123. Then copy the datafile using cp, and rename it using mv (read the manpages!)

## Commands you may need to solve this level

grep, sort, uniq, strings, base64, tr, tar, gzip, bzip2, xxd, mkdir, cp, mv, file

## Helpful Reading Material

  * `https://en.wikipedia.org/wiki/Hex_dump`

## Walkthrough

  * Searched for ways to re-create file using hexdump
  * Found: `https://www.linuxjournal.com/content/doing-reverse-hex-dump`
  * Read man page for xxd, looks like the -r opertion allows revert of hexdump
```
bandit12@bandit:~$ pwd
/home/bandit12
bandit12@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r-----  1 bandit13 bandit12 2581 Oct 16  2018 data.txt
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
bandit12@bandit:~$ mkdir -p /tmp/otwb12
bandit12@bandit:~$ cp data.txt /tmp/otwb12/
bandit12@bandit:~$ cd /tmp/otwb12
bandit12@bandit:/tmp/otwb12$ ls -las
total 305928
     4 drwxr-sr-x 2 bandit12 root      4096 Mar 22 05:51 .
305920 drwxrws-wt 1 root     root 313204736 Mar 22 05:51 ..
     4 -rw-r----- 1 bandit12 root      2581 Mar 22 05:51 data.txt
bandit12@bandit:/tmp/otwb12$ head -2 data.txt
00000000: 1f8b 0808 d7d2 c55b 0203 6461 7461 322e  .......[..data2.
00000010: 6269 6e00 013c 02c3 fd42 5a68 3931 4159  bin..<...BZh91AY
bandit12@bandit:/tmp/otwb12$ xxd -r data.txt > data.bin
bandit12@bandit:/tmp/otwb12$ ls -las
total 305932
     4 drwxr-sr-x 2 bandit12 root      4096 Mar 22 05:51 .
305920 drwxrws-wt 1 root     root 313204736 Mar 22 05:51 ..
     4 -rw-r--r-- 1 bandit12 root       605 Mar 22 05:51 data.bin
     4 -rw-r----- 1 bandit12 root      2581 Mar 22 05:51 data.txt
bandit12@bandit:/tmp/otwb12$ file data.bin
data.bin: gzip compressed data, was "data2.bin", last modified: Tue Oct 16 12:00                                                                                                                                                             :23 2018, max compression, from Unix
bandit12@bandit:/tmp/otwb12$ gunzip < data.bin > data.bin0
bandit12@bandit:/tmp/otwb12$ file data.bin0
data.bin0: bzip2 compressed data, block size = 900k
bandit12@bandit:/tmp/otwb12$ bunzip2 -dc data.bin0 > data.bin1
bandit12@bandit:/tmp/otwb12$ file data.bin1
data.bin1: gzip compressed data, was "data4.bin", last modified: Tue Oct 16 12:0                                                                                                                                                             0:23 2018, max compression, from Unix
bandit12@bandit:/tmp/otwb12$ gunzip < data.bin1 > data.bin2
bandit12@bandit:/tmp/otwb12$ file data.bin2
data.bin2: POSIX tar archive (GNU)
bandit12@bandit:/tmp/otwb12$ tar -xvf data.bin2
data5.bin
bandit12@bandit:/tmp/otwb12$ file data5.bin
data5.bin: POSIX tar archive (GNU)
bandit12@bandit:/tmp/otwb12$ tar -xvf data5.bin
data6.bin
bandit12@bandit:/tmp/otwb12$ file data6.bin
data6.bin: bzip2 compressed data, block size = 900k
bandit12@bandit:/tmp/otwb12$ bunzip2 -dc data6.bin > data.bin7
bandit12@bandit:/tmp/otwb12$ file data.bin7
data.bin7: POSIX tar archive (GNU)
bandit12@bandit:/tmp/otwb12$ tar -xvf data.bin7
data8.bin
bandit12@bandit:/tmp/otwb12$ file data8.bin
data8.bin: gzip compressed data, was "data9.bin", last modified: Tue Oct 16 12:0                                                                                                                                                             0:23 2018, max compression, from Unix
bandit12@bandit:/tmp/otwb12$ gunzip < data8.bin > data.bin9
bandit12@bandit:/tmp/otwb12$ file data.bin9
data.bin9: ASCII text
bandit12@bandit:/tmp/otwb12$ cat data.bin9
The password is 8ZjyCRiBWFYkneahHwxCv3wb2a1ORpYL
```


# Bandit Level 13 --> Level 14

## Level Goal

The password for the next level is stored in /etc/bandit_pass/bandit14 and can only be read by user bandit14. For this level, you don’t get the next password, but you get a private SSH key that can be used to log into the next level. Note: localhost is a hostname that refers to the machine you are working on

## Commands you may need to solve this level

ssh, telnet, nc, openssl, s_client, nmap

## Helpful Reading Material

  * `https://help.ubuntu.com/community/SSH/OpenSSH/Keys`

```
bandit13@bandit:~$ pwd
/home/bandit13
bandit13@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
4 -rw-r-----  1 bandit14 bandit13 1679 Oct 16  2018 sshkey.private
bandit13@bandit:~$ file sshkey.private
sshkey.private: PEM RSA private key
bandit13@bandit:~$ cat sshkey.private
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAxkkOE83W2cOT7IWhFc9aPaaQmQDdgzuXCv+ppZHa++buSkN+
gg0tcr7Fw8NLGa5+Uzec2rEg0WmeevB13AIoYp0MZyETq46t+jk9puNwZwIt9XgB
ZufGtZEwWbFWw/vVLNwOXBe4UWStGRWzgPpEeSv5Tb1VjLZIBdGphTIK22Amz6Zb
ThMsiMnyJafEwJ/T8PQO3myS91vUHEuoOMAzoUID4kN0MEZ3+XahyK0HJVq68KsV
ObefXG1vvA3GAJ29kxJaqvRfgYnqZryWN7w3CHjNU4c/2Jkp+n8L0SnxaNA+WYA7
jiPyTF0is8uzMlYQ4l1Lzh/8/MpvhCQF8r22dwIDAQABAoIBAQC6dWBjhyEOzjeA
J3j/RWmap9M5zfJ/wb2bfidNpwbB8rsJ4sZIDZQ7XuIh4LfygoAQSS+bBw3RXvzE
pvJt3SmU8hIDuLsCjL1VnBY5pY7Bju8g8aR/3FyjyNAqx/TLfzlLYfOu7i9Jet67
xAh0tONG/u8FB5I3LAI2Vp6OviwvdWeC4nOxCthldpuPKNLA8rmMMVRTKQ+7T2VS
nXmwYckKUcUgzoVSpiNZaS0zUDypdpy2+tRH3MQa5kqN1YKjvF8RC47woOYCktsD
o3FFpGNFec9Taa3Msy+DfQQhHKZFKIL3bJDONtmrVvtYK40/yeU4aZ/HA2DQzwhe
ol1AfiEhAoGBAOnVjosBkm7sblK+n4IEwPxs8sOmhPnTDUy5WGrpSCrXOmsVIBUf
laL3ZGLx3xCIwtCnEucB9DvN2HZkupc/h6hTKUYLqXuyLD8njTrbRhLgbC9QrKrS
M1F2fSTxVqPtZDlDMwjNR04xHA/fKh8bXXyTMqOHNJTHHNhbh3McdURjAoGBANkU
1hqfnw7+aXncJ9bjysr1ZWbqOE5Nd8AFgfwaKuGTTVX2NsUQnCMWdOp+wFak40JH
PKWkJNdBG+ex0H9JNQsTK3X5PBMAS8AfX0GrKeuwKWA6erytVTqjOfLYcdp5+z9s
8DtVCxDuVsM+i4X8UqIGOlvGbtKEVokHPFXP1q/dAoGAcHg5YX7WEehCgCYTzpO+
xysX8ScM2qS6xuZ3MqUWAxUWkh7NGZvhe0sGy9iOdANzwKw7mUUFViaCMR/t54W1
GC83sOs3D7n5Mj8x3NdO8xFit7dT9a245TvaoYQ7KgmqpSg/ScKCw4c3eiLava+J
3btnJeSIU+8ZXq9XjPRpKwUCgYA7z6LiOQKxNeXH3qHXcnHok855maUj5fJNpPbY
iDkyZ8ySF8GlcFsky8Yw6fWCqfG3zDrohJ5l9JmEsBh7SadkwsZhvecQcS9t4vby
9/8X4jS0P8ibfcKS4nBP+dT81kkkg5Z5MohXBORA7VWx+ACohcDEkprsQ+w32xeD
qT1EvQKBgQDKm8ws2ByvSUVs9GjTilCajFqLJ0eVYzRPaY6f++Gv/UVfAPV4c+S0
kAWpXbv5tbkkzbS0eaLPTKgLzavXtQoTtKwrjpolHKIHUz6Wu+n4abfAIRFubOdN
/+aLoRQ0yBDRbdXMsZN/jvY44eM+xRLdRVyMmdPtP8belRi2E2aEzA==
-----END RSA PRIVATE KEY-----
bandit13@bandit:~$ ssh -i sshkey.private bandit14@127.0.0.1
Could not create directory '/home/bandit13/.ssh'.
The authenticity of host '127.0.0.1 (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit13/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

Linux bandit 4.18.12 x86_64 GNU/Linux

      ,----..            ,----,          .---.
     /   /   \         ,/   .`|         /. ./|
    /   .     :      ,`   .'  :     .--'.  ' ;
   .   /   ;.  \   ;    ;     /    /__./ \ : |
  .   ;   /  ` ; .'___,/    ,' .--'.  '   \' .
  ;   |  ; \ ; | |    :     | /___/ \ |    ' '
  |   :  | ; | ' ;    |.';  ; ;   \  \;      :
  .   |  ' ' ' : `----'  |  |  \   ;  `      |
  '   ;  \; /  |     '   :  ;   .   \    .\  ;
   \   \  ',  /      |   |  '    \   \   ' \ |
    ;   :    /       '   :  |     :   '  |--"
     \   \ .'        ;   |.'       \   \ ;
  www. `---` ver     '---' he       '---" ire.org


Welcome to OverTheWire!

If you find any problems, please report them to Steven or morla on
irc.overthewire.org.

--[ Playing the games ]--

  This machine might hold several wargames.
  If you are playing "somegame", then:

    * USERNAMES are somegame0, somegame1, ...
    * Most LEVELS are stored in /somegame/.
    * PASSWORDS for each level are stored in /etc/somegame_pass/.

  Write-access to homedirectories is disabled. It is advised to create a
  working directory with a hard-to-guess name in /tmp/.  You can use the
  command "mktemp -d" in order to generate a random and hard to guess
  directory in /tmp/.  Read-access to both /tmp/ and /proc/ is disabled
  so that users can not snoop on eachother. Files and directories with
  easily guessable or short names will be periodically deleted!

  Please play nice:

    * don't leave orphan processes running
    * don't leave exploit-files laying around
    * don't annoy other players
    * don't post passwords or spoilers
    * again, DONT POST SPOILERS!
      This includes writeups of your solution on your blog or website!

--[ Tips ]--

  This machine has a 64bit processor and many security-features enabled
  by default, although ASLR has been switched off.  The following
  compiler flags might be interesting:

    -m32                    compile for 32bit
    -fno-stack-protector    disable ProPolice
    -Wl,-z,norelro          disable relro

  In addition, the execstack tool can be used to flag the stack as
  executable on ELF binaries.

  Finally, network-access is limited for most levels by a local
  firewall.

--[ Tools ]--

 For your convenience we have installed a few usefull tools which you can find
 in the following locations:

    * pwndbg (https://github.com/pwndbg/pwndbg) in /usr/local/pwndbg/
    * peda (https://github.com/longld/peda.git) in /usr/local/peda/
    * gdbinit (https://github.com/gdbinit/Gdbinit) in /usr/local/gdbinit/
    * pwntools (https://github.com/Gallopsled/pwntools)
    * radare2 (http://www.radare.org/)
    * checksec.sh (http://www.trapkit.de/tools/checksec.html) in /usr/local/bin/checksec.sh

--[ More information ]--

  For more information regarding individual wargames, visit
  http://www.overthewire.org/wargames/

  For support, questions or comments, contact us through IRC on
  irc.overthewire.org #wargames.

  Enjoy your stay!

bandit14@bandit:~$ id
uid=11014(bandit14) gid=11014(bandit14) groups=11014(bandit14)
bandit14@bandit:~$ pwd
/home/bandit14
bandit14@bandit:~$ ls -l /etc/bandit_pass/
total 136
-r-------- 1 bandit0  bandit0   8 Oct 16  2018 bandit0
-r-------- 1 bandit1  bandit1  33 Oct 16  2018 bandit1
-r-------- 1 bandit10 bandit10 33 Oct 16  2018 bandit10
-r-------- 1 bandit11 bandit11 33 Oct 16  2018 bandit11
-r-------- 1 bandit12 bandit12 33 Oct 16  2018 bandit12
-r-------- 1 bandit13 bandit13 33 Oct 16  2018 bandit13
-r-------- 1 bandit14 bandit14 33 Oct 16  2018 bandit14
-r-------- 1 bandit15 bandit15 33 Oct 16  2018 bandit15
-r-------- 1 bandit16 bandit16 33 Oct 16  2018 bandit16
-r-------- 1 bandit17 bandit17 33 Oct 16  2018 bandit17
-r-------- 1 bandit18 bandit18 33 Oct 16  2018 bandit18
-r-------- 1 bandit19 bandit19 33 Oct 16  2018 bandit19
-r-------- 1 bandit2  bandit2  33 Oct 16  2018 bandit2
-r-------- 1 bandit20 bandit20 33 Oct 16  2018 bandit20
-r-------- 1 bandit21 bandit21 33 Oct 16  2018 bandit21
-r-------- 1 bandit22 bandit22 33 Oct 16  2018 bandit22
-r-------- 1 bandit23 bandit23 33 Oct 16  2018 bandit23
-r-------- 1 bandit24 bandit24 33 Oct 16  2018 bandit24
-r-------- 1 bandit25 bandit25 33 Oct 16  2018 bandit25
-r-------- 1 bandit26 bandit26 33 Oct 16  2018 bandit26
-r-------- 1 bandit27 bandit27 33 Oct 16  2018 bandit27
-r-------- 1 bandit28 bandit28 33 Oct 16  2018 bandit28
-r-------- 1 bandit29 bandit29 33 Oct 16  2018 bandit29
-r-------- 1 bandit3  bandit3  33 Oct 16  2018 bandit3
-r-------- 1 bandit30 bandit30 33 Oct 16  2018 bandit30
-r-------- 1 bandit31 bandit31 33 Oct 16  2018 bandit31
-r-------- 1 bandit32 bandit32 33 Oct 16  2018 bandit32
-r-------- 1 bandit33 bandit33 33 Oct 16  2018 bandit33
-r-------- 1 bandit4  bandit4  33 Oct 16  2018 bandit4
-r-------- 1 bandit5  bandit5  33 Oct 16  2018 bandit5
-r-------- 1 bandit6  bandit6  33 Oct 16  2018 bandit6
-r-------- 1 bandit7  bandit7  33 Oct 16  2018 bandit7
-r-------- 1 bandit8  bandit8  33 Oct 16  2018 bandit8
-r-------- 1 bandit9  bandit9  33 Oct 16  2018 bandit9
bandit14@bandit:~$ file /etc/bandit_pass/bandit14
/etc/bandit_pass/bandit14: ASCII text
bandit14@bandit:~$ cat /etc/bandit_pass/bandit14
4wcYUJFw0k0XLShlDzztnTBHiqxU3b3e
```


# Bandit Level 14 --> Level 15

## Level Goal

The password for the next level can be retrieved by submitting the password of the current level to port 30000 on localhost.

## Commands you may need to solve this level

ssh, telnet, nc, openssl, s_client, nmap

```
bandit14@bandit:~$ pwd
/home/bandit14
bandit14@bandit:~$ ls -las
total 24
4 drwxr-xr-x  3 root root 4096 Oct 16  2018 .
4 drwxr-xr-x 41 root root 4096 Oct 16  2018 ..
4 -rw-r--r--  1 root root  220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root root 3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root root  675 May 15  2017 .profile
4 drwxr-xr-x  2 root root 4096 Oct 16  2018 .ssh
bandit14@bandit:~$ echo 4wcYUJFw0k0XLShlDzztnTBHiqxU3b3e | nc 127.0.0.1 30000
Correct!
BfMYroe26WYalil77FoDi9qh59eK5xNr
```

# Bandit Level 15 --> Level 16

## Level Goal

The password for the next level can be retrieved by submitting the password of the current level to port 30001 on localhost using SSL encryption.

Helpful note: Getting "HEARTBEATING" and "Read R BLOCK"? Use -ign_eof and read the "CONNECTED COMMANDS" section in the manpage. Next to ‘R’ and ‘Q’, the ‘B’ command also works in this version of that command…

## Commands you may need to solve this level

ssh, telnet, nc, openssl, s_client, nmap

## Helpful Reading Material
  * `https://en.wikipedia.org/wiki/Secure_Socket_Layer`
  * `https://www.feistyduck.com/library/openssl-cookbook/online/ch-testing-with-openssl.html`

## Walkthrough

```
bandit15@bandit:~$ openssl s_client -connect 127.0.0.1:30001
CONNECTED(00000003)
depth=0 CN = localhost
verify error:num=18:self signed certificate
verify return:1
depth=0 CN = localhost
verify return:1
---
Certificate chain
 0 s:/CN=localhost
   i:/CN=localhost
---
Server certificate
-----BEGIN CERTIFICATE-----
MIICBjCCAW+gAwIBAgIEYo1NxTANBgkqhkiG9w0BAQUFADAUMRIwEAYDVQQDDAls
b2NhbGhvc3QwHhcNMjAwMTA1MTQzNTU4WhcNMjEwMTA0MTQzNTU4WjAUMRIwEAYD
VQQDDAlsb2NhbGhvc3QwgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAKF4u2eu
a8VipZPviX0hfNiCnaD2ojAffdBhKTy1bmZSNRuHPBDnU7z8rblNSknSjCITda1C
GEAI8ZktRbtLpBTbYeTgqPN/EiN5UIRMKbU6P2O93zNFPBsmyfQLrgt+DSLnsxlB
i/yYyT7WLdtNVBpgwRwkqi9K7dk9vf9waswLAgMBAAGjZTBjMBQGA1UdEQQNMAuC
CWxvY2FsaG9zdDBLBglghkgBhvhCAQ0EPhY8QXV0b21hdGljYWxseSBnZW5lcmF0
ZWQgYnkgTmNhdC4gU2VlIGh0dHBzOi8vbm1hcC5vcmcvbmNhdC8uMA0GCSqGSIb3
DQEBBQUAA4GBAJECW6IB3Ria4xG002BqD3zEbtmrDlK6nmJq+uQ4eJ6cT18o9REb
npy/lFzlv2LfcrYAnuAp6Fh89MKaYjNzJURjRQ9RkmcYgQJa1n+OBkATb7V+84/a
k9PDRkscxdNFMGBSvzFD33XZ5lbaGdrwCPyoxenoYghV/753wffN7J6H
-----END CERTIFICATE-----
subject=/CN=localhost
issuer=/CN=localhost
---
No client certificate CA names sent
Peer signing digest: SHA512
Server Temp Key: X25519, 253 bits
---
SSL handshake has read 1019 bytes and written 269 bytes
Verification error: self signed certificate
---
New, TLSv1.2, Cipher is ECDHE-RSA-AES256-GCM-SHA384
Server public key is 1024 bit
Secure Renegotiation IS supported
Compression: NONE
Expansion: NONE
No ALPN negotiated
SSL-Session:
    Protocol  : TLSv1.2
    Cipher    : ECDHE-RSA-AES256-GCM-SHA384
    Session-ID: 7105CE9B413C5CCC0A2A97C9D7D0C862E60DAC266DF04DAE1EB6496CB41FE500
    Session-ID-ctx:
    Master-Key: 4560522870CB819DDF824D4D8C71DFCF3E3444715878BB541579E1581FBB65CB1485A9409A02E22740A66F5E5F3ABD22
    PSK identity: None
    PSK identity hint: None
    SRP username: None
    TLS session ticket lifetime hint: 7200 (seconds)
    TLS session ticket:
    0000 - 56 e9 4e 87 6a 28 48 d0-13 42 5f b9 61 b0 dd d0   V.N.j(H..B_.a...
    0010 - 0c 43 e2 e2 bc 86 d4 5b-07 06 93 13 c7 13 74 eb   .C.....[......t.
    0020 - fe db 46 d8 e2 a9 75 4a-81 f2 77 5d ee 70 cc 6f   ..F...uJ..w].p.o
    0030 - b6 8c c0 27 e2 48 55 c4-2a f1 34 3a 84 dc 16 82   ...'.HU.*.4:....
    0040 - 60 9c 6c b7 be 7c ed e9-1e e4 d9 a8 6f cc 1b 44   `.l..|......o..D
    0050 - 3a a5 e6 f1 5a ba 7d 1c-9a 38 47 cb 65 57 bc 04   :...Z.}..8G.eW..
    0060 - 26 08 70 0d 7c f6 69 4c-59 c8 d1 85 16 ab cc 92   &.p.|.iLY.......
    0070 - d5 68 2a c9 06 51 5a 88-68 1b 4b 1a 2e 9b 74 35   .h*..QZ.h.K...t5
    0080 - e3 e9 04 e9 1d ee f0 45-f9 10 25 d3 08 4d 73 2b   .......E..%..Ms+
    0090 - 88 43 0b 67 68 8f b1 a4-75 63 b0 58 ec 2f e6 77   .C.gh...uc.X./.w

    Start Time: 1584871648
    Timeout   : 7200 (sec)
    Verify return code: 18 (self signed certificate)
    Extended master secret: yes
---
BfMYroe26WYalil77FoDi9qh59eK5xNr
Correct!
cluFn7wTiGryunymYOu4RcffSxQluehd

closed
```


# Bandit Level 16 --> Level 17

## Level Goal

The credentials for the next level can be retrieved by submitting the password of the current level to a port on localhost in the range 31000 to 32000. First find out which of these ports have a server listening on them. Then find out which of those speak SSL and which don’t. There is only 1 server that will give the next credentials, the others will simply send back to you whatever you send to it.

## Commands you may need to solve this level

ssh, telnet, nc, openssl, s_client, nmap

## Helpful Reading Material

  * `https://en.wikipedia.org/wiki/Port_scanner`

## Walkthrough

```
bandit16@bandit:~$ which nmap
/usr/bin/nmap
bandit16@bandit:~$ nmap -n -v -p 31000-32000 127.0.0.1

Starting Nmap 7.40 ( https://nmap.org ) at 2020-03-22 11:11 CET
Initiating Ping Scan at 11:11
Scanning 127.0.0.1 [2 ports]
Completed Ping Scan at 11:11, 0.00s elapsed (1 total hosts)
Initiating Connect Scan at 11:11
Scanning 127.0.0.1 [1001 ports]
Discovered open port 31790/tcp on 127.0.0.1
Completed Connect Scan at 11:11, 1.21s elapsed (1001 total ports)
Nmap scan report for 127.0.0.1
Host is up (0.00022s latency).
Not shown: 999 closed ports
PORT      STATE    SERVICE
31518/tcp filtered unknown
31790/tcp open     unknown

Read data files from: /usr/bin/../share/nmap
Nmap done: 1 IP address (1 host up) scanned in 1.25 seconds
bandit16@bandit:~$ echo cluFn7wTiGryunymYOu4RcffSxQluehd | nc 127.0.0.1 31518
^C
bandit16@bandit:~$ echo cluFn7wTiGryunymYOu4RcffSxQluehd | nc 127.0.0.1 31790
bandit16@bandit:~$ openssl s_client -connect 127.0.0.1:31790
CONNECTED(00000003)
depth=0 CN = localhost
verify error:num=18:self signed certificate
verify return:1
depth=0 CN = localhost
verify return:1
---
Certificate chain
 0 s:/CN=localhost
   i:/CN=localhost
---
Server certificate
-----BEGIN CERTIFICATE-----
MIICBjCCAW+gAwIBAgIEcmwVYzANBgkqhkiG9w0BAQUFADAUMRIwEAYDVQQDDAls
b2NhbGhvc3QwHhcNMjAwMzEyMjEwNjEwWhcNMjEwMzEyMjEwNjEwWjAUMRIwEAYD
VQQDDAlsb2NhbGhvc3QwgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBALFdFndG
5HH7n1xnkEqopNToRtkQ3NOch1Hp8fOpmMQ5UgIZ0JxG0HfajmyWo+VBypWwV41O
ZpJj+MImEE3bNzyeGRhYX+2UJPx95sAqqq2/Q9kWq1MWEZORk3xp8M5mOMF+Dwo/
wmxDYV4VCRteA4RbMzIHkgwuCelXcRHfU7AHAgMBAAGjZTBjMBQGA1UdEQQNMAuC
CWxvY2FsaG9zdDBLBglghkgBhvhCAQ0EPhY8QXV0b21hdGljYWxseSBnZW5lcmF0
ZWQgYnkgTmNhdC4gU2VlIGh0dHBzOi8vbm1hcC5vcmcvbmNhdC8uMA0GCSqGSIb3
DQEBBQUAA4GBAGeti3DzNJdh9WscUItDF0cAg6O7mmKHhj7WVRJtb/LYd93Ke9av
5733KbJE5CNyG5dSWJGN4xOmsD+Kqn1URzoXPbac+mqjmDzF2YNhdykg/5JdBZO3
cEeHS7jLRtdEYvIf5UXU5xOG6222dw2wQuxZm7zU9r3MHHCR9RNcYcXe
-----END CERTIFICATE-----
subject=/CN=localhost
issuer=/CN=localhost
---
No client certificate CA names sent
Peer signing digest: SHA512
Server Temp Key: X25519, 253 bits
---
SSL handshake has read 1019 bytes and written 269 bytes
Verification error: self signed certificate
---
New, TLSv1.2, Cipher is ECDHE-RSA-AES256-GCM-SHA384
Server public key is 1024 bit
Secure Renegotiation IS supported
Compression: NONE
Expansion: NONE
No ALPN negotiated
SSL-Session:
    Protocol  : TLSv1.2
    Cipher    : ECDHE-RSA-AES256-GCM-SHA384
    Session-ID: 8CB0DBFD5D3A606ED6992E6D5F2166C1D171AFD10E852CC91575AA7C4BA4E829
    Session-ID-ctx:
    Master-Key: FB03E92B7BA72128D1D7FAAEF7F3E68DED17490A8D55C92EA78A0CAF54BA2083131E                                                                                                                                                         D6F53C1044F46EE7FA1B244FE3A3
    PSK identity: None
    PSK identity hint: None
    SRP username: None
    TLS session ticket lifetime hint: 7200 (seconds)
    TLS session ticket:
    0000 - 10 ef fb 6a be df 31 ba-c3 2a 34 55 b6 de c8 ae   ...j..1..*4U....
    0010 - 74 95 37 97 3c 0d db ca-07 b6 2c 0d c0 38 d8 b3   t.7.<.....,..8..
    0020 - 4c 8b 33 b8 ae 81 7e b4-e8 91 cd 3f f4 41 07 31   L.3...~....?.A.1
    0030 - 12 fc 82 32 c8 da b5 6b-e7 4b 71 30 8f c1 c7 cb   ...2...k.Kq0....
    0040 - 38 01 07 77 8f df aa db-5f 5a d8 34 91 9b 3e 52   8..w...._Z.4..>R
    0050 - 40 2b 35 d1 4c d9 35 83-f6 81 8a be b6 c2 b2 3d   @+5.L.5........=
    0060 - f4 c3 60 3c 82 e1 fa 54-7e 72 cb 6b 02 37 45 7f   ..`<...T~r.k.7E.
    0070 - 97 c5 b0 fa 0c fe 4c 3c-9d 28 f9 b4 49 ce be e6   ......L<.(..I...
    0080 - 1b 11 2c 1b c5 ae b6 87-1b be 01 ab 71 1f c5 4a   ..,.........q..J
    0090 - 85 0a b3 25 f9 d4 82 66-bc 85 20 fe 8a 7d 0e 93   ...%...f.. ..}..

    Start Time: 1584871991
    Timeout   : 7200 (sec)
    Verify return code: 18 (self signed certificate)
    Extended master secret: yes
---
cluFn7wTiGryunymYOu4RcffSxQluehd
Correct!
-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQEAvmOkuifmMg6HL2YPIOjon6iWfbp7c3jx34YkYWqUH57SUdyJ
imZzeyGC0gtZPGujUSxiJSWI/oTqexh+cAMTSMlOJf7+BrJObArnxd9Y7YT2bRPQ
Ja6Lzb558YW3FZl87ORiO+rW4LCDCNd2lUvLE/GL2GWyuKN0K5iCd5TbtJzEkQTu
DSt2mcNn4rhAL+JFr56o4T6z8WWAW18BR6yGrMq7Q/kALHYW3OekePQAzL0VUYbW
JGTi65CxbCnzc/w4+mqQyvmzpWtMAzJTzAzQxNbkR2MBGySxDLrjg0LWN6sK7wNX
x0YVztz/zbIkPjfkU1jHS+9EbVNj+D1XFOJuaQIDAQABAoIBABagpxpM1aoLWfvD
KHcj10nqcoBc4oE11aFYQwik7xfW+24pRNuDE6SFthOar69jp5RlLwD1NhPx3iBl
J9nOM8OJ0VToum43UOS8YxF8WwhXriYGnc1sskbwpXOUDc9uX4+UESzH22P29ovd
d8WErY0gPxun8pbJLmxkAtWNhpMvfe0050vk9TL5wqbu9AlbssgTcCXkMQnPw9nC
YNN6DDP2lbcBrvgT9YCNL6C+ZKufD52yOQ9qOkwFTEQpjtF4uNtJom+asvlpmS8A
vLY9r60wYSvmZhNqBUrj7lyCtXMIu1kkd4w7F77k+DjHoAXyxcUp1DGL51sOmama
+TOWWgECgYEA8JtPxP0GRJ+IQkX262jM3dEIkza8ky5moIwUqYdsx0NxHgRRhORT
8c8hAuRBb2G82so8vUHk/fur85OEfc9TncnCY2crpoqsghifKLxrLgtT+qDpfZnx
SatLdt8GfQ85yA7hnWWJ2MxF3NaeSDm75Lsm+tBbAiyc9P2jGRNtMSkCgYEAypHd
HCctNi/FwjulhttFx/rHYKhLidZDFYeiE/v45bN4yFm8x7R/b0iE7KaszX+Exdvt
SghaTdcG0Knyw1bpJVyusavPzpaJMjdJ6tcFhVAbAjm7enCIvGCSx+X3l5SiWg0A
R57hJglezIiVjv3aGwHwvlZvtszK6zV6oXFAu0ECgYAbjo46T4hyP5tJi93V5HDi
Ttiek7xRVxUl+iU7rWkGAXFpMLFteQEsRr7PJ/lemmEY5eTDAFMLy9FL2m9oQWCg
R8VdwSk8r9FGLS+9aKcV5PI/WEKlwgXinB3OhYimtiG2Cg5JCqIZFHxD6MjEGOiu
L8ktHMPvodBwNsSBULpG0QKBgBAplTfC1HOnWiMGOU3KPwYWt0O6CdTkmJOmL8Ni
blh9elyZ9FsGxsgtRBXRsqXuz7wtsQAgLHxbdLq/ZJQ7YfzOKU4ZxEnabvXnvWkU
YOdjHdSOoKvDQNWu6ucyLRAWFuISeXw9a/9p7ftpxm0TSgyvmfLF2MIAEwyzRqaM
77pBAoGAMmjmIJdjp+Ez8duyn3ieo36yrttF5NSsJLAbxFpdlc1gvtGCWW+9Cq0b
dxviW8+TFVEBl1O4f7HVm6EpTscdDxU+bCXWkfjuRb7Dy9GOtt9JPsX8MBTakzh3
vBgsyi/sN3RqRBcGU40fOoZyfAMT8s1m/uYv52O6IgeuZ/ujbjY=
-----END RSA PRIVATE KEY-----

closed
```


# Bandit Level 17 --> Level 18

## Level Goal

There are 2 files in the homedirectory: passwords.old and passwords.new. The password for the next level is in passwords.new and is the only line that has been changed between passwords.old and passwords.new

NOTE: if you have solved this level and see ‘Byebye!’ when trying to log into bandit18, this is related to the next level, bandit19

## Commands you may need to solve this level

cat, grep, ls, diff

## Walkthrough

  * Used puttygen to convert the PEM ssh key to ppk
  * Used the private key to SSH onto the server
```
bandit17@bandit:~$ pwd
/home/bandit17
bandit17@bandit:~$ ls -las
total 36
4 drwxr-xr-x  3 root     root     4096 Oct 20 16:45 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r-----  1 bandit17 bandit17   33 Oct 20 16:45 .bandit16.password
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r-----  1 bandit18 bandit17 3300 Oct 16  2018 passwords.new
4 -rw-r-----  1 bandit18 bandit17 3300 Oct 16  2018 passwords.old
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
4 drwxr-xr-x  2 root     root     4096 Oct 20 16:45 .ssh
bandit17@bandit:~$ diff passwords.old passwords.new
42c42
< hlbSBPAWJmL6WFDb06gpTx1pPButblOA
---
> kfBf3eYk5BPBRzwjqutbbfE887SVc5Yd
```

# Bandit Level 18 --> Level 19

## Level Goal

The password for the next level is stored in a file readme in the homedirectory. Unfortunately, someone has modified .bashrc to log you out when you log in with SSH.
## Commands you may need to solve this level

ssh, ls, cat

## Walkthrough

  * Unable to SSH directly using the password from Level 17 solve
```
ssh bandit18@bandit.labs.overthewire.org -p 2220
The authenticity of host '[bandit.labs.overthewire.org]:2220 ([176.9.9.172]:2220)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Warning: Permanently added '[bandit.labs.overthewire.org]:2220,[176.9.9.172]:2220' (ECDSA) to the list of known hosts.
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit18@bandit.labs.overthewire.org's password:
Linux bandit 4.18.12 x86_64 GNU/Linux

      ,----..            ,----,          .---.
     /   /   \         ,/   .`|         /. ./|
    /   .     :      ,`   .'  :     .--'.  ' ;
   .   /   ;.  \   ;    ;     /    /__./ \ : |
  .   ;   /  ` ; .'___,/    ,' .--'.  '   \' .
  ;   |  ; \ ; | |    :     | /___/ \ |    ' '
  |   :  | ; | ' ;    |.';  ; ;   \  \;      :
  .   |  ' ' ' : `----'  |  |  \   ;  `      |
  '   ;  \; /  |     '   :  ;   .   \    .\  ;
   \   \  ',  /      |   |  '    \   \   ' \ |
    ;   :    /       '   :  |     :   '  |--"
     \   \ .'        ;   |.'       \   \ ;
  www. `---` ver     '---' he       '---" ire.org


Welcome to OverTheWire!

If you find any problems, please report them to Steven or morla on
irc.overthewire.org.

--[ Playing the games ]--

  This machine might hold several wargames.
  If you are playing "somegame", then:

    * USERNAMES are somegame0, somegame1, ...
    * Most LEVELS are stored in /somegame/.
    * PASSWORDS for each level are stored in /etc/somegame_pass/.

  Write-access to homedirectories is disabled. It is advised to create a
  working directory with a hard-to-guess name in /tmp/.  You can use the
  command "mktemp -d" in order to generate a random and hard to guess
  directory in /tmp/.  Read-access to both /tmp/ and /proc/ is disabled
  so that users can not snoop on eachother. Files and directories with
  easily guessable or short names will be periodically deleted!

  Please play nice:

    * don't leave orphan processes running
    * don't leave exploit-files laying around
    * don't annoy other players
    * don't post passwords or spoilers
    * again, DONT POST SPOILERS!
      This includes writeups of your solution on your blog or website!

--[ Tips ]--

  This machine has a 64bit processor and many security-features enabled
  by default, although ASLR has been switched off.  The following
  compiler flags might be interesting:

    -m32                    compile for 32bit
    -fno-stack-protector    disable ProPolice
    -Wl,-z,norelro          disable relro

  In addition, the execstack tool can be used to flag the stack as
  executable on ELF binaries.

  Finally, network-access is limited for most levels by a local
  firewall.

--[ Tools ]--

 For your convenience we have installed a few usefull tools which you can find
 in the following locations:

    * pwndbg (https://github.com/pwndbg/pwndbg) in /usr/local/pwndbg/
    * peda (https://github.com/longld/peda.git) in /usr/local/peda/
    * gdbinit (https://github.com/gdbinit/Gdbinit) in /usr/local/gdbinit/
    * pwntools (https://github.com/Gallopsled/pwntools)
    * radare2 (http://www.radare.org/)
    * checksec.sh (http://www.trapkit.de/tools/checksec.html) in /usr/local/bin/checksec.sh

--[ More information ]--

  For more information regarding individual wargames, visit
  http://www.overthewire.org/wargames/

  For support, questions or comments, contact us through IRC on
  irc.overthewire.org #wargames.

  Enjoy your stay!

Linux bandit 4.18.12 x86_64 GNU/Linux

      ,----..            ,----,          .---.
     /   /   \         ,/   .`|         /. ./|
    /   .     :      ,`   .'  :     .--'.  ' ;
   .   /   ;.  \   ;    ;     /    /__./ \ : |
  .   ;   /  ` ; .'___,/    ,' .--'.  '   \' .
  ;   |  ; \ ; | |    :     | /___/ \ |    ' '
  |   :  | ; | ' ;    |.';  ; ;   \  \;      :
  .   |  ' ' ' : `----'  |  |  \   ;  `      |
  '   ;  \; /  |     '   :  ;   .   \    .\  ;
   \   \  ',  /      |   |  '    \   \   ' \ |
    ;   :    /       '   :  |     :   '  |--"
     \   \ .'        ;   |.'       \   \ ;
  www. `---` ver     '---' he       '---" ire.org


Welcome to OverTheWire!

If you find any problems, please report them to Steven or morla on
irc.overthewire.org.

--[ Playing the games ]--

  This machine might hold several wargames.
  If you are playing "somegame", then:

    * USERNAMES are somegame0, somegame1, ...
    * Most LEVELS are stored in /somegame/.
    * PASSWORDS for each level are stored in /etc/somegame_pass/.

  Write-access to homedirectories is disabled. It is advised to create a
  working directory with a hard-to-guess name in /tmp/.  You can use the
  command "mktemp -d" in order to generate a random and hard to guess
  directory in /tmp/.  Read-access to both /tmp/ and /proc/ is disabled
  so that users can not snoop on eachother. Files and directories with
  easily guessable or short names will be periodically deleted!

  Please play nice:

    * don't leave orphan processes running
    * don't leave exploit-files laying around
    * don't annoy other players
    * don't post passwords or spoilers
    * again, DONT POST SPOILERS!
      This includes writeups of your solution on your blog or website!

--[ Tips ]--

  This machine has a 64bit processor and many security-features enabled
  by default, although ASLR has been switched off.  The following
  compiler flags might be interesting:

    -m32                    compile for 32bit
    -fno-stack-protector    disable ProPolice
    -Wl,-z,norelro          disable relro

  In addition, the execstack tool can be used to flag the stack as
  executable on ELF binaries.

  Finally, network-access is limited for most levels by a local
  firewall.

--[ Tools ]--

 For your convenience we have installed a few usefull tools which you can find
 in the following locations:

    * pwndbg (https://github.com/pwndbg/pwndbg) in /usr/local/pwndbg/
    * peda (https://github.com/longld/peda.git) in /usr/local/peda/
    * gdbinit (https://github.com/gdbinit/Gdbinit) in /usr/local/gdbinit/
    * pwntools (https://github.com/Gallopsled/pwntools)
    * radare2 (http://www.radare.org/)
    * checksec.sh (http://www.trapkit.de/tools/checksec.html) in /usr/local/bin/checksec.sh

--[ More information ]--

  For more information regarding individual wargames, visit
  http://www.overthewire.org/wargames/

  For support, questions or comments, contact us through IRC on
  irc.overthewire.org #wargames.

  Enjoy your stay!

Byebye !
Connection to bandit.labs.overthewire.org closed.
```
  * Note in Level 17 mentions 'Byebye', and the hint for Level 18 confirms that .bashrc is modified
  * So performed a manual Internet search for a way to run ssh without running the .bashrc
  * Found: `https://unix.stackexchange.com/questions/98698/ssh-parameter-to-ignore-bashrc-script`
  * Ran the `ssh bandit18@bandit.labs.overthewire.org -p 2220 "bash --noprofile --norc"`
```
ssh bandit18@bandit.labs.overthewire.org -p 2220 "bash --noprofile --norc"
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit18@bandit.labs.overthewire.org's password:

id
uid=11018(bandit18) gid=11018(bandit18) groups=11018(bandit18)
pwd
/home/bandit18
ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r-----  1 bandit19 bandit18 3549 Oct 16  2018 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
4 -rw-r-----  1 bandit19 bandit18   33 Oct 16  2018 readme
cat readme
IueksS7Ubh8G3DCwVzrTd8rAVOwq3M5x
```


# Bandit Level 19 --> Level 20

## Level Goal

To gain access to the next level, you should use the setuid binary in the homedirectory. Execute it without arguments to find out how to use it. The password for this level can be found in the usual place (/etc/bandit_pass), after you have used the setuid binary.

## Helpful Reading Material

  * `https://en.wikipedia.org/wiki/Setuid`

## Walkthrough

```
bandit19@bandit:~$ ls -las
total 28
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
8 -rwsr-x---  1 bandit20 bandit19 7296 Oct 16  2018 bandit20-do
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
bandit19@bandit:~$ ./bandit20-do
Run a command as another user.
  Example: ./bandit20-do id
bandit19@bandit:~$ ./bandit20-do id
uid=11019(bandit19) gid=11019(bandit19) euid=11020(bandit20) groups=11019(bandit19)
bandit19@bandit:~$ ./bandit20-do cat /etc/bandit_pass/bandit20
GbKksEFF4yrVs6il55v6gwY5aVje5f0j
```


# Bandit Level 20 --> Level 21

## Level Goal

There is a setuid binary in the homedirectory that does the following: it makes a connection to localhost on the port you specify as a commandline argument. It then reads a line of text from the connection and compares it to the password in the previous level (bandit20). If the password is correct, it will transmit the password for the next level (bandit21).

NOTE: Try connecting to your own network daemon to see if it works as you think

## Commands you may need to solve this level

ssh, nc, cat, bash, screen, tmux, Unix ‘job control’ (bg, fg, jobs, &, CTRL-Z, ...) 

## Walkthrough

  * Reviewed the program
```
bandit20@bandit:~$ pwd
/home/bandit20
bandit20@bandit:~$ ls -las
total 32
 4 drwxr-xr-x  2 root     root      4096 Oct 16  2018 .
 4 drwxr-xr-x 41 root     root      4096 Oct 16  2018 ..
 4 -rw-r--r--  1 root     root       220 May 15  2017 .bash_logout
 4 -rw-r--r--  1 root     root      3526 May 15  2017 .bashrc
 4 -rw-r--r--  1 root     root       675 May 15  2017 .profile
12 -rwsr-x---  1 bandit21 bandit20 12088 Oct 16  2018 suconnect
bandit20@bandit:~$ ./suconnect
Usage: ./suconnect <portnumber>
This program will connect to the given port on localhost using TCP. If it receives the correct password from the other side, the next password is transmitted back.
bandit20@bandit:~$ file suconnect
suconnect: setuid ELF 32-bit LSB executable, Intel 80386, version 1 (SYSV), dynamically linked, interpreter /lib/ld-linux.so.2, for GNU/Linux 2.6.32, BuildID[sha1]=74c0f6dc184e0412b6dc52e542782f43807268e1, not stripped
bandit20@bandit:~$ echo GbKksEFF4yrVs6il55v6gwY5aVje5f0j | nc -l -p 65535 &
[1] 18964
bandit20@bandit:~$ ./suconnect 65535
Read: GbKksEFF4yrVs6il55v6gwY5aVje5f0j
Password matches, sending next password
gE269g2h3mw3pwgrj0Ha9Uoqen1c9DGr
[1]+  Done                    echo GbKksEFF4yrVs6il55v6gwY5aVje5f0j | nc -l -p 65535

```


# Bandit Level 21 --> Level 22

## Level Goal

A program is running automatically at regular intervals from cron, the time-based job scheduler. Look in /etc/cron.d/ for the configuration and see what command is being executed.

## Commands you may need to solve this level

cron, crontab, crontab(5) (use "man 5 crontab" to access this)

## Walkthrough

```
bandit21@bandit:~$ pwd
/home/bandit21
bandit21@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -r--------  1 bandit21 bandit21   33 Oct 16  2018 .prevpass
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
bandit21@bandit:~$ ls -l /etc/cron.d/
total 16
-rw-r--r-- 1 root root 189 Jan 25  2017 atop
-rw-r--r-- 1 root root 120 Oct 16  2018 cronjob_bandit22
-rw-r--r-- 1 root root 122 Oct 16  2018 cronjob_bandit23
-rw-r--r-- 1 root root 120 Oct 16  2018 cronjob_bandit24
bandit21@bandit:~$ cat /etc/cron.d/cronjob_bandit22
@reboot bandit22 /usr/bin/cronjob_bandit22.sh &> /dev/null
* * * * * bandit22 /usr/bin/cronjob_bandit22.sh &> /dev/null
bandit21@bandit:~$ cat /usr/bin/cronjob_bandit22.sh
#!/bin/bash
chmod 644 /tmp/t7O6lds9S0RqQh9aMcz6ShpAoZKF7fgv
cat /etc/bandit_pass/bandit22 > /tmp/t7O6lds9S0RqQh9aMcz6ShpAoZKF7fgv
bandit21@bandit:~$ cat /tmp/t7O6lds9S0RqQh9aMcz6ShpAoZKF7fgv
Yk7owGAcWjwMVRwrTesJEwB7WVOiILLI
```


# Bandit Level 22 --> Level 23

## Level Goal

A program is running automatically at regular intervals from cron, the time-based job scheduler. Look in /etc/cron.d/ for the configuration and see what command is being executed.

NOTE: Looking at shell scripts written by other people is a very useful skill. The script for this level is intentionally made easy to read. If you are having problems understanding what it does, try executing it to see the debug information it prints.

## Commands you may need to solve this level

cron, crontab, crontab(5) (use "man 5 crontab" to access this)

## Walkthrough

```
bandit22@bandit:~$ cat /etc/cron.d/cronjob_bandit23
@reboot bandit23 /usr/bin/cronjob_bandit23.sh  &> /dev/null
* * * * * bandit23 /usr/bin/cronjob_bandit23.sh  &> /dev/null
bandit22@bandit:~$ cat /usr/bin/cronjob_bandit23.sh
#!/bin/bash

myname=$(whoami)
mytarget=$(echo I am user $myname | md5sum | cut -d ' ' -f 1)

echo "Copying passwordfile /etc/bandit_pass/$myname to /tmp/$mytarget"

cat /etc/bandit_pass/$myname > /tmp/$mytarget
bandit22@bandit:~$ echo I am user bandit23 | md5sum | cut -d ' ' -f 1
8ca319486bfbbc3663ea0fbe81326349
bandit22@bandit:~$ cat /tmp/8ca319486bfbbc3663ea0fbe81326349
jc1udXuA1tiHqjIsL8yaapX5XIAI6i0n
```


# Bandit Level 23 --> Level 24
## Level Goal

A program is running automatically at regular intervals from cron, the time-based job scheduler. Look in /etc/cron.d/ for the configuration and see what command is being executed.

NOTE: This level requires you to create your own first shell-script. This is a very big step and you should be proud of yourself when you beat this level!

NOTE 2: Keep in mind that your shell script is removed once executed, so you may want to keep a copy around...

## Commands you may need to solve this level

cron, crontab, crontab(5) (use "man 5 crontab" to access this)

## Walkthrough

  * The biggest issue with this challenge was not the script but setting the correct permission on the target file to ensure that the cronjob could write to it, hence the touch to create the file initially and then the chmod to 666 to enable read and write permissions globally.
```
bandit23@bandit:~$ mkdir -p /tmp/otwb23
bandit23@bandit:~$ cd /tmp/otwb23
bandit23@bandit:/tmp/otwb23$ vi /tmp/otwb23/b23.sh
bandit23@bandit:/tmp/otwb23$ cat /tmp/otwb23/b23.sh
#!/bin/bash
src=/etc/bandit_pass/bandit24
dst=/tmp/otwb23/b24pass
cat $src > $dst
bandit23@bandit:/tmp/otwb23$ touch /tmp/otwb23/b24pass
bandit23@bandit:/tmp/otwb23$ chmod 666 /tmp/otwb23/b24pass
bandit23@bandit:/tmp/otwb23$ cp /tmp/otwb23/b23.sh /var/spool/bandit24/b23.sh
bandit23@bandit:/tmp/otwb23$ cat /tmp/otwb23/b24pass
UoMYTrfrBFHyQXmg6gzctqAwOmw1IohZ
```


# Bandit Level 24 --> Level 25

## Level Goal

A daemon is listening on port 30002 and will give you the password for bandit25 if given the password for bandit24 and a secret numeric 4-digit pincode. There is no way to retrieve the pincode except by going through all of the 10000 combinations, called brute-forcing.

## Walkthrough

  * Manually reviewed the connection to confirm data format, expected the previous key, space and then the 4 digit code
  * Wrote a simple script to loop through the combination, and create a multi-line variable of them, and then submit to the TCP port
  * `for i in {0000..9999}; do j="UoMYTrfrBFHyQXmg6gzctqAwOmw1IohZ $i\n$j"; done; echo -e $j | nc 127.0.0.1 30002`
  * It took a little bit of time to run to create the input list
```
<snip>
Wrong! Please enter the correct pincode. Try again.
Wrong! Please enter the correct pincode. Try again.
Wrong! Please enter the correct pincode. Try again.
Wrong! Please enter the correct pincode. Try again.
Wrong! Please enter the correct pincode. Try again.
Wrong! Please enter the correct pincode. Try again.
Wrong! Please enter the correct pincode. Try again.
Correct!
The password of user bandit25 is uNG9O58gUE7snukf3bvZ0rxhtnjzSGzG

Exiting.
```

# Bandit Level 25 --> Level 26

## Level Goal

Logging in to bandit26 from bandit25 should be fairly easy... The shell for user bandit26 is not /bin/bash, but something else. Find out what it is, how it works and how to break out of it.

## Commands you may need to solve this level

ssh, cat, more, vi, ls, id, pwd

## Walkthrough

  * Based on the hint, check the shall for bandit26 in /etc/passwd
```
bandit25@bandit:~$ grep bandit26 /etc/passwd
bandit26:x:11026:11026:bandit level 26:/home/bandit26:/usr/bin/showtext
```
  * Manually reviewed the shell
```
bandit25@bandit:~$ file /usr/bin/showtext
/usr/bin/showtext: POSIX shell script, ASCII text executable
bandit25@bandit:~$ cat /usr/bin/showtext
#!/bin/sh

export TERM=linux

more ~/text.txt
exit 0
bandit25@bandit:~$ ls -l /usr/bin/showtext
-rwxr-xr-x 1 root root 53 Oct 16  2018 /usr/bin/showtext
```
  * Found the SSH private key which is named bandit26.sshkey
  * Attempted to SSH using the SSH as bandit26, could confirm that the contents of ~/text.txt is displayed and the shell exits
  * Suspected we may need to find a way to get code execution from the `more` command, so started manual Internet search for possible solutions for getting code execution or escape out of `more.
  * Found: `https://www.techonthenet.com/linux/commands/more.php`
  * !<cmd> or :!<cmd> seems to be a way out, to trigger more to page, had to resize the window :)
  * Tried the following as a command `mkdir -p /tmp/otwb25; touch /tmp/otwb25/b26pass; chmod 666 /tmp/otwb25/b26pass; cat /etc/bandit_pass/bandit26 > /tmp/otwb25/b26pass` but was unsuccessful. The commands did not appear to execute.
  * Tried !/bin/bash, !/bin/sh !bash !sh, but none of these worked
  * Manual Internet search for escaping restricted shells and found a number of useful resources:
    * `https://www.sans.org/blog/escaping-restricted-linux-shells/`
    * `https://fireshellsecurity.team/restricted-linux-shell-escaping-techniques/`
  * A useful hint was provided on p.141 of the book "Real-world Linux Security: Intrusion, Prevention, Detection, and Recovery" on Shell Escapes, specifically around `more` and `vi`, recalled from the initial link that `v` allows "Start up an editor at current line. The editor is taken from the environment variable VISUAL if defined, or EDITOR if VISUAL is not defined, or defaults to "vi" if neither VISUAL nor EDITOR is defined."
  * Tried `v` to get into edit mode, then attempt `:!/bin/bash`, and was unsuccessful but when I tried `:!/bin/sh` and `:!sh` got an error message "Cannot fork", so we are on the right track.
  * More manual Internet searching and found `http://web.physics.ucsb.edu/~pcs/apps/editors/vi/vi_unix.html`, which suggests ways of starting a shell from within vi using the `$SHELL` variable, but can be set internally in vi as well as an option (Refer `http://web.physics.ucsb.edu/~pcs/apps/editors/vi/tables_vi_options.html#vi_options`), so attempted to set a shell variable using vi and then spawning a shell.
  * So we repeat the SSH using a small terminal window to trigger paging using `more`, then we escape out of more into a visual editor which defaults to vi using `v`, once in vi, we set the shell using `:set shell=/bin/bash`, then finally invoke the shell using `:shell`
  * Once we have the shell we can get the password for the next level
```
:shell
bandit26@bandit:~$ id
uid=11026(bandit26) gid=11026(bandit26) groups=11026(bandit26)
bandit26@bandit:~$ ls -las
total 36
4 drwxr-xr-x  3 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
8 -rwsr-x---  1 bandit27 bandit26 7296 Oct 16  2018 bandit27-do
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .ssh
4 -rw-r-----  1 bandit26 bandit26  258 Oct 16  2018 text.txt
bandit26@bandit:~$ cat /etc/bandit_pass/bandit26
5czgV9L3Xx8JPOyRbXh6lQbmIOWvPT6Z
bandit26@bandit:~$
```
 

# Bandit Level 26 --> Level 27

## Level Goal

Good job getting a shell! Now hurry and grab the password for bandit27!

## Commands you may need to solve this level

ls

## Walkthrough

  * Logged into Level bandit26 using the same approach from Level bandit25
```
bandit26@bandit:~$ pwd
/home/bandit26
bandit26@bandit:~$ ls -las
total 36
4 drwxr-xr-x  3 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
8 -rwsr-x---  1 bandit27 bandit26 7296 Oct 16  2018 bandit27-do
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .ssh
4 -rw-r-----  1 bandit26 bandit26  258 Oct 16  2018 text.txt
bandit26@bandit:~$ file ./bandit27-do
./bandit27-do: setuid ELF 32-bit LSB executable, Intel 80386, version 1 (SYSV), dynamically linked, interpreter /lib/ld-linux.so.2, for GNU/Linux 2.6.32, BuildID[sha1]=8e941f24b8c5cd0af67b22b724c57e1ab92a92a1, not stripped
bandit26@bandit:~$ ./bandit27-do
Run a command as another user.
  Example: ./bandit27-do id
bandit26@bandit:~$ ./bandit27-do bandit27
env: ‘bandit27’: No such file or directory
bandit26@bandit:~$ ./bandit27-do cat /etc/bandit_pass/bandit27
3ba3118a22e93127a4ed485be72ef5ea
bandit26@bandit:~$
```



# Bandit Level 27 --> Level 28

## Level Goal

There is a git repository at ssh://bandit27-git@localhost/home/bandit27-git/repo. The password for the user bandit27-git is the same as for the user bandit27.

Clone the repository and find the password for the next level.

## Commands you may need to solve this level

git

## Walkthrough

```
bandit27@bandit:~$ mkdir -p /tmp/otwb27
bandit27@bandit:~$ cd /tmp/otwb27
bandit27@bandit:/tmp/otwb27$ git clone ssh://bandit27-git@127.0.0.1:/home/bandit27-git/repo
Cloning into 'repo'...
Could not create directory '/home/bandit27/.ssh'.
The authenticity of host '127.0.0.1 (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit27/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit27-git@127.0.0.1's password:
remote: Counting objects: 3, done.
remote: Compressing objects: 100% (2/2), done.
remote: Total 3 (delta 0), reused 0 (delta 0)
Receiving objects: 100% (3/3), done.
bandit27@bandit:/tmp/otwb27$ ls -las
total 305928
     4 drwxr-sr-x 3 bandit27 root      4096 Mar 24 13:12 .
305920 drwxrws-wt 1 root     root 313204736 Mar 24 13:13 ..
     4 drwxr-sr-x 3 bandit27 root      4096 Mar 24 13:13 repo
bandit27@bandit:/tmp/otwb27$ cd repo
bandit27@bandit:/tmp/otwb27/repo$ ls -las
total 16
4 drwxr-sr-x 3 bandit27 root 4096 Mar 24 13:13 .
4 drwxr-sr-x 3 bandit27 root 4096 Mar 24 13:12 ..
4 drwxr-sr-x 8 bandit27 root 4096 Mar 24 13:13 .git
4 -rw-r--r-- 1 bandit27 root   68 Mar 24 13:13 README
bandit27@bandit:/tmp/otwb27/repo$ cat README
The password to the next level is: 0ef186ac70e04ea33b4c1853d2526fa2
```


# Bandit Level 28 --> Level 29

## Level Goal

There is a git repository at ssh://bandit28-git@localhost/home/bandit28-git/repo. The password for the user bandit28-git is the same as for the user bandit28.

Clone the repository and find the password for the next level.

## Commands you may need to solve this level

git

## Walkthrough

```
bandit28@bandit:~$ mkdir -p /tmp/otwb28
bandit28@bandit:~$ cd /tmp/otwb28
bandit28@bandit:/tmp/otwb28$ git clone ssh://bandit28-git@localhost/home/bandit28-git/repo
Cloning into 'repo'...
Could not create directory '/home/bandit28/.ssh'.
The authenticity of host 'localhost (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit28/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit28-git@localhost's password:
remote: Counting objects: 9, done.
remote: Compressing objects: 100% (6/6), done.
remote: Total 9 (delta 2), reused 0 (delta 0)
Receiving objects: 100% (9/9), done.
Resolving deltas: 100% (2/2), done.
bandit28@bandit:/tmp/otwb28$ ls -las
total 305928
     4 drwxr-sr-x 3 bandit28 root      4096 Mar 24 13:18 .
305920 drwxrws-wt 1 root     root 313204736 Mar 24 13:18 ..
     4 drwxr-sr-x 3 bandit28 root      4096 Mar 24 13:18 repo
bandit28@bandit:/tmp/otwb28$ cd repo
bandit28@bandit:/tmp/otwb28/repo$ ls -las
total 16
4 drwxr-sr-x 3 bandit28 root 4096 Mar 24 13:18 .
4 drwxr-sr-x 3 bandit28 root 4096 Mar 24 13:18 ..
4 drwxr-sr-x 8 bandit28 root 4096 Mar 24 13:18 .git
4 -rw-r--r-- 1 bandit28 root  111 Mar 24 13:18 README.md
bandit28@bandit:/tmp/otwb28/repo$ cat README.md
# Bandit Notes
Some notes for level29 of bandit.

## credentials

- username: bandit29
- password: xxxxxxxxxx

bandit28@bandit:/tmp/otwb28/repo$ cd .git
bandit28@bandit:/tmp/otwb28/repo/.git$ ls -las
total 52
4 drwxr-sr-x 8 bandit28 root 4096 Mar 24 13:18 .
4 drwxr-sr-x 3 bandit28 root 4096 Mar 24 13:18 ..
4 drwxr-sr-x 2 bandit28 root 4096 Mar 24 13:18 branches
4 -rw-r--r-- 1 bandit28 root  276 Mar 24 13:18 config
4 -rw-r--r-- 1 bandit28 root   73 Mar 24 13:18 description
4 -rw-r--r-- 1 bandit28 root   23 Mar 24 13:18 HEAD
4 drwxr-sr-x 2 bandit28 root 4096 Mar 24 13:18 hooks
4 -rw-r--r-- 1 bandit28 root  137 Mar 24 13:18 index
4 drwxr-sr-x 2 bandit28 root 4096 Mar 24 13:18 info
4 drwxr-sr-x 3 bandit28 root 4096 Mar 24 13:18 logs
4 drwxr-sr-x 4 bandit28 root 4096 Mar 24 13:18 objects
4 -rw-r--r-- 1 bandit28 root  107 Mar 24 13:18 packed-refs
4 drwxr-sr-x 5 bandit28 root 4096 Mar 24 13:18 refs
bandit28@bandit:/tmp/otwb28/repo/.git$ cd ..
bandit28@bandit:/tmp/otwb28/repo$ git log README.md
commit 073c27c130e6ee407e12faad1dd3848a110c4f95
Author: Morla Porla <morla@overthewire.org>
Date:   Tue Oct 16 14:00:39 2018 +0200

    fix info leak

commit 186a1038cc54d1358d42d468cdc8e3cc28a93fcb
Author: Morla Porla <morla@overthewire.org>
Date:   Tue Oct 16 14:00:39 2018 +0200

    add missing data

commit b67405defc6ef44210c53345fc953e6a21338cc7
Author: Ben Dover <noone@overthewire.org>
Date:   Tue Oct 16 14:00:39 2018 +0200

    initial commit of README.md
bandit28@bandit:/tmp/otwb28/repo$ git log -p README.md
commit 073c27c130e6ee407e12faad1dd3848a110c4f95
Author: Morla Porla <morla@overthewire.org>
Date:   Tue Oct 16 14:00:39 2018 +0200

    fix info leak

diff --git a/README.md b/README.md
index 3f7cee8..5c6457b 100644
--- a/README.md
+++ b/README.md
@@ -4,5 +4,5 @@ Some notes for level29 of bandit.
 ## credentials

 - username: bandit29
-- password: bbc96594b4e001778eee9975372716b2
+- password: xxxxxxxxxx


commit 186a1038cc54d1358d42d468cdc8e3cc28a93fcb
Author: Morla Porla <morla@overthewire.org>
Date:   Tue Oct 16 14:00:39 2018 +0200

    add missing data

diff --git a/README.md b/README.md
index 7ba2d2f..3f7cee8 100644
--- a/README.md
+++ b/README.md
@@ -4,5 +4,5 @@ Some notes for level29 of bandit.
 ## credentials

 - username: bandit29
-- password: <TBD>
+- password: bbc96594b4e001778eee9975372716b2


commit b67405defc6ef44210c53345fc953e6a21338cc7
Author: Ben Dover <noone@overthewire.org>
Date:   Tue Oct 16 14:00:39 2018 +0200

    initial commit of README.md

diff --git a/README.md b/README.md
new file mode 100644
index 0000000..7ba2d2f
--- /dev/null
+++ b/README.md
@@ -0,0 +1,8 @@
+# Bandit Notes
+Some notes for level29 of bandit.
+
+## credentials
+
+- username: bandit29
+- password: <TBD>
+

```

+- password: bbc96594b4e001778eee9975372716b2


# Bandit Level 29 --> Level 30

## Level Goal

There is a git repository at ssh://bandit29-git@localhost/home/bandit29-git/repo. The password for the user bandit29-git is the same as for the user bandit29.

Clone the repository and find the password for the next level.

## Commands you may need to solve this level

git

```
bandit29@bandit:~$ mkdir -p /tmp/otwb29
bandit29@bandit:~$ cd /tmp/otwb29
bandit29@bandit:/tmp/otwb29$ git clone ssh://bandit29-git@localhost/home/bandit29-git/repo
Cloning into 'repo'...
Could not create directory '/home/bandit29/.ssh'.
The authenticity of host 'localhost (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit29/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit29-git@localhost's password:
remote: Counting objects: 16, done.
remote: Compressing objects: 100% (11/11), done.
remote: Total 16 (delta 2), reused 0 (delta 0)
Receiving objects: 100% (16/16), done.
Resolving deltas: 100% (2/2), done.
bandit29@bandit:/tmp/otwb29$ ls -las
total 305928
     4 drwxr-sr-x 3 bandit29 root      4096 Mar 24 13:27 .
305920 drwxrws-wt 1 root     root 313204736 Mar 24 13:27 ..
     4 drwxr-sr-x 3 bandit29 root      4096 Mar 24 13:27 repo
bandit29@bandit:/tmp/otwb29$ cd repo/
bandit29@bandit:/tmp/otwb29/repo$ ls -l
total 4
-rw-r--r-- 1 bandit29 root 131 Mar 24 13:27 README.md
bandit29@bandit:/tmp/otwb29/repo$ cat README.md
# Bandit Notes
Some notes for bandit30 of bandit.

## credentials

- username: bandit30
- password: <no passwords in production!>

bandit29@bandit:/tmp/otwb29/repo$ git log -p README.md
commit 84abedc104bbc0c65cb9eb74eb1d3057753e70f8
Author: Ben Dover <noone@overthewire.org>
Date:   Tue Oct 16 14:00:41 2018 +0200

    fix username

diff --git a/README.md b/README.md
index 2da2f39..1af21d3 100644
--- a/README.md
+++ b/README.md
@@ -3,6 +3,6 @@ Some notes for bandit30 of bandit.

 ## credentials

-- username: bandit29
+- username: bandit30
 - password: <no passwords in production!>


commit 9b19e7d8c1aadf4edcc5b15ba8107329ad6c5650
Author: Ben Dover <noone@overthewire.org>
Date:   Tue Oct 16 14:00:41 2018 +0200

    initial commit of README.md

diff --git a/README.md b/README.md
new file mode 100644
index 0000000..2da2f39
--- /dev/null
+++ b/README.md
@@ -0,0 +1,8 @@
+# Bandit Notes
+Some notes for bandit30 of bandit.
+
+## credentials
+
+- username: bandit29
+- password: <no passwords in production!>
+
bandit29@bandit:/tmp/otwb29/repo$ git branch -a
* master
  remotes/origin/HEAD -> origin/master
  remotes/origin/dev
  remotes/origin/master
  remotes/origin/sploits-dev
bandit29@bandit:/tmp/otwb29/repo$ git checkout remotes/origin/dev
Note: checking out 'remotes/origin/dev'.

You are in 'detached HEAD' state. You can look around, make experimental
changes and commit them, and you can discard any commits you make in this
state without impacting any branches by performing another checkout.

If you want to create a new branch to retain commits you create, you may
do so (now or later) by using -b with the checkout command again. Example:

  git checkout -b <new-branch-name>

HEAD is now at 33ce2e9... add data needed for development
bandit29@bandit:/tmp/otwb29/repo$ ls -las
total 20
4 drwxr-sr-x 4 bandit29 root 4096 Mar 24 13:29 .
4 drwxr-sr-x 3 bandit29 root 4096 Mar 24 13:27 ..
4 drwxr-sr-x 2 bandit29 root 4096 Mar 24 13:29 code
4 drwxr-sr-x 8 bandit29 root 4096 Mar 24 13:29 .git
4 -rw-r--r-- 1 bandit29 root  134 Mar 24 13:29 README.md
bandit29@bandit:/tmp/otwb29/repo$ git branch
* (HEAD detached at origin/dev)
  master
bandit29@bandit:/tmp/otwb29/repo$ cat README.md
# Bandit Notes
Some notes for bandit30 of bandit.

## credentials

- username: bandit30
- password: 5b90576bedb2cc04c86a9e924ce42faf

```


# Bandit Level 30 --> Level 31

## Level Goal

There is a git repository at ssh://bandit30-git@localhost/home/bandit30-git/repo. The password for the user bandit30-git is the same as for the user bandit30.

Clone the repository and find the password for the next level.

## Commands you may need to solve this level

git

## Walkthrough

```
bandit30@bandit:~$ mkdir -p /tmp/otwb30
bandit30@bandit:~$ cd /tmp/otwb30
bandit30@bandit:/tmp/otwb30$ git clone ssh://bandit30-git@localhost/home/bandit30-git/repo
Cloning into 'repo'...
Could not create directory '/home/bandit30/.ssh'.
The authenticity of host 'localhost (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit30/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit30-git@localhost's password:
remote: Counting objects: 4, done.
remote: Total 4 (delta 0), reused 0 (delta 0)
Receiving objects: 100% (4/4), done.
bandit30@bandit:/tmp/otwb30$ ls -las
total 305928
     4 drwxr-sr-x 3 bandit30 root      4096 Mar 24 13:33 .
305920 drwxrws-wt 1 root     root 313204736 Mar 24 13:33 ..
     4 drwxr-sr-x 3 bandit30 root      4096 Mar 24 13:33 repo
bandit30@bandit:/tmp/otwb30$ cd repo/
bandit30@bandit:/tmp/otwb30/repo$ ls -las
total 16
4 drwxr-sr-x 3 bandit30 root 4096 Mar 24 13:33 .
4 drwxr-sr-x 3 bandit30 root 4096 Mar 24 13:33 ..
4 drwxr-sr-x 8 bandit30 root 4096 Mar 24 13:33 .git
4 -rw-r--r-- 1 bandit30 root   30 Mar 24 13:33 README.md
bandit30@bandit:/tmp/otwb30/repo$ cat README.md
just an epmty file... muahaha
bandit30@bandit:/tmp/otwb30/repo$ git log -p README.md
commit 3aa4c239f729b07deb99a52f125893e162daac9e
Author: Ben Dover <noone@overthewire.org>
Date:   Tue Oct 16 14:00:44 2018 +0200

    initial commit of README.md

diff --git a/README.md b/README.md
new file mode 100644
index 0000000..029ba42
--- /dev/null
+++ b/README.md
@@ -0,0 +1 @@
+just an epmty file... muahaha
bandit30@bandit:/tmp/otwb30/repo$ git branch -a
* master
  remotes/origin/HEAD -> origin/master
  remotes/origin/master
bandit30@bandit:/tmp/otwb30/repo$ git log --diff-filter=D
bandit30@bandit:/tmp/otwb30/repo$ git log --oneline
3aa4c23 initial commit of README.md
bandit30@bandit:/tmp/otwb30/repo$ git tag
secret
bandit30@bandit:/tmp/otwb30/repo$ git show secret
47e603bb428404d265f59c42920d81e5
```


# Bandit Level 31 --> Level 32

## Level Goal

There is a git repository at ssh://bandit31-git@localhost/home/bandit31-git/repo. The password for the user bandit31-git is the same as for the user bandit31.

Clone the repository and find the password for the next level.

## Commands you may need to solve this level

git

## Walkthrough

```
bandit31@bandit:~$ mkdir /tmp/otwb31
bandit31@bandit:~$ cd /tmp/otwb31
bandit31@bandit:/tmp/otwb31$ git clone ssh://bandit31-git@localhost/home/bandit31-git/repo
Cloning into 'repo'...
Could not create directory '/home/bandit31/.ssh'.
The authenticity of host 'localhost (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit31/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit31-git@localhost's password:
remote: Counting objects: 4, done.
remote: Compressing objects: 100% (3/3), done.
remote: Total 4 (delta 0), reused 0 (delta 0)
Receiving objects: 100% (4/4), done.
bandit31@bandit:/tmp/otwb31$ ls -las
total 305928
     4 drwxr-sr-x 3 bandit31 root      4096 Mar 24 13:51 .
305920 drwxrws-wt 1 root     root 313204736 Mar 24 13:52 ..
     4 drwxr-sr-x 3 bandit31 root      4096 Mar 24 13:52 repo
bandit31@bandit:/tmp/otwb31$ cd repo
bandit31@bandit:/tmp/otwb31/repo$ ls -las
total 20
4 drwxr-sr-x 3 bandit31 root 4096 Mar 24 13:52 .
4 drwxr-sr-x 3 bandit31 root 4096 Mar 24 13:51 ..
4 drwxr-sr-x 8 bandit31 root 4096 Mar 24 13:52 .git
4 -rw-r--r-- 1 bandit31 root    6 Mar 24 13:52 .gitignore
4 -rw-r--r-- 1 bandit31 root  147 Mar 24 13:52 README.md
bandit31@bandit:/tmp/otwb31/repo$ cat README.md
This time your task is to push a file to the remote repository.

Details:
    File name: key.txt
    Content: 'May I come in?'
    Branch: master

bandit31@bandit:/tmp/otwb31/repo$ echo 'May I come in?' > key.txt
bandit31@bandit:/tmp/otwb31/repo$ cat .gitignore
*.txt
bandit31@bandit:/tmp/otwb31/repo$ echo '!key.txt' >> .gitignore
bandit31@bandit:/tmp/otwb31/repo$ git add key.txt
bandit31@bandit:/tmp/otwb31/repo$ git commit -m 'bandit31-->bandit32'
[master 3ebe995] bandit31-->bandit32
 1 file changed, 1 insertion(+)
 create mode 100644 key.txt
bandit31@bandit:/tmp/otwb31/repo$ git push
Could not create directory '/home/bandit31/.ssh'.
The authenticity of host 'localhost (127.0.0.1)' can't be established.
ECDSA key fingerprint is SHA256:98UL0ZWr85496EtCRkKlo20X3OPnyPSB5tB5RPbhczc.
Are you sure you want to continue connecting (yes/no)? yes
Failed to add the host to the list of known hosts (/home/bandit31/.ssh/known_hosts).
This is a OverTheWire game server. More information on http://www.overthewire.org/wargames

bandit31-git@localhost's password:
Counting objects: 3, done.
Delta compression using up to 4 threads.
Compressing objects: 100% (2/2), done.
Writing objects: 100% (3/3), 321 bytes | 0 bytes/s, done.
Total 3 (delta 0), reused 0 (delta 0)
remote: ### Attempting to validate files... ####
remote:
remote: .oOo.oOo.oOo.oOo.oOo.oOo.oOo.oOo.oOo.oOo.
remote:
remote: Well done! Here is the password for the next level:
remote: 56a9bf19c63d650ce78e6ec0354ee45e
remote:
remote: .oOo.oOo.oOo.oOo.oOo.oOo.oOo.oOo.oOo.oOo.
remote:
To ssh://localhost/home/bandit31-git/repo
 ! [remote rejected] master -> master (pre-receive hook declined)
error: failed to push some refs to 'ssh://bandit31-git@localhost/home/bandit31-git/repo'
```


# Bandit Level 32 --> Level 33

After all this git stuff its time for another escape. Good luck!

## Commands you may need to solve this level

sh, man

## Walkthrough

  * Logged into shell and attempted to execute commands, appeared as though it was taking the input, converting it to uppercase and then passing it to the `sh` shell to execute, found that `$SHELL` did not work to launch a shell, $$ still shows what may appear to be the process id of the shell, then tried $LOGNAME, and saw the username in the error message, so it appears that variables are left unchanged and passed to the shell for execution. Reviewed special parameters for bash shell`https://www.gnu.org/software/bash/manual/bash.html#Special-Parameters`. The first parameter $0, is always the filename, i.e. a shell must have been used to launch the "UPPERCASE SHELL", so tried `$0` as input and managed to get a `sh` shell

```
WELCOME TO THE UPPERCASE SHELL
>>
>> $0
$ id
uid=11033(bandit33) gid=11032(bandit32) groups=11032(bandit32)
$ pwd
/home/bandit32
$ ls -las
total 28
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
8 -rwsr-x---  1 bandit33 bandit32 7556 Oct 16  2018 uppershell
$ cat /etc/bandit_pass/bandit33
c9c3199ddf4121b10cf581a98d51caee
```


# Bandit Level 33 --> Level 34

At this moment, level 34 does not exist yet.

## Walkthough

```
bandit33@bandit:~$ ls -las
total 24
4 drwxr-xr-x  2 root     root     4096 Oct 16  2018 .
4 drwxr-xr-x 41 root     root     4096 Oct 16  2018 ..
4 -rw-r--r--  1 root     root      220 May 15  2017 .bash_logout
4 -rw-r--r--  1 root     root     3526 May 15  2017 .bashrc
4 -rw-r--r--  1 root     root      675 May 15  2017 .profile
4 -rw-------  1 bandit33 bandit33  430 Oct 16  2018 README.txt
bandit33@bandit:~$ cat README.txt
Congratulations on solving the last level of this game!

At this moment, there are no more levels to play in this game. However, we are constantly working
on new levels and will most likely expand this game with more levels soon.
Keep an eye out for an announcement on our usual communication channels!
In the meantime, you could play some of our other wargames.

If you have an idea for an awesome new level, please let us know!
```
