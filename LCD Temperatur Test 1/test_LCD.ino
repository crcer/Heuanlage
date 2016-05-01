#include <Wire.h> 

#include <LiquidCrystal_I2C.h>

#include <dht.h>
#define dataPin 11
dht DHT; 

LiquidCrystal_I2C lcd(0x27, 20, 4);


 

void setup()

{

lcd.begin();

}

 

void loop()

{
 
int readData = DHT.read22(dataPin); // Reads the data from the sensor
  float t = DHT.temperature; // Gets the values of the temperature
  float h = DHT.humidity; // Gets the values of the humidity


lcd.setCursor(0,0); // In der ersten Zeile soll der Text „Messwert:“ angezeigt werden.

lcd.print("Temperatur:");

lcd.setCursor(0,1);  // In der zweiten Zeile soll der Messwert, der vom Feuchtigkeitssensor bestimmt wurde, angezeigt werden.

lcd.print(t);
lcd.print(" *C");

lcd.setCursor(0,2); // In der ersten Zeile soll der Text „Messwert:“ angezeigt werden.

lcd.print("Humidity:");

lcd.setCursor(0,3);  // In der zweiten Zeile soll der Messwert, der vom Feuchtigkeitssensor bestimmt wurde, angezeigt werden.

lcd.print(h);
lcd.print(" %");

delay(3000);
}
