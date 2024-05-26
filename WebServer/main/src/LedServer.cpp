#include "LedServer.hpp"
#include "ArduinoJson.h"
#include "Enigma.hpp"
#include "HTTPResponse.hpp"

#define WEB_PAGE_ADDR "192.168.43.194"
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
      Serial.println("[LedServer]: Could not inform database for init. Will be Retried in 1 sec until success..");
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

void LedServer::loop(){

  WiFiClient client = server.available();   // listen for incoming clients

  if (client) {
    //server processes POST requests
    Serial.print("[LED Server]: new request from: ");
    Serial.println(client.remoteIP());

    String currentLine = "";                // make a String to hold incoming data from the client

    boolean isPostRequest=false;            //shows if it is not GET but POST

    while (client.connected()) {            // loop while the client's connected

      if (client.available()) {             // if there's bytes to read from the client,

        char c = client.read();             // read a byte, then
        Serial.write(c);                    // print it out the serial monitor

        if(c=='\n'){// if the byte is a newline character

          // if the current line is blank, you got two newline characters in a row.
          //only post data remained if POST requests
          if(currentLine.length()==0){

              //server response heere
              if( !isPostRequest ){
                HTTPResponse().respond(client, RESPONSE_OK,
                  "<p style=\"font-size:4vw;\"> send data with <b>POST</b> requests</p>"
                );
                break;

              }else{
                break;
              }
          }else{
            currentLine="";

          }

        }else if(c!='\r'){
          currentLine+=c;
        }

        if(currentLine.endsWith("POST /")){
          isPostRequest=true;
        }



      }
    }
    if(isPostRequest){//process post requests

      int8_t counter=0;
      String data="";

      while(client.connected()){

        if( client.available() ){

          char c=client.read();
          Serial.write(c);

          data+=c;

        }else{
          if( counter<10){//retry to read 10 times, if not drop
            counter++;
            delay(10);
          }else{
            StaticJsonDocument<200> doc;
            DeserializationError error = deserializeJson(doc, data);

            HTTPResponse http=HTTPResponse();
            if( error ){
              Serial.print("[LED Server]: Data is not json! --> ");
              Serial.println(data);

              http.respond(client, RESPONSE_OK,
                "<p>This server expects POST data as JSON object. Request could not processed</p>"
                );break;
            }

            data="";

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

                //this->display->blinkLed(ledNum);

              }else{
                Serial.print("[Led Matrix]: desired led index #");
                Serial.print(ledNum);
                Serial.print(" exceeds max num of LEDs #");
                Serial.println(this->display->getNumLeds());
              }
            }

            Serial.println();
            break;
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


      driverBoard_api_client.print("GET /");
      driverBoard_api_client.print(WEB_PAGE_API);
      driverBoard_api_client.print("?ip=");
      driverBoard_api_client.print(WiFi.localIP());
      driverBoard_api_client.print("&boardId=1");
      driverBoard_api_client.print("&auth=qw1a");//database side password
      driverBoard_api_client.print("&port=");
      driverBoard_api_client.print(this->port);
      driverBoard_api_client.print("&token=");
      driverBoard_api_client.println(token);
      driverBoard_api_client.println(" HTTP/1.1");
      driverBoard_api_client.print("Host: ");
      driverBoard_api_client.println(WiFi.localIP());
      driverBoard_api_client.println("Connection: close");
      driverBoard_api_client.println();

    }else{
        Serial.println("[Led Server]: Could not connect to web API to update token!");
        return retval;
    }

    while(1){
        if(driverBoard_api_client.available()){
            char response = driverBoard_api_client.read();

            if(response=='1'){
                Serial.println("[LedServer]: Token succesfully sended to WEB API");
                this->setToken(token);
                lastUpdateTime=millis();
                retval=1;
                break;

            }else if(response='0'){
                Serial.println("[LedServer]: API: database get the request but not processed. Possibly authentication issues");
                retval=0;
                break;
            }
        }
    }
    driverBoard_api_client.stop();
    return retval;
}

boolean LedServer::tokenUpdate(){
  return this->tokenUpdate(true);//ignore time
}