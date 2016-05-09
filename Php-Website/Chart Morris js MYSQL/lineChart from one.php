<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>LineChart</title>

    1 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
2 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
3 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
4 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


  <?php
  //error_reporting(E_ALL);
  //ini_set('display_errors', '1');

  $mysqlhost="localhost";
  $mysqluser="logger";
  $mysqlpwd="Ci5hnkwV8";
  $mysqldb="logger";
  $tabelle="one";

  // --- Schreibe Daten in die Datenbank ---
  $connection=mysqli_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Konnte die Verbindung zur Datenbank nicht aufbauen! ");
  mysqli_select_db($connection, $mysqldb) or die("Konnte die Datenbank nicht auswählen!");
  // Das ist der Quary zu erstellen der Daten in der Datenbank
  $sql_query = "SELECT * FROM `$tabelle` ORDER BY `datum` ASC";

  //Führe Quary aus.
  $rows = array();
  $result = mysqli_query($connection,$sql_query) or die("Fehler! Auslesen nicht erfolgreich! :(");
  echo "Auslesen aus der Tabelle $tabelle erfolgreich! :)";


  $total_rows =  $result->num_rows;

  if($result)
  {

    while ($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
  }

   ?>





  </head>




  <body>

<div id="morris-line-chart"></div>

<script>

new  Morris.Line({

    // ID of the element in which to draw the chart.
    element: 'morris-line-chart',

    // Chart data records -- each entry in this array corresponds to a point
    // on the chart.
    data: <?php echo json_encode($rows);?>,


    // The name of the data record attribute that contains x-values.
    xkey: 'datum',

    // A list of names of data record attributes that contain y-values.
    ykeys: ['temperatur', 'feuchtigkeit'],

    // Labels for the ykeys -- will be displayed when you hover over the
    // chart.
    labels: ['Temperatur','Feuchtigkeit'],

    lineColors: ['#0b62a4', '#ff7706'],
    xLabels: 'hour',

    // Disables line smoothing
    smooth: true,
    resize: true,
    parseTime: false //bug in Firefox http://stackoverflow.com/questions/23061821/script-isnt-answering-any-more-error-using-morris-js-in-firefox
});
</script>



  </body>
</html>
