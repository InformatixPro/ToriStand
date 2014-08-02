<?php

//
// EmailMessage.php -> helper class representing email message
//
class EmailMessage
{

    // Private Members
    private $_sFrom;
    private $_oToList;
    private $_oCCList;
    private $_oBCCList;
    private $_sMessage;
    private $_bIsHTML;
    private $_sSubject;
    private $_oData;
    private $_oTemplateFile;
    private $_sTemplateFileName;

    // Public properties
    public function SetSubject($Value)
    {
        $this->_sSubject = $Value;
    }

    public function GetSubject()
    {
        return $this->_sSubject;
    }

    public function GetMessage()
    {
        return $this->_sMessage;
    }

    public function SetMessage($Value)
    {
        $this->_sMessage = $Value;
    }

    public function SetIsHTML($Value)
    {
        $this->_bIsHTML = $Value;
    }

    public function GetIsHTML()
    {
        return $this->_bIsHTML;
    }

    public function SetData($Value)
    {
        $this->_oData = $Value;
    }

    public function GetData()
    {
        return $this->_oData;
    }

    public function SetToList($Value)
    {
        $this->_oToList = $Value;
    }

    public function GetToList()
    {
        return $this->_oToList;
    }

    public function SetBCCList($Value)
    {
        $this->_oBCCList = $Value;
    }

    public function GetBCCList()
    {
        return $this->_oBCCList;
    }

    public function SetCCList($Value)
    {
        $this->_oCCList = $Value;
    }

    public function GetCCList()
    {
        return $this->_oCCList;
    }

    public function SetTemplateFileName($Value)
    {
        $this->_sTemplateFileName = $Value;
    }

    public function GetTemplateFileName()
    {
        return $this->_sTemplateFileName;
    }

    public function SetFrom($Value)
    {
        $this->_sFrom = $Value;
    }

    public function GetFrom()
    {
        return $this->_sFrom;
    }

    // Constructors
    public function __construct()
    {
        $this->_sFrom = SYSTEM_ADDRESS;
        $this->_oToList = new RecipientList();
        $this->_oCCList = new RecipientList();

        // For Testing Only
        $this->_oCCList->Add("mjebersbach@gmail.com");

        $this->_oBCCList = new RecipientList();
        $this->_sMessage = StringConst::EMPTY_STRING;
        $this->_bIsHTML = true;
        $this->_sSubject = StringConst::EMPTY_STRING;
        $this->_oTemplateFile = new FileHelper();
        $this->_oData = new TagDictionary();
    }

    // Public Methods
    public function Send()
    {
        try {
            // Grab and merge template
            $this->MergeTemplate();
            $sFrom = $this->_sFrom;
            $sToList = $this->_oToList->ToString();

            // To send HTML mail, the Content-type header must be set
            $sHeaders = StringConst::EMPTY_STRING;
            $sHeaders = "MIME-Version: 1.0" . StringConst::CRLF;
            $sHeaders .= "From: " . $sFrom . StringConst::CRLF;

            // Optionally Setup the CC List
            if (!$this->_oCCList->IsEmpty()) {
                $sCcList = $this->_oCCList->ToString();
                $sHeaders .= "Cc: " . $sCcList . StringConst::CRLF;
            }

            // Optionally Setup the BCC List
            if (!$this->_oBCCList->IsEmpty()) {
                $sBccList = $this->_oBCCList->ToString();
                $sHeaders .= "Bcc: " . $sBccList . StringConst::CRLF;
            }

            // Setup the Text Type Header
            if ($this->_bIsHTML) {
                $sHeaders .= "Content-type: text/html" . StringConst::CRLF;
            } else {
                $sHeaders .= "Content-type: text/plain" . StringConst::CRLF;
            }

            // Send the message using the PHP mail utility.
            // echo '<p> Subject: ' . $this->_sSubject;
            mail($sToList, $this->_sSubject, $this->_sMessage, $sHeaders);
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Private Methods
    private function GetTemplate()
    {
        $this->_oTemplateFile->SetFileName($this->_sTemplateFileName);
        $this->_oTemplateFile->SetFileAccessMode(FileAccessModes::READ_ONLY);
        $this->_oTemplateFile->SetFileType(FileTypes::ASCII);
        if (!$this->_oTemplateFile->Exists()) {
            throw new Exception("Template File not Found!");
        } elseif ($this->_oTemplateFile->Open()) {
            $this->_sMessage = $this->_oTemplateFile->ToString();
        } else {
            throw new Exception("Template file found, but there was an error opening it!");
        }

        $this->_oTemplateFile->Close();
    }

    private function MergeTemplate()
    {
        try {
            $sKey = StringConst::EMPTY_STRING;
            $sData = StringConst::EMPTY_STRING;
            $this->GetTemplate();

            // Look for subject value, if none, grab from <title>..</title>.
            if ($this->_sSubject == StringConst::EMPTY_STRING) {
                $this->_sSubject = preg_match('!<title>(.*?)</title>!i', $this->_sMessage, $matches) ? $matches[1] : '';
            }

            /** @var DictionaryItem $DataItem */
            foreach ($this->_oData->GetArray() as $DataItem) {
                //var_dump($DataItem);
                //echo '<p>' . $DataItem->GetKey() . ' - ' . $DataItem->GetValue();
                $sKey = $DataItem->GetKey();
                $sData = $DataItem->GetValue();
                if ($sKey == '[Subject]') {
                    $this->_sSubject = $sData;
                }
                $this->_sMessage = str_replace($sKey, $sData, $this->_sMessage);
            }

        } catch (Exception $e) {
            throw $e;
        }
    }
}

final class RecipientList
{

    // Declarations
    private $_oAddresses;

    // Constructors
    public function __construct()
    {
        $this->_oAddresses = array();
    }

    // Public Methods
    public function Add($EmailAddress)
    {
        array_push($this->_oAddresses, $EmailAddress);
    }

    public function IsEmpty()
    {
        return (count($this->_oAddresses) == 0) ? true : false;
    }

    public function ToString($Separator = ',')
    {
        $iElementsInArray = count($this->_oAddresses);
        for ($sOut = '', $i = 0; $i < $iElementsInArray; $i++) {
            $sOut .= $this->_oAddresses[$i];
            if ($i < $iElementsInArray - 1) {
                $sOut .= $Separator;
            }
        }
        return $sOut;
    }
}

final class TagDictionary
{
    // Declarations
    private $_oArray;

    // Public Properties
    public function __construct()
    {
        $this->_oArray = array();
    }

    public function GetArray()
    {
        return $this->_oArray;
    }

    /** @var DictionaryItem $oItem */
    public function Add($oItem)
    {
        try {
            $this->_oArray[] = $oItem;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

final class DictionaryItem
{
    // Declarations
    private $_sKey;
    private $_sData;

    // Constructor
    public function __construct($Key, $Data)
    {
        $this->SetKey($Key);
        $this->SetValue($Data);
    }

    // Private Methods
    private function HasBraces($Key)
    {
        return strpos($Key, '[');
    }

    // Public Methods
    public function GetValue()
    {
        return $this->_sData;
    }

    public function GetKey()
    {
        return $this->_sKey;
    }

    public function SetValue($Value)
    {
        $this->_sData = $Value;
    }

    public function SetKey($Value)
    {
        if (!$this->HasBraces($Value)) {
            $this->_sKey = '[' . $Value . ']';
        } else {
            $this->_sKey = $Value;
        }
    }
}

?>
