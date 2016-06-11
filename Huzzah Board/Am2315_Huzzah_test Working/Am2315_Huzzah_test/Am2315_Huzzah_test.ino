#include<Wire.h>


void setup() {
  // put your setup code here, to run once:
  Wire.pins(4,5);
  Wire.begin();
  Serial.begin(115200);

}

void loop() {
  // put your main code here, to run repeatedly:

  Wire.beginTransmission(0x5c);
  delay(2);
  Wire.endTransmission();

  Wire.beginTransmission(0x5c);
  
  Wire.write(0x03);
  Wire.write(0x00);
  Wire.write(4);

  Wire.endTransmission();


  delay(10);
  


  Wire.requestFrom(0x5c, 8);


  int arrayHex[8];

  for(int i = 0; i < 8; i++)
  {
    arrayHex[i] = Wire.read();
    Serial.println(arrayHex[i]);
  }


  Serial.println(((arrayHex[4] & 0x7f)*256+arrayHex[5])/10);
  Serial.println((arrayHex[2] * 256+arrayHex[3]) / 10);
  Serial.println("==================================");



  delay(3000);


  

}
