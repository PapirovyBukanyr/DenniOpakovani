<?php
/**
 * Stránka pro registraci nového uživatele
 */
include 'pripojeni.php';
$pripojeni = new Pripojeni();
$zabrana_cisla = array();
if(!($result = $pripojeni->provedPrikaz("SELECT klic FROM uzivatele"))){
    include 'zpet.php';
    die;
}
while ($row = $result->fetch_assoc()) {
    array_push($zabrana_cisla, $row['klic']);
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrace účastníka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>
<body class="bg-light row justify-content-center">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light">
        <div class="container">
            <button class="btn btn-light mr-auto" onclick="window.history.back()">Zpět</button>
        </div>
    </nav>

    <div class="container mt-5 row justify-content-center">
        <div class="row justify-content-center" >
            <div class="col-md-4" >
                <h2>Registrace nového uživatele</h2>
                <br>
                <form action="registrovat.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="cislo">Osobní číslo:</label>
                        <input type="number" class="form-control" id="cislo" name="cislo" required>
                        <small id="numberHelp" class="form-text text-danger"></small>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="jmeno">Jméno:</label>
                        <input type="text" class="form-control" id="jmeno" name="jmeno" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="heslo">Heslo:</label>
                        <input type="password" class="form-control" id="heslo" name="heslo" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="heslo_potvrzeni">Potvrzení hesla:</label>
                        <input type="password" class="form-control" id="heslo_potvrzeni" name="heslo_potvrzeni" required>
                        <small id="passwordHelp" class="form-text text-danger"></small>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-dark">Registrovat</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function validateForm() {
            var password = document.getElementById("heslo").value;
            var confirmPassword = document.getElementById("heslo_potvrzeni").value;
            var passwordHelp = document.getElementById("passwordHelp");
            var number = document.getElementById("cislo").value;
            var numberHelp =document.getElementById("numberHelp");
            
            numberHelp.textContent = "";
            <?php
            foreach ($zabrana_cisla as $cisla) {
                ?>
                if(number ==<?php echo $cisla; ?>) {
                numberHelp.textContent = "Číslo již je zabráno";
                return false;
            }    
            <?php
            }
            ?>

            if (password !== confirmPassword) {
                passwordHelp.textContent = "Hesla se neshodují! Ty jsi ale šikula ♥"; //Ondro, nezlob se na mě, byl jsem donucen...
                return false;
            } else {
                passwordHelp.textContent = "";
                return true;
            } 
        }
    </script>
</body>
</html>
