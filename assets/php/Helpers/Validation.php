<?php

class Validation
{

    // <editor-fold desc=" Core Methods ">

        public static function IsNull($Value)
        {
            return ($Value == null) ? '' : $Value;
        }

        public static function IsProvided($Value)
        {
            return ($Value != null && $Value != "" );
        }

        public static function InRange($Value, $Lower, $Upper)
        {
            return ($Value >= $Lower && $Value <= $Upper);
        }

        public static function InList($Value)
        {
            for ($CSV = array(), $i = 1;$i < func_num_args();$i++) {
                array_push($CSV, func_get_arg($i));
            }
            return in_array($Value, $CSV);
        }

        public static function RemovePadding($Value, $PaddingChar)
        {
            if ($Value < 10) { return str_replace($PaddingChar, '', $Value); }
            return $Value;
        }

    // </editor-fold>

    // <editor-fold desc=" Datetime Methods ">

        private static $oDaysInMonth = array(   0 => -1, 1 => 31, 2 => 28, 3 => 31,
                                                4 => 30, 5 => 31, 6 => 30, 7 => 31,
                                                8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31 );

        public static function GetDaysInMonth($Month)
        {
            return self::$oDaysInMonth[$Month];
        }

        private static function IsValidMonth($Value)
        {
            $Value = self::RemovePadding($Value, '0');
            return ( self::IsProvided($Value) && self::InRange($Value, 1, 12) );
        }

        private static function IsValidYear($Value)
        {
            return ( self::IsProvided($Value) && $Value > 0 );
        }

        private static function IsLeapYear($Value)
        {
            return (($Value % 4) == 0);
        }

        private static function IsValidDay($Day, $Month, $Year)
        {
            $Day = self::RemovePadding($Day, '0');
            $Month = self::RemovePadding($Month, '0');
            $iDaysInMonth = (!self::IsLeapYear($Year)) ? self::$oDaysInMonth[$Month] : self::$oDaysInMonth[$Month] + 1;
            return ( self::IsProvided($Day) && self::InRange($Day, 1, $iDaysInMonth) );
        }

        public static function IsValidDate($Day, $Month, $Year)
        {
            //echo 'IsValidMonth: ' . (self::IsValidMonth($Month) ? "true" : "false");
            //echo 'IsValidYear: ' . (self::IsValidYear($Year) ? "true" : "false");
            //echo 'IsValidDay: ' . (self::IsValidDay($Day, $Month, $Year) ? "true" : "false");
            return (self::IsValidMonth($Month) && self::IsValidYear($Year) && self::IsValidDay($Day, $Month, $Year));
        }

    // </editor-fold>

}

?>
