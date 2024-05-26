#include <Arduino.h>

class Enigma{

    public:

        Enigma();

        static uint32_t gcd(uint32_t a, uint32_t b);

        static String caesarEncrypt(String d, int shift);
        static String caesarDecrypt(String d, int shift);

        static String vigenereEncrypt(String key, String text);
        static String vigenereDecrypt(String key, String text);

        static String generateToken(uint8_t size);
};