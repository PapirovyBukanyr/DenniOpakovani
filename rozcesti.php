<?php
/**
 * Rozcestí, kde si člověk vybírá, jaký obor (volbu, proboha, to budu muset sjednotit nebo ti z toho hrábne) denní výzvy chce
 * 
 * @param $_POST["osobni_cislo"] osobní číslo uživatele
 * @param $_POST["heslo"] heslo uživatele
 */
    $jmeno = null;
    include 'pripojeni.php';

    if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
    {
        $osobni_cislo = $_POST["osobni_cislo"];
        $heslo = $_POST["heslo"];
        $pripojeni = new Pripojeni();
        $jmeno = $pripojeni->ziskejJmeno($osobni_cislo,$heslo);
    }
    if ($jmeno != null){
        include 'menu.php';
        $currentDate = date('Y-m-d');
        $result = $pripojeni->provedPrikaz("SELECT obor FROM uzivatele_reseni WHERE datum=? AND cislo_uzivatele=?",array($currentDate, $osobni_cislo));
        $mojePole = array();
        for ($i = 0; $i < 4; $i++){
            array_push($mojePole,false);
        }
        while($row = $result -> fetch_assoc()){
            $mojePole[$row["obor"]] = true;
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
    <title>Rozcestí</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<style>
        .custom-button {
            width: 200px;
            margin: 10px;
            text-align: center; 
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Vyberte denní výzvu:</h2>
        <form method="POST" action="otazka.php">
            <input type="radio" name='osobni_cislo' value='<?php echo $osobni_cislo;?>' checked hidden/> 
            <input type="radio" name='heslo' value='<?php echo $heslo;?>' checked hidden/>  
            <div class="row">
                <?php
                    include 'moznost_rozcesti.php';
                    pridatMoznostRozcesti($mojePole[0],"Matematická analýza");
                    pridatMoznostRozcesti($mojePole[4],"Obecná algebra");
                    pridatMoznostRozcesti($mojePole[5],"Fyzika");
                    pridatMoznostRozcesti($mojePole[6],"BUM");
                ?>
            </div>
        </form>
    </div>
</body>
</html>