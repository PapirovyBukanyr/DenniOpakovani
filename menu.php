<?php
$sql = "SELECT * FROM uzivatele_reseni WHERE cislo_uzivatele='$osobni_cislo'";
$result = $conn->query($sql);
$pocetUloh = 0;
while($row = $result -> fetch_assoc()){
    $pocetUloh++;    
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light">
        <div class="container">
            <button class="btn btn-light mr-auto" onclick="window.history.back()">Zpět</button>
            <div class="d-flex">
               <form action="profil.php" method="Post">
            <input type="radio" name='osobni_cislo' value='<?php echo $osobni_cislo;?>' checked hidden/> 
            <input type="radio" name='heslo' value='<?php echo $heslo;?>' checked hidden/> 
               <a href="profil.php">
                    <button class="btn btn-light" href="profil.php"><?php echo $jmeno; ?> <span class="badge bg-dark"><?php echo $pocetUloh;?></span></button>
                </a> 
                </form>
                &nbsp;
               <a href="index.php">
                    <button class="btn btn-light" href="index.php">Odhlásit</button>
                </a>
            </div>
        </div>
    </nav>
</body>
</html>
