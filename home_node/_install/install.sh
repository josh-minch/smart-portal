#!/usr/bin/env bash

openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout portal.key -out portal.crt
mv ece191.key /etc/ssl/private/portal.key
mv ece191.crt /etc/ssl/private/portal.crt

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
mv /etc/motion/motion.conf /etc/motion/motion.conf.bak
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
	RewriteEngine on
	RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,QSA,R=permanent]
</VirtualHost>

<VirtualHost *:443>
    DocumentRoot /var/www/portal
    <Directory "/var/www/portal">
        AllowOverride All
        Require all granted
    </Directory>

    SSLEngine on
    SSLOptions +StrictRequire
    SSLCertificateFile /etc/ssl/private/portal.crt
    SSLCertificateKeyFile /etc/ssl/private/portal.key
</VirtualHost>
EOF
)

echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

# enable mod_rewrite
a2enmod rewrite
a2enmod ssl

# install php7.0
apt-get install -y php7.0 php7.0-mysql

# restart apache
service apache2 restart

# change permissions and owner
chmod 750 -r /var/www/portal
chown -R www-data /var/www/portal

# create gpio group and add userspace
groupadd gpio 
usermod -a -G gpio www-data
usermod -a -G gpio linaro

# remove exit 0 from rc.local
sed -i "/exit 0/d " /etc/rc.local

# Inserting command to take place after boot into rc.local

new_boot=$(cat <<EOF
# Export GPIO to userspace
echo "33" > /sys/class/gpio/export
echo "34" > /sys/class/gpio/export
echo "4" > /sys/class/gpio/export
echo "69" > /sys/class/gpio/export
echo "28" > /sys/class/gpio/export
echo "115" > /sys/class/gpio/export
echo "13" > /sys/class/gpio/export

# Set GPIO direction
echo "out" > /sys/class/gpio/gpio33/direction
echo "out" > /sys/class/gpio/gpio34/direction
echo "out" > /sys/class/gpio/gpio4/direction
echo "out" > /sys/class/gpio/gpio69/direction
echo "out" > /sys/class/gpio/gpio28/direction
echo "out" > /sys/class/gpio/gpio115/direction
echo "out" > /sys/class/gpio/gpio13/direction

# Give permissions to group gpio
chown -R root:gpio /sys/class/gpio
chmod -R 770 /sys/class/gpio
chown -R root:gpio /sys/devices/platform/soc/1000000.pinctrl/gpio*
chmod -R 770 /sys/devices/platform/soc/1000000.pinctrl/gpio*

# start motion
motion &
exit 0
EOF
)

echo "${new_boot}" >> /etc/rc.local

# clean up
apt-get clean
rm -r /var/www/portal/_install





