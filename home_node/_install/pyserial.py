import serial, sys

# open serial 
ser = serial.Serial('/dev/ttyUSB0', 115200)

# get data
data = ser.readline()
data = data.split(',')[1]

# convert to decimal
data = str(int(data, 16))

# store
f = open('temp_data', 'w')
f.write(data)

f.close()
ser.close()
