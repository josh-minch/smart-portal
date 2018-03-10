import serial, sys

# open serial 
ser = serial.Serial('/dev/ttyUSB0', 115200)

# get data
data = ser.readline()

# convert to decimal
data = int(data, 16)

# convert celsius to fahrenheit
data = 9.0/5.0 * data + 32

# store
data = str(data)
f = open('temp_data', 'w')
f.write(data)

f.close()
ser.close()
