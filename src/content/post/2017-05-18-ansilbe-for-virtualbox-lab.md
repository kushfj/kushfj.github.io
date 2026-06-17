---
date: '2018-05-18T13:15:27+10:00'
draft: true
tags:
- ansible
- vm
- virtualbox
- lab
title: Ansible for Virtualbox Virtual Lab
---

This post is about getting an Ansible control node configured on an Ubuntu VM
within Virtualbox to be able to rapidly stand up and deploy other virtual
machines within Virtualbox for a virtual lab environment, along with some
examples. Since this is a lab environment, and we are running ansible off a
guest virtual machine within virtualbox, the closing of machines is outside the
scope of this post and assumes that the machines are already installed and
provisioned to be on the management network.

A few key concepts
  * Playbooks - describe the end state of the systems
  * Inventory - list of systems

  1. Install ansible on the control node, on the Ubuntu host, e.g. ubuntu-dev, reference the [installation guide|https://launchpad.net/~ansible/+archive/ubuntu/ansible]
```
sudo apt-get update
sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ansible/ansible
sudo apt-get update
sudo apt-get install ansible
```
  * Verify that the installation was successful
```
root@ubuntu-dev:~# ansible --version
ansible 2.5.2
  config file = /etc/ansible/ansible.cfg
  configured module search path = [u'/root/.ansible/plugins/modules', u'/usr/share/ansible/plugins/modules']
  ansible python module location = /usr/lib/python2.7/dist-packages/ansible
  executable location = /usr/bin/ansible
  python version = 2.7.12 (default, Dec  4 2017, 14:50:18) [GCC 5.4.0 20160609]

```
  * Edit the ansible configuration to disable host key file checking, useful in development environment where VMs may be rebuilt frequently
```
host_key_checking = False
```
  * Edit the ansible hosts file to specify the targets
```
[lab-firewalls]
172.17.0.1
172.17.0.2
[lab-webservers]
172.17.0.3
```
  * Generate SSH keys for Ansible and store them in ```~/.ssh/authorized_keys/``` by running ```ssh-keygen -t rsa -b 4096 -C ''ansible@lab.localhost ansible```
  * Setup the SSH authentication agent (```ssh-agent bash```) and provide it
 the private key (```ssh-add ~/.ssh/authorized_keys/ansible```)
  * Copy the SSH key to the remote target machines e.g. ```ssh-copy-id -i ~/.ssh/authorized_keys/ansible.pub root@172.17.0.1```
  * Confirm that Ansible is able to connect to the remote target machines ```ansible all -m ping```
  *
  *
  *







Appendix
  * CentOS host configuration
    * hostnamectl set-hostname fw1.lab.localhost --static
    * vi /etc/sysconfig /network-scripts/ifcfg-eth3
```
HWADDR="08:00:00:00:00:00"
TYPE=Ethernet
BOOTPROTO=static
NAME=eth3
IPADDR=172.17.0.1
PREFIX=24
ONBOOT=yes
NM_CONTROLLED=no
```
    * systemctl restart network


