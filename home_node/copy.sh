#!/usr/bin/env bash

sudo apt-get update
sudo apt-get -y update

sudo apt-get install motion

sed 's/ no"/ yes"/g' /etc/default/motion

sudo apt-get install -y mysql-server mysql-client 

sudo apt-get install -y php7.0 php7.0-fpm php7.0-mysql php7.0-cgi

sudo apt-get install -y lighttpd

sudo apt-get install -y 


sudo chmod 554 -r ./var/www/html
sudo chown www-data:www-data -r ./var/www/html
sudo cp -r ./var/www/* /var/www/*

sudo chmod 644  -r /etc
sudo chown root:root -r /etc/



