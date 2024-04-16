#include <WiFi.h>
#define PORT 80

char ssid[] = "ORYAZ";            //ag adi
char pass[] = "OrWf_1453571!*";   //ad sifresi

WiFiServer server(PORT);

void setup() {
  
  Serial.begin(9600);

  // attempt to connect to Wifi network:

  Serial.print("baglaniliyor: ");
  Serial.print(ssid);
  WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300);
  }

  Serial.print("\nbaglandi. IP address: ");
  Serial.println(WiFi.localIP());
  server.begin();                           
}


void loop() {
  WiFiClient client = server.available();   // listen for incoming clients

  if (client) {                             
    Serial.println("yeni baglanti istemi");
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
            client.print("Click <a href=\"/H\">here</a> turn the LED on pin 9 on<br>");
            client.print("Click <a href=\"/L\">here</a> turn the LED on pin 9 off<br>");

            // The HTTP response ends with another blank line:
            client.println();
            // break out of the while loop:
            break;
          } else {    // if you got a newline, then clear currentLine:
            currentLine = "";
          }
        } else if (c != '\r') {  // if you got anything else but a carriage return character,
          currentLine += c;      // add it to the end of the currentLine
        }

        // Check to see if the client request was "GET /H" or "GET /L":
        if (currentLine.endsWith("GET /H")) {
          //digitalWrite(9, HIGH);               // GET /H turns the LED on
          Serial.println("/H secildi");
        }
        if (currentLine.endsWith("GET /L")) {
          //digitalWrite(9, LOW);                // GET /L turns the LED off
          Serial.println("/L secildi");
        }
      }
    }
    // close the connection:
    client.stop();
    Serial.println("client disonnected");
  }
}
