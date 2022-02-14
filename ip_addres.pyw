from tkinter import *
import tkinter.messagebox as mb
import socket
import os
import re
import webbrowser
import subprocess

for line in os.popen('tasklist').readlines():
    if line.startswith('ip_addres.exe'):
        if line.split()[1] != str(os.getpid()):
            os.system(f'taskkill /F /PID {line.split()[1]}')
            break

s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
s.connect(("8.8.8.8", 80))

##print(s.getsockname()[0])

with open('.env') as f:
    lines = f.readlines()

str = 'IP_ADDRESS'
pattern = re.compile(re.escape(str))
with open('.env', 'w') as f:
    for line in lines:
        result = pattern.search(line)
        if result is None:
            f.write(line)


my_file = open('.env', 'a')
ip = s.getsockname()[0]
webbrowser.open('http://'+ip+':8000/Organiser/public', new=2)
text_for_file ='IP_ADDRESS='+ip
if my_file.write(text_for_file):
    my_file.close()
    mb.showinfo("Информация", "Ваш IP "+ip)
    CREATE_NO_WINDOW = 0x08000000
    subprocess.call('php artisan websockets:serve', creationflags=CREATE_NO_WINDOW)
  
else:
    mb.showerror("Ошибка", "Не удалось записать IP! Повторите попытку")



