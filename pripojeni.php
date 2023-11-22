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
function ziskejJmeno(int $osobni_cislo,string $heslo) {
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
function provedPrikaz(string $prikaz,array $hodnoty = null) {
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