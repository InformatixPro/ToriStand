<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Matt
 * Date: 10/1/12
 * Time: 8:08 PM
 * To change this template use File | Settings | File Templates.
 */

class FileHelper
{
    // Declarations
    private $_oFile;
    private $_sFileName;
    private $_iSizeInBytes;
    private $_oFileType;
    private $_oFileAccessMode;

    // Properties
    public function GetFile() { return $this->_oFile; }
    public function SetFileName($Value) { $this->_sFileName = $Value; }
    public function GetFileName() { return $this->_sFileName; }
    public function GetFileSize() { return $this->_iSizeInBytes; }
    public function SetFileType($Value) { $this->_oFileType = $Value; }
    public function GetFileType() { return $this->_oFileType; }
    public function SetFileAccessMode($Value) { $this->_oFileAccessMode = $Value; }
    public function GetFileAccessMode() { return $this->_oFileAccessMode; }

    // Core Methods
    public function Open()
    {
        try {
            $this->_oFile = fopen($this->_sFileName, $this->_oFileAccessMode);
            $this->_iSizeInBytes = filesize($this->_sFileName);
            return ($this->_oFile) ? true : false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function Close() { return fclose($this->_oFile); }

    public function Exists() { return file_exists($this->_sFileName); }

    public function ToString() { return fread($this->_oFile, $this->_iSizeInBytes); }
}
