<?php if ($_SESSION['__notify'])  { ?>
<script type="text/javascript">
    window.location= 'main.php'
</script>
<?php

exit(6);

}
?>
<div style="width:99%">
<?php


$connectionNumber = array();
$action = array();
$extra = array();
$date = array();
$oparr = array();

foreach (xmlCall("base.getLdapLog",array($_SESSION['ajax']['filter'])) as $line) {
    if (is_array($line)) {
    $connectionNumber[] = '<a href="#" onClick="jQuery(\'#param\').val(\''.'conn='.$line["conn"].'\'); pushSearch(); return false">'.$line["conn"].'</a>';
    $action[] = '<a href="#" onClick="jQuery(\'#param\').val(\''.$line["op"].'\'); pushSearch(); return false">'.$line["op"].'</a>';
    $extra[] = $line["extra"];
    $dateparsed = strftime('%b %d %H:%M:%S',$line["time"]);
    $date[] = str_replace(" ", "&nbsp;", $dateparsed);
    if ($line["opfd"] == "op") {
            $oparr[] = $line["opfdnum"];
        } else {
            $oparr[] = "";
        }
    } else {
    $connectionNumber[] = "";
    $action[] = "";
    $date[] = "";
    $oparr[] = "";
    $extra[] = $line;
    }
}

$n = new UserInfos($date,_("Date"),"1px");
$n->addExtraInfo($connectionNumber,_("Connection"),"1px");
$n->addExtraInfo($oparr,_("Operation"),"1px");
$n->addExtraInfo($action,_("Actions"),"1px");
$n->addExtraInfo($extra,_("Extra information"));
$n->end= 200;
$n->first_elt_padding = 1;
$n->display(0,0);

?>
</div>
