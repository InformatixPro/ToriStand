<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Matt
 * Date: 10/9/12
 * Time: 11:42 PM
 * To change this template use File | Settings | File Templates.
 */

// MJE Includes

// Base class Alert which all subsequent child classes inherit
abstract class Alert 
{
	protected $_oRecipientList;
  protected $_oData;
  protected $_sTemplateFile;

	public function SetRecipientList($Value) { $this->_oRecipientList = $Value; }
  public function SetTemplateFile($Value) { $this->_sTemplateFile = $Value; }
  public function SetData($Value) { $this->_oData = $Value; }

  // These methods must be implimented in child classes
  public abstract function __construct($RecipientList, $DataDictionary);
  public abstract function Send();
}

class EscrowAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/escrowAlert.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }

}

class ApplyAssociationAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/applyAssoc.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }

}

class ApproxAppraisalAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/approxAppraisal.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }

}

class ApproveAssocAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/assocApproval.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }

}

class DaysToGetCommitmentAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/loanCommitment.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

class DaysToInspectionAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/inspection.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

class PropertyInsuranceAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/propertyInsurance.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

class ClosingAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/closing.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

class OfferSentAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/offerSent.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

class BirthdayAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/birthday.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

class ChatAlert extends Alert
{
  public function __construct($RecipientList, $DataDictionary)
  {
    if ($RecipientList == null) { throw new Exception('RecipientList Cant be NULL'); }
    if ($DataDictionary == null) { throw new Exception('DataDictionary Cant be NULL'); }

    $this->SetRecipientList($RecipientList);
    $this->SetData($DataDictionary);
    $this->SetTemplateFile(BASE_PATH . 'cms/templates/chat.html');
  }

  public function Send()
  {
    try {
      $oEmail = new EmailMessage();
      $oEmail->SetToList($this->_oRecipientList);
      $oEmail->SetTemplateFileName($this->_sTemplateFile);
      $oEmail->SetData($this->_oData);
      $oEmail->Send();
    } catch (Exception $e) {
      throw $e;
    }

  }
}

?>
