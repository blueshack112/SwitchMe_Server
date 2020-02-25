#include <SoftwareSerial.h> // Arduino IDE <1.6.6
#include "PZEM004T.h"
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

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

// Hassan's house WiFi
const char *ssid =  "643 Ground";
const char *pass =  "643block13";

// Ebad's WiFi
//const char *ssid =  "Ebads Wifi";
//const char *pass =  "khanfamily4";


// Change IP here!!! Set it to Macbook's IP Address
String URL = "http://192.168.18.4/SwitchMe/";
// Change ID here
int MY_ID = 1;


String ADDRESS = URL + "update.php"; 
String getStateAddress = URL +  "checkSwitch.php";
String getScheduleAddress = URL + "getSchedule.php";
String removeScheduleAddress = URL + "scheduleExecuted.php";
String getTimeInMillisAddress = URL + "getTimeInMillis.php";
long minuteTimer = 0;
float minuteEnergy = 0;
float minuteCost = 0;
int unit=17 ;//rupees per kwh
float rupees=0;
float ee=0;
bool scheduleSet;
long scheduleTime;
const long utcOffsetTimezone = 18000000;


WiFiClient client;
PZEM004T pzem(&Serial);
IPAddress ip(192,168,1,1);
int relayInput = 13;
bool isOn = true;

void setup() {
  pzem.setAddress(ip);
  pinMode(pzem.setAddress(ip),INPUT);
  pinMode(relayInput,OUTPUT);
  digitalWrite(relayInput,HIGH);
  Serial.begin(9600);
  delay(500);
  Serial.print("trying...");
  WiFi.begin(ssid, pass); 
  while (WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.print("Connected");

  delay(1000);
  minuteTimer = micros() + 60000; // 60 seconds in one minute multiplied by 1000 microseconds per second
  minuteCost = 0;
  minuteEnergy = 0;
  scheduleSet = false;
}

void loop() {
  // Checking for state
  HTTPClient http1; 
  http1.begin(getStateAddress); 
  http1.addHeader("Content-Type", "application/x-www-form-urlencoded"); 
  String postData = "id="  + String(MY_ID);
  Serial.println();
  auto http1Code = http1.POST(postData); 
  String payload1 = http1.getString(); 
  http1.end(); //Close connection
  if (payload1 == "OFF"){
    isOn = false;
    digitalWrite(relayInput, HIGH);
    delay (1000);
  } else {
    isOn = true;
    digitalWrite(relayInput, LOW);
  }
  Serial.println("Checked state from server...");
  // Checking for state end
  
  // Check for schedule
  HTTPClient http2; 
  http2.begin(getScheduleAddress); 
  http2.addHeader("Content-Type", "application/x-www-form-urlencoded"); 
  String post1Data = "id=" + String(MY_ID);
  auto http2Code = http2.POST(postData); 
  String payload2 = http2.getString();
  http2.end(); //Close connection
  
  if (payload2 == "yes") {
    if (!isOn) {
        isOn = true;
        digitalWrite(relayInput, HIGH);
        Serial.println("Started relay based on Schedule...");
      }
      // Check for schedule
      HTTPClient http3; 
      http3.begin(removeScheduleAddress); 
      http3.addHeader("Content-Type", "application/x-www-form-urlencoded"); 
      String post3Data = "id=" + String(MY_ID);
      auto http3Code = http3.POST(postData); 
      String payload3 = http3.getString(); 
      long startTime = long(payload3.toInt());
      http3.end(); //Close connection
  }
  Serial.println("Schedule Checked...");
  // End check for schedule
  
  // Main Logic
  if (isOn) {  
  float v = pzem.voltage(ip);
  if (v < 0.0) v = 0.0;
  Serial.print(v);
  Serial.print("V; ");
  delay(200);

  float i = pzem.current(ip);
  if(i >= 0.0)
  { 
  Serial.print(i);
  Serial.print("A; "); 
  delay(200);
  }
  
  float p = pzem.power(ip);
  if(p >= 0.0)
  { 
    Serial.print(p);
    Serial.print("W; ");
    delay(200);
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
  delay(200);   
   
  rupees=ee*unit;
  Serial.print(rupees);
  Serial.print("RS; ");
  delay(200);

  // Sending data
  HTTPClient http; 
  
  http.begin(ADDRESS); 
  http.addHeader("Content-Type", "application/x-www-form-urlencoded"); 
  postData = "volts=" + String(v);
  postData += "&amps=" + String(i);
  postData += "&power=" + String(e);
  postData += "&energy=" + String(ee);
  postData += "&cost=" + String(rupees);
  postData += "&id=" + String(MY_ID);
  Serial.println();
  
  auto httpCode = http.POST(postData); 
  String payload = http.getString(); 
  http.end(); //Close connection
  Serial.println("Sent Readings to Server.");
  // Sent Data
  }
}
