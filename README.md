# Dot-LED-Matrix-Driver
## Folder structure
### ESP32 development board
- Contains the Proteus project for a simple custom development board features
  1. ESP32-Wroom-32 microcontroller
  2. RJ45 LAN jak with ENC28J60
  3. USB type B as Power and programming medium
### ESP32 LED Matrix Control driver board
-  Contains the Proteus project for a Custom PCB driver to contol a 16*16 LED Matrix

### WebServer
#### main/
- Basic ESP32 webserver to provide interaction with the LEDs on shelves.
- WebServer can be accessed through web browser using its ip address
#### admin/
- computer web server and pages usig WAMP to manage employees and permissions, and acces LED's over ESP32
# Sample screenshows of web server pages
## login page on a mobile device
![mobile](https://github.com/ibo52/Dot-LED-Matrix-Driver/blob/main/screenshots/mobile.png)

## components search page: search or add new component
![search](https://github.com/ibo52/Dot-LED-Matrix-Driver/blob/main/screenshots/component-search.png)

## employee search and management page: authorize or delete employee permissions
![search2](https://github.com/ibo52/Dot-LED-Matrix-Driver/blob/main/screenshots/manage-employee.png)

## shelf search page: search any item in shelves, and click the button to blink the LED on the shelves
![search3](https://github.com/ibo52/Dot-LED-Matrix-Driver/blob/main/screenshots/shelf-search.png)
