#include <Arduino.h>
#include "WiFi.h"
#include "ArduinoJson.h"
#define RESPONSE_OK 1
#define RESPONSE_UNAUTH 2


/*
GET and POST are not Thread SAFE!!!!
*/
class HTTPResponse{
    public:
        static boolean respond(WiFiClient client, int8_t response, String body);

        static boolean POST(WiFiClient client, String forwardLink, String param,  boolean haveParam);

        static boolean POST2(WiFiClient client, String forwardLink, String param,  boolean haveParam);

        static boolean GET(WiFiClient client, String forwardLink, String param,  boolean haveParam);

        static String getResponse(WiFiClient client, boolean print);

        static StaticJsonDocument<768> getResponse(WiFiClient client);


};