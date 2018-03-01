# Home Node

## Table of Contents
- [1) Prerequisites](#prerequistes)
- [2) Installation](#installation)
- [3) Provisioning](#provisioning)
- [4) Credits](#Credits)

## 1) Prerequisites <a name="prerequistes"></a>
1. The Dragonboard must be flashed with a Linux operating system.
Note: This project is only tested with the default Debian image provided by 96boards.
2. With the Dragonboard unpowered, attached the Sensors Mezzanine board 
3. Attach other accessories.
- Display through HDMI
- USB webcam
- IoT board
- wires and kits according to the table below

| Type        | Grove / Output | Arduino Input | GPIOs |
| ----------- |:--------------:|:-------------:|:-----:|
| X Servo     | D7             | 13,12         | L, J |
| Y Servo     | D6             | 11,10         | F, D |
| Servo Reset | NA             | 9             | K    |
| Buzzer      | D5             | 1             | E    |
| Laser       | D4             | 0             | C    |

## 2) Installation <a name="installation"></a>

### 2.1 Auto-Installation
Additional packages and basic configuration can be accomplished through the auto-install script.

Download the install script
```
wget https://https://github.com/96boards-projects/smart-portal/tree/master/home_node/_install/install.sh
```

Make it executable
```
chmod +x install.sh
```

Run it with root privileges.
```
sudo bash ./install.sh
```

Skip to 2.3 Additonal Configuration.

### 2.2 Self Installation
1. Most commands need to executed with root privileges. Update the package list and newer versions of packages.
```
sudo su
apt-get update
apt-get upgrade
```

2. Install additional packages
```
apt get install -y motion mysql-server mysql-client apache2 php7.0 php7.0-mysql
apt get install -y arduino-mk arduino
```

3. Edit motion's configuration file `/etc/default/motion` and `/etc/motion/motion.conf` to your needs. Note: The portal assumes motion stream port is 8081. Attach the webcam and check that motion works.

2. Clone the home_node repository into `/var/www/portal`

3. Execute SQL statements from `/var/www/portal/_install` folder to setup database tables and user.

4. Generate ssl key and cert for encrypted http connection.
```
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout portal.key -out portal.crt
mv portal.key /etc/ssl/private/portal.key
mv portal.crt /etc/ssl/private/portal.crt
```

5. Configure Apache. `/etc/apache2/sites-available/000-default.conf'
```
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
```

6. enable apache modules
```
a2enmod rewrite
a2enmod ssl
```

7. Add these lines to '/etc/rc.local' (above the line exit 0) to give www-data access to GPIOs and start motion on boot
```
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
```

### 2.3 Additional Configuration
Some additional configuration is necessary to access that Dragonboard from the Internet. There are numerous variation and the details are out of scope of this project.
- ddclient for DDNS
- static IP on dragonboard
- router port forwarding / firewall configuration

## 3) Provisioning <a name="provisioning"></a>
- Work In Progress

## Credits
- 96boards for providing the hardware and guidance for this project
- @Repox SimpleUsers php code  https://github.com/Repox/SimpleUsers
- [Tutorialrepublic] (https://www.tutorialrepublic.com/) for php and sql examples 
- Dragonboard 410c Case: https://www.thingiverse.com/thing:1090288

