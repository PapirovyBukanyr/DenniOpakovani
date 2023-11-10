<?php
$jmeno = null;
if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
{
    $osobni_cislo = $_POST["osobni_cislo"];
    $heslo = $_POST["heslo"];
    include 'pripojeni.php';
    $jmeno = ziskejJmeno();
}
if ($jmeno != null){
    $conn = pripoj();
    include "menu.php";
    $currentDate = date('Y-m-d');
    $sql = "SELECT * FROM uzivatele_reseni ORDER BY datum ASC";
        $result = $conn->query($sql);
        $pocetUlohZaUzivatelem = array();
        $pocetpocetMychUlohZaDenUlohZaDen = array();
        $CelkovyPocetUlohTridy = array();
        $uzivatelu = array();
        $uzivatelZacal = false;
        while($row = $result -> fetch_assoc()){
            if(isset($pocetUlohZaUzivatelem[$row['cislo_uzivatele']])){
                $pocetUlohZaUzivatelem[$row['cislo_uzivatele']]++;
            }
            else{
                $pocetUlohZaUzivatelem[$row['cislo_uzivatele']]=1;
            }
            if(!isset($pocetMychUlohZaDen[$row['datum']])){
                $pocetMychUlohZaDen[$row['datum']] = 0;
            }
            if($row['cislo_uzivatele'] == $osobni_cislo){
                $uzivatelZacal = true;
                $pocetMychUlohZaDen[$row['datum']]++;
            } 
            if(isset($CelkovyPocetUlohTridy[$row['datum']])){
                $CelkovyPocetUlohTridy[$row['datum']]++;
            }
            else{
                $CelkovyPocetUlohTridy[$row['datum']] = 1;
            }               
        }
        $pocetUzivatelu = count($pocetUlohZaUzivatelem);
        arsort($pocetUlohZaUzivatelem);
        $jezdec = 0;
        foreach($pocetUlohZaUzivatelem as $x => $value){
            $jezdec++;
            if($x == $osobni_cislo) $poradi = $jezdec; 
        }
        $jezdec = key($pocetMychUlohZaDen);
    foreach ($pocetMychUlohZaDen as $k => $v) {
        if (strtotime($k) < strtotime($jezdec)) $jezdec = $k;
    }
        $prumernyPocetUlohTridy = array();
        while(strtotime($jezdec) <= strtotime($currentDate)){
            $prumernyPocetUlohTridy[$jezdec]=0;
            if(isset($CelkovyPocetUlohTridy[$jezdec])){
                $prumernyPocetUlohTridy[$jezdec]=$CelkovyPocetUlohTridy[$jezdec]/$pocetUzivatelu; 
            }
            $jezdec = date("Y-m-d",86400+strtotime($jezdec));
        } 
    }
else{
    include 'zpet.php';
    die;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Statistiky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>      
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Datum');
            data.addColumn('number', 'Počet mnou splněných úloh');
            data.addColumn('number', 'Třídní průměr');

            <?php
    foreach ($pocetMychUlohZaDen as $datum => $mujPocet) {
        if(isset ($prumernyPocetUlohTridy[$datum]))
        $tridniPocet = $prumernyPocetUlohTridy[$datum];
    else $tridniPocet=0;
        echo "data.addRow(['$datum', $mujPocet, $tridniPocet]);";
    }
    ?>

            var options = {
                title: 'Graf splněných úloh za den',
                curveType: 'line',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<div class="container mt-5 row justify-content-center">
        <div class="row justify-content-center" >
            <div class="col-md-8" >
                <h2>Statistiky uživatel <?php echo $jmeno;?></h2>
                <h4>Podle celkového počtu sezbíraných úloh jste aktuálně na <?php echo $poradi;?>. pozici</h4>
                <div id="curve_chart" style="width: 100%; height: 400%"></div>
            </div>
        </div>
    </div>
    
</body>
</html>
