<?php
class Tlacitka{
    public function Tlacitko(
        string $text, 
        ?string $tridyTlacitek = "dark", 
        ?string $odkaz = null,
        ?string $action = null,
        ?string $id = null
    ){
        switch($tridyTlacitek){
            case "dark":
                $TridyTlacitek = "btn btn-dark";
                break;
            case "light":
                $TridyTlacitek = "btn btn-light";
                break;
            case "warning":
                $TridyTlacitek = "btn btn-warning";
                break;
            case "danger":
                $TridyTlacitek = "btn btn-danger";
                break;
            case "success":
                $TridyTlacitek = "btn btn-success";
                break;
            default:
                $TridyTlacitek = "btn btn-dark";
                break;
        }
        $tlacitko = "<button type='submit' class='".$TridyTlacitek."' ";
        if($action != null) $tlacitko .= " onclick='".$action."' ";
        if($id != null) $tlacitko .= " id='".$id."' ";
        $tlacitko .= ">".$text."</button>";
        if($odkaz != null) $tlacitko = "<a href='".$odkaz."'>" . $tlacitko . "</a>";
        echo $tlacitko;
    }
}
