# Temperature Sensing on the Carbon 

## Setting up the Zephyr development environment

Follow the getting started guide at http://docs.zephyrproject.org/getting_started/getting_started.html

## Build

To build an application, navigate to the root of the application folder then

```
mkdir build && cd build
cmake -GNinja -DBOARD=96b_carbon ..
ninja
```

## Flash

Get Bluetooth functionaly on the Carbon's STM32 chip with the following guide:
https://www.96boards.org/blog/96boards-carbon-self-programming/

To flash to Carbon you must have dfu-util. Get it with `sudo apt-get install dfu-util`. Then put the Carbon in bootloader mode by holding the BOOT button, pressing and releasing the RST button, then releasing the BOOT button.

After building, flash to the board with 
```
ninja flash
```

For more detailed instructions see 

## Referenced guides
http://docs.zephyrproject.org/getting_started/getting_started.html#building-and-running-an-application
http://docs.zephyrproject.org/boards/arm/96b_carbon/doc/96b_carbon.html

