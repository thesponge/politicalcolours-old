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

class db
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
    
    public  static $errors;
    private static $connected = false;
    
    function init()
    {
        $constring = 'host='.conf::val('db_host').' port='.conf::val('db_port').' dbname='.conf::val('db_db').' user='.conf::val('db_user').'  password='.conf::val('db_pass');
        
        $link = pg_connect ($constring); 
		if (!$link)
        { 
			die('Error: Could not connect: ' . pg_last_error());
		}
        
        self::$connected = true;
        
        return true;
    }
    // afiseaza query
    function eecho($query)
    {
        echo $query;
        return true;
    }
    
    
    // citeste toate rezultatele din query
    function a($query, $identif_string="")
    {
        $return = array();
        
        if (strlen($query) > 0)
        {
            // Check cached results
            $cache = cache::exists($query);
            if ($cache) { return $cache; }
            
            // Query the database
            $result = self::q($query);
            
            if ($result)
            {
                while ($row = pg_fetch_row($result))
                {
                    $output = array();
                    
                    if (is_array($row))
                    {
                        $i = 0;
                        foreach($row as $element)
                        {
                            //echo pg_field_type($result, $i) . "<br>\n";
                            if (substr(pg_field_type($result, $i), 0, 1) == '_')
                            {
                                $element = explode(",", substr($element, 1, -1));
                                
                                $output[pg_field_name($result, $i)] = $element;
                            }
                            else
                            {   
                                if (pg_field_type($result, $i)=='numeric')
                                {
                                    $fieldname = pg_field_name($result, $i);
                                    
                                    switch ($fieldname)
                                    {
                                        case 'cnp':
                                        case 'age':
                                        case 'identity_card_no':
                                        case 'registration_no':
                                            $output[pg_field_name($result, $i)] = $element;
                                            break;
                                        default:
                                            $output[pg_field_name($result, $i)] = floatval($element);
                                            break;
                                    }
                                    
                                }
                                else $output[pg_field_name($result, $i)] = $element;
                            }
                            
                            $i++;
                        }
                    }
                    
                    if (strlen($identif_string) > 0 && strlen($output[$identif_string]) > 0)
                    {
                        $return[$output[$identif_string]] = $output;
                    }
                    else
                    {
                        $return[] = $output;
                    }
                }
                
                cache::update($query, $return);
            }
        }
        return $return;
    }
    
    // returneaza primul rezultat dintr-un query executat
    function aq($query)
    {
        $result = self::a($query);
        return $result[0];
    }
    
    
    // executa query
    function q($query)
    {
        if (strlen($query) > 0)
        {
            if (self::$connected == false) { self::init(); }
            
            $result = pg_query($query);        
            return $result;
        }
        
        return false;
    }
    // returneaza numarul de rezultate
    function nr($query)
    {
        // Check cached results
        $cache = cache::exists($query);
        if ($cache) { return $cache; }
        
        if (self::$connected == false) { self::init(); }
        
        $counted = 0;
        
        $resultCount = pg_query($query);
        if ($resultCount)
        {
            while ($row = pg_fetch_row($resultCount)) { 
                $counted = $row[0];
            }
            pg_free_result($resultCount);
        }
        
        cache::update($query, $counted);
        
        return $counted;
    }
    // foloseste o functie de scriere si returneaza $row[0]
    function ins($q)
    {
        if (self::$connected == false) { self::init(); }
        
        $result = pg_query($q);
        $row = pg_fetch_row($result);
        if (!$result)
        {
            self::$errors[] = pg_last_error();
            $return = false;
        }
        else
        {
            $return = $row[0];
        }
        
        return $return;
    }
    // sterge un anumit row din baza de date cu functie
    function del($q)
    {
        if (self::$connected == false) { self::init(); }
        
        $result = pg_query($q);
        if (!$result)
        {
            self::$errors[] = pg_last_error();
            $return = false;
        }
        else
        {
            $return = true;
        }
        
        return $return;
    }
    
    
    
    // field-urile unui select, daca exista rezultate
    function fields($query)
    {
        $return = array();
        if (strlen($query) > 0)
        {
            $result = self::q($query);
            
            if ($result)
            {
                $row = pg_fetch_row($result);
                
                for ($i=0; $i < pg_num_fields($result); $i++)
                {
                    $return[pg_field_name($result, $i)] = pg_field_type($result, $i);
                }
                
                pg_free_result($result);
            }
        }
        return $return;
    }
    
    // returneaza numele campului si tipul pentru un anumit table sau view
    function head($select)
    {
        $r = self::a("SELECT a.attnum, a.attname AS field, t.typname AS type FROM pg_class c, pg_attribute a, pg_type t WHERE c.relname = '".$select."' and a.attnum > 0 and a.attrelid = c.oid and a.atttypid = t.oid ORDER BY a.attnum");
        foreach ($r as $key=>$value)
        {
            $array[$value['field']] = $value['type'];
        }
        
        return $array;
    }
}
?>