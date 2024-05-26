#include "RSA.hpp"

//to find gcd

int RSA::gcd(int a, int h){

        int temp;
        while(1){
            temp = a%h;

            if(temp==0)
                return h;

            a = h;
            h = temp;
        }
}

void RSA::generate_keys(int p, int q){
        int n=p*q;
        int z=(p-1)*(q-1);

        //public key

        //e stands for encrypt
        int e=2;

        while(e<z){//condition 1<e<z && gcd(e,z)==1 (they have to be coprime)

            if(this->gcd(e,z)==1)
                break;

            e++;
        }

        double d=(1+ 2*z)/e;

        this->N=n;
        this->E=e;
        this->D=d;
    }

String RSA::encrypt(String data,int16_t n,int16_t e){

        String ciphered="";

        int16_t i;
        for (i = 0; i < data.length(); i++/*2*/ ){

            char result=pow(data[i], e);
            result%= n;

            ciphered+="\\0x"+String(result,HEX);
        }

        return ciphered;

}
String RSA::decrypt(String data, int16_t n, int16_t d){
    String deciphered="";
    int i;
    int idx=data.lastIndexOf("\\0x");

    while(idx>-1){

        int16_t hexData=strtoll(data.substring(idx+3, data.length()).c_str(), NULL, 16 );

        hexData=pow(hexData, d);
        hexData %= n;

        String temp="";
        temp+=char((hexData&0xff00)>>8 );
        temp+=char( hexData&0xff );

        deciphered=temp+deciphered;

        data=data.substring(0,idx);

        idx=data.lastIndexOf("\\0x");
    }

    return deciphered;
}