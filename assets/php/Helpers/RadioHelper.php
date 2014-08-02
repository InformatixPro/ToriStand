<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Matt
 * Date: 10/25/12
 * Time: 9:08 PM
 * To change this template use File | Settings | File Templates.
 */

class RadioItem
{
  // <editor-fold desc=" Private Members ">

    private $_id;
    private $_name;
    private $_value;
    private $_text;
    private $_checked;

  // </editor-fold>

  // <editor-fold desc=" Private Members ">

    public function GetID() { return $this->_id; }
    public function SetID($Value) { $this->_id = $Value; }
    public function GetName() { return $this->_name; }
    public function SetName($Value) { $this->_name = $Value; }
    public function GetValue() { return $this->_value; }
    public function SetValue($Value) { $this->_value = $Value; }
    public function GetText() { return $this->_text; }
    public function SetText($Value) { $this->_text = $Value; }
    public function GetChecked() { return $this->_checked; }
    public function SetChecked($Value) { $this->_checked = $Value; }

  // </editor-fold>

  // <editor-fold desc=" Constructors ">

    public function __construct($ID, $Name, $Value, $Text, $CheckedValue)
    {
      $this->SetID($ID);
      $this->SetName($Name);
      $this->SetValue($Value);
      $this->SetText($Text);

      if($this->_value == $CheckedValue) {
        $this->SetChecked('checked="true"');
      } else {
        $this->SetChecked('');
      }
    }

  // </editor-fold>

  // <editor-fold desc=" Public Methods ">

    public function Render()
    {
      return sprintf('<input name="%s" type="radio" id="%s" value="%s" %s />%s',
                      $this->GetName(), $this->GetID(), $this->GetValue(), $this->GetChecked(), $this->GetText());
    }

  // </editor-fold>
}

class RadioHelper
{
  private $_oItemList;

  public function __construct($CheckedValue)
  {
    $this->_oItemList = array();
  }

  public function Add($Item)
  {
     array_push($this->_oItemList, $Item);
  }

  public function Render()
  {
    /** @var RadioItem $oRadItem  */
    $sOut = StringConst::EMPTY_STRING;
    $oRadItems = $this->_oItemList;
    foreach ($oRadItems as $oRadItem)
    {
      $sOut .= $oRadItem->Render();
    }
    return $sOut;
  }
}
