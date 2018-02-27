# Treat Dispenser Module -- Controlling a Servo on the Carbon

## Set up the Zephyr development environment

Follow the getting started guide at http://docs.zephyrproject.org/getting_started/getting_started.html

## Build

To build an application, navigate to the root of the application folder then

```
mkdir build && cd build
cmake -GNinja -DBOARD=96b_carbon ..
ninja
```

## Flash

Install dfu-util

```
sudo apt-get install dfu-util
```

Put the Carbon in bootloader mode by holding the BOOT button, pressing and releasing the RST button, then releasing the BOOT button. Plug your micro-USB into the micro-USB OTG port

Flash to the board with 
```
ninja flash
```

## Work in progress

Implementing predefined servo movements 

## Referenced guides

For more detailed instructions see 

http://docs.zephyrproject.org/getting_started/getting_started.html#building-and-running-an-application
http://docs.zephyrproject.org/boards/arm/96b_carbon/doc/96b_carbon.html

