# Home Node

### Install motion package
```
sudo apt-get install -y motion
```

Edit `/etc/default/motion` and set "start_motion_daemon = yes" to allow motion to run in the background.

Edit `/etc/motion/motion.conf` and set the following:
set "daemon on"
set "width 640"
set "height 480"
set "framerate 10"
set "output_pictures off"
set "ffmpeg_output_movies off"
set "stream_port 8081"
set "webcontrol_port 8080"
set "stream_maxrate 10"
set "stream_localhost off"

Attached the webcam. Start motion.
```
motion
```
On a web brwoser to http://localhost:8081 or http://[ip address]:8081 to check that the setup works.

### Install Lighttpd with PHP 7 and MySQL
(work in progress)
Follow the instructions at the following site to get a web server running
https://www.howtoforge.com/tutorial/installing-lighttpd-with-php7-php-fpm-and-mysql-on-ubuntu-16.04-lts/

### Install web portal
Clone the repository and enter into the directory
```
git clone https://github.com/96boards-projects/smart-portal.git
cd smart-portal
```

Run the mysql script to create tables and data required by the portal.
```
mysql -u root -p <./var/www/html/simpleusers/tables.sql
```

Copy the php files over to the document root of the web server and change the ownership to www-data.
```
sudo cp -r ./var/www/* /var/www/
sudo chmod 554 -r /var/www/html
sudo chown www-data:www-data -r /var/www/html
```

Edit `/etc/lighttpd/lighttpd.conf' set the following:
```
server.document-root	= "/var/www/html"
index-file.names		= ( "login.php", "index.html" )
```

### Work in Progress
- proxy
- openssl
- ddclient
