<?php

$mysqlhost="localhost";
$mysqluser="logger";
$mysqlpwd="Ci5hnkwV8";
$mysqldb="logger";
$tabelle="one";

// --- Schreibe Daten in die Datenbank ---
$connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Konnte die Verbindung zur Datenbank nicht aufbauen! ");
mysql_select_db($mysqldb, $connection) or die("Konnte die Datenbank nicht auswählen!");
// Das ist der Quary zu erstellen der Daten in der Datenbank
$sql_query = "SELECT * FROM $tabelle;";

//Führe Quary aus.
$rows = '';
$result = mysql_query($sql_query) or die("Fehler! Auslesen nicht erfolgreich! :(");
echo "Auslesen aus der Tabelle $tabelle erfolgreich! :)";



$total_rows =  $result->num_rows;

if($result)
{
      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
 ?>
