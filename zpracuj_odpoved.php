<?php
$jmeno = null;
if(isset($_POST["osobni_cislo"]) and isset($_POST["heslo"]))
{
    $osobni_cislo = $_POST["osobni_cislo"];
    $heslo = $_POST["heslo"];
    include 'pripojeni.php';
    $jmeno = ziskejJmeno();
}
if ($jmeno != null and isset($_POST['odpoved'])){
    $spravnost = false;
    $conn = pripoj();
    $odpoved = $_POST['odpoved'];
    $volba = $_POST['volba'];
    $currentDate = date('Y-m-d');
    $sql = "SELECT odpoved FROM ulohy WHERE datum='$currentDate' AND obor='$volba'";
    $result = $conn->query($sql);
    if($row = $result -> fetch_assoc()){
        if (trim(strtolower($odpoved)) == trim(strtolower($row["odpoved"]))){
            
            $spravnost = true;
            $volba = $_POST["volba"];
            $sql = "SELECT * FROM uzivatele_reseni WHERE obor='$volba' AND datum='$currentDate' AND cislo_uzivatele='$osobni_cislo'";
            $result1 = $conn->query($sql);
            if(!$karel = $result1->fetch_assoc()){
            $sql = "INSERT INTO uzivatele_reseni (obor, datum, cislo_uzivatele) VALUES ('$volba', '$currentDate', '$osobni_cislo')";
            $conn->query($sql);
        }
        }   
    }
    include 'menu.php';
    $conn->close();
    switch($_POST["volba"]){
        case 0:
            $volba = "Matematická analýza";
            break;
        case 1:
            $volba = "Lineární algebra";
            break;
        case 2:
            $volba = "Konstruování";
            break;
        case 3:
            $volba = "Jiné";
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
                            <input type="submit" class="btn <?php if($spravnost)echo "btn-success"; else echo "btn-danger";?>" value="Zpět na rozcestí"></input>
                        </div>
        </form>
    </div>
</body>