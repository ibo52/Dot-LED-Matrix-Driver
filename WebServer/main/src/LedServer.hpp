#ifndef HALO_LED_SERVER
#define HALO_LED_SERVER

#include <Arduino.h>
#include <WiFi.h>
#include "LEDController.hpp"

class LedServer{

    private:
        int port;
        WiFiServer server;

        LEDMatrix* display;

    public:
        LedServer(int numOfLeftReg, int numOfTopReg,
                int left_latchPin, int left_dataPin, int left_clockPin,
                int top_latchPin, int top_dataPin, int top_clockPin
                ,int serverPort);
                
        ~LedServer();

        void loop();//continuosuly listen for a client connection

        int16_t toNumeric(String string);


};

#endif