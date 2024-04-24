#include "LedServer.hpp"

#define LED_SERVER_PORT 80

//DISPLAY MATRIX PROPERTIES
#define TOP_PIN_LATCH 0
#define TOP_PIN_CLOCK 0
#define TOP_PIN_DATA 0
#define NUM_OF_TOP_REG 2

#define LEFT_PIN_LATCH 0
#define LEFT_PIN_CLOCK 0
#define LEFT_PIN_DATA 0
#define NUM_OF_LEFT_REG 2


char ssid[] = "ORYAZ";            //ag adi
char pass[] = "OrWf_1453571!*";   //ad sifresi

LedServer* ledServer;

void setup(){
    Serial.begin(9600);
    Serial.println("ESP led Sunucu deneme");

    Serial.print("aga baglaniliyor: ");
    Serial.print(ssid);
    WiFi.begin(ssid, pass);

    while (WiFi.status() != WL_CONNECTED) {
        Serial.print(".");
        delay(300);
    }

    Serial.print("\nbaglandi. IP address: ");
    Serial.println(WiFi.localIP());

    
    ledServer=new LedServer(NUM_OF_LEFT_REG, NUM_OF_TOP_REG,
        LEFT_PIN_LATCH,LEFT_PIN_DATA, LEFT_PIN_CLOCK,
        TOP_PIN_LATCH, TOP_PIN_DATA, TOP_PIN_CLOCK,
        LED_SERVER_PORT);

}

void loop(){

    ledServer->loop();//continuously listen for any connection

}