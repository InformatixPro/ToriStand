<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 4/4/14
 * Time: 11:05 PM
 */

require_once('./base.php');

$sFullName = PageHelper::GetQuery('FullName');
$sEmailAddress = PageHelper::GetQuery('Email');
$sMessageBody = PageHelper::GetQuery('MessageBody');
$dateNow = date('Y/m/d');

$oRecipientList = new RecipientList();
$oRecipientList->Add('mjebersbach@gmail.com');

$oData = new TagDictionary();
$oData->Add(new DictionaryItem('FullName', $sFullName));
$oData->Add(new DictionaryItem('EmailAddress', $sEmailAddress));
$oData->Add(new DictionaryItem('MessageBody', $sMessageBody));
$oData->Add(new DictionaryItem('Now', $dateNow));

echo '<p>'. $sFullName . ' ' . 'Address: ' . $sEmailAddress;

//$oEmail = new EmailMessage();
//$oEmail->SetToList($oRecipientList);
//$oEmail->SetData($oData);
//$oEmail->SetIsHTML(true);
//$oEmail->SetTemplateFileName(BASE_PATH . '/Templates/contact.html');
//$oEmail->Send();

?>