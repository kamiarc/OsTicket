<?php
$title=($cfg && is_object($cfg))?$cfg->getTitle():'osTicket';
$trl->sendHeader();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="<?php echo $trl->getLang(); ?>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo $trl->getCharset(); ?>">
    <title><?=Format::htmlchars($title)?></title>
    <link rel="stylesheet" href="./styles/main.css" media="screen">
    <link rel="stylesheet" href="./styles/colors.css" media="screen">
    <link rel="shortcut icon" href="favicon.ico" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>
<body dir="<?php echo $dir; ?>">
<div id="container">
    <div id="header">
        <a id="logo" href="index.php" title="<?= $trl->translate('TEXT_SUPPORT_CENTER'); ?>"><img src="./images/logo-cubo.png" border=0 alt="Support Center"></a>
    </div>
    <ul id="nav">
         <?                    
         if($thisclient && is_object($thisclient) && $thisclient->isValid()) {?>
         <li><a class="log_out" href="logout.php"><?= $trl->translate('TEXT_LOG_OUT'); ?></a></li>
         <?}else {?>
         <li><a class="ticket_status" href="tickets.php"><?= $trl->translate('TEXT_TICKETS_STATUS'); ?></a></li>
         <?}?>
         <li><a class="new_ticket" href="open.php"><?= $trl->translate('TEXT_NEW_TICKET'); ?></a></li>
         <li><a class="home" href="index.php"><?= $trl->translate('TEXT_HOME'); ?></a></li>
    </ul>
    <div id="content">
