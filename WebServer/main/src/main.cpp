#include "LedServer.hpp"
#include "LEDController.hpp"
#include "Enigma.hpp"
#include "RSA.hpp"

#define LED_SERVER_PORT 80

//DISPLAY MATRIX PROPERTIES
//shift reg pin 12(ST_CP)
#define TOP_PIN_LATCH 4
//shift reg pin 11(SH_CP)
#define TOP_PIN_CLOCK 5
//shift reg pin 14(DS)
#define TOP_PIN_DATA 6
#define NUM_OF_TOP_REG 2

#define LEFT_PIN_LATCH 0
#define LEFT_PIN_CLOCK 0
#define LEFT_PIN_DATA 0
#define NUM_OF_LEFT_REG 1

char ssid[] = "Mut Home";//"TurkTelekom_TPE352_2.4GHz";//"fatoşmodaevi";//"ORYAZ";// //ag adi
char pass[] = "10610933452ysm";//"hV9gm3U9FJx3";//"hoopdedikdur";//"OrWf_1453571!*";// //ad sifresi

LedServer* ledServer;

/*
    Update ESP32 token periodically
    and inform database
*/


void setup(){

    Serial.begin(9600);
    Serial.println("ESP32 LED Server Initializing");

    Serial.print("Connecting to AP: ");
    Serial.print(ssid);
    WiFi.begin(ssid, pass);

    while (WiFi.status() != WL_CONNECTED) {
        Serial.print(".");
        delay(300);
    }

    Serial.print("\nConnected. IP address: ");
    Serial.println(WiFi.localIP());

    ledServer=new LedServer(NUM_OF_LEFT_REG, NUM_OF_TOP_REG,
        LEFT_PIN_LATCH,LEFT_PIN_DATA, LEFT_PIN_CLOCK,
        TOP_PIN_LATCH, TOP_PIN_DATA, TOP_PIN_CLOCK,
        LED_SERVER_PORT);

    /*Serial.begin(9600);
    Serial.println("Şifreleme: metin='deneme'");
    Enigma rsa=Enigma();

    Serial.println("vigenere\n---------------");
    String token=rsa.generateToken(16);
    String c=rsa.vigenereEncrypt(token,"deneme çöğüşIÖÇÜĞ");

    Serial.print("şifreli: ");
    Serial.print(c);
    Serial.println("\ttoken: "+token+"| ");
    Serial.print("çözümle:");
    Serial.println(rsa.vigenereDecrypt(token, c));
    Serial.println("========================");

    while(1)
        delay(1000);*/
}

void loop(){

    ledServer->loop();//continuously listen for any connection

}