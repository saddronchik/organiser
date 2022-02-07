from tkinter import *
import tkinter.messagebox as mb
import socket
import os
import re


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

text_for_file ='IP_ADDRESS='+ip
if my_file.write(text_for_file):
    my_file.close()
    mb.showinfo("Информация", "Ваш IP "+ip)
    os.system("php artisan websockets:serve")
else:
    mb.showerror("Ошибка", "Не удалось записать IP! Повторите попытку")

