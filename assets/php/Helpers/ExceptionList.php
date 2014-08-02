<?php

class ExceptionItem
{
    // <editor-fold desc=" Declarations ">

    private $_source;
    private $_message;

    // </editor-fold>

    // <editor-fold desc=" Constructors ">

    public function __construct($Message, $Source='')
    {
        $this->_source = $Source;
        $this->_message = $Message;
    }

    // </editor-fold>

    // <editor-fold desc=" Public Methods ">

    public function ToString()
    {
        return  $this->_message . ($this->_source != '' ? ' (' . $this->_source . ')' : '');
    }

    // </editor-fold>
}

class ExceptionList
{

    // <editor-fold desc=" Declarations ">

    private $_oExceptionItems;
    private $_iItemCount;

    // </editor-fold>

    // <editor-fold desc=" Constructors ">

    public function __construct()
    {
        $this->_oExceptionItems = array();
        $this->_iItemCount = 0;
    }

    // </editor-fold>

    public function Append( ExceptionItem $Exception )
    {
        array_push($this->_oExceptionItems, $Exception);
        $this->_iItemCount++;
    }

    public function HasErrors() { return $this->_iItemCount > 0; }

    public function ToString($WithBreak = false)
    {
        $sOut = "";
        if ($this->HasErrors()) {
            $sOut = '<div class="ErrorBox">';
            $sOut .= '<ul>';

            /** @var ExceptionItem $Exception  */
            foreach( $this->_oExceptionItems as $Exception )
            {
                $sOut .= '<li>' . $Exception->ToString() . '</li>';
            }
            $sOut .= '</ul></div>';

            if ($WithBreak) $sOut .= '<br />';
        }
        return $sOut;
    }
}

?>