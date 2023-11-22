<?php
/**
 * Stránka na zpracovávání nové registrace
 * 
 * @input cislo osobní číslo uživatele
 * @input heslo heslo uživatele
 * @input jmeno jméno uživatele
 */
include 'pripojeni.php';
$cislo = $_POST["cislo"];
$heslo = $_POST["heslo"];
if((provedPrikaz("INSERT INTO uzivatele (klic, jmeno, heslo) VALUES (?,?,?)", array($cislo,$_POST["jmeno"],$heslo)))){
    include 'zpet.php';
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light">
        <div class="container">
            <div class="d-flex">
                <a href="index.php">
                    <button class="btn btn-light" href="index.php">Odhlásit</button>
                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-5 bg-success rounded" style = "padding:60px">
        <form action="rozcesti.php" method="post">
            <input type="radio" name='osobni_cislo' value='<?php echo $cislo;?>' checked hidden/> 
            <input type="radio" name='heslo' value='<?php echo $heslo;?>' checked hidden/> 
                        <H2>Registrace proběhla úspěšně</H2>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-success" value="Vstoupit do aplikace"></input>
                        </div>
        </form>
    </div>
</body>