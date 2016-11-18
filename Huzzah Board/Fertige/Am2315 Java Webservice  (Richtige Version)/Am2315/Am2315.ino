#include<Wire.h>

#include <ESP8266WiFi.h>
const char* ssid = "RPI";
const char* password = "rpi123rpi123";
const char* host = "192.168.2.2";

void setup() {
Serial.begin(115200);
 delay(100);

 // We start by connecting to a WiFi network

 Serial.println();
 Serial.println();
 
 reconnect();
 pinMode(0, OUTPUT);
 digitalWrite(0, LOW);

   Wire.pins(4,5);
   Wire.begin();
}

int value = 0;
int queryDelay = 600000; //600000


void loop() {
  reconnect();
  

 ++value;
Serial.println("");
Serial.println("");
Serial.println("");
Serial.println("=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=");
 Serial.print("Verbinde zu: ");
 Serial.println(host);
 
 // Use WiFiClient class to create TCP connections
 WiFiClient client;
 const int httpPort = 8080;
 if (!client.connect(host, httpPort)) {
 Serial.println("Verbindung konnte nicht aufgebaut werden!");
 return;
 }
 
 // We now create a URI for the request
 String passwort = "Ci5hnkwV8";
 String sensor ="roof";//roof, outside
 
 float temperatur = null;
 float feuchtigkeit = null;



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
    arrayHex[i] =  Wire.read();
  }


 temperatur = ((float)(arrayHex[4] & 0x7f)*256+(float)arrayHex[5])/10;
 feuchtigkeit = ((float)arrayHex[2] * 256+(float)arrayHex[3]) / 10;
  
 String url = "/sensor?sensor="+sensor+"&temperatur="+temperatur+"&feuchtigkeit="+feuchtigkeit+"&pw="+passwort;
 
 Serial.print("Abfrage-URL: ");
 Serial.println(url);
 Serial.println("");
 Serial.println("");
 Serial.println("Parameter für den Web-Request:");
  Serial.println("========================================================");
 Serial.println("Sensor: "+sensor);
  Serial.print("Temperatur: ");
  Serial.println(temperatur);
   Serial.print("Feuchtigkeit: ");
   Serial.println(feuchtigkeit);
     Serial.println("========================================================");
      Serial.println("");
 
 // This will send the request to the server
 client.print(String("GET ") + url + " HTTP/1.1\r\n" +
 "Host: " + host + "\r\n" + 
 "Connection: close\r\n\r\n");
 delay(500);

  boolean go = true;//Die Variable, ob er die 10 min delay machen soll
 // Read all the lines of the reply from server and print them to Serial
 while(client.available()){
 String line = client.readStringUntil('\r');
 Serial.print(line);
   if(line.substring(1) == "false")//wenn false zurück kommt, dann gibt es keine Pause, und es wird wiederhohlt
   {
    Serial.println("\n FEHLER! - Es wird sofort neu versucht!");
    go = false;
    break;
   }
 }
 
 digitalWrite(0, LOW);
 delay(500);
 digitalWrite(0,HIGH);
 
 Serial.println();
 Serial.println("Verbindung getrennt");
Serial.println("=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=");
Serial.println("");
Serial.println("");
Serial.println("");

  if(go == true)
  {
    delay(queryDelay);
  }
}

void reconnect()
{
  if  (WiFi.status() != WL_CONNECTED)
  {
              Serial.print("Verbinde zum WLAN: ");
              Serial.println(ssid);
           
              WiFi.begin(ssid, password);
           
                   while (WiFi.status() != WL_CONNECTED) {
                   delay(500);
                   Serial.print(".");
                   }
          
           Serial.println("");
           Serial.println("WiFi connected"); 
           Serial.println("IP address: ");
           Serial.println(WiFi.localIP());
  }
}

