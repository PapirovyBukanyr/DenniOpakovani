<?php
class Tlacitka{
    private ?string $TridyTlacitek = null;
    public function __construct(string $text, string $tridyTlacitek = null){
        if($tridyTlacitek == null){
            $TridyTlacitek = "btn btn-dark";
        }
        else {
            $TridyTlacitek=$tridyTlacitek;
        }
        echo "<button type='submit' class='".$TridyTlacitek."'>".$text."</button>";
    }
}
?>