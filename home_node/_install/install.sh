#!/usr/bin/env bash

mkdir /var/www/
mkdir /var/www/portal

# update system
apt-get update
apt-get upgrade -y

sudo git clone https://github.com/96boards-projects/smart-portal/tree/master/home_node /var/www/portal

# install motion
apt-get install motion

# edit /etc/default/motion to switch daemon to on
sed -i 's =no =yes ' /etc/default/motion

# backup and copy configuration file
cp /var/www/portal/_install/motion.conf /var/www/portal/_install/motion.conf.bak
chmod 744 /var/www/portal/_install/motion.conf 
cp /var/www/portal/install/_motion.conf /etc/motion/motion.conf

# install mysql
apt-get install -y mysql-server mysql-client 

# setup database and user
mysql -r root < /var/www/portal/_install/tables.sql

# install apache2
apt-get install -y apache2

# setup hosts file
VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot "/var/www/html/portal"
    <Directory "/var/www/html/portal">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)

echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

# enable mod_rewrite
sudo a2enmod rewrite

# install php7.0
apt-get install -y php7.0 php7.0-mysql

# restart apache
service apache2 restart

# change permissions and owner
chmod 750 -r ./var/www/portal
chown -R www-data -r ./var/www/portal

# clean up
rm -r /var/www/portal/_install

# to include crontab to start motion @reboot



