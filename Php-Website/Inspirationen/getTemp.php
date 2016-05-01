<?php
/*
* Gesetze des erstellten Benutzers eintrgen
*
*/
$mysqlhost="localhost";
$mysqluser="";
$mysqlpwd="";
$mysqldb="";

//Hier muss der Sensor Name eingeragen werden !
$temperatureSensorPath = "/sys/bus/w1/devices/28-00043a27ddff/w1_slave";


// --- Lese Daten aus ---
$tempSensorRawData = implode('', file($temperatureSensorPath));
//Unnötige dinge, vor der Temperatur werden verworfen
$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
//Kommastelle wird verschoben
$temperature = sprintf("%2.2f", $tempSensorTemperature / 1000);
$timestamp = time();

// --- Schreibe Daten in die Datenbank ---
$connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Could not connect to DB!");
mysql_select_db($mysqldb, $connection) or die("Could not select DB!");
// Das ist der Quary zu erstellen der Daten in der Datenbank
$sql_query = "INSERT INTO tbl_Wetter VALUES ($timestamp, $temperature);";
//Führe Quary aus.
mysql_query($sql_query);

?>
