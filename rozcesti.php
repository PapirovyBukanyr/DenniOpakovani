<?php
/**
 * Rozcestí, kde si člověk vybírá, jaký obor (volbu, proboha, to budu muset sjednotit nebo ti z toho hrábne) denní výzvy chce
 * 
 * @param POST["osobni_cislo"] osobní číslo uživatele
 * @param POST["heslo"] heslo uživatele
 */
    $jmeno = null;
    if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
    {
        $osobni_cislo = $_POST["osobni_cislo"];
        $heslo = $_POST["heslo"];
        include 'pripojeni.php';
        $jmeno = ziskejJmeno($osobni_cislo,$heslo);
    }
    if ($jmeno != null){
        $conn = pripoj();
        include 'menu.php';
        $currentDate = date('Y-m-d');
        $sql = "SELECT obor FROM uzivatele_reseni WHERE datum='$currentDate' AND cislo_uzivatele='$osobni_cislo'";
        $result = $conn->query($sql);
        $mojePole = array(false, false, false, false);
        while($row = $result -> fetch_assoc()){
            $mojePole[$row["obor"]] = true;
        }
        $conn->close();
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
            height: 200px;
            margin: 10px;
            text-align: center; 
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
                <div class="col-md-3">
                    <input type="submit" class="btn <?php if($mojePole[0])echo "btn-success"; else echo "btn-danger";?> custom-button" name = 'volba' value = "Matematická analýza"></input>
                    <input type="submit" formaction="archiv.php" class="btn btn-dark" name = 'volba' value = "Archiv úloh do matematické analýzy"></input>
                </div>
                <div class="col-md-3">
                        <input type="submit" class="btn <?php if($mojePole[1])echo "btn-success"; else echo "btn-danger";?> custom-button" name = 'volba' value = "Lineární algebra"></input>
                        <input type="submit" formaction="archiv.php" class="btn btn-dark" name = 'volba' value = "Archiv úloh do lineární algebry"></input>
                </div>
                <div class="col-md-3">
                        <input type="submit" class="btn <?php if($mojePole[2])echo "btn-success"; else echo "btn-danger";?> custom-button" name = 'volba'  value = "Konstruování"></input>
                        <input type="submit" formaction="archiv.php" class="btn btn-dark" name = 'volba' value = "Archiv úloh do konstruování"></input>
                </div>
                <div class="col-md-3">
                        <input type="submit" class="btn <?php if($mojePole[3])echo "btn-success"; else echo "btn-danger";?> custom-button" name = 'volba' value = "Jiné"></input>
                        <input type="submit" formaction="archiv.php" class="btn btn-dark" name = 'volba' value = "Archiv jiných úloh"></input>
                </div>
            </div>
        </form>
    </div>
</body>
</html>