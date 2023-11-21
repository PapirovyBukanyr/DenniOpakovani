<?php
/**
 * Vypsání samotné otázky, sám nemám tušení, jakto, že to funguje...
 * 
 * @param $_POST["osobni_cislo"] osobní číslo uživatele
 * @param $_POST["heslo"] heslo uživatele
 * @param $_POST["volba"] obor, který si uživatel zvolil
 */
$jmeno = null;
if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
{
    $osobni_cislo = $_POST["osobni_cislo"];
    $heslo = $_POST["heslo"];
    include 'pripojeni.php';
    $jmeno = ziskejJmeno($osobni_cislo,$heslo);
}
if ($jmeno != null and isset($_POST["volba"])){
    $pocetOtazek = 5;
    $volba = $_POST["volba"];
    switch ($volba) {
        case "Vygenerovat test z otázek kategorie matematická analýza":
            $nadpis = "<h2>Test z kategorie matematická analýza: <br> </h2>";
            $volba = 0;
            break;
        case "Vygenerovat test z otázek kategorie lineární algebra":
            $nadpis ="<h2>Test z kategorie lineární algebra: <br> </h2>";
            $volba = 1;
            break;
        case "Vygenerovat test z otázek kategorie konstruování":
            $nadpis = "<h2>Test z kategorie:<br>  </h2>";
            $volba = 2;
            break;
        case "Vygenerovat test z otázek kategorie jiné":
            $nadpis = "<h2>Test z kategorie \"jiné\":<br> </h2>";
            $volba = 3;
            break;
        default:
            $nadpis = "<p>Neplatná volba.</p>";
    }
    include 'menu.php';
    $currentDate = date('Y-m-d');
    $result = provedPrikaz("SELECT otazka FROM ulohy WHERE  obor=? AND NOT datum=?", array($volba,$currentDate));
    $otazka = array();
    while($row = $result -> fetch_assoc()){
        array_push($otazka, $row['otazka']);
    }
    shuffle($otazka);
    $vybrane_otazky = array_slice($otazka,0,$pocetOtazek);
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
    <title>Výzva</title>
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

        echo $nadpis ;
            ?>
            <br><br>
                <?php
                $i = 0;
                foreach($vybrane_otazky as $otazecka){
                ?>
            <div class="form-group">
                    <label><?php echo $otazecka;?></label>
                    <br>
                    <input type="text"  class="form-control" id="odpoved<?php echo $i;?>" name="odpoved" rows="1" required/>
                </div>
                <br>
                <?php 
                $i++;
            }
                ?>
                <br>
                <button class="btn btn-dark" onclick=overitSpravnost()>Vyhodnotit odpovědi</button>
    </div>
    <br>
    <br>
</body>
</html>
<script>
    function overitSpravnost(){
        var odpoved =document.getElementById("odpoved0").value;
        window.alert(odpoved);
        var odpoved =document.getElementById("odpoved1").value;
        window.alert(odpoved);
    }
</script>
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