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

# create gpio group and add userspace
groupadd gpio 
usermod -a -G gpio www-data
usermod -a -G gpio linaro

# remove exit 0 from rc.local
sed -i "/exit 0/d " /etc/rc.local

# Inserting command to take place after boot into rc.local

new_boot=$(cat <<EOF
# Export GPIO to userspace
echo "115" > /sys/class/gpio/export
echo "24" > /sys/class/gpio/export
echo "35" > /sys/class/gpio/export
echo "28" > /sys/class/gpio/export
echo "34" > /sys/class/gpio/export
echo "33" > /sys/class/gpio/export

# Set GPIO direction
echo "out" > /sys/class/gpio/gpio115/direction
echo "out" > /sys/class/gpio/gpio24/direction
echo "out" > /sys/class/gpio/gpio35/direction
echo "out" > /sys/class/gpio/gpio28/direction
echo "out" > /sys/class/gpio/gpio34/direction
echo "out" > /sys/class/gpio/gpio33/direction

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
rm -r /var/www/portal/_install





