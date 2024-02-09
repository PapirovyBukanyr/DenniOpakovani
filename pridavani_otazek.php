<?php
/**
 * K této stránce veřejnost nemá přístup, přidávám tu otázky
 * 
 * @param $_POST["osobni_cislo"] osobní číslo uživatele
 * @param $_POST["heslo"] heslo uživatele
 * 
 * @param $_POST['otazka'] zadaná otázka
 * @param $_POST['odpoved'] zadaná odpověď
 * @param $_POST['datum'] zadané datum
 * @param $_POST['obor'] zadaný obor
 */
if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
    {
        $osobni_cislo = $_POST["osobni_cislo"];
            $heslo = $_POST["heslo"];
        if($osobni_cislo == 12345 and $heslo == 12345){//bezpečnost přede vším, plánuji to změnit, neboj se
            
            include 'pripojeni.php';
            $pripojeni = new Pripojeni();
            if(isset($_POST["otazka"]) and isset($_POST["odpoved"]) and isset($_POST["datum"]) and isset($_POST["obor"])){
                $datum =$_POST["datum"];
                $otazka = $_POST["otazka"];
                $odpoved = $_POST["odpoved"];
                $obor = $_POST["obor"];
                $result = $pripojeni->provedPrikaz("SELECT otazka FROM ulohy WHERE datum=? AND obor=?", array($datum, $obor));
                $klic = time();
                if(!($row = $result -> fetch_assoc())){
                    $pripojeni->provedPrikaz("INSERT INTO ulohy (obor, datum, otazka, odpoved, klic) VALUES (?,?,?,?,?)", array($obor, $datum, $otazka, $odpoved, $klic));
                    echo "Otazka pridana";
                }
                else{
                    echo "uz existuje";
                    echo $row["otazka"];
                }
            }
        }
        else{
            include 'zpet.php';    
            die;
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Otázka</title>
<!-- Latest compiled and minified CSS --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
    <form action="pridavani_otazek.php" method="post">
            <input type="radio" name='osobni_cislo' value='<?php echo $osobni_cislo;?>' checked hidden/> 
            <input type="radio" name='heslo' value='<?php echo $heslo;?>' checked hidden/> 
                
            <div class="form-group">
            <label>otazka:</label>
                    <textarea class="form-control" id="otazka" name="otazka" rows="3" required></textarea>
                    <label>odpoved:</label>
                    <textarea class="form-control" id="odpoved" name="odpoved" rows="1" required></textarea>
                    <label>datum:</label><br>
                    <input type="date" class="form-control" id="datum" name="datum" required/>
                    <label>obor</label><br>
                    <input type="radio" name="obor" value="0" required> Matematická analýza<br>
                    <input type="radio" name="obor" value="4" required> Obecná algebra<br>
                    <input type="radio" name="obor" value="5" required> Fyzika<br>
                    <input type="radio" name="obor" value="6" required> BUM<br>                   
                </div>
                <br>
                <?php
                    $tlacitka = new Tlacitka();
                    $tlacitka->Tlacitko("Odeslat");
                ?>
            </form> 
        </div>
            </body>