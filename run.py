import os


os.system('docker build -t php-main .')
os.system('docker run -p 80:80 php-main')