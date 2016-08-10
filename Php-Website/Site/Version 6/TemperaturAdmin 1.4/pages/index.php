<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TemperaturAdmin 1.4</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--> 

<style>

    h1{
    font-weight: bold;
    color: #6F777D;
    }


</style>






<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    
    
$time = new DateTime();

$mysqlhost="localhost";
$mysqluser="logger";
$mysqlpwd="Ci5hnkwV8";
$mysqldb="logger";

$connection = mysqli_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Konnte die Verbindung zur Datenbank nicht aufbauen! ");
mysqli_select_db($connection, $mysqldb) or die("Konnte die Datenbank nicht auswählen!");


$sql_query = "SELECT * FROM data WHERE sensor='roof' ORDER BY datum DESC LIMIT 1";
//Führe Quary aus.
$roofResult = mysqli_query($connection,$sql_query) or die("Fehler! Auslesen nicht erfolgreich! :(");





$roofTemp;
$roofHum;
$roofDate;
while ($row = $roofResult->fetch_assoc())
{

    $roofTemp = $row["temperatur"];
    $roofHum = $row["feuchtigkeit"];
    $roofDate = $row["datum"];

    //working
    /*
    $date_expire = '2014-08-06 00:00:00';    
    $date = new DateTime($date_expire);
    $now = new DateTime();
    echo date_diff($now, $date)->format("%d days, %h hours and %i minuts");
    */
    
    //rechnet den Zeitunterschied aus :)
    $lastRoofTime = new DateTime($roofDate);
    $differenzRoof =  date_diff($time, $lastRoofTime);

    //i ist in Minuten
    if ($differenzRoof->i > 15)
    {
        $roofTemp = "--";
        $roofHum = "--";
    }
    else{
        echo $differenzRoof->i;
    }

}

$sql_query = "SELECT * FROM data WHERE sensor='outside' ORDER BY datum DESC LIMIT 1";
//Führe Quary aus.
$outsideResult = mysqli_query($connection,$sql_query) or die("Fehler! Auslesen nicht erfolgreich! :(");

$outsideTemp;
$outsideHum;
$outsideDate;
while ($row = $outsideResult->fetch_assoc())
{

    $outsideTemp = $row["temperatur"];
    $outsideHum = $row["feuchtigkeit"];
    $outsideDate = $row["datum"];
    
    //rechnet den Zeitunterschied aus :)
    $lastOutsideTime = new DateTime($outsideDate);
    $differenzOutside =  date_diff($time, $lastOutsideTime);

    
    if ($differenzOutside->i > 15)
    {
        $outsideTemp = "--";
        $outsideHum = "--";
    }
    else{
        echo $differenzOutside->i;
        echo $differenzOutside->i;
    }

}




$differenz = $roofTemp - $outsideTemp;
$differenz = round($differenz, 1);
$differenzVorzeichen = "";
$farbCode;

if ($differenz > 0) {
  $differenzVorzeichen = "+";
  $farbCode = "#5CB85C";
}
elseif ($differenz == 0) {
  $farbCode = "#F0AD4E";
}
else {
  $farbCode = "#D9534F";
}









$mysqlhost="localhost";
$mysqluser="logger";
$mysqlpwd="Ci5hnkwV8";
$mysqldb="logger";

$connection=mysqli_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Konnte die Verbindung zur Datenbank nicht aufbauen! ");
mysqli_select_db($connection, $mysqldb) or die("Konnte die Datenbank nicht auswählen!");
// Das ist der Quary zu erstellen der Daten in der Datenbank
$sql_query = "SELECT * FROM data WHERE sensor='roof' ORDER BY datum DESC LIMIT 144";//144

//Führe Quary aus.
$rowsRoof = array();
$result = mysqli_query($connection,$sql_query) or die("Fehler! Auslesen nicht erfolgreich! :(");


$total_rows =  $result->num_rows;
if($result)
{

  while ($rowRoof = $result->fetch_assoc()) {
    $rowsRoof[] = $rowRoof;
  }
}


$sql_query = "SELECT * FROM data WHERE sensor='outside' ORDER BY datum DESC LIMIT 144";//144
$rowsOutside = array();
$result = mysqli_query($connection,$sql_query) or die("Fehler! Auslesen nicht erfolgreich! :(");


$total_rows =  $result->num_rows;
if($result)
{

    while ($rowOutside = $result->fetch_assoc()) {
        $rowsOutside[] = $rowOutside;
    }
}

 ?>

 <link rel="stylesheet" href="../morris/morris.css">
 <script src="../morris/jquery.min.js"></script>
 <script src="../morris/raphael-min.js"></script>
 <script src="../morris/morris.min.js"></script>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">TemperaturAdmin 1.4</a>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Heutrocknung</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">



              <div class="col-lg-12 col-md-6">
                  <div class="panel panel-default" style=<?php echo "border-color:" . $farbCode; ?>>
                      <div class="panel-heading" style=<?php echo "background-color:" . $farbCode; ?>> <!-- style=<?php echo "background-color:" . $farbCode; ?> -->
                          <div class="row">

                            <div class="col-xs-3">
                                <i class="fa fa-flag-o fa-5x"></i> <!--https://fortawesome.github.io/Font-Awesome/icons/   ===> Leaf or Sun-o or Fire are good too-->
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo "Differenz: " . $differenzVorzeichen . $differenz . " °C"?></div>
                                <div>Datum</div>
                            </div>
                          </div>
                      </div>
                      <a href="#">
                          <div class="panel-footer" style=<?php echo "color:" . $farbCode; ?>>
                              <span class="pull-left">View Details</span>
                              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                              <div class="clearfix"></div>
                          </div>
                      </a>
                  </div>
              </div>


                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">

                              <div class="col-xs-3">
                                  <i class="fa fa-sun-o fa-5x"></i> <!--https://fortawesome.github.io/Font-Awesome/icons/   ===> Leaf or Sun-o or Fire are good too-->
                              </div>
                              <div class="col-xs-9 text-right">
                                  <div class="huge"><?php echo "Außen: " . $outsideTemp . " °C / " . $outsideHum . " %"; ?></div>
                                  <div><?php echo "Datum: " . $outsideDate; ?></div>
                              </div>


                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>






                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-home fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <div class="huge"><?php echo "Dach: " . $roofTemp . " °C"; ?></div>
                                    <div><?php echo "Datum: " .  $roofDate; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="#"> <!--Hier bei href kommt der Link rein!-->
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>




                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-default" >
                        <div class="panel-heading" style="background-color:#A7B3BC">
                            <div class="row">

                              <div class="col-xs-3">
                                  <i class="fa fa-leaf fa-5x" style="color:#FFFFFF"></i> <!--https://fortawesome.github.io/Font-Awesome/icons/   ===> Leaf or Sun-o or Fire are good too-->
                              </div>
                              <div class="col-xs-9 text-right">
                                  <div class="huge" style="color:#FFFFFF">Box 1: - °C / -%</div>
                                  <div style="color:#FFFFFF">Datum</div>
                              </div>


                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left" style="color:#A7B3BC">View Details</span>
                                <span class="pull-right" style="color:#A7B3BC"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>






                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color:#A7B3BC">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-leaf fa-5x" style="color:#FFFFFF"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" style="color:#FFFFFF">Box 2: - °C / -%</div>
                                    <div style="color:#FFFFFF">Datum</div>
                                </div>
                            </div>
                        </div>
                        <a href="#"> <!--Hier bei href kommt der Link rein!-->
                            <div class="panel-footer">
                                <span class="pull-left" style="color:#A7B3BC">View Details</span>
                                <span class="pull-right" style="color:#A7B3BC"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>


                <div  class="col-lg-6 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color:#A7B3BC">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-leaf fa-5x" style="color:#FFFFFF"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" style="color:#FFFFFF">Box 3: - °C / -%</div>
                                    <div style="color:#FFFFFF">Datum</div>
                                </div>
                            </div>
                        </div>
                        <a href="#"> <!--Hier bei href kommt der Link rein!-->
                            <div class="panel-footer">
                                <span class="pull-left" style="color:#A7B3BC">View Details</span>
                                <span class="pull-right" style="color:#A7B3BC"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>







            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-line-chart fa-fw"></i> Verlauf 24h Dach
                        </div>



                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="roof-chart"></div>
                        </div>


                        <script>
                        new Morris.Line({
                            element: 'roof-chart',
                            data: <?php echo json_encode($rowsRoof);?>,

                            xkey: 'datum',
                            //ykeys: ['temperatur', 'feuchtigkeit'],
                            ykeys: ['temperatur'],
                            //labels: ['Temperatur', 'Feuchtigkeit'],
                            labels: ['Temperatur'],
                            pointSize: 2,
                            hideHover: 'auto',
                            resize: true
                        });
                        </script>






                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <!-- /.panel -->
                </div>

                <!-- /.col-lg-4 -->
            </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-line-chart fa-fw"></i> Verlauf 24h Außen
                            </div>



                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="outside-chart"></div>
                            </div>


                            <script>
                                new Morris.Line({
                                    element: 'outside-chart',
                                    data: <?php echo json_encode($rowsOutside);?>,

                                    xkey: 'datum',
                                    ykeys: ['temperatur', 'feuchtigkeit'],
                                    labels: ['Temperatur', 'Feuchtigkeit'],
                                    pointSize: 2,
                                    hideHover: 'auto',
                                    resize: true
                                });
                            </script>






                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                        <!-- /.panel -->
                    </div>

                    <!-- /.col-lg-4 -->
                </div>



            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
  <!--  <script src="../bower_components/morrisjs/morris.min.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>














</body>

</html>
