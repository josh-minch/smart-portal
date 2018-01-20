# Home Node


### Install lighttpd
- light weight web server
''''linux
sudo apt-get update
sudo apt-get install lighttpd
''''

The installation should start lighttpd automatically. Test the status of the server through a web browser by inserting the device's ip address. You should see the lighttpd welcome page.
''''
sudo service lighttpd start
''''

The device's ip address can be determined by this code: 
''''linux
ip address show
''''

lighttpd configuration resides in '/etc/lighttpd/lighttpd.conf'.
- mod_cgi
- set server.document-root
- index-file.names
