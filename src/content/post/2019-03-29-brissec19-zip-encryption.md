---
author: Kush, Nishchal
date: '2019-03-30T00:58:32+10:00'
draft: false
tags:
- zip
- encryption
- compression
- aes
- confidentiality
- integrity
- hash
- AES
- SHA
- CRC32
title: GPG Better than Zip Encryption
---


# Is GPG/OpenPGP really Better than Zip ?

I attended a local conference yesterday (2019-03-29) and during one of the talks a senior analyst from one of the world's first CERT said that the preference was to use GPG for symmetric key encryption of files to transfer confidential information to their clients over zip. The reason presented was that zip did not provide the desired level of confidentiality and integrity. This comment got me thinking as I had thought that zip used AES for encryption, so now I am awake at 0100hrs in the morning and curious to understand the encryption used in zip.

I decided to look at the encryption and integrity mechanism provided in the Zip format (not to be confused with Zip compression - RFC1951) and compare it with those provided in GPG. In an effort to minimise the combination of algorithms to compare across the different version of the specifications for Zip and GPG, I used the current version. At the time of this post for Zip it was version 6.3.5 and GPG was based off RFC 4880. 

## Review

To further reduce the amount of qualitative analysis to be done, I limited my algorithms to AES (AES-128 or better) and SHA (SHA-224 or better), regardless of the key lengths, so long as the same key lengths were supported by both implementations.  So if both mechanism supported AES for providing some assurance of confidentiality and SHA based hash for some assurance of integrity then I would consider them equal if the key length supported were the same. I do not consider the cipher modes of the algorithm, known flaws against specific algorithms and modes, nor the specific of the implementations in managing session keys, rounds of hashing, etc. in producing the zip and gpg archieves in the comparison.


### Zip Format

So it turns out that since inception there have been several version to the Zip format specification. The initial version used a known weak encryption algorithm (PKZIP cipher), but also supports additional ciphers, including AES.  AES in cipher block chaining (CBC) is defined in the specification.  AES-128, AES-192 and AES-256 have been supported since version 5.1 of the specification.  The commonly preferred WinZip implementation uses AES in CTR mode for encryption to provide some assurance of confidentiality. 

Most implementation will use PKZIP cipher by default, and newer ciphers need to be manually specified to ensure confidentiality and integrity.  Data integrity for individual files is implemented using CRC32 to detect accidental modification.

When using digital signature to provide assurances for non-repudiation, and protection against deliberate modification, data hashing is used. Data hashing may be performed using SHA1, SHA256, SHA384 as well as SHA512 amonst other algorithms.  Version 2 of SHA has been specified since 6.3.0 of the zip file format specification. 

### OpenPGP

GPG can be used for symmetric encryption, and support AES-256 encryption as a symetric key algorithm as well as SHA as a hash algorithm. GPG implementes symmetric encryption using a variant of cipher block forwarding (CBF).  According to the RFC, implementations should implement AES-128. The RFC also references the NIST 800-57 key management recommendations to a hash length of 256-bits for a 128-bit symmetric cipher key length.

Assurance of integrity against deliberate modification is provided by including a hash based modification detection code (MDC) with the plaintext prior to encrypting. Only SHA1 is can be used for computing the MDC.

When using digital signatures, SHA225, SHA256, SHA384 and SHA512 may also be used in additiont to other hash algorithms.

# Conclusion

<!--
|                  | Zip Format           | OpenPGP               |
| ---------------- | -------------------- | --------------------- |
| Specification    | APPNOTE-6.3.5        | RFC 4880              |
| AES              | AES128, 192, 256     | AES128, 192, 256      |
| AES mode         | CBC                  | CBF                   |
| Data integrity   | CRC32 (accidental)   | SHA1 (deliverate)     |
| Sign. hash       | SHA256, 384, 512     | SHA224, 256, 384, 512 |
-->

Both mechanism provide data compression, in fact OpenPGP may use Zip to provide data compression services. Confidentiality is provided using data encryption, and some assurance of data integrity is provided using CRC32 for Zip against accidental modification, and using SHA1 against deliberate modification for OpenPGP.

In terms of providing data confidentiallity, I cannot tell the two approached apart. It is clear that OpenPGP provides greater assurance of integrity since it protects against deliberate modification. However, if the threat model included the requirement for protection against deliberate modification, then the use of digital signature should have been considered.

At the end of it, I am still not clear how the analyst came to his decision and made the comment. To seek further clarification I have also reached out to the analyst for more information, but have not heard anything back yet. Perhaps they are privy to some insider information, due to the nature of their work, regarding the algorithms employed by Zip and OpenPGP, and not at liberty to share.

# References
  * https://courses.cs.ut.ee/MTAT.07.022/2015_fall/uploads/Main/dmitri-report-f15-16.pdf
  * https://pkware.cachefly.net/webdocs/APPNOTE/APPNOTE-6.3.5.TXT
  * https://www.ietf.org/rfc/rfc4880.txt
  * https://www.ietf.org/rfc/rfc1951.txt
  * https://www.winzip.com/win/en/aes_info.html
  * https://nvlpubs.nist.gov/nistpubs/SpecialPublications/NIST.SP.800-57pt1r4.pdf
