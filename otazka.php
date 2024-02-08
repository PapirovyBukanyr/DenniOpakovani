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
    require 'pripojeni.php';
    $pripojeni = new Pripojeni();
    $jmeno = $pripojeni->ziskejJmeno($osobni_cislo,$heslo);
}
if ($jmeno != null and isset($_POST["volba"])){
    $volba = $_POST["volba"];
    switch ($volba) {
        case "Matematická analýza":
            $nadpis = "<h2>Denní výzva do matematické analýzy: <br> </h2>";
            $volba = 0;
            break;
        case "Obecná algebra":
            $nadpis ="<h2>Denní výzva do obecné algebry: <br> </h2>";
            $volba = 4;
            break;
        case "Fyzika":
            $nadpis = "<h2>Denní výzva do fyziky:<br>  </h2>";
            $volba = 5;
            break;
        case "BUM":
            $nadpis = "<h2>Denní výzva do BUM:<br> </h2>";
            $volba = 6;
            break;
        default:
            $nadpis = "<p>Neplatná volba.</p>";
    }
    require 'menu.php';
    $currentDate = date('Y-m-d');
    $result = $pripojeni->provedPrikaz("SELECT otazka FROM ulohy WHERE datum=? AND obor=?", array($currentDate, $volba));
    if($row = $result -> fetch_assoc()){
        $otazka = $row["otazka"];    
    }
    else{
        $otazka = "Výzva nenalezena. Ozvěte se Markovi, ten vám dá deset důvodů proč...";
    }
    $result = $pripojeni->provedPrikaz("SELECT cislo_uzivatele FROM uzivatele_reseni WHERE datum=? AND obor=?",array($currentDate,$volba));
    if ($result->num_rows > 0) {
        $resitele = array();
        while($row = $result->fetch_assoc()) {
            if($row1 = $pripojeni->provedPrikaz("SELECT jmeno FROM uzivatele WHERE klic=?", array($row["cislo_uzivatele"])) -> fetch_assoc()){
                array_push($resitele,$row1["jmeno"]);
            }
        }
      }
}
else {
    require 'zpet.php';
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
        echo $otazka;
            ?>
            <br><br>
            <form action="zpracuj_odpoved.php" method="post">
            <input type="radio" name='osobni_cislo' value='<?php echo $osobni_cislo;?>' checked hidden/> 
            <input type="radio" name='heslo' value='<?php echo $heslo;?>' checked hidden/> 
            <input type="radio" name='volba' value='<?php echo $volba;?>' checked hidden/> 
                
            <div class="form-group">
                    <label>Odpověď:</label>
                    <br>
                    <input type="text" class="form-control" id="odpoved" name="odpoved" rows="1" required/>
                </div>
                <br>
                <?php
                    new Tlacitka(text: "Odeslat");
                ?>
            </form>
        
    </div>
    <br>
    <br>
    <div class="container mt-3">
        <ul class="list-group">
            <li class="list-group-item bg-dark text-light">Lidé, co tuto výzvu již splnili</li>
            <?php
                if (isset($resitele)) {
                    foreach($resitele as $resitel){
                        echo "<li class=\"list-group-item\">".$resitel."</li>"; 
                    }
                } else {
                    echo "<li class=\"list-group-item \">Tuto úlohu zatím nikdo nevyřešil. Buď ten první!</li>";
                }
            ?>
        </ul>
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