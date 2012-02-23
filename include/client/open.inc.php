<script>
    $(document).ready(function(){
        $('#userMail').blur(function(){
            if($(this).val().length > 6){
                $('#loading').fadeIn(1);
                $.post('script/getUserData.php',{mail:$(this).val()}, function(data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj != false){
                        $('#userName').val(obj.name);
                        $('#userPhone').val(obj.phone);
                        $('#userPhoneExt').val(obj.phone_ext);
                    }
                    $('#loading').fadeOut(1);
                });
            }
        });
    });
</script>


<?php

//Check for includes
if(!defined('OSTCLIENTINC')) die('Erro em em Includes');

// Conditional to prevent POST data error
$info=($_POST && $errors)?Format::input($_POST):array();

/**
 * Error and Warning printing
 */
?>
<div>
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" id="infomessage"><?=$msg?></p>
    <?}elseif($warn) {?>
        <p id="warnmessage"><?=$warn?></p>
    <?}?>
</div>


<?
/**
 * New Ticket Form
 */
?>

<div><?=$trl->translate('TEXT_PLEASE_FILL_FORM_NEW_TICKET')?></div><br/>

<form action="open.php" method="POST" enctype="multipart/form-data">

<table align="left" cellpadding="2" cellspacing="1" width="90%">

<?
/**
 * ====================== EMAIL ======================
 */ 
?>

    <tr>
        <th nowrap="nowrap" ><?=$trl->translate('LABEL_EMAIL_ADDRESS')?>:</th>
        <td>
            <?if ($thisclient && ($email=$thisclient->getEmail())) {
                ?>
                <input type="hidden" name="email" size="25" value="<?=$email?>"/><?=$email?>
            <?}else {?>             
                <input id="userMail" type="text" name="email" size="25" value="<?=$info['email']?>"/>
                <span style="display: none;" id="loading"><img src="images/loading.gif"/></span>
            <?}?>
            &nbsp;<font class="error">*&nbsp;<?=$errors['email']?></font>
            <?if ($thisclient && ($name=$thisclient->getName())) { ?>
            	<br/>
				<A href="logout.php" ><?=$trl->translate('TEXT_NOT_THIS_USER')?></A>
			<?}?>
        </td>
    </tr>

<?
/**
 * ====================== FULL NAME ======================
 */ 
?>

    <tr>
        <th width="20%"><?=$trl->translate('LABEL_FULL_NAME')?>:</th>
        <td>
            <?if ($thisclient && ($name=$thisclient->getName())) {
                ?>
                <input type="hidden" name="name" value="<?=$name?>"/><?=$name?>
            <?}else {?>
                <input id="userName" type="text" name="name" size="25" value="<?=$info['name']?>"/>
	        <?}?>
            &nbsp;<font class="error">*&nbsp;<?=$errors['name']?></font>
	        </td>
    </tr>

<?
/**
 * ====================== TELEPHONE ======================
 */ 
?>

    <tr>
        <td><?=$trl->translate('LABEL_TELEPHONE'); ?>:</td>
        <td><input id="userPhone" type="text" name="phone" size="25" value="<?=$info['phone']?>"/>
             &nbsp;Ext&nbsp;<input id="userPhoneExt" type="text" name="phone_ext" size="6" value="<?=$info['phone_ext']?>"/>
            &nbsp;<font class="error">&nbsp;<?=$errors['phone']?></font></td>
    </tr>

    <tr height="2px"><td align="left" colspan="2" >&nbsp;</td></tr>

<?
/**
 * ====================== HELP TOPIC ======================
 */ 
?>

    <tr>
        <th><?=$trl->translate('LABEL_HELP_TOPIC'); ?>:</th>
        <td>
            <select name="topicId">
                <option value="" selected="true"><?php $trl->_('LABEL_SELECT_ONE_TOPIC') ?></option>
                <?
                 $services= db_query('SELECT topic_id,topic FROM '.TOPIC_TABLE.' WHERE isactive=1 ORDER BY topic');
                 while (list($topicId,$topic) = db_fetch_row($services)){
                    $selected = ($info['topicId']==$topicId)?'selected':''; ?>
                    <option value="<?=$topicId?>"<?=$selected?>><?=$trl->_('TOPIC_'.$topic)?></option>
                <?
                 }?>
                <?php /*<option value="0" ><?=$trl->translate('TEXT_GENERAL_INQUIRY');?></option> */ ?>
            </select>
            &nbsp;<font class="error">*&nbsp;<?=$errors['topicId']?></font>
        </td>
    </tr>

<?
/**
 * ====================== SUBJECT ======================
 */ 
?>

    <tr>
        <th><?=$trl->translate('LABEL_SUBJECT')?>:</th>
        <td>
            <input type="text" name="subject" size="35" value="<?=$info['subject']?>"/>
            &nbsp;<font class="error">*&nbsp;<?=$errors['subject']?></font>
        </td>
    </tr>

<?
/**
 * ====================== MESSAGE ======================
 */ 
?>

    <tr>
        <th valign="top"><?=$trl->translate('LABEL_MESSAGE')?>:</th>
        <td>
            <? if($errors['message']) {?> <font class="error"><b>&nbsp;<?=$errors['message']?></b></font><br/><?}?>
            <textarea name="message" cols="35" rows="8" wrap="soft" style="width:85%"><?=$info['message']?></textarea></td>
    </tr>

<?
/**
 * ====================== PRIORITY ======================
 */ 
?>

    <?
    if($cfg->allowPriorityChange() ) {
      $sql='SELECT priority_id,priority_desc FROM '.TICKET_PRIORITY_TABLE.' WHERE ispublic=1 ORDER BY priority_urgency DESC';
      if(($priorities=db_query($sql)) && db_num_rows($priorities)){ ?>
      <tr>
        <td><?=$trl->translate('LABEL_PRIORITY')?>:</td>
        <td>
            <select name="pri">
              <?
                $info['pri']=$info['pri']?$info['pri']:$cfg->getDefaultPriorityId(); //use system's default priority.
                while($row=db_fetch_array($priorities)){ ?>
                    <option value="<?=$row['priority_id']?>" <?=$info['pri']==$row['priority_id']?'selected':''?> ><?=$row['priority_desc']?></option>
              <?}?>
            </select>
        </td>
       </tr>
    <? }
    }?>

<?
/**
 * ====================== UPLOAD ======================
 */ 
?>

    <?if(($cfg->allowOnlineAttachments() && !$cfg->allowAttachmentsOnlogin())  
                || ($cfg->allowAttachmentsOnlogin() && ($thisclient && $thisclient->isValid()))){
        
        ?>
    <tr>
        <td><?=$trl->translate('LABEL_ATTACHMENT')?>:</td>
        <td>
            <input type="file" name="attachment"/><font class="error">&nbsp;<?=$errors['attachment']?></font>
        </td>
    </tr>
    <?}?>

<?
/**
 * ====================== CAPTCHA ======================
 */
?>

    <?if($cfg && $cfg->enableCaptcha() && (!$thisclient || !$thisclient->isValid())) {
        if($_POST && $errors && !$errors['captcha'])
            $errors['captcha']=$trl->translate('CAPTCHA_ERROR');
        ?>
    <tr>
        <th valign="top"><?=$trl->translate('CAPTCHA_TEXT')?>:</th>
        <td><img src="captcha.php" border="0" align="left"/>
        
        <span>&nbsp;&nbsp;
            <input type="text" name="captcha" size="7" value="" style="width: 78px; height: 25px; margin-left: 10px; float:left;"/>&nbsp;
            <i> <small style="float:left; display:block; max-width:250px; margin-left:10px;"><?=$trl->translate('CAPTCHA_DESC')?></small></i>
        </span>
        <br/>
                <font class="error">&nbsp;<?=$errors['captcha']?></font>
        </td>
    </tr>
    <?}?>

    <tr height="2px"><td align="left" colspan="2" >&nbsp;</td></tr>

<?
/**
 * ====================== SEND ======================
 */ 
?>

    <tr>
        <td></td>
        <td>
            <input class="button" type="submit" name="submit_x" value="<?=$trl->translate('LABEL_SUBMIT_TICKET')?>"/>
            <input class="button" type="reset" value="<?=$trl->translate('LABEL_RESET')?>"/>
            <input class="button" type="button" name="cancel" value="<?=$trl->translate('LABEL_CANCEL')?>" onClick='window.location.href="index.php"'/>    
        </td>
    </tr>
</table>

</form>