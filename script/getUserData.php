<?php
    require_once('../main.inc.php');
    $qr = "SELECT name,phone,phone_ext FROM ost_ticket WHERE email = '".$_POST['mail']."' LIMIT 1,1";
    $qrd = mysql_query($qr);
    $r = mysql_fetch_array($qrd);
    echo json_encode($r);
?>