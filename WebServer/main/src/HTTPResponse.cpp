#include "HTTPResponse.hpp"

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
        client.println(" HTTP/1.1");
        client.print("Host: ");
        client.println(WiFi.localIP());
        client.println("Connection: close");
        client.println();

        begin=true;//set to false; thus it will begin with 'GET /' header on next call for new responses

    }

    return 1;
}

boolean HTTPResponse::POST(WiFiClient client, String forwardLink, String param,  boolean haveParam){
    return 1;
}