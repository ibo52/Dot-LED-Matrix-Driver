#include "HTTPResponse.hpp"
#include <HTTPClient.h>

boolean HTTPResponse::respond(WiFiClient client, int8_t response, String body){
    client.print("HTTP/1.1 ");

    switch (response){

    case RESPONSE_OK:
        client.println("200 OK");
        break;

    case RESPONSE_UNAUTH:
        client.println("401 Unauthorized");
        break;

    default:
        client.println("200 OK");
    }


    client.println("Access-Control-Allow-Origin: *");
    client.println("Content-type:text/html");
    client.println("Connection: close");

    client.println();
    client.println(" <!DOCTYPE html><html><head><title>ESP32 Led Server</title><body>");
    client.println("<h1 style=\"font-size:7vw;background-color:powderblue;border-bottom:solid 2px;\">LED Server</h1>");
    client.println(body);
    client.println("</body></html>");
    client.println();

    return 1;

}

boolean HTTPResponse::GET(WiFiClient client, String forwardLink, String param,  boolean haveParam){
    //when at init its set to true,
    //if haveParam set to false; it will be true for a new GET request
    static boolean begin=true;

    if( begin ){//GET request start at init, also param start with ? sign
        client.print("GET /");
        client.print(forwardLink);

        client.print("?");
        client.print(param);

        begin=false;

    }else{//field to append next parameters

        //write params to client
        client.print("&");
        client.print(param);
    }

    //if no param after that, send remaininng headers to complete requests
    if( !haveParam ){
        client.println();
        client.println("HTTP/1.1");
        client.print("Host: ");
        client.println(WiFi.localIP().toString());
        client.println("Connection: close");
        client.println();

        begin=true;//set to false; thus it will begin with 'GET /' header on next call for new responses

    }

    return 1;
}

boolean HTTPResponse::POST(WiFiClient client, String forwardLink, String param,  boolean haveParam){

        HTTPClient http;
        WiFiClient c;
        http.begin(c,"http://" +client.remoteIP().toString()+"/"+forwardLink);
        http.addHeader("Content-Type", "application/json");
        int httpResponseCode = http.POST(param);


    return 1;
}

boolean HTTPResponse::POST2(WiFiClient client, String forwardLink, String param, boolean haveParam){

    //when at init its set to true,
    //cuurently POST request params have to be json string

        client.print("POST /");
        client.print(forwardLink);

        client.println(" HTTP/1.1");
        client.print("Host: ");
        client.println(WiFi.localIP().toString());
        client.println("Content-Type: application/json");
        client.print("Content-Length: ");
        client.println(String(param.length()));
        client.println();
        client.print(param);

    return 1;
}

String HTTPResponse::getResponse(WiFiClient client, boolean print){

    String currentLine="";
    int contentLength=0;

    while(client.connected()){

        if( client.available() ){

            char c=client.read();
            if (print)
                Serial.write(c);

            //determine the if line is heeader or data
            if( c=='\n' ){// if the byte is a newline character

                // if the current line is blank, you got two newline characters in a row.
                //only post data remained if POST requests
                if(currentLine.length()==0){

                    //remaining data from there is response as data of html or other
                    break;

                }else{
                    //optional: we may store or process header data at this section

                    if(currentLine.startsWith("Content-Length")){

                        contentLength=currentLine.substring(currentLine.indexOf(":")+1).toInt();
                    }
                    currentLine="";

                }
            }else if(c!='\r'){
                currentLine+=c;
            }
        }
    }

    String response="";
    //get data section
    while(client.connected() && contentLength>0){

        if( client.available() ){

            char c=client.read();
            response+=c;
            contentLength--;

            if (print)
                Serial.write(c);

        }
    }
    if( print )
        Serial.println();

    return response;
}

StaticJsonDocument<768> HTTPResponse::getResponse(WiFiClient client){

    String currentLine="";

    StaticJsonDocument<768> response;

    while(client.connected()){

        if( client.available() ){

            char c=client.read();

            //determine the if line is heeader or data
            if( c=='\n' ){// if the byte is a newline character

                // if the current line is blank, you got two newline characters in a row.
                //only post data remained if POST requests
                if(currentLine.length()==0){

                    //remaining data from there is response as data of html or other
                    break;

                }else{
                    //optional: we may store or process header data at this section

                    if(currentLine.startsWith("POST")){
                        response["type"]="POST";
                    }
                    else if(currentLine.startsWith("GET")){
                        response["type"]="GET";

                    }else if(currentLine.startsWith("Content-Type")){
                        response["Content-Type"]=currentLine.substring(currentLine.indexOf(":")+1);

                    }else if(currentLine.startsWith("Content-Length")){

                        String st=currentLine.substring(currentLine.indexOf(":")+1);
                        st.replace(" ", "");
                        response["Content-Length"]=st.toInt();

                    }
                    currentLine="";

                }
            }else if(c!='\r'){
                currentLine+=c;
            }
        }
    }

    //get data section
     response["data"]="";
    while(client.connected() && response["Content-Length"].as<int>() > 0){

        if( client.available() ){

            char c=client.read();

            response["data"]=response["data"].as<String>()+c;
            response["Content-Length"]=response["Content-Length"].as<int>()-1;

        }
    }

    //json dosyasının boyutu yetersizse eklenen veriler null oluyor!!
    return response;
}

//---begin GET request-----------
/*
    http.GET(driverBoard_api_client, WEB_PAGE_API, "ip="+WiFi.localIP().toString(), true);
    http.GET(driverBoard_api_client, "", "boardId=1", true);
    http.GET(driverBoard_api_client, "", "auth=qw1a", true);
    http.GET(driverBoard_api_client, "", "port="+String(this->port), true);
    http.GET(driverBoard_api_client, "", "token="+token, false);
*/
   //---end GET request-------------
/*
      driverBoard_api_client.print("GET /");
      driverBoard_api_client.print(WEB_PAGE_API);
      driverBoard_api_client.print("?ip=");
      driverBoard_api_client.print(WiFi.localIP());
      driverBoard_api_client.print("&boardId=1");
      driverBoard_api_client.print("&auth=qw1a");//database side password
      driverBoard_api_client.print("&port=");
      driverBoard_api_client.print(this->port);
      driverBoard_api_client.print("&token=");
      driverBoard_api_client.print(token);
      driverBoard_api_client.println();
      driverBoard_api_client.println("HTTP/1.1");
      driverBoard_api_client.print("Host: ");
      driverBoard_api_client.println(WiFi.localIP());
      driverBoard_api_client.println("Connection: close");
      driverBoard_api_client.println();
*/