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
 * 
 * @param osobni_cislo Osobní číslo uživatele
 * @param heslo heslo uživatele
 */
function ziskejJmeno($osobni_cislo, $heslo) {
$conn = pripoj();
$jmeno = null; 
$sql = "SELECT jmeno FROM uzivatele WHERE klic='$osobni_cislo' AND heslo='$heslo'";
$result = $conn->query($sql);
if($row = $result -> fetch_assoc()){
    $jmeno= $row["jmeno"]; 
    $conn->close(); 
    return $jmeno;
}
$conn->close();
}


?>
</body>