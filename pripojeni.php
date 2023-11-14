<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<?php

/**
 * Funkce na pripojeni se k databázi
 * @return mysqli pripojeni
*/
function pripoj(){
$servername = "localhost";
$username = "root";
$password = "";
$database = "denniopakovani";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}     
return $conn;
}

/**
 * Funkce na získání jména
 * @param int $osobni_cislo Osobní číslo uživatele
 * @param string $heslo heslo uživatele
 * @return string jméno uživatele
 */
function ziskejJmeno($osobni_cislo, $heslo) {
    $hodnoty = array($osobni_cislo,$heslo);
    if($row = provedPrikaz("SELECT jmeno FROM uzivatele WHERE klic=? AND heslo=?", $hodnoty)-> fetch_assoc()){
        return $row["jmeno"]; 
    }
    return null;
}

/**
 * Funkce na získání jména
 * @param string $prikaz příkaz k provedení
 * @param string[] $hodnoty pole hodnot k nahrání
 * @return mysqli_result výsledek příkazu
 */
function provedPrikaz($prikaz,$hodnoty = null) {
    $conn = pripoj();
    $stmt = $conn->prepare($prikaz);
    if (isset($hodnoty)) {
    //přemýšlím, jak by to šlo hodit do cyklu
    switch (sizeof($hodnoty)){
        case 1:
            $stmt->bind_param("s", $hodnoty[0]);
            break;
        case 2:
            $stmt->bind_param("ss", $hodnoty[0],$hodnoty[1]);
            break;
        case 3:
            $stmt->bind_param("sss", $hodnoty[0], $hodnoty[1], $hodnoty[2]);
            break;
        case 4:
            $stmt->bind_param("ssss", $hodnoty[0], $hodnoty[1], $hodnoty[2],$hodnoty[3]);
            break;
        case 5:
            $stmt->bind_param("sssss", $hodnoty[0], $hodnoty[1], $hodnoty[2],$hodnoty[3],$hodnoty[4]);
            break;
        default:
            break;
    }
    }
    $stmt->execute();
    $vystup = $stmt->get_result();
    $conn ->close();
    return $vystup;    
}
?>
</body>