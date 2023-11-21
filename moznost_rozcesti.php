<?php
/**
 * Funkce na přidání možnosti do rozcestí
 * 
 * @param bool $splneno jestli je daná úloha splněná
 * @param string $nazev název kategorie, do které úloha spadá
 */
function pridatMoznostRozcesti(bool $splneno, string $nazev ){
    echo '<div class="col-md-3">';
    if($splneno){
        $barva = "btn-success";
    }
    else{
        $barva = "btn-danger";
    }
    echo '<input type="submit" style="height: 200px;" class="btn '.$barva.' custom-button" name = "volba" value = "'.$nazev.'"/>';
    echo '<input type="submit" formaction="test.php" class="btn btn-dark custom-button" name = "volba" value = "Vygenerovat test z otázek kategorie '.strtolower($nazev).'"></input>';
    echo '<input type="submit" formaction="archiv.php" class="btn btn-dark custom-button" name = "volba" value = "Archiv úloh z kategorie '.strtolower($nazev).'"></input>';
    echo '</div>';
}
?>