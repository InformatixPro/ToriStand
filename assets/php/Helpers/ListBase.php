<?php

  // <editor-fold desc=" Base Class ">

	abstract class ListItemBase
	{
		protected $_oValue;
    protected $_oText;
    protected $_bIsSelected;
    protected $_bHasValue;

		public function SetValue($Value) { $this->_oValue = $Value; }
		public function GetValue() { return $this->_oValue; }
		public function SetTextValue($Value) { $this->_oText = $Value; }
		public function GetTextValue() { return $this->_oText; }
		public function GetIsSelected() { return $this->_bIsSelected; }

		abstract public function __construct($Value, $Text, $Name="",  $IsSelected=false, $HasValue=true);
		abstract public function SetSelected($Value);
		abstract public function ToString();
	}

  // </editor-fold>

  // <editor-fold desc=" DropDownList Class ">

	class DropDownListItem extends ListItemBase
	{
		public function SetSelected($Value) 
		{
			//if (!Validation::InList($Value, true, false)) { throw new Exception('Bad Value: Must either be TRUE or FALSE'); 
			$this->_bIsSelected = $Value;
		}

		public function __construct($Value, $Text, $Name="", $IsSelected=false, $HasValue=true)
		{
			$this->_oValue = $Value;
			$this->_oText = $Text;
			$this->_bIsSelected = $IsSelected;
      $this->_bHasValue = $HasValue;
		}

		public function ToString()
		{
			$sValue = ($this->_bHasValue ? sprintf('Value="%s"', $this->_oValue) : '');
			$sSelected = ($this->_bIsSelected ? sprintf('Selected="%s"', "true") : '');
			return sprintf('<option %s %s>%s</option>', $sValue, $sSelected, $this->_oText);
		}
	}

	class DropDownList 
	{
		private $_oData;          /* Input Array */
		private $_oArray;         /* Output Array */
		private $_oDataField;     /* Field for the data value */
		private $_oTextField;     /* Field for the text value */
		private $_oListDataType;  /* Enumeration for type of data passed in */
		private $_oSelectedValue; /* Selected Value - Note, could be null if there's no selected */

		public function __construct($Data, $ListDataType, $SelectedValue=null)
		{
			$this->_oData = $Data;
			$this->_oArray = array();
			$this->_oSelectedValue = $SelectedValue;
			$this->_oListDataType = $ListDataType;
		}

		public function SetDataField($Value) { $this->_oDataField = $Value; }
		public function SetTextField($Value) { $this->_oTextField = $Value; }

		private function Populate()
		{
			if (!$this->_oData) { throw new Exception("Data set cannot be empty!"); }
			else {
				switch ($this->_oListDataType) 
				{
					case ListDataType::STATICLIST:
						foreach($this->_oData as $oKeyItem => $oDataItem) {
							$bIsSelectedValue = ($this->_oSelectedValue != null && $this->_oSelectedValue == $oKeyItem);
							array_push($this->_oArray, new DropDownListItem($oKeyItem, $oDataItem, null , $bIsSelectedValue,true));
						}
						break;
					case ListDataType::SQLDATATABLE:
						throw new Exception("Not Implemented Yet");
						break;
				}
			}
		}

		public function ToString($WithBreaks=false)
		{
			$this->Populate();

			$sOut = StringConst::EMPTY_STRING;

      /** @var DropDownListItem $oItem */
			foreach($this->_oArray as $oItem)
			{
				$sOut .= $oItem->ToString() . ($WithBreaks ? '<br />' : '');
			}
			return $sOut;
		}
	}

  // </editor-fold>

  // <editor-fold desc="CheckList">

  class CheckListItem extends ListItemBase
  {
    private $_sName;

    public function SetSelected($Value)
    {
      if (!Validation::InList($Value, true, false)) { throw new Exception('Bad Value: Must either be TRUE or FALSE'); }
      $this->_bIsSelected = $Value;
    }

    private function GetName() { return $this->_sName . '[]'; }

    public function __construct($Value, $Text, $Name="", $IsSelected=false, $HasValue=true)
    {
      $this->_sName = $Name;
      $this->_oValue = $Value;
      $this->_oText = $Text;
      $this->_bIsSelected = $IsSelected;
      $this->_bHasValue = $HasValue;
    }

    public function ToString()
    {
      $sText = $this->_oText;
      $sValue = ($this->_bHasValue ? sprintf('Value="%s"', $this->_oValue) : '');
      $sSelected = ($this->_bIsSelected) ? 'checked' : '';
      $sName = $this->GetName();
      return sprintf('<div class="left"><input class="emailChk" type="checkbox" id="%s" name="%s" %s %s />&nbsp;%s</div>', $sName, $sName, $sValue, $sSelected, $sText);
    }
  }

  class CheckList
  {
    private $_sName;          /* Name of Control, used when list items render(populate) */
    private $_oData;          /* Input Array */
    private $_oArray;         /* Output Array */
    private $_oDataField;     /* Field for the data value */
    private $_oTextField;     /* Field for the text value */
    private $_oListDataType;  /* Enumeration for type of data passed in */
    private $_oSelectedValue; /* Selected Value - Note, could be null if there's no value(s) selected (ARRAY) */

    public function __construct($Name, $Data, $ListDataType, $SelectedValue=null)
    {
      $this->_sName = $Name;
      $this->_oData = $Data;
      $this->_oArray = array();
      $this->_oSelectedValue = (!is_null($SelectedValue)) ? $SelectedValue : array();
      $this->_oListDataType = $ListDataType;
    }

    public function SetName($Value) { $this->_sName = $Value; }
    private function GetName() { return $this->_sName; }
    public function SetDataField($Value) { $this->_oDataField = $Value; }
    public function GetDataField() { return $this->_oDataField; }
    public function SetTextField($Value) { $this->_oTextField = $Value; }
    public function GetTextField() { return $this->_oTextField; }
    private function GetSelectedValues() { return $this->_oSelectedValue; }
    private function SetSelected($Value) { return in_array($Value, $this->GetSelectedValues()); }

    private function Populate()
    {
      if (!$this->_oData) { throw new Exception("Data set cannot be empty!"); }
      else {
        switch ($this->_oListDataType)
        {
          case ListDataType::STATICLIST:
            throw new Exception('Not implimented here yet...');
            break;
          case ListDataType::SQLDATATABLE:
            foreach ($this->_oData as $oRow) {
              $sName = $this->GetName();
              $sDataFieldValue = $oRow[$this->GetDataField()];
              $sTextFieldValue = $oRow[$this->GetTextField()];
              array_push($this->_oArray, new CheckListItem($sDataFieldValue, $sTextFieldValue, $sName, $this->SetSelected($sDataFieldValue) ));
            }
            break;
        }
      }
    }

    public function ToString($WithBreaks=false)
    {
      $this->Populate();

      $sOut = StringConst::EMPTY_STRING;

      /** @var CheckListItem $oItem */
      foreach($this->_oArray as $oItem)
      {
        $sOut .= $oItem->ToString() . ($WithBreaks ? '<div class="clrLeft"></div>' : '');
      }
      return $sOut;
    }

  }

  // </editor-fold>

  // <editor-fold desc=" Static Lists ">

	final class StaticLists
	{
		public static function DaysInMonth()
		{
			return array(
        "-1" => "",
        "0" => "0 days",
				"1" => "1 day",
				"2" => "2 days",
				"3" => "3 days",
				"4" => "4 days",
				"5" => "5 days",
				"6" => "6 days",
				"7" => "7 days",
				"8" => "8 days",
				"9" => "9 days",
				"10" => "10 days",
				"11" => "11 days",
				"12" => "12 days",
				"13" => "13 days",
				"14" => "14 days",
				"15" => "15 days",
				"16" => "16 days",
				"17" => "17 days",
				"18" => "18 days",
				"19" => "19 days",
				"20" => "20 days",
				"21" => "21 days",
				"22" => "22 days",
				"23" => "23 days",
				"24" => "24 days",
				"25" => "25 days",
				"26" => "26 days",
				"27" => "27 days",
				"28" => "28 days",
				"29" => "29 days",
				"30" => "30 days",
				"31" => "31 days"
			);
		}
	}

  // </editor-fold>

?>
