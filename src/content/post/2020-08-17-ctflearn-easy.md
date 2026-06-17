---
author: Kush, Nishchal
date: '2020-08-17T21:15:16+10:00'
tags:
- ctf
- ctflearn
- web
- forensics
- steg
- hexdump
- exif
- bacon cipher
title: CTFlearn Easy
---

Sorted all challenges by difficult so that I could attempt and learn from the easier ones.

# Easy

## Misc

### Practice Flag - 20pts

Try inputting the flag: flag{CTFLearn_is_awesome}

  * Submitted: `CTFLearn{CTFLearn_is_awesome}`

### Wikipedia - 30pts

Not much to go off here, but it’s all you need: Wikipedia and 128.125.52.138. 

  * Navigated to wikipedia site `https://www.wikipedia.org/`
  * Searched for `128.125.52.138` and found page on Flag. Searched within page for CTF and found reference to CTF flgs
  * Submitted: `CTFlearn{cNi76bV2IVERlh97hP}`

### QR Code - 30pts

Do you remember something known as QR Code? Simple. Here for you : <br /> https://mega.nz/#!eGYlFa5Z!8mbiqg3kosk93qJCP-DBxIilHH2rf7iIVY-kpwyrx-0

  * Naviagted to `https://mega.nz/#!eGYlFa5Z!8mbiqg3kosk93qJCP-DBxIilHH2rf7iIVY-kpwyrx-0`
  * Scanned the code using QR scanner on phone and got what appeared to be Base64 encoded string `c3ludCB2ZiA6IGEwX29icWxfczBldHJnX2RlX3BicXI=`
  * Used Cyberchef recipe From Base64 and got `synt vf : a0_obql_s0etrg_de_pbqr` which appears to be further encoded as something
  * Used Text Analysis at `https://www.boxentriq.com/code-breaking/text-analysis` which indicated Cesear cipher with a key of 13 as a likely candidate. Since I already had it loaded in Cyberchef added the ROT13 recipe with Rotate lower case chars and Rotate upper case chars set and Amount=13, got `flag is : n0_body_f0rget_qr_code`
  * Submitted: `CTFlearn{n0_body_f0rget_qr_code}`

### QR Code v2 - 30pts

How well are you in the ways of the QR Code? https://mega.nz/#!JItR3aqI!QKGxexShAPt-HUU_2DAdJKUljXc69sx1fXuaGUeoKaY

  * Naviagated to `https://mega.nz/file/JItR3aqI#QKGxexShAPt-HUU_2DAdJKUljXc69sx1fXuaGUeoKaY`
  * Scanned the code using QR scanner on phone and appeared to redirect to another page `https://mega.nz/file/9NFhUbwQ#vtrLVum8z-ZXzur33RrGJ4uivMJhA9_5TW2ulHucXoU`, downloaded the 13 byte Flag.txt file which contained `CTF{2_QR_4_U}`
  * Submitted: `CTFlearn{2_QR_4_U}`

## Web

### Basic Injection - 30pts

See if you can leak the whole database. The flag is in there somwhere… https://web.ctflearn.com/web4/

  * `curl -v https://web.ctflearn.com/web4/`
  * Used standard web browser and attempted to inject `' or 1 = '1'; -- xx`
  * Got a dump of name and data
```
...
Name: fl4g__giv3r
Data: th4t_is_why_you_n33d_to_sanitiz3_inputs 
...
```
  * Submitted: `CTFLearn{th4t_is_why_you_n33d_to_sanitiz3_inputs}`

### Where Can My Robot Go? - 30pts

Where do robots find what pages are on a website?

Hint:

    What does disallow tell a robot?

  * Attempted CTFLearn{robots.txt}, CTFLearn{/robots.txt}, and CTFLearn{./robots.txt}
  * Attempted to get robots.txt from https://ctflearn.com/challenge/107, and https://ctflearn.com/challenge/
  * 
```
User-agent: *
Disallow: /70r3hnanldfspufdsoifnlds.html 
```
  * Navigated to `https://ctflearn.com/70r3hnanldfspufdsoifnlds.html`
```
CTFlearn{r0b0ts_4r3_th3_futur3}
```
  * Submitted: `CTFlearn{r0b0ts_4r3_th3_futur3}`

## Crypto

### Character Encoding - 20pts

In the computing industry, standards are established to facilitate information interchanges among American coders. Unfortunately, I've made communication a little bit more difficult. Can you figure this one out? 41 42 43 54 46 7B 34 35 43 31 31 5F 31 35 5F 55 35 33 46 55 4C 7D

  * Used Cyberchef recipe, From Hex - Delimiter = Space
  * Got `ABCTF{45C11_15_U53FUL}`
  * Submitted: `CTFLearn{45C11_15_U53FUL}`

### Reversal of fortune - 20pts

Our team of agents have been tracking a hacker that sends cryptic messages to other hackers about what he's doing. We intercepted the below message he sent recently, can you figure out what it says? He mentions his hacker name in it, that's the code you need.

.nac uoy fi tIe$reveRpilF eldnah ym gnisu em egassem ,avaj yllacificeps ,gnidoc emos htiw pleh deen I ,deifitnedi tegrat txeN

  * Used Cyberchef recipe, Reverse - By Character
```
Next target identified, I need help with some coding, specifically java, message me using my handle FlipRever$eIt if you can.
```
  * Submitted: `CTFLearn{FlipRever$eIt}`

### Base 2 2 the 6 - 20pts

There are so many different ways of encoding and decoding information nowadays... One of them will work! Q1RGe0ZsYWdneVdhZ2d5UmFnZ3l9

  * Used Cyberchef recipe, From Base64
```
CTF{FlaggyWaggyRaggy}
```
  * Submitted: `CTFLearn{FlaggyWaggyRaggy}`

### BruXOR - 20pts

There is a technique called bruteforce. Message: q{vpln'bH_varHuebcrqxetrHOXEj No key! Just brute .. brute .. brute ... :D

  * Used Cyberchef recipe, XOR Brute Force: Key length=1, Sample length=100, Sample offset=0, Scheme= Standard, Print key
```
Key = 16: gm`fzx1t^I`wd^cstudgnsbd^YNS|
Key = 17: flag{y0u_Have_bruteforce_XOR}
Key = 18: icnhtv?zPGnyjPm}z{ji`}ljPW@]r
```
  * Submitted: `CTFLearn{y0u_Have_bruteforce_XOR}`

### Vigenere Cipher - 20pts

The vignere cipher is a method of encrypting alphabetic text by using a series of interwoven Caesar ciphers based on the letters of a keyword.<br />

I’m not sure what this means, but it was left lying around: blorpy

gwox{RgqssihYspOntqpxs}

  * Used `https://www.boxentriq.com/code-breaking/vigenere-cipher`
  * Input key as blorpy and got flag{CiphersAreAwesome}
  * Submitted: CTFLearn{CiphersAreAwesome} 

### Morse Code

`..-. .-.. .- --. ... .- -- ..- . .-.. -- --- .-. ... . .. ... -.-. --- --- .-.. -... -.-- - .... . .-- .- -.-- .. .-.. .. -.- . -.-. .... . . ...`

  * Used Cyberchef recipe, From Morse Code, Letter delimiter: Space, Word delimiter Line feed and got `FLAGSAMUELMORSEISCOOLBYTHEWAYILIKECHEESA`
  * Submitted: `CTFLearn{SAMUELMORSEISCOOLBYTHEWAYILIKECHEES}`

### Reverse Polarity - 30 pts

I got a new hard drive just to hold my flag, but I'm afraid that it rotted. What do I do? The only thing I could get off of it was this: 01000011010101000100011001111011010000100110100101110100010111110100011001101100011010010111000001110000011010010110111001111101

  * Used Cyberchef recipe From Binary with DElimiter=Space and `01000011010101000100011001111011010000100110100101110100010111110100011001101100011010010111000001110000011010010110111001111101` as imput, got `CTF{Bit_Flippin}`
  * Submitted: CTFlearn{Bit_Flippin}

### HyperStream Test#2

I love the smell of bacon in the morning! ABAAAABABAABBABBAABBAABAAAAAABAAAAAAAABAABBABABBAAAAABBABBABABBAABAABABABBAABBABBAABB

  * Attempted to use `https://www.boxentriq.com/code-breaking/cipher-identifier` to identify the cipher used but got nothing useful
  * Decided to just do an Internet search for the string (ignored the CTF write up by other people) but found something useful `https://mothereff.in/bacon`, this lines up with the clue in the text which references bacon.
  * Pasted the text in the ciphertext text input box
  * Checked Cyberchef and found recipe for Bacon Cipher Decode with Alphbet=Standard, Translation=A/B and got `ILOUEBACONDONTYOU`
  * Submitted: CTFlearn{ILOUEBACONDONTYOU}

### Hextroadinary - 30 pts

Meet ROXy, a coder obsessed with being exclusively the worlds best hacker. She specializes in short cryptic hard to decipher secret codes. The below hex values for example, she did something with them to generate a secret code, can you figure out what? Your answer should start with 0x.

0xc4115 0x4cf8

  * The code appear to be hexadecimal digits, plus the title of the challenge and the clue from the hackers handle appears to make reference to the reverse and XOR. Loaded into Cyberchef and tried XOR brute force and reverse but got nothing
  * Although this was not a programming challenge decided to write a Pythong script to simply XOR the two values because if A XOR B = C, then C XOR B = A and C XOR A = B
```
a = 0xc4115
b = 0x4cf8

c = a ^ b
print("CTFlearn{{{flag}}}".format(flag=hex(c)))
```
  * Submitted: `CTFlearn{0xc0ded}`

## Forensics

### WOW.... So Meta - 20 pts

This photo was taken by our target. See what you can find out about him from it. https://mega.nz/#!ifA2QAwQ!WF-S-MtWHugj8lx1QanGG7V91R-S1ng7dDRSV25iFbk

  * Downloaded the image and viewed the file properties using Windows explorer
  * Manually reviewed the Details meta data and found Camera serial number: `flag{EEe_x_I_FFf}`
  * Submitted: `CTFLearn{EEe_x_I_FFf}`

### Rubber Duck - 10 pts

Find the flag! Simple forensics challenge to get started with.

  * Downloaded RubberDuck.jpg from https://ctflearn.com/challenge/download/933
  * Performed a `strings` on the image and found the flag on the second line of the output
  * Submitted: `CTFlearn{REDACTED}`

### Exif - 20 pts

If only the password were in the image?

https://mega.nz/#!SDpF0aYC!fkkhBJuBBtBKGsLTDiF2NuLihP2WRd97Iynd3PhWqRw You could really ‘own’ it with exif.

  * Downloaded the image from the file
  * Since the name of the challenge was exif, just ran `exiftool` and found the `Owner Name` exif tag
  * Submitted: `CTFlearn{3l1t3_3x1f_4uth0r1ty_dud3br0}`


### PikesPeak - 20 pts

Pay attention to those strings!

  * Downloaded PikesPeak.jpg from `https://ctflearn.com/challenge/download/935`
  * Performed strings on the image and found multiple lines with possible flags
  * Grepped for ctf using `grep -i ctf` in the strings output, found multiple possible flags, but only one patching the flag prefix CTFLearn exactly, i.e. `CTFLearn{Colorado}` but that wasn't it, tried multiple others without success until `CTFlearn{REDACTED}`
  * Submitted: `CTFlearn{REDACTED}`

### Snowboard - 20 pts

Find the flag in the jpeg file. Good Luck!

  * Downloaded Snowboard.jpg from `https://ctflearn.com/challenge/download/934`
  * Manually inpsected the image, got nothing
  * Checked file metadata, got nothing
  * Ran file on the image and got:
```
Snowboard.jpg: JPEG image data, JFIF standard 1.01, resolution (DPI), density 300x300, segment length 16, comment: "CTFlearn{CTFIsEasy!!!}", comment: "Q1RGbGVhcm57U2tpQmFuZmZ9Cg==", Exif Standard: [TIFF image data, little-endian, direntries=8, manufacturer=Canon, model=Canon EOS 6D Mark II, xresolution=138, yresolution=146, resolutionunit=2, software=GIMP 2.10.6, datetime=2019:05:07 14:37:21], progressive, precision 8, 1200x800, frames 3
```
  * Tried to submit `CTFlearn{CTFIsEasy!!!}` but that was not it, then used Cyberchef recipe From Base64 with defaults and got `CTFlearn{REDACTED}`
  * Submitted: `CTFlearn{REDACTED}`

### Tux! - 20 pts

The flag is hidden inside the Penguin! Solve this challenge before solving my 100 point Scope challenge which uses similar techniques as this one.

  * Downloaded Tux.jpg from `https://ctflearn.com/challenge/download/973`
  * Got nothing for:
    * Manual inspection of the image
    * Manual review of the file meta data
  * Found a base64 value `ICAgICAgUGFzc3dvcmQ6IExpbnV4MTIzNDUK` when performing `file` which decodes to `      Password: Linux12345`, this might be a password for stegohide
  * Downloaded `steghide` from `http://steghide.sourceforge.net/download.php`
  * Attempted to use `steghide.exe extract -sf Tux.jpg` but got nothing using empty pass phrase, the decoded passprase, and Linux12345
  * Copied the file to Linux machine and ran `foremost`, found zip file
  * Extracted the file using `unzip 00000010.zip` and used `Linux12345` as the password and got a `flag` file
  * `cat flag`
```
CTFlearn{REDACTED}
```
  * Submitted: `CTFlearn{REDACTED}`

### Forensics 101

Think the flag is somewhere in there. Would you help me find it? https://mega.nz/#!OHohCbTa!wbg60PARf4u6E6juuvK9-aDRe_bgEL937VO01EImM7c

  * Navigated to `https://mega.nz/#!OHohCbTa!wbg60PARf4u6E6juuvK9-aDRe_bgEL937VO01EImM7c`, downloaded `95f6edfb66ef42d774a5a34581f19052.jpg`
  * Checked metadata using Windows explorer properties, got nothing
  * Manually inspected the image and did not notice anything in the image
  * Ran `strings` on the file and found `flag{wow!_data_is_cool}`
  * Submitted: `CTFlearn{wow!_data_is_cool}`

### Taking LS

Just take the Ls. Check out this zip file and I be the flag will remain hidden. https://mega.nz/#!mCgBjZgB!_FtmAm8s_mpsHr7KWv8GYUzhbThNn0I8cHMBi4fJQp8

  * Navigated to `https://mega.nz/file/mCgBjZgB#_FtmAm8s_mpsHr7KWv8GYUzhbThNn0I8cHMBi4fJQp8`
  * Downloaded `The Flag.zip`
  * Extracted the archive, found a password protected PDF, and found the password in `The Flag\.ThePassword\ThePassword.txt` file and opened the PDF
  * Submitted: `CTFlearn{T3Rm1n4l_is_C00l}`

### GandalfTheWise - 30 pts

Extract the flag from the Gandalf.jpg file. You may need to write a quick script to solve this.

  * Downloaded the image from `https://ctflearn.com/challenge/download/936`
  * Checked metadata using Windows explorer properties details, got nothing
  * Manually inspected the image, got nothing
  * Ran `file` on the file and found what appears to be Base64 encoded string
```
Gandalf.jpg: JPEG image data, JFIF standard 1.01, aspect ratio, density 1x1, segment length 16, comment: "Q1RGbGVhcm57eG9yX2lzX3lvdXJfZnJpZW5kfQo=", comment: "xD6kfO2UrE5SnLQ6WgESK4kvD/Y/rDJPXNU45k/p", comment: "h2riEIj13iAp29VUPmB+TadtZppdw3AuO7JRiDyU", baseline, precision 8, 225x225, frames 3
```
  * Decoded the first string `Q1RGbGVhcm57eG9yX2lzX3lvdXJfZnJpZW5kfQo=` and got `CTFlearn{xor_is_your_friend}` and tried to submit it, got nothing, the other two strings did not decode to ASCII 
  * The length of both strings are 40, so we should be able to XOR them, the first time I ran this I forgot that the strings were base64 encoded, so I had to decode them first before the XOR
```
import base64

a = "xD6kfO2UrE5SnLQ6WgESK4kvD/Y/rDJPXNU45k/p"
A = base64.b64decode(a)

b = "h2riEIj13iAp29VUPmB+TadtZppdw3AuO7JRiDyU"
B = base64.b64decode(b)

c = []
l = len(A)

i = 0
while i < l:
  c.append(chr(A[i] ^ B[i]))
  i += 1

print("".join(c))
```
  * Submitted: CTFlearn{REDACTED}

### Binwalk

Here is a file with another file hidden inside it. Can you extract it? https://mega.nz/#!qbpUTYiK!-deNdQJxsQS8bTSMxeUOtpEclCI-zpK7tbJiKV0tXYY

  * Naviagated to `https://mega.nz/#!qbpUTYiK!-deNdQJxsQS8bTSMxeUOtpEclCI-zpK7tbJiKV0tXYY` and downloaded `PurpleThing.jpeg`
  * Ran `file` on the downloaded file and found that is was actually a PNG file
  * Ran `pngcheck` and found there was data following the IEND chunk
  * Ran `binwalk` and found that there was another PNG embedded into the image
  * Extracted the file using `binwalk --dd=".*" PurpleThing.jpeg`, found the 0 and 25795 PNG files in the extracted folder location, 0 appeared to be the original file, but `eog 25795` revealed the file
  * Submitted: CTFlearn{b1nw4lk_is_us3ful}

### Chalkboard

Solve the equations embedded in the jpeg to find the flag. Solve this problem before solving my Scope challenge which is worth 100 points.

  * Downloaded file from `https://ctflearn.com/challenge/download/972`
  * Ran `strings` and found the clue
```
The flag for this challenge is of the form:
CTFlearn{I_Like_Math_x_y}
where x and y are the solution to these equations:
3x + 5y = 31
7x + 9y = 59

```
  * Used Wolframalpha to solve the equation using `solve 3x + 5y = 31 and 7x + 9y = 59`, and got x = 2 and y = 5, refer `https://www.wolframalpha.com/input/?i=solve+3x+%2B+5y+%3D+31+and+7x+%2B+9y+%3D+59`
  * Submitted: `CTFlearn{REDACTED}`

### Pho Is Tasty!

The flag is hidden in the jpeg file. Good Luck! Have some Pho! Solve this challenge before solving my Scope challenge for 100 points.

  * Downloaded the image from `https://ctflearn.com/challenge/download/971`
  * Manually examined the file meta data using Windows properties, got nothing
  * Ran `file` on the image and found nothing 
  * Ran `strings` on the image and found nothing 
  * Ran `stegsolv` on the image and found nothing 
  * Checked to make sure there was nothing in the file following the JPEG trailer, i.e. after `ff d9`, found nothing 
  * Performed a reverse image search using TinEye but got too many results to examine.
  * Got stuck and asked for help, @1337s mentioned using a hex editor, so opened up using HxD and manually inspected the file and foud the flag
  * Submitted: CTFlearn{REDACTED}


## Networking

### IP Tracer

Bob is an amateur hacker and has collected the following IP Address: 159.167.16.5, but Bob needs help finding where the IP Address is located. Can you help Bob find where the IP Address is located. (Type the City name)

  * Navigated to `https://ipinfo.io/159.167.16.5` but didnt get anything useful, tried `https://www.lookip.net/ip/159.167.16.5` and found that the IP appears to be pinned to London
  * Submitted: `CTFlearn{London}`

## Reverse Engineering

### Basic Android RE 1

A simple APK, reverse engineer the logic, recreate the flag, and submit!

  * Downloaded the BasicAndroidRE1.apk from `https://ctflearn.com/challenge/download/962`
  * Googled on how to reverse engineer APK files, found references to use `apktool` to extract resources from an APK file, so installed apktools `choco install apktool`
  * Attempted to decode tha APK file using `apktool -v decode BasicAndroidRE1.apk`
  * Manually inspected the AndroidManifest.xml file in `BasicAndroidRE1` directory and found reference to `com.example.secondapp.MainActivity` which appears to be a Java class file
  * Manually located the MainActivity `MainActivity.smali` file under `BasicAndroidRE1\smali\com\example\secondapp`, noticed that number of const_string references which appeared to be consistent with CTFlearn flag format, performed `grep const-string MainActivity.smali` and got 
```
    const-string v1, "b74dec4f39d35b6a2e6c48e637c8aedb"
    const-string v2, "Success! CTFlearn{"
    const-string p1, "_is_not_secure!}"
```
  * Tried submitting CTFlearn{b74dec4f39d35b6a2e6c48e637c8aedb_is_not_secure!} but got nothing, then manually re-read the code and looks like the `b74dec4f39d35b6a2e6c48e637c8aedb` is an MD5 hash of a string, so checked on crackstation but found nothing
  * Tried `https://md5.gromweb.com/?md5=b74dec4f39d35b6a2e6c48e637c8aedb` and found Sprint2019.
  * Submitted: `CTFlearn{Spring2019_is_not_secure!}`

### Lazy Game Challenge



I found an interesting game made by some guy named "John_123". It is some betting game. I made some small fixes to the game; see if you can still pwn this and steal $1000000 from me!

To get flag, pwn the server at: nc thekidofarcrania.com 10001

  * `nc thekidofarcrania.com 10001`
```
?c?[3J?[5m?[36mWelcome to the Game of Luck !. ?[0m
?[31m
Rules of the Game :?[0m
(1) You will be Given 500$
(2) Place a Bet
(3) Guess the number what computer thinks of !
(4) computer's number changes every new time !.
(5) You have to guess a number between 1-10
(6) You have only 10 tries !.
(7) If you guess a number > 10, it still counts as a Try !
(8) Put your mind, Win the game !..
(9) If you guess within the number of tries, you win money !
(10) Good Luck !..

theKidOfArcrania:
  I bet you cannot get past $1000000!


Are you ready? Y/N :
```
  * Played the game for a couple of rounds to try and figure out how it worked then found out it didnt, i.e. even with the correct guess you lose
```
Make a Guess : 1

Computer's number :  1
Your Guess :  1
Sorry Wrong Guess, Try Again !. -_-
```
  * So decided to bet -1000000 and just kept entering 1 as the guess then something bad happened... I won (note was running on Windows using cygwin, so the terminal color codes are shown)
```
Make a Guess : 1

Computer's number :  1
Your Guess :  1
Sorry Wrong Guess, Try Again !. -_-
?c?[3J

You made it !.
You won JACKPOT !..
You thought of what computer thought !.
Your balance has been updated !
?[31m

Current balance?[0m : ?[0m?[5m?[32m-1999500$?[0m
Want to play again? Y/N : N
?[36mThank you for playing ! ?[0m
?[5m?[33mMade by John_123?[0m
?[5m?[31mSmall mods by theKidOfArcrania?[0m
?[1m?[36mGive it a (+1) if you like !..?[0m
```
  * So next decided to repeat, and was lucky enought to not guess the number and lost the bet.
```
?c?[3JSorry you didn't made it !
Play Again !...
Better Luck next Time !.
Sorry you lost some money !..
Your balance has been updated !.
?[31mCurrent balance : ?[0m : ?[0m
?[5m?[32m1001000$?[0m
?[36mWhat the... how did you get that money (even when I tried to stop you)!? I guess you beat me!
?[0m
?[36mThe flag is CTFlearn{d9029a08c55b936cbc9a30_i_wish_real_betting_games_were_like_this!}
?[0m
?[36mThank you for playing ! ?[0m
?[5m?[33mMade by John_123?[0m
?[5m?[31mSmall mods by theKidOfArcrania?[0m
?[1m?[36mGive it a (+1) if you like !..?[0m
```
  * Submitted: `CTFlearn{d9029a08c55b936cbc9a30_i_wish_real_betting_games_were_like_this!}`


## Programming

### The Credit Card Fraudster

I just arrested someone who is probably the most wanted credit card fraudster in Europe. She is a smart cybercriminal, always a step ahead INTERPOL and she kept unnoticed for years by never buying online, but buying goods with a different card every time and in different stores. My cyber-analysts found out after collecting all evidences she hacked into one the largest payment provider in Europe, reverse-engineered the software present on the server and partly corrupted the card number validation code to accept all her payments. The change enables acceptance of any transaction with a card number multiple of 123457 and the Luhn check digit is valid.

I caught her because every year she bought a bouquet of flowers next to the same cemetery. While handcuffing her at the flower shop's exit, she said the flowers were for her lost father and today it is his death anniversary. She broke down in tears and she did some steps and threw something in the sewers. My female colleague conducted a search on her, but she couldn't find the card she used, only the receipt.

```
The little flower shop
======================

European Express Debit
Card Number: 543210******1234
SALE

Please debit my account
Amount: 25.00€
```

Can you help me to recover the card number so that I can confirm with the flower merchant's bank the card number was used in that shop and is fraudulent?

Hints:

1/ Luhn_algorithm

2/ Flag format is CTFlearn{card_number}

  * cc = x * 123457, cc like 543210...1234
  * Read up on Luhn's algorithm at `https://en.wikipedia.org/wiki/Luhn_algorithm`
  * Write a python script to verify numbers as complying with Luhn's algorithm, then attempted to brute force all numbers in the range, checked if it was a multiple of 123457 and if so then checked if was value and printed the output
```
def is_luhn_valid(acc):
  d = list(map(int, str(acc)))

  i = 0 
  s = 0 

  l = len(d)
  while i < l:
    if i % 2 == 0:
      d[i] = d[i] * 2
      if d[i] > 9:
        d[i] = d[i] - 9
    s += d[i] 
    i += 1

  if s % 10 == 0:
    return True
  else:
    return False


## 543210******1234
s1 = "543210"
s3 = "1234"

for x in range(999999):
  s = s1 + (str(x).zfill(6)) + s3
  if int(s) % 123457 == 0:
    if is_luhn_valid(s):
      print("{}".format(s))
```
  * Submitted: `CTFlearn{5432103279251234}`

### Simple Programming - 30 pts

Can you help me? I need to know how many lines there are where the number of 0's is a multiple of 3 or the numbers of 1s is a multiple of 2. Please! Here is the file: https://mega.nz/#!7aoVEKhK!BAohJ0tfnP7bISIkbADK3qe1yNEkzjHXLKoJoKmqLys

  * Navigated to `https://mega.nz/#!7aoVEKhK!BAohJ0tfnP7bISIkbADK3qe1yNEkzjHXLKoJoKmqLys`
  * Downloaded `data.txt`, although the 156KB file is downloaded as `data.dat`
  * Ran `file` and `wc -l` on the file and it appears to be an ASCII text file with 10000 lines of text. Performed a `head` and `tail` on the file to get an indication of the type of data, and it appears to be a string on 0s and 1s.
  * Write a python program to open the file for reading, read each line, and count the number of 0s and 1s and then see if the number if the count of 0s is multiple of 3 or if the count of 1s is a multiple of 2 then increment the line out, and finally print out the number of lines which matched.
```
try:
  fp = open('data.dat', 'r')
  line = fp.readline()
  count = 0

  while line:
    zeros = line.count('0')
    ones = line.count('1')

    if zeros % 3 == 0 or ones % 2 == 0:
      count += 1

    line = fp.readline()

finally:
  fp.close()
  print("CTFlearn{{{count}}}".format(count=count))
```
  * Submitted: `CTFlearn{6662}`
