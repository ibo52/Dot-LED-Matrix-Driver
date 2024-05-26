#include<Arduino.h>


//to find gcd

class RSA{
    public:

    //n,e : public key
    //n,d : private key
    int N,D,E;

    public:

    static int gcd(int a, int h);

    void generate_keys(int p, int q);

    static String encrypt(String data,int16_t n,int16_t e);

    static String decrypt(String data,int16_t n,int16_t d);
};