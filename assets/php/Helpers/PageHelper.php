<?php

//
// PageHelper.php -> helper class with static methods for page utils
//
	class PageHelper {

    // Internal Methods 
    private static function _IsPostback() {
        $isPostBack = false;
        $referer = "";
        $thisPage = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }

        if ($referer == $thisPage) {
            $isPostBack = true;
        }

        return $isPostBack;
    }

    // Utility to check and see if a value is empty
    private static function IsNull($Value) {
        return (!isset($Value) || trim($Value) === '');
    }

    // Pulbic Exposed Utility Methods
    // God, when is method overloading going to be directly supported in php ;)		
    // --> Checks to see if postback occured by $Control
    // $Control => ID of control which initiated postback.
    // note, Overloading here is achieved by optional params.
    // Please see above rant, true overloading of methods is not yet supported in php
    public static function IsPostback($Control = '') {
        $nm = $Control;
        $a = self::IsNull($Control);
        $b = self::_IsPostback();
        $c = isset($_POST[$Control]);

        var_dump($nm, $a, $b, $c);

        if (self::IsNull($Control))
            return self::_IsPostback();
        return ( self::_IsPostback() && isset($_POST[$Control]) );
    }
    
    public static function GetQuery($Name)
    {
        $value = (!isset($_REQUEST[$Name])) ? "" : $_REQUEST[$Name];
        if ($value == null || $value == "") return "";        
        return $value;
    }        
    
    public static function GetQueryNumber($Name)
    {
        if (!empty($_REQUEST[$Name])) {
            $value = $_REQUEST[$Name];
        } else {
            $value = 0;
        }
        return $value;
    }

    public static function GetQueryArray($Name)
    {
      $oArray = array();
      foreach($_REQUEST[$Name] as $oItem) { array_push($oArray, $oItem); }
      return $oArray;
    }

    public static function FormatDate($Value)
    {
      //echo "<p>Value" . $Value;
      if ($Value == null || $Value == StringConst::EMPTY_STRING) return StringConst::EMPTY_STRING;
      list($sYear, $sMonth, $sDay) = preg_split('/[\/:-]/', $Value);
      return sprintf("%s/%s/%s", $sMonth, $sDay, $sYear);
    }

    public static function EnableControl($Condition)
    {
      return ($Condition) ? StringConst::EMPTY_STRING : 'disabled="true"';
    }

    public static function EnableImgControl($Condition, $CommandToExec)
    {
      return ($Condition) ? $CommandToExec : StringConst::EMPTY_STRING;
    }

    public static function Pluralize($Count, $Word, $PluralWord, $ZeroMessage='')
    {
			if ($Count == 0) return $ZeroMessage; /* Returns Custom Message on Zero'th day */
      return ($Count > 1) ? $PluralWord : $Word;
    }

    public static function DisplayControl($Condition)
    {
      return ($Condition) ? '' : 'style="display: none;"';
    }
}

?>
