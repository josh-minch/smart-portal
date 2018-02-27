# Home Node

### Index
+ [Prerequisites](#prerequistes)
+ [Auto-Installation](#auto-installation)
+ [Installation](#installation)
+ [Links](#links)

### Prerequisites <a name="prerequistes"></a>
The Dragonboard must be flashed with a Linux operating system.
Note: This project is only tested with the default Debian image provided by 96boards.

### Auto-Installation <a name="auto-installation"></a>
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

### Installation <a name="installation"></a>
1. Install motion package. Edit its configuration file `/etc/default/motion` and `/etc/motion/motion.conf`. Note: The portal assumes motion stream port is 8081. Attach the webcam and check that motion works
2. Clone the repository into `/var/www/{folder}`
3. Install MySQL. Execute SQL statements from the `./home_node/_install` folder to setup database tables and user.
4. Install Apache and PHP. Configure Apache.
5. Edit crontab to start motion with root privileges.

### Links <a name="links"></a>
Dragonboard 410c Case .stl file can be found here:
https://www.thingiverse.com/thing:1090288

### Work in Progress
- openssl (to provide encrption)
- ddclient (to provide DDNS)
- sensor (temperature sensor on home_node)
- BLE Mesh (script to obtain data from the BLE mesh network)
