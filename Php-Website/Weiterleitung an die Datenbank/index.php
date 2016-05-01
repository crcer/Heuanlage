<?php


if (isset($_GET['tabelle']) && isset($_GET['pw'])&& isset($_GET['temperatur'])&& isset($_GET['feuchtigkeit'])) {

    $tabelle = $_GET['tabelle'];
    $pw=$_GET['pw'];
    $temperatur=$_GET['temperatur'];
    $feuchtigkeit=$_GET['feuchtigkeit'];



    //MYSQL teil
    $mysqlhost="localhost";
    $mysqluser="logger";
    $mysqlpwd=$pw;
    $mysqldb="logger";

    // --- Schreibe Daten in die Datenbank ---
    $connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Konnte die Verbindung zur Datenbank nicht aufbauen! ");
    mysql_select_db($mysqldb, $connection) or die("Konnte die Datenbank nicht auswählen!");
    // Das ist der Quary zu erstellen der Daten in der Datenbank
    $sql_query = "INSERT INTO $tabelle (temperatur, feuchtigkeit) VALUES ($temperatur, $feuchtigkeit);";

    //Führe Quary aus.
    mysql_query($sql_query) or die("Fehler! Eintrag nicht erfolgreich! :(");
    echo "Eintag in die Tabelle $tabelle erfolgreich! :)";

//Query: http://192.168.178.29/index.php?tabelle=one&temperatur=11&feuchtigkeit=11&pw=Ci5hnkwV8
}
else {
  echo "Es müssen alle Werte gesetzt sein!(tabelle, pw, temperatur, feuchtigkeit)";
}
