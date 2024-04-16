#ifndef LED_MATRIX_CONTROLLER
#define LED_MATRIX_CONTROLLER

#include <Arduino.h>

class LEDMatrix{
    byte* TOP_REG;
    byte* LEFT_REG;

    int numLeftReg, left_latchPin, left_dataPin, left_clockPin;
    int numTopReg, top_latchPin, top_dataPin, top_clockPin;

    public:

    LEDMatrix(int numOfLeftReg, int numOfTopReg,
                int left_latchPin, int left_dataPin, int left_clockPin,
                int top_latchPin, int top_dataPin, int top_clockPin
                );

    
    void clear(void);

    void updateDisplay(void);

    void blinkLed(int ledNum);

    void blinkLed(int row, int col);

    private:

    void regWrite(byte* shiftRegister, int registerCount, int dataPin, int clockPin, int latchPin);
};

#endif