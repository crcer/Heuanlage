/*
* Simple HTTP get webclient test
*/

#include "DHT.h"
#define DHTPIN 2     // what digital pin we're connected to
#define DHTTYPE DHT22   // DHT 22  (AM2302), AM2321
DHT dht(DHTPIN, DHTTYPE);

#include <ESP8266WiFi.h>
const char* ssid = "RPI";
const char* password = "rpi123rpi123";
const char* host = "10.11.12.1";

void setup() {
Serial.begin(115200);
 delay(100);

 // We start by connecting to a WiFi network

 Serial.println();
 Serial.println();
 
 reconnect();
 pinMode(0, OUTPUT);
 digitalWrite(0, LOW);
 
  dht.begin();
}

int value = 0;
int queryDelay = 300000;


void loop() {
  reconnect();
  
 delay(queryDelay);
 ++value;
Serial.println("");
Serial.println("");
Serial.println("");
Serial.println("=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=");
 Serial.print("Verbinde zu: ");
 Serial.println(host);
 
 // Use WiFiClient class to create TCP connections
 WiFiClient client;
 const int httpPort = 80;
 if (!client.connect(host, httpPort)) {
 Serial.println("Verbindung konnte nicht aufgebaut werden!");
 return;
 }
 
 // We now create a URI for the request
 //String url = "/testwifi/index.html";
 String passwort = "Ci5hnkwV8";
 String tabelle ="one";
 
 float temperatur = dht.readTemperature();
 float feuchtigkeit = dht.readHumidity();

 if (isnan(temperatur) || isnan(feuchtigkeit)) {
    Serial.println("Konnte nicht vom DTH-Sensor lesen!");
    return;
  }
 
 String url = "/index.php?tabelle="+tabelle+"&temperatur="+temperatur+"&feuchtigkeit="+feuchtigkeit+"&pw="+passwort;
 
 Serial.print("Abfrage-URL: ");
 Serial.println(url);
 Serial.println("");
 Serial.println("");
 Serial.println("Parameter für den Web-Request:");
  Serial.println("========================================================");
 Serial.println("Tabelle: "+tabelle);
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
  
 // Read all the lines of the reply from server and print them to Serial
 while(client.available()){
 String line = client.readStringUntil('\r');
 Serial.print(line);
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

}

void reconnect()
{
  if  (WiFi.status() !=WL_CONNECTED)
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

