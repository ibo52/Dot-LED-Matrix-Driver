#include "LedServer.hpp"

LedServer::LedServer(int numOfLeftReg, int numOfTopReg,
                int left_latchPin, int left_dataPin, int left_clockPin,
                int top_latchPin, int top_dataPin, int top_clockPin
                ,int serverPort){

    //init webserver
    server=WiFiServer(serverPort);

    //init led display matrix
    display=new LEDMatrix(numOfLeftReg,numOfTopReg,
            left_latchPin,left_dataPin,left_clockPin
            ,top_latchPin,top_dataPin,top_clockPin);

    server.begin();  
}
LedServer::~LedServer(){
    delete this->display;
}

void LedServer::loop(){

  WiFiClient client = server.available();   // listen for incoming clients

  if (client) {

    Serial.print("[LED Server]: yeni baglanti istemi: ");
    Serial.println(client.remoteIP());

    String currentLine = "";                // make a String to hold incoming data from the client

    while (client.connected()) {            // loop while the client's connected

      if (client.available()) {             // if there's bytes to read from the client,

        char c = client.read();             // read a byte, then
        Serial.write(c);                    // print it out the serial monitor

        if (c == '\n') {                    // if the byte is a newline character

          // if the current line is blank, you got two newline characters in a row.
          // that's the end of the client HTTP request, so send a response:
          if (currentLine.length() == 0) {
            // HTTP headers always start with a response code (e.g. HTTP/1.1 200 OK)
            // and a content-type so the client knows what's coming, then a blank line:
            client.println("HTTP/1.1 200 OK");
            client.println("Content-type:text/html");
            client.println();

            // the content of the HTTP response follows the header:
            client.print("<p> To send data to device: type, for example: http://this-device-address/NUMERIC_DATA<p>");

            // The HTTP response ends with another blank line:
            client.println();

            // break out of the while loop:
            break;
          } else {
          /*if you got a newline,check if request contains data,
          then clear currentLine for new clients*/
            
            int idx=currentLine.indexOf("GET /");
            if(idx>-1){
              idx+=5;//"GET /" have 5 chars, thus increment by 5 to skip that chars

              String data=currentLine.substring(idx , currentLine.length() );
              
              data=data.substring(0, data.indexOf(" "));

              if(  !data.equals("") ){//anasayfaya değil de parametre gönderdiyse
              
                Serial.print("[LED Server]: ayrıştırılan \"GET\" data:");
                Serial.println(data);
                
                int16_t ledNum=this->toNumeric(data);

                if(ledNum>-1 && (  ledNum < this->display->getNumLeds()  ) ){
                //gelen veri numerik ise yanacak ledi sec

                //Sonra LEDController.cpp dosyasından ledi yakacak fonksiyonu çağıracağız
                
                Serial.print("[Led Server]: matristeki ");
                Serial.print(ledNum);
                Serial.print(". led yakılacak");

                //this->display->blinkLed(ledNum);
                
                }//else: numerik degil, 0dan kucuk, led sayısından buyuk

              }

            }
            currentLine = "";
          }
        } else if (c != '\r') {  // if you got anything else but a carriage return character,
          currentLine += c;      // add it to the end of the currentLine
        }
      }
    }
    // close the connection:
    client.stop();
    Serial.println("[LED Server]: istemci baglantiyi kesti");
  }
}

//return integer if string does not contains anything but digits( except signs -+ at begin)
int16_t LedServer::toNumeric(String string){
  
  byte check=string.charAt(0);
  unsigned int i=0;

  if(  check=='+' || check=='-' ){
    i++;
  }

  for ( ; i <string.length(); i++){

    check=string.charAt(i);

    //numerik deger degilse -1 gönder
    if(  check<'0'  || check>'9' ){
      Serial.print(i);
      Serial.print(". index 0-9 degil:");
      Serial.println(string);
      return -1;
    }
  }

  return (int16_t)string.toInt();
}