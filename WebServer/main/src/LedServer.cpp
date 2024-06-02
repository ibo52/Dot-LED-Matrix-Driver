#include "LedServer.hpp"
#include "ArduinoJson.h"
#include "Enigma.hpp"
#include "HTTPResponse.hpp"
#include "HTTPClient.h"
#define WEB_PAGE_ADDR "192.168.1.78"
#define WEB_PAGE_API "admin/api/api_setDriverBoardInfo.php"

LedServer::LedServer(int numOfLeftReg, int numOfTopReg,
                int left_latchPin, int left_dataPin, int left_clockPin,
                int top_latchPin, int top_dataPin, int top_clockPin
                ,int serverPort){

    this->port=serverPort;
    //init webserver
    server=WiFiServer(serverPort);

    token="qw1a";

    //init led display matrix
    display=new LEDMatrix(numOfLeftReg,numOfTopReg,
            left_latchPin,left_dataPin,left_clockPin
            ,top_latchPin,top_dataPin,top_clockPin);

    server.begin();

    //inform database of ip,port, token of this server
    while( this->tokenUpdate()==false ){
      Serial.print("[LedServer]: Could not connected API address for init:");
      Serial.print(WEB_PAGE_ADDR);
      Serial.println(": Will be Retried in 1 sec until success..");
      delay(1000);
    }
}
LedServer::~LedServer(){
    delete this->display;
}

String LedServer::getToken(){
    return this->token;
}

void LedServer::setToken(String token){
  this->token=token;
}


/*
Loop the listening process of server*/
void LedServer::loop(){

  WiFiClient client = server.available();   // listen for incoming clients

  HTTPResponse http=HTTPResponse();
  if (client) {
    //server processes POST requests
    Serial.print("[LED Server]: new request from: ");
    Serial.println(client.remoteIP());

    StaticJsonDocument<768> request=http.getResponse(client);

    //received GET request
    if(request["type"].as<String>()=="GET"){

      HTTPResponse().respond(client, RESPONSE_OK,
                  "<p style=\"font-size:4vw;\"> This Webserver serves for data with <b>POST</b> requests</p>");

    //received POST request
    }else if(request["type"].as<String>()=="POST"){//process post requests


      StaticJsonDocument<256> doc;
      DeserializationError error = deserializeJson(doc, request["data"].as<String>());

      if( error ){
        Serial.print("[LED Server]: Data is not json! --> ");
        Serial.println(request["data"].as<String>());

        http.respond(client, RESPONSE_OK,
          "<p>This server expects POST data as JSON object. Thus request could not processed</p>"
          );

      }else{

        int8_t ledNum=doc["lednum"];
        String token=doc["token"];

        //token control
        if( token.compareTo(this->getToken())!=0){
          http.respond(client, RESPONSE_UNAUTH,
            "<p>You have<b> no authentication</b> to request operations on this server</p>"
          );

              Serial.print("[LED Server]: Client's token :'");
              Serial.print(token);
              Serial.print("' does not match with server's: '");
              Serial.print(this->getToken());
              Serial.println("'");
              Serial.println("[LED Server]: Drop unauthorized client");

        }else{

              // HTTP headers always start with a response code (e.g. HTTP/1.1 200 OK)
              // and a content-type so the client knows what's coming, then a blank line:
              http.respond(client, RESPONSE_OK,
                "<p> Request <i>received</i> <br> LED Server</br><p>");

              if(ledNum>-1 && ( ledNum < this->display->getNumLeds()  ) ){
                //gelen veri numerik ise yanacak ledi sec
                //Sonra LEDController.cpp dosyasından ledi yakacak fonksiyonu çağıracağız
                Serial.print("[Led Matrix]: ");
                Serial.print(ledNum);
                Serial.println("'th LED on the matrix will blink");

                this->display->clear();
                this->display->blinkLed(ledNum);

              }else{
                Serial.print("[Led Matrix]: desired led index #");
                Serial.print(ledNum);
                Serial.print(" exceeds max num of LEDs #");
                Serial.println(this->display->getNumLeds());
              }
        }
      }
    }

    // close the connection:
    client.stop();
    Serial.println("[LED Server]: Client has dropped the connection");
    this->tokenUpdate(false);

  }

}

/*
    update driverboard info by calling PHP API of web page
*/
boolean LedServer::tokenUpdate(boolean ignoreTime){
  boolean retval=0;

  static unsigned long lastUpdateTime=millis();
  if( !ignoreTime ){
    if(  !( (millis()- lastUpdateTime)> (300 * 1000) ) ){//300 saniyede bir token güncelle
      return retval;
    }
  }

  WiFiClient driverBoard_api_client;

  String token=Enigma().generateToken(8);

  //inform web page for esp32 ip, port, and token to be able to communicate
  if( driverBoard_api_client.connect(WEB_PAGE_ADDR, 80) ){
    HTTPResponse http=HTTPResponse();

    StaticJsonDocument<320> j;
    j["ip"]=WiFi.localIP().toString();
    j["boardId"]=1;
    j["auth"]="qw1a";
    j["port"]=String(this->port);
    j["token"]=token;

    String jsonStr;
    serializeJson(j, jsonStr);

    http.POST2(driverBoard_api_client, WEB_PAGE_API, jsonStr, false);

    int8_t apiResponse=http.getResponse(driverBoard_api_client, false).toInt();

    switch (apiResponse){
    case 1:
      Serial.println("[LedServer]: Token succesfully sended to WEB API");
      this->setToken(token);
      lastUpdateTime=millis();
      retval=1;
      break;

    case -8:
      Serial.print("[LedServer]: API: database get the request but not processed. Possibly authentication or response read issues:");
      retval=0;
      break;

    default:
      Serial.print("[LedServer]: API: Unknown retval from API:");
      Serial.println(apiResponse);
      retval=0;
      break;
    }

  }else{
    Serial.println("[Led Server]: Could not connect to web API to update token!");
    return retval;
  }

  return retval;
}

boolean LedServer::tokenUpdate(){
  return this->tokenUpdate(true);//ignore time
}