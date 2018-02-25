#!/bin/bash

if [ "$1" == "y" ] && [ "$2" == "pos" ]; then 
	var=115
fi
if [ "$1" == "y" ] && [ "$2" == "neg" ]; then 
	var=24
fi
if [ "$1" == "x" ] && [ "$2" == "pos" ]; then 
	var=35
fi
if [ "$1" == "x" ] && [ "$2" == "neg" ]; then 
	var=28
fi
if [ "$1" == "buz" ]; then
	var=34
fi
if [ "$1" == "lase" ]; then
	var=33
fi
	
echo "1" > /sys/class/gpio/gpio$var/value
sleep 1
echo "0" > /sys/class/gpio/gpio$var/value

exit 0