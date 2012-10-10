<?php
//Copyright (C) 2012  PoliticalColours.ro - Project of TheSponge.eu Some Rights Reserved.
//
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, either version 3 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.

/*
 Loads configuration values into a class
*/
if (!is_included) { die(); }

class conf 
{    
    private static $instance;
    
    public static function singleton()
    {
        if (!isset(self::$instance))
        {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }
        return self::$instance;
    }
    
    public function val($string='')
    {
        global $config;
        
        if (strlen($string) > 0) 
        {
            return $config[$string];
        }
    }
    
    public function aval($array, $string)
    {
        global $config;
        return $config[$array][$string];
    }
}
?>