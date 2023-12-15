<?php
/**
 * Archiv denních výzev, které se nahrají do polí zatím bez omezení maximálního počtu
 * 
 * @param $_POST["osobni_cislo"] osobní číslo uživatele
 * @param $_POST["heslo"] heslo uživatele
 * @param $_POST["volba"] obor, který si uživatel zvolil
 */
$jmeno = null;
include 'pripojeni.php';
include 'tlacitka.php';

if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
{
    $osobni_cislo = $_POST["osobni_cislo"];
    $heslo = $_POST["heslo"];
    $pripojeni = new Pripojeni();
    $jmeno = $pripojeni->ziskejJmeno($osobni_cislo,$heslo);
}
if ($jmeno != null and isset($_POST['volba'])){
    $volba = $_POST['volba'];
    switch ($volba) {
        case "Archiv úloh z kategorie matematická analýza":
            $nadpis = "<h2>Archiv výzev do matematické analýzy: <br> </h2>";
            $volba = 0;
            break;
        case "Archiv úloh z kategorie lineární algebra":
            $nadpis ="<h2>Archiv výzev do lineární algebry: <br> </h2>";
            $volba = 1;
            break;
        case "Archiv úloh z kategorie konstruování":
            $nadpis = "<h2>Archiv výzev do konstruování:<br>  </h2>";
            $volba = 2;
            break;
        case "Archiv úloh z kategorie jiné":
            $nadpis = "<h2>Archiv výzev do kategorie \"jiné\":<br> </h2>";
            $volba = 3;
            break;
        default:
            $nadpis = "<p>Neplatná volba.</p>";
    }
    include 'menu.php';
    $currentDate = date('Y-m-d');
    $result = $pripojeni->provedPrikaz("SELECT otazka, odpoved,datum FROM ulohy WHERE obor=?", array($volba));
    $otazky = array();
    while($row = $result -> fetch_assoc()){
      if($row["datum"]<$currentDate){
        $otazky[$row["otazka"]]=$row["odpoved"]; 
      } 
    }
}
else {
    include 'zpet.php';
    die;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archiv</title>
<!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.13.11/dist/katex.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.13.11/dist/contrib/auto-render.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.11/dist/katex.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        echo $nadpis;
        foreach($otazky as $otazka=>$odpoved){
        echo "<h5>".$otazka."</h5>";
        echo "[".$odpoved."]<br><br>";
        }
            ?>
    </div>
</body>
</html>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    renderMathInElement(document.getElementById("math-element"), {
      delimiters: [
        { left: "$$", right: "$$", display: true },
        { left: "\\[", right: "\\]", display: true },
        { left: "\\(", right: "\\)", display: false },
      ],
    });
  });
</script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      renderMathInElement(document.body);
    });
  </script>