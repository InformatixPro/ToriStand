<?php

// <editor-fold desc=" Global Enums ">

final class OperatingMode
{
    const DEBUGGING = '1';
    const PRODUCTION = '0';
}

final class DBConnectionInfo
{
    const Server = "localhost";
    const User = "dev";
    const Password = "6HZ8T6iboT14R";
    const DBName = "vr_SyaffeR";
}

// </editor-fold>

// <editor-fold desc=" Application Settings ">

// Settings
const MODE = OperatingMode::DEBUGGING;
const SYSTEM_ADDRESS = 'noreply@toristand.com';
const BASE_PATH = '/var/www/html/assets/php/';
//const BASE_PATH = '';

// Includes MJE - Please make special note that we specify the paths this way
// eventhough this file is located in sub directory(includes/).  Im not sure
// why this is, but I will update this section when I find out.  Currently this
// works, but not quite sure why.

// Framework Includes
require_once(BASE_PATH . 'Helpers/Alert.php');
require_once(BASE_PATH . 'Helpers/Debug.php');
require_once(BASE_PATH . 'Helpers/DBHelper.php');
require_once(BASE_PATH . 'Helpers/DBParam.php');
require_once(BASE_PATH . 'Helpers/PageHelper.php');
require_once(BASE_PATH . 'Helpers/ExceptionList.php');
require_once(BASE_PATH . 'Helpers/EmailMessage.php');
require_once(BASE_PATH . 'Helpers/FileHelper.php');
require_once(BASE_PATH . 'Helpers/Enumerations.php');
require_once(BASE_PATH . 'Helpers/ListBase.php');
require_once(BASE_PATH . 'Helpers/Validation.php');
require_once(BASE_PATH . 'Helpers/RadioHelper.php');

// Business Objects Includes
//require_once(BASE_PATH . 'BusinessLogic/ClientExt.php');
//require_once(BASE_PATH . 'BusinessLogic/ClientNotifications.php');

// </editor-fold>

// <editor-fold desc=" Off Limits - Don't Touch! - This code will bite you! ">

// This was set here as the show errors setting in the php.ini
// is set to off we are overriding.
if (!ini_get('display_errors')) {
    ini_set('display_errors', MODE);
}

// </editor-fold>


?>
