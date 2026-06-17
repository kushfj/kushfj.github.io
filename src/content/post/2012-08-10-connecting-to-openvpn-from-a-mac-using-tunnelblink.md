---
author: Nishchal Kush
published: '2012-08-10T12:04:00+10:00'
slug: 2012-08-10-connecting-to-openvpn-from-a-mac-using-tunnelblink
tags:
- apple
- client
- openvpn
- mac os x
- Mac
- configuration
- SSL
- tunnelblink
title: Connecting to OpenVPN from a Mac using Tunnelblink
---
To connect to an OpenVPN server you need an appropriate OpenVPN client
installed to establish the SSL link. For Apple Mac OS X systems,
TunnelBlick (http://code.google.com/p/tunnelblick/) is a good graphical
user interface. At the time of this blog the current latest stable
version of TunnelBlick available was 3.2.7. These instructions were
executed on an Apple iMac running Mac OS X 10.7.4. As with all other
posts on this blog, the purpose of this post is not to provide a
tutorial, but instead to documents the steps taken, for my own
benefit.  
  
Download and install Tunnelblink  
  

1.  Download the latest stable version of TunnelBlick (3.2.7).
2.  Click on the downloaded dmg package file to mount it.
3.  Once the Tunnelblink window is open double-click the Tunnelblink.app
    icon
4.  A warning may be displayed to indicate that the package may be
    unsafe as it was downloaded, continue by clicking the "Open" button
5.  Enter the system administrator credentials to start the install
6.  Once installation is completed, the installation succeeded window
    will be displayed, click the "Quit" button
7.  Close the Tunnelblink window, and eject the dmg package
8.  Start the Tunnelblink GUI by going to Applications and clicking
    Tunnelblink.app
9.  You should see a Tunnelblink icon up the top

The first time you start the Tunnelblink application

1.  A warning may be displayed to indicate that the package may be
    unsafe as it was downloaded, continue by clicking "Open" button
2.  When prompted, click on the "I have configuration files" button

Setting up the OpenVPN connection

Then click on "OpenVPN Configuration(s)" button

Select the "Create Tunnelblick VPN Configuration" button to generate a
configuration based on your OpenVPN configuration files

Take a note of the instructions in the dialog box and Click the "Done"
button

You may be prompted for automatic updates

1.  To prevent your system details (although it is anonymous) from being
    transmitted, uncheck the "Include anonymous system profile" 
2.  Then click on "Check Automatically" button to enable automatic
    checking of updates

You should have a directory called "Empty Tunnelblick VPN Configuration"
on your desktop

Get the CA certificate (ca.crt), your private key (I used MACHINE.key as
an example) and certificate (e.g. MACHINE.crt) and your client
configuration file (this may be something like client.ovpn or
client.conf). These should be provided by your network administrator.

1.  ca.crt
2.  MACHINE.crt
3.  MACHINE.key
4.  client-config.ovpn

Copy or move the files above into the directory on your desktop

Rename the directory into something meaningful with a .tblk extension,
e.g. Office-VPN.tblk

When prompted to add the .tblk extension click on the "Add" button, you
should see the directory icon change to a Tunnelblink icon

Double-click the renamed directory to install the configuration

When prompted to continue the installation click the "Only Me" button

Enter the system administrator credentials to complete the install

Once installed, click the "OK button"

Changing DNS settings

1.  Right click on the Tunnelblink icon up the top
2.  Select VPN Details, then select the VPN connection you wish to edit,
    e.g. "Office-VPN"
3.  Select the "Settings" option on the middle of the window
4.  Change the "Set DNS/WINS" option to suit, e.g. You may want to
    disable DNS changes to be pushed through from the VPN tunnel, thus
    to use your existing nameserver configuration select "Do not set
    nameserver"

Connecting to the VPN  
  

1.  Once Tunnelblink has been installed and the configuration completed
2.  Right click the Tunnelblink icon up the top
3.  You should see the VPN connection, e.g. "Connect Office-VPN", select
    it to connect

  
Disconnecting from the VPN  
  

1.  Once the VPN connection has been established and you wish to
    disconnect
2.  Right click the Tunnelblink icon up the top
3.  You should see the VPN connection, e.g. "Disconnect Office-VPN",
    select it to disconnect

Here is a sample client configuration file for reference, substitute the
SERVER, PORT and MACHINE as appropriate

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">client</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">dev
tun</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">proto
udp</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">remote
*SERVER PORT*</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">resolv-retry
infinite</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">nobind</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">persist-key</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">persist-tun</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">ca
ca.crt</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">cert
*MACHINE*.crt</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">key
*MACHINE*.key</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">comp-lzo</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">verb
3</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">;
the following lines are needed for Windows Vista, 7 and 8 machines, not
needed for Windows XP</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">route-method
exe</span>

<span
style="font-family: Courier New, Courier, monospace; font-size: x-small;">route-delay
2</span>

  

  
<span class="underline">References</span>:  
  

1.  http://code.google.com/p/tunnelblick/
