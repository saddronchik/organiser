from tkinter import *
import tkinter.messagebox as mb
import socket
import os
import re
import webbrowser
from subprocess import call
import psutil

process_to_kill = "organaizer.exe"

# get PID of the current process
my_pid = os.getpid()

# iterate through all running processes
for p in psutil.process_iter():
    # if it's process we're looking for...
    if p.name() == process_to_kill:
        # and if the process has a different PID than the current process, kill it
        if not p.pid == my_pid:
            p.terminate()

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
    mb.showinfo("Добро пожаловать!", "Для работы с приложением нажмите ОК")
    webbrowser.open('http://'+ip+':8000/organaizer/public', new=2)
    call("websockets.cmd")
  
else:
    mb.showerror("Ошибка", "Не удалось записать IP! Повторите попытку")



