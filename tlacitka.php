<?php
class Tlacitka{
    public function __construct(
        string $text, 
        BarvyTlacitek $tridyTlacitek = BarvyTlacitek::dark, 
        string $odkaz = null,
        string $action = null,
        string $id = null,
        ){
        switch($tridyTlacitek){
            case BarvyTlacitek::dark:
                $TridyTlacitek = "btn btn-dark";
                break;
            case BarvyTlacitek::light:
                $TridyTlacitek = "btn btn-light";
                break;
            case BarvyTlacitek::warning:
                $TridyTlacitek = "btn btn-warning";
                break;
            case BarvyTlacitek::danger:
                $TridyTlacitek = "btn btn-danger";
                break;
            case BarvyTlacitek::success:
                $TridyTlacitek = "btn btn-success";
                break;
            default:
                $TridyTlacitek = "btn btn-dark";
                break;
        }
        $tlacitko = "<button type='submit' class='".$TridyTlacitek."' ";
        if($action!=null) $tlacitko = $tlacitko." onclick='".$action."' ";
        if($id!=null) $tlacitko = $tlacitko." id='".$id."' ";
        $tlacitko = $tlacitko.">".$text."</button>";
        if($odkaz!=null) $tlacitko = "<a href=".$odkaz.">" . $tlacitko . "</a>";
        echo $tlacitko;
    }
}

enum BarvyTlacitek{
    case light;
    case dark;
    case danger;
    case warning;
    case success;
}
?>