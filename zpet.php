<?php
/**
 * Text co se vygeneruje pro většinu chyb
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    
</head>
<body>
<div class="container mt-5">
                Moc se omlouvám, někde došlo k chybě. Prosím, přihlašte se znovu <br><br>
                <?php
                require 'tlacitka.php';
                    new Tlacitka(text:"Zpět", odkaz: "index.php")
                ?>
            </div>
</body>