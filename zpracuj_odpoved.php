<?php
/**
 * stránka, která zpracovává odpověď přijatou z odpoved.php a vyhodnocuje její správnost
 * 
 * @param $_POST["osobni_cislo"] osobní číslo uživatele
 * @param $_POST["heslo"] heslo uživatele
 * @param $_POST['volba'] vybraný obor
 * @param $_POST['odpoved'] odpověď na otázku
 */
$jmeno = null;
if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
{
    $osobni_cislo = $_POST["osobni_cislo"];
    $heslo = $_POST["heslo"];
    include 'pripojeni.php';
    $pripojeni = new Pripojeni();
    $jmeno = $pripojeni->ziskejJmeno($osobni_cislo,$heslo);
}
if ($jmeno != null and isset($_POST['odpoved']) and isset($_POST['volba'])){
    $spravnost = false;
    $odpoved = $_POST['odpoved'];
    $volba = $_POST['volba'];
    $currentDate = date('Y-m-d');
    $result = $pripojeni->provedPrikaz("SELECT odpoved FROM ulohy WHERE datum=? AND obor=?",array($currentDate,$volba));
    if($row = $result -> fetch_assoc()){
        if (trim(strtolower($odpoved)) == trim(strtolower($row["odpoved"]))){
            $spravnost = true;
            $volba = $_POST["volba"];
            if(!$pomocna_prommenna = $pripojeni->provedPrikaz("SELECT * FROM uzivatele_reseni WHERE obor=? AND datum=? AND cislo_uzivatele=?",array($volba,$currentDate,$osobni_cislo))->fetch_assoc()){
            $pripojeni->provedPrikaz("INSERT INTO uzivatele_reseni (obor, datum, cislo_uzivatele) VALUES (?, ?,?)", array($volba,$currentDate,$osobni_cislo));   
        }
        }   
    }
    include 'menu.php';
    switch($_POST["volba"]){
        case 0:
            $volba = "Matematická analýza";
            break;
        case 4:
            $volba = "Obecná algebra";
            break;
        case 5:
            $volba = "Fyzika";
            break;
        case 6:
            $volba = "BUM";
            break;
    }
}
else {
    include "zpet.php";
    die;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Odpověď</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5 <?php if($spravnost)echo "bg-success"; else echo "bg-danger";?> rounded" style = "padding:60px">
        <form action="rozcesti.php" method="post">
            <input type="radio" name='osobni_cislo' value='<?php echo $osobni_cislo;?>' checked hidden/> 
            <input type="radio" name='heslo' value='<?php echo $heslo;?>' checked hidden/> 
            <input type="volba" name='volba' value='<?php echo $volba;?>' checked hidden/> 
            <?php
                if($spravnost){?>
                        <H2>Odpověď byla správná</H2>
            <?php
                }
                else {
            ?>
                        <h2>Někde nejspíš došlo k drobné chybce</h2>
            <?php
                }
            ?>
                        <div class="col-md-3">
                            <?php
                            if($spravnost){
                                new Tlacitka (text:"Zpět na rozcestí", tridyTlacitek:BarvyTlacitek::success);
                            }
                            else{
                                new Tlacitka (text:"Zpět na rozcestí", tridyTlacitek:BarvyTlacitek::danger);
                            }
                            ?>
                        </div>
        </form>
    </div>
</body>