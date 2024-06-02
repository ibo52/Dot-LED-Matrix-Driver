/* ibrahim mut
*webserver/http server kullanarak esp ile bilgisayar arasında
*eri aktarımı yaparak led matrisini yak
*
*
* LED matrix deneme
*	LEDLER ile LCD panel mantığında görüntü ekranı oluşturur
*	TOP_REG adlı deigsken üst taraftaki shift regleri değiştirmek için. register sayısı kadar byte tutar
*	LEFT_REG adlı degisken sol taraftaki shift regleri değiştirmek için. register sayısı kadar byte tutar
*	------
*	Satranc tahtasi mantigi gibi:
*	    ustten; yakmak istedigimiz ledin bagli oldugu pini 1 yaparız(voltaj girisi)
*	    soldan; yakmak istediğimiz ledin bagli olduğu pini 0 yaparız(toprak)
*
*	NOT: USTTE ve allta bulunan registerlara yenisi eklendiginde NUM_OF_TOP_REG ve NUM_OF_LEFT_REG sayilari guncellenmeli
*/

#include "LEDController.hpp"
#include<Arduino.h>


LEDMatrix::LEDMatrix(int numOfLeftReg, int numOfTopReg,
                int left_latchPin, int left_dataPin, int left_clockPin,
                int top_latchPin, int top_dataPin, int top_clockPin
                ){

   TOP_REG=new byte[numOfTopReg];
   LEFT_REG=new byte[numOfLeftReg];

   this->left_clockPin=left_clockPin;
   this->left_dataPin=left_dataPin;
   this->left_latchPin=left_latchPin;

   this->top_clockPin=top_clockPin;
   this->top_dataPin=top_dataPin;
   this->top_latchPin=top_latchPin;

   this->numLeftReg=numOfLeftReg;
   this->numTopReg=numOfTopReg;

   pinMode(left_latchPin, OUTPUT);
   pinMode(left_clockPin, OUTPUT);
   pinMode(left_dataPin, OUTPUT);

   pinMode(top_latchPin, OUTPUT);
   pinMode(top_clockPin, OUTPUT);
   pinMode(top_dataPin, OUTPUT);

   this->clear();
   this->updateDisplay();
}

/*Tum ledleri sondur ve çıkışları toprakla*/
void LEDMatrix::clear(void){
   //tum voltaj cıkısını toprakla
   for (size_t i = 0; i < this->numLeftReg; i++) {
		LEFT_REG[i] = 0xff;
   }

   //tum voltaj girişini sıfırla
   for (size_t i = 0; i < this->numTopReg; i++) {
	   TOP_REG[i] = 0;
   }

}

/*tek numara girerek matrisin istenilen ogesine erismek icin*/
void LEDMatrix::blinkLed(int num){

    //soldan (soldan sağa) kaçıncı led olacağı
    int satir=num%(numTopReg*8);//8 shift registerin çıkış sayısıdır

    //üstten (soldan sağa) kaçıncı led olacağı
    int sutun=num/(numLeftReg*8);//8 shift registerin çıkış sayısıdır

    this->blinkLed(satir, sutun);
    //NUM_OF_TOP_REG*sutun+satir=num;
}

/*led numaraları 0dan başlamak uzere; istenen ledin satır ve sutun numarası*/
void LEDMatrix::blinkLed(int satir, int sutun){
   //-----------------------------------------
   //satır ve sutunun kaçıncı registere denk geldigini hesaplıyoruz

   int leftReg=sutun/8;
   int topReg=satir/8;

   int leftPin=sutun%8;
   int topPin=satir%8;

   bitWrite(TOP_REG[topReg], topPin,1);//voltaj girisi olan pin
   bitWrite(LEFT_REG[leftReg], leftPin,0);//topraklamaya giden pin

   updateDisplay();
}
/*tablodaki ilgili tum register degerlerini gunceller*/
void LEDMatrix::updateDisplay(void){

   regWrite(TOP_REG, this->numTopReg, this->top_dataPin, this->top_clockPin, this->top_latchPin);
   regWrite(LEFT_REG, this->numLeftReg, this->left_dataPin, this->left_clockPin, this->left_latchPin);
}

/*ilgili registera yazma işlemi yapar*/
void LEDMatrix::regWrite(byte* shiftRegister, int registerCount, int dataPin, int clockPin, int latchPin){
  //writes from first connected REGİSTER and MOST SIGNıficant BIT
	//Determines register, as each register have 8 pins
	//int reg = pinToChange / 8;
	//Determines pin address on led matrix,for actual register
	//int actualPin = pinToChange - (8 * reg);

	//Begin session
	digitalWrite(latchPin, LOW);

	for (int i = registerCount-1; i >=0; i--){


		//Get actual states for register
		byte* states = &shiftRegister[i];

		//Update state
		/*if (i == reg){
			bitWrite(*states, actualPin, state);
		}*/

		//Write
		shiftOut(dataPin, clockPin, MSBFIRST, *states);
	}

	//End session
	digitalWrite(latchPin, HIGH);
}

int16_t LEDMatrix::getNumLeds(void){

   return (this->numLeftReg*8 *this->numTopReg*8);
}