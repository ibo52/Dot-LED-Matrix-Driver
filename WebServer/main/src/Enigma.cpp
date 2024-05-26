#include "Enigma.hpp"

Enigma::Enigma(){
}


uint32_t Enigma::gcd(uint32_t a, uint32_t b){
    //find greatest common divisor between two numbers
        while (b!=0){
            int32_t temp=a;
            a=b;
            b=temp%b;
        }
        return a;
}

String Enigma::caesarEncrypt(String d, int shift){
    String ciphered="";
    for(int i=0; i< d.length(); i++){
        ciphered.concat( char(d.charAt(i)+shift) );
    }

    return ciphered;
}

String Enigma::caesarDecrypt(String d, int shift){

    String ciphered="";
    for(int i=0; i< d.length(); i++){
        ciphered.concat( char(d.charAt(i)-shift) );
    }

    return ciphered;
}

String Enigma::vigenereEncrypt(String key, String text){

    String ciphered="";
    for(int i=0; i<text.length(); i++){
        char keyx=key.charAt(i%key.length());

        ciphered+=char((text.charAt(i)+keyx));
    }

    return ciphered;
}

String Enigma::vigenereDecrypt(String key, String text){

    String ciphered="";
    for(int i=0; i<text.length(); i++){
        char keyx=key.charAt(i%key.length());

        ciphered+=char((text.charAt(i)-keyx));
    }

    return ciphered;
}

/*
Generate random string token
*/
String Enigma::generateToken(uint8_t size){

    String c="";
    for(int8_t i=0; i<size; i++){

        uint8_t time=millis();//last numbers of time
        char num=random(33,127);

        bitWrite(num, time>>5, random(0,2));

        while(num>126)
            num--;
        while (num<33)
            num++;

        c.concat(num);
    }
    return c;
}