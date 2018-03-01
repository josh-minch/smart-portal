#!/bin/bash

if [ $1 == 'xpos' ]
then
	var=33
elif [ $1 == 'xneg' ]
then
	var=34
elif [ $1 == 'ypos' ]
then 
	var=4
elif [ $1 == 'yneg' ]
then 
	var=69
elif [ $1 == 'reset' ]
then
	var=28
elif [ $1 == 'buzz' ]
then
	var=115
elif [ $1 == 'lase' ]
then
	var=13
fi

echo "1" > /sys/class/gpio/gpio$var/value
sleep 1
echo "0" > /sys/class/gpio/gpio$var/value

exit 0