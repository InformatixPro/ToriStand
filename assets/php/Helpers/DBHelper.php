<?php

/**
 * Class: DBConnection
 * Purpose: Represents connection to database.
 * Author: MJE
 * Created: 01sep2012
 */
class DBConnection
{

  // <editor-fold desc=" Declarations ">

  private $_userName;
  private $_password;
  private $_serverName;
  private $_dbName;
  private $_oConnection;

  // </editor-fold>

  // <editor-fold desc=" Properties ">

  public function SetDBName($Name)
  {
    $this->_dbName = $Name;
  }

  public function GetDbName()
  {
    return $this->_dbName;
  }

  public function Status()
  {
    return ($this->_oConnection) ? 1 : 0;
  }

  public function Connection()
  {
    return $this->_oConnection;
  }

  // </editor-fold>

  // <editor-fold desc=" Constructors ">

  /**
   *
   */
  function __construct()
  {
    // DBCOnnectionInfo is defined inside includes/base.php
    $this->_serverName = DBConnectionInfo::Server;
    $this->_userName = DBConnectionInfo::User;
    $this->_password = DBConnectionInfo::Password;
    $this->_dbName = DBConnectionInfo::DBName;
    $this->_oConnection = mysql_connect($this->_serverName, $this->_userName, $this->_password);
    if (!$this->_oConnection) {
      throw new Exception(DBErrors::CouldNotConnect);
    }
  }

  // </editor-fold>

  // <editor-fold desc=" Public Methods ">

  public function Close()
  {
    mysql_close($this->_oConnection);
    $this->_oConnection = null;
  }

  // </editor-fold>

}

/**
 * Name: DBCommand
 * Purpose: Impliments a ADO.net style SQL Command interface to mysql
 * Author: MJE
 * Created: 01sep2012
 */
class DBCommand
{

  // <editor-fold desc=" Declarations ">

  private $_sCommandText;
  private $_oCommandType;
  private $_oParams;
  private $_oResults;

  // </editor-fold>

  // <editor-fold desc=" Constructors ">
  function __construct()
  {
    $this->_sCommandText = "";
    $this->_oResults = array();
    $this->_oParams = array();
  }

  // </editor-fold>

  // <editor-fold desc=" Properties ">

  public function SetCommandType($Type)
  {
    $this->_oCommandType = $Type;
  }

  public function SetCommandText($Query)
  {
    $this->_sCommandText = $Query;
  }

  public function GetResults()
  {
    return $this->_oResults;
  }

  public function GetRow($Row = 0)
  {
    return $this->_oResults[$Row];
  }

  // </editor-fold>

  // <editor-fold desc=" Public Methods ">

  public function AddParam($Param)
  {
    array_push($this->_oParams, $Param);
  }

  /**
   * Name: Execute()
   * @param bool $ReturnsData - Opional, default value: False.  Indicates we are returning data
   * @param bool $Debugging - Optional, default value: False. Causes return of statment w/o executing at db.
   * @return int - Returns success if finishes without problems.
   * @throws Exception:
   *  - 1. If database could not be selected.
   */
  public function Execute($ReturnsData = FALSE, $Debugging = FALSE)
  {
    $oConn = new DBConnection();
    $sPreparedStatement = $this->Prepare($Debugging);
    if ($Debugging) return $sPreparedStatement;

    if (!mysql_select_db($oConn->GetDbName())) {
      throw new Exception("Can't select database");
    }

    // Wrapper function to Mysql_Query --> Throws exception if theres a database error.
    $oResultsRaw = $this->MySQLQuery($sPreparedStatement);

    while ($ReturnsData && $row = mysql_fetch_assoc($oResultsRaw)) {
      array_push($this->_oResults, $row);
    }

    $oConn->Close();
    return DBStatus::SUCCESS;
  }

  /**
   * Name: ExecuteScalar()
   * @param bool $Debugging - Optional, default value: False. Causes return of statment w/o executing at db.
   * @return Object - Returns a scalar value from the database
   * @throws Exception:
   *  - 1. If database could not be selected.
   */
  public function ExecuteScalar($Debugging = FALSE, $DefaultValue = "undefined")
  {
    $ReturnValue = null;
    $oConn = new DBConnection();
    $sPreparedStatement = $this->Prepare();
    if ($Debugging) return $sPreparedStatement;

    if (!mysql_select_db($oConn->GetDbName())) {
      throw new Exception("Can't select database");
    }

    // Wrapper function to Mysql_Query --> Throws exception if theres a database error.
    $oResultsRaw = $this->MySQLQuery($sPreparedStatement);

    if (mysql_num_rows($oResultsRaw) == 0)
      $ReturnValue = $DefaultValue;
    else
      $ReturnValue = mysql_result($oResultsRaw, 0);

    $oConn->Close();
    return $ReturnValue;
  }

  // </editor-fold>

  // <editor-fold desc=" Private Methods ">

  /**
   * Name: Prepare() - Prepares the statment to be executed against the database. Called by Execute
   * @return string - Returns the prepared statment (in this case the st. proc with params (if any).
   */
  private function Prepare($Debugging = false)
  {
    $sStatement = "";

    if ($this->_oCommandType == DBCommandType::STOREDPROCEDURE) {
      $sStatement = "CALL ";
    }

    $sStatement .= $this->_sCommandText;
    $sStatement .= "(";
    $oParams = $this->_oParams;

    $iIndex = 1;
    $iNumItems = count($oParams);

    /** @var DBParam $oParam */
    foreach ($oParams as $oParam) {
      if ($Debugging) sprintf('<p> Name: %s, Value: %s', $oParam->GetName(), $oParam->GetValue());

      $sStatement .= $oParam->GetValue();
      if ($iIndex++ < $iNumItems) {
        $sStatement .= ", ";
      }
    }
    $sStatement .= ")";

    return $sStatement;
  }

  /**
   * Name: MySQLQuery - A wrapper function whichs relays DB error via throwing and exception.
   * @param $Statement - Raw or prepared SQL statment to execute
   * @return resource - Results to return.  either a scaler, row, or table.
   * @throws Exception - Throws exception if MYSQL ErrorNumber <> 0
   */
  private function MySQLQuery($Statement)
  {
    $oResults = mysql_query($Statement);
    if (!$oResults) throw new Exception(sprintf("Database Errors (%d): %s", mysql_errno(), mysql_error()));
    return $oResults;
  }
  // </editor-fold>

}

/**
 * Name: DBHelper
 * Purpose: Exposes static helper methods which either list data or run a SQL statment
 * Author: MJE
 * Created: 01sep2012
 */
class DBHelper
{

  // <editor-fold desc=" Public Methods ">

  /* Lists the data either a data table or a data row */
  public static function ListData( /* This method supports variable length arguments - php is wierd */)
  {
    $oCmd = new DBCommand();
    $oCmd->SetCommandType(DBCommandType::STOREDPROCEDURE);

    /* Parses the variable length arguments and sets up the private member variables */
    for ($i = 0; $i < func_num_args(); $i++) {
      /* This is the command text (or stored procedure) */
      if ($i == 0) {
        $oCmd->SetCommandText(func_get_arg($i));
      } else {
        $oCmd->AddParam(func_get_arg($i));
      }
    }

    /* Executes the Query */
    $oCmd->Execute(true);
    return $oCmd->GetResults();
  }

  public static function ListScalar( /* This method supports variable length arguments - php is wierd */)
  {
    $oCmd = new DBCommand();
    $oCmd->SetCommandType(DBCommandType::STOREDPROCEDURE);

    /* Parses the variable length arguments and sets up the private member variables */
    for ($i = 0; $i < func_num_args(); $i++) {
      /* This is the command text (or stored procedure) */
      if ($i == 0) {
        $oCmd->SetCommandText(func_get_arg($i));
      } else {
        $oCmd->AddParam(func_get_arg($i));
      }
    }

    /* Executes the Query */
    return $oCmd->ExecuteScalar();
  }

  /* Runs a SQL statement or stored procedure which does not return data */
  public static function Run( /* This method supports variable length arguments - php is wierd */)
  {
    $oCmd = new DBCommand();
    $oCmd->SetCommandType(DBCommandType::STOREDPROCEDURE);

    /* Parses the variable length arguments and sets up the private member variables */
    for ($i = 0; $i < func_num_args(); $i++) {
      /* This is the command text (or stored procedure) */
      if ($i == 0) {
        $oCmd->SetCommandText(func_get_arg($i));
      } else {
        $oCmd->AddParam(func_get_arg($i));
      }
    }

    /* Executes the Query */
    $RetVal = $oCmd->Execute(false, false);
    return $RetVal;
  }

  public static function RunWithReturn( /* This method supports variable length arguments - php is wierd */)
  {
    $oCmd = new DBCommand();
    $oCmd->SetCommandType(DBCommandType::STOREDPROCEDURE);

    /* Parses the variable length arguments and sets up the private member variables */
    for ($i = 0; $i < func_num_args(); $i++) {
      /* This is the command text (or stored procedure) */
      if ($i == 0) {
        $oCmd->SetCommandText(func_get_arg($i));
      } else {
        $oCmd->AddParam(func_get_arg($i));
      }
    }

    /* Executes the Query */
    $oCmd->Execute(true);
    $oResults = $oCmd->GetResults();
    return $oResults[0]['RetVal']; // We are interested in the first(only)
                                   // row and first cell aptly named RetVal form db proc.
  }

  public static function ToArray($oTable, $sColumnName)
  {
    $oArray = array();
    foreach ($oTable as $oRow) {
      array_push($oArray, $oRow[$sColumnName]);
    }
    return $oArray;
  }

  // </editor-fold>

}

?>
