<?php

//require_once('Validation.php');

/**
 * Class: DBParam
 * Purpose: Represents a database parameter to mysql database server for use with DBHelper List and run methods
 * Author: MJE
 * Created: 01sep2012
 */
class DBParam {

    // <editor-fold desc=" Declarations ">
    
    private $_Name;
    private $_Value;
    private $_DBType;
    private $_Direction;
    private $_MonthFirst;
    
    // </editor-fold>
    
    // <editor-fold desc=" Constructors ">
    
    public function __construct($Name, $Value, $DBType=DBType::AlphaNumeric,
                                $Direction=DBParamDir::INPUT, $MonthFirst=true) {
        $this->_Name = $Name;
        $this->_Value = $Value;
        $this->_DBType = $DBType;
        $this->_Direction = $Direction;
        $this->_MonthFirst = $MonthFirst;
    }
    
    // </editor-fold>
    
    // <editor-fold desc=" Public Methods ">

    public function GetName()
    {
      return $this->_Name;
    }

    public function GetValue()
    {
        switch ($this->_DBType)
        {
            case DBType::Numeric:
                return $this->GetValueNumeric();
            case DBType::DateTime:
                return $this->GetValueDatetime();
            default:
                return $this->GetValueAlphaNumeric();
        }
    }

    // </editor-fold>

    // <editor-fold desc=" Private Methods ">

    private function GetValueNumeric() { return $this->_Value; }
    private function GetValueAlphaNumeric() { return "'" . $this->_Value . "'"; }

    private function GetValueDatetime()
    {
        $sTempDate = $this->_Value;
        if ($sTempDate == StringConst::EMPTY_STRING) return 'null';

        list($sYear, $sMonth, $sDay) = preg_split('/[\/:-]/', $sTempDate);
        if ($sYear < 2000) {
            if ($this->_MonthFirst) { list($sMonth, $sDay, $sYear) = preg_split('/[\/:-]/', $sTempDate); }
            else { list($sDay, $sMonth, $sYear) = preg_split('/[\/:-]/', $sTempDate); }
        }

        if (Validation::IsValidDate($sDay, $sMonth, $sYear))
        {
            return "'" . $sYear . "-" . $sMonth . "-" . $sDay . "'";
        }

	    /* TODO: throw exception here -> If we get this far, then there was an error. */
        throw new Exception("GetValueDateTime(): There was a problem getting the datetime value");
    }

    // </editor-fold>
}

?>
