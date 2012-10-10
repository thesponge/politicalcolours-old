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

class cache 
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
    
    public function exists($query)
    {
        // if cache is activated
        if (conf::val('site_cache') == 1)
        {
            $filename = self::filename($query);
            
            if (file_exists($filename))
            {
                $difference = (time() - filemtime($filename)) / 60;
                
                if ($difference <= conf::val('cache_time') )
                {
                    $contents = self::get_contents($query, $filename);
                    
                    if ($contents != false)
                    {
                        return $contents;
                    }
                }
                else
                {
                    @unlink($filename);
                }
            }
        }
        
        return false;
    }
    
    public function update($query, $data)
    {
        // if cache is activated
        if (conf::val('site_cache') == 1)
        {
            $filename = self::filename($query);
            $data = $query."\r".serialize($data);
            
            if (is_writable($filename) || (!file_exists($filename) && is_writable(conf::val('cache_root') ) ) )
            {
                w($filename, $data);
                return true;
            }
        }
        
        return false;
    }
    
    public function filename($query)
    {
        $query = preg_replace("/[^a-zA-Z0-9]/", "", $query);
        $query = substr($query, -250);
        $query = conf::val('cache_root'). $query;
        
        return $query;
    }
    
    public function get_contents($query, $filename)
    {
        if (file_exists($filename) && is_readable($filename))
        {
            $contents = r($filename);
            
            if ( $query == substr($contents, 0, strlen($query) ) )
            {
                return unserialize( trim(substr($contents, (strlen($query."\r") -1 )  )) );
            }
        }
        
        return false;
    }
}
?>