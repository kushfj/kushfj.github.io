---
author: Nishchal Kush
published: '2014-11-05T20:53:00+10:00'
slug: 2014-11-05-setting-up-git
tags:
- ssh
- rsa
- server
- version control
- git
- public key
- cvs
- svn
title: 'Setting up git '
---
Git is yet another open source version control, and seems to be the tool
of choice for contemporary coding mavericks. I still prefer svn and cvs,
for centralised version control, but can appreciate why some projects
may require distributed repositories as afforded by git.  
  
Setting up a central git repository on a server is easy. You basically
setup a user, whose home directory is used to store the repositories,
and allow access to people using keys, where the user retain their
private key and their public key is saved as an authorised key for the
git user account.  
  
*Note: I've documented the steps I used below for my benefit. The name
of the server has been replace with &lt;SERVER&gt;, and the source code
repository example is project.git*  
  
<span class="underline">Set-up</span>  
  

groupadd git

useradd -g git -d /home/git -m git

su - git

mkdir -p /home/git/.ssh

cat id\_rsa.pub &gt; /home/git/.ssh/authorized\_keys

chmod 600 /home/git/.ssh/authorized\_keys

chmod 700 /home/git/.ssh

exit

vi /etc/passwd     *\# change the shell for user git from /bin/bash
to /usr/bin/git-shell*

1.  /usr/bin/git-shell

vi /etc/ssh/sshd\_config     *\# ensure that the following are
uncommented*

1.  RSAAuthentication yes
2.  PubkeyAuthentication yes
3.  AuthorizedKeysFile      .ssh/authorized\_keys

service sshd restart

<span class="underline">Git Notes</span>

-   Create repositories

1.  cd /home/git
2.  mkdir project.git
3.  cd project.git
4.  git --bare init

-   Initially adding to the repository

1.  git init
2.  git add .
3.  git commit -m 'initial commit'
4.  git remote add origin git@&lt;SERVER&gt;:/home/git/project.git
5.  git push origin master

-   Other users cloning the repository

1.  git clone git@&lt;SERVER&gt;:/home/git/project.git

<span class="underline">References</span>:  

1.  http://git-scm.com/book/en/Git-on-the-Server-Setting-Up-the-Server
