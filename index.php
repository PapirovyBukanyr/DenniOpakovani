<?php
/**
 * Tato stránka neobsahuje žádnou logiku, pouze je to zobrazení přihlašovacího vstupu
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Přihlášení</title>
   <!-- Latest compiled and minified CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body class="bg-light row justify-content-center">
    <div class="container mt-5 row justify-content-center">
        <div class="row justify-content-center" >
            <div class="col-md-4" >
                <h2>Přihlášení</h2>
                <form action="rozcesti.php" method="post">
                    <div class="form-group">
                        <label for="osobni_cislo">Osobní číslo:</label>
                        <input type="text" class="form-control" id="osobni_cislo" name="osobni_cislo" required>
                    </div>
                    <div class="form-group">
                        <label for="heslo">Heslo:</label>
                        <input type="password" class="form-control" id="heslo" name="heslo" required>
                        <label style="opacity:0.6"for="heslo">Pokud bylo heslo zapomenuto, neváhej napsat Markovi, již brzy to bude autonomní</label>
                    </div>
                    <button type="submit" class="btn btn-dark">Přihlásit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>