# Expansion Modules: BLE Mesh 

## Table of Contents
- [1) Prerequisites](#prerequistes)
- [2) Installation](#installation)
   - [2.1) Prepare the Carbons](#prepare)
   - [2.2) Flash Prebuilt Application](#flash)
   - [2.3) Build from Source](#build)
- [3) Provisioning and Configure](#provisioning)
   - [3.1) Installing Bluez](#bluez)
   - [3.2) Server Node](#server)
   - [3.3) Client Node](#client)

## 1) Prerequisites <a name="prerequistes"></a>
1. Set up the Zephyr development environment on Linux by following the getting started guide [here](http://docs.zephyrproject.org/getting_started/getting_started.html).
2. Enable Bluetooth functionality on both Carbons by self-programming their nRF51 coprocessors with the **hci_spi** firmware found in Zephyr's sample applications. To do so follow the self-programming guide [here](https://www.96boards.org/blog/96boards-carbon-self-programming/).

## 2) Installation <a name="installation"></a>

### 2.1) Preparing the Carbons <a name="prepare"></a>
To flash an application to the Carbon, connect it to your host Linux machine via USB to micro-USB, plugging the micro-USB end into the Carbon's OTG port. Put the Carbon in bootloader mode by holding the BOOT button, pressing and releasing the RST button, then releasing the BOOT button. To check that it's in bootloader mode, get dfu-util
```
sudo apt-get install dfu-util
```
then check the Carbon's status with
```
dfu-util -l
```
This should display that it found 4 DFU devices.
### 2.2) Flash Prebuilt Application <a name="flash"></a>
Prebuilt applications ready to be flashed are already provided.

To flash the server node, navigate to its install directory
```
cd smart-portal/expansion_module/ble_mesh_srv/install
```
then flash the board you will be using as the server
```
ninja flash
```
To flash the client node, navigate to its install directory
```
cd smart-portal/expansion_module/ble_mesh_cli/install
```
then flash the board you will be using as the client
```
ninja flash
```
To ensure each board has been successfully programed, plug the micro-USB into the UART port and listen to its serial output. You can do so with `minicom`
```
sudo apt-get install minicom
sudo minicom -D /dev/ttyUSB0
```
Reset the board. It should say that Bluetooth has been initialized. 

### 2.3) Build from Source <a name="build"></a>
Alternatively, you can build each application from source. 
First, open a terminal and
```
cd ~/zephyr
source zephyr-env.sh
```
To build the server node, navigate to `ble_mesh_srv`, make a build directory, and build
```shell
cd ~/smart-portal/expansion_module/ble_mesh_srv
mkdir build && cd build
cmake -GNinja -DBOARD=96b_carbon ..
ninja
```
as before, flash with
```
ninja flash
```

To build the client node, navigate to `ble_mesh_cli`, make a build directory, and build
```
cd ~/smart-portal/expansion_module/ble_mesh_cli
mkdir build && cd build
cmake -GNinja -DBOARD=96b_carbon ..
ninja
```
as before, flash with
```
ninja flash
```
## 3) Provisioning and Configuring <a name="provisioning"></a>
### 3.1) Installing Bluez <a name="bluez"></a>
Get Bluez and required packages
```
sudo apt-get install automake libtool libglib2.0-dev libudev-dev libdbus-1-dev libjson-c-dev libical-dev libreadline-dev
git clone https://git.kernel.org/pub/scm/bluetooth/bluez.git
cd bluez
```
Then install Bluez for BLE mesh
```
./bootstrap
./configure --prefix=/usr --mandir=/usr/share/man --sysconfdir=/etc --localstatedir=/var --enable-mesh
make
sudo make install
```
### 3.2) Server Node <a name="server"></a>
Plug your micro-USB into the UART port and look at serial output
```
sudo minicom -D /dev/ttyUSB0
```
In a second terminal provision the board with `meshctl`'s command line interface
```
cd bluez/mesh
meshctl
```
In meshctl:
```
discover-unprovisioned on
provision dddd
```
Enter the 4 digit OOB number displayed by the server node. Then,
```
menu config
target 0100
```
where **0100** is the node address assigned to the server node. Modify this to reflect the address your server is assigned. 
Finally, configure the device with
```
appkey-add 1
bind 0 1 1100
sub-add 0100 c000 1100
pub-set 0100 c000 1 0 0 1100
```
again, modifying the address **0100** to reflect your own address.

### 3.3) Client Node <a name="client"></a>
Plug your micro-USB into the UART port and look at serial output
```
sudo minicom -D /dev/ttyUSB1
```
In a second terminal provision the board in meshctl's command line interface
```
cd bluez/mesh
meshctl
```
In meshctl:
```
discover-unprovisioned on
provision dddd
```
Enter the 4 digit OOB number displayed by the client node. Then,
```
menu config
target 0101
```
where **0102** is the node address assigned to the server node. Modify this to reflect the address your server is assigned. 
Finally, configure the device with
```
appkey-add 1
bind 0 1 1102
sub-add 0101 c000 1102
pub-set 0101 c000 1 0 0 1102
```
again, modifying the address **0102** to reflect your own address.
