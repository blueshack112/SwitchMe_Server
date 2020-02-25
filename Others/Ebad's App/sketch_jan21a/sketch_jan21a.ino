#include <SoftwareSerial.h> // Arduino IDE <1.6.6
#include "PZEM004T.h"
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <TridentTD_7Segs74HC595.h>

static const uint8_t D0   = 16;
static const uint8_t D1   = 5;
static const uint8_t D2   = 4;
static const uint8_t D3   = 0;
static const uint8_t D4   = 2;
static const uint8_t D5   = 14;
static const uint8_t D6   = 12;
static const uint8_t D7   = 13;
static const uint8_t D8   = 15;
static const uint8_t D9   = 3;
static const uint8_t D10  = 1;

#define SCLK D5
#define RCLK D6
#define DIO D8

TridentTD_7Segs74HC595  my7SEGMENT( SCLK, RCLK, DIO);

  

int unit=17 ;//rupees per kwh
float rupees=0;
float ee=0;

PZEM004T pzem(&Serial);
IPAddress ip(192,168,1,1);

void setup() 
{

pzem.setAddress(ip);
pinMode(pzem.setAddress(ip),INPUT);
pinMode(D7,OUTPUT);
digitalWrite(D7,HIGH);
Serial.begin(57600);
my7SEGMENT.init();
delay(1000);
 


}


void loop() {
  float v = pzem.voltage(ip);
  if (v < 0.0) v = 0.0;
  Serial.print(v);
  Serial.print("V; ");
  my7SEGMENT.setText("UUUU");
  delay(2000);
  my7SEGMENT.setNumber(v,0);
  delay(1000);

  float i = pzem.current(ip);
  if(i >= 0.0)
  { 
  Serial.print(i);
  Serial.print("A; "); 
  my7SEGMENT.setText("AAAA");
  delay(2000);
  my7SEGMENT.setNumber(i,3);
  delay(1000);
  }
  
  float p = pzem.power(ip);
  if(p >= 0.0)
  { 
    Serial.print(p);
    Serial.print("W; ");
    my7SEGMENT.setText("PPPP");
    delay(2000);
    my7SEGMENT.setNumber(p,2);
    delay(1000);
    }
  
  float e = pzem.energy(ip);
  if(e >= 0.0)
  {
    Serial.print(e);
    Serial.print("Wh; ");
    }

  ee=p*1/1000; // kwh
  Serial.print(ee);
  Serial.print("KWh; ");
  my7SEGMENT.setText("EEEE");
  delay(2000);
  my7SEGMENT.setNumber(ee,3);
  delay(1000);
   
   
  rupees=ee*unit;
  Serial.print(rupees);
  Serial.print("RS; ");
  my7SEGMENT.setText("COST");
  delay(2000);
  my7SEGMENT.setNumber(rupees,3);
  delay(1000);

  Serial.println();

  delay(1000);
}
