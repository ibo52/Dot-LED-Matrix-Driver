#ifndef HALO_LED_SERVER
#define HALO_LED_SERVER

#include <Arduino.h>
#include <WiFi.h>
#include "LEDController.hpp"

/*
    struct to manage expected GET parameters from requests
*/
typedef struct __GET_PARAM{
    int8_t ledNum;  //request of the client
    String token;   //for security, we will check if the incming token matches with our's
}_GET_PARAM;

/*
    LedServer class to host a webserver to control led matrix over web.

    Respectively
        1. Initializes the physically connected led matrix board
        2. Initializes a webserver
        3. listens for web requests
*/
class LedServer{

    private:
        int16_t port;
        WiFiServer server;

        boolean tokenUpdate();
        boolean tokenUpdate(boolean ignoreTime);

public:
        LEDMatrix* display;

        String token;

    public:
        LedServer(int numOfLeftReg, int numOfTopReg,
                int left_latchPin, int left_dataPin, int left_clockPin,
                int top_latchPin, int top_dataPin, int top_clockPin
                ,int serverPort);

        ~LedServer();

        void loop();//continuosuly listen for a client connection

        String getToken();
        void setToken(String token);


};

#endif