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


# parse params in case friendly urls are enabled
function parse_get_params() 
{
	$params = $_GET['params'];
	
	$varval = explode('_', $params);
    $counter = count($varval);
    $i = 0;
    while ($i < $counter) 
    {
		if (strlen($varval[$i]) > 0)
		{
			$varval2 = explode('-',$varval[$i]);
			if (strlen($varval2[0]) > 0 && strlen($varval2[1]) > 0)
			{
				$_GET[$varval2[0]] = $varval2[1];
			}
		}
		$i++;
	}
	
    unset($_GET['params']);
}


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        //check ip from share internet
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        //to check ip is pass from proxy
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function post_pg_escape_string()
{
    foreach ($_POST as $key=>$value)
    {
        if (is_array($value))
        {
            $value = null;
        }
        else
        {
            if (is_numeric($value))
            {
                $value = floatval($value);
            }
            $value = pg_escape_string($value);
        }
        
        $_POST[$key] = $value;
    }
    
    return true;
}

function sql_from_array_alter_string($string)
{
    if ($string == 'null' || $string == '')
    {
        $string = 'null,';
    }
    else
    {
        if (is_numeric($string))
        {
            $string = floatval($string).",";
        }
        else
        {
            $string = "'".$string."',";
        }
    }
    
    return $string;
}

function sql_from_array($pg_function, $values, $overwrite=array())
{
    // stabileste tipurile de date din functie
    $types = sql_from_array_types($pg_function);
    
    // suprascrie valorile fortate in lista de valori trimisa
    foreach ($overwrite as $key=>$value)
    {
        $values[$key] = $value;
    }
    
    // creaza string-ul
    $string = "(";
    foreach ($types as $key=>$value)
    {
        if ($values[$key] == 'null' || $values[$key] == '')
        {
            $string .= 'null,';
        }
        else
        {
            switch ($value)
            {
                case 'integer[]':
                case 'numeric[]':
                    //$string .= "null,";
                    if (is_array($values[$key]) && count($values[$key]) > 0)
                    {
                        $newvalue = "array[";
                        $count = 0;
                        foreach ($values[$key] as $key2=>$value2)
                        {
                            if (strlen($value2) > 0)
                            {
                                $newvalue .= $value2.",";
                                $count++;
                            }
                        }
                        if (strlen($newvalue) > 6) { $newvalue = substr($newvalue, 0, -1); }
                        $newvalue .= "]";
                        
                        if ($count == 0)
                        {
                            $newvalue = "null";
                        }
                    }
                    else
                    {
                        $newvalue = "null";
                    }
                    
                    $string .= $newvalue.",";
                    break;
                case 'varchar[]':
                    //$string .= "null,";
                    if (is_array($values[$key]) && count($values[$key]) > 0)
                    {
                        $newvalue = "array[";
                        $count = 0;
                        foreach ($values[$key] as $key2=>$value2)
                        {
                            if (strlen($value2) > 0)
                            {
                                $newvalue .= "'".$value2."',";
                                $count++;
                            }
                        }
                        if (strlen($newvalue) > 6) { $newvalue = substr($newvalue, 0, -1); }
                        $newvalue .= "]";
                        
                        if ($count == 0)
                        {
                            $newvalue = "null";
                        }
                    }
                    else
                    {
                        $newvalue = "null";
                    }
                    
                    $string .= $newvalue.",";
                    break;
                case 'varchar':
                case 'date':
                case 'timestamp':
                case 'char':
                    $string .= "'".$values[$key]."',";
                    break;
                case 'numeric':
                case 'integer':
                case 'float':
                    $string .= floatval($values[$key]).",";
                    break;
            }
        }
    }
    if (strlen($string) > 1) { $string = substr($string, 0, -1); } $string .= ")";
    
    return $string;
}

function sql_from_array_types($string)
{
    $array = array();
    
    if (isset($_SESSION['sql_insert'][md5($pg_function)]))
    {
        $array = $_SESSION['sql_insert'][md5($pg_function)];
    }
    else
    {
        // clean comments from function
        $string = preg_replace('/(\s\s+|\t|\n)/', "\n", $string);
        $string = preg_replace('/--([^\n]+)/'."\n", '', $string);
        $string = preg_replace('/(\s\s+|\t|\n)/', " ", $string);
        
        // create the array with values
        preg_match('/\(([^\)]+)\)/', $string, $match);
        $string = preg_replace('/(\s\s+|\t|\n)/', ' ', $match[1]);
        
        $work = explode(",", $string);
        foreach ($work as $key=>$value)
        {
            if (substr(trim($value), 0, 6) == 'param$' || substr(trim($value), 0, 6) == 'array$')
            {
                $row = substr(trim($value), 6);
                $parts = explode(" ", $row);
                $array[trim($parts[0])] = trim($parts[1]);
            }
        }
        
        // store the array in the session
        //$_SESSION['sql_insert'][md5($pg_function)] = $array;
    }
    
    return $array;
}

/*
 Cod pentru curatarea array-urilor
*/
function sanitize($input)
{
    if (is_array($input))
    {
        foreach($input as $var=>$val)
        {
            $output[$var] = sanitize($val);
        }
    }
    else
    {
        if (get_magic_quotes_gpc())
        {
            $input = stripslashes($input);
        }
        $output = pg_escape_string($input);
    }
    
    return $output;
}

/*
 Redirectionare pagina
*/
function redirect($url)
{
    // curata continutul paginii pentru redirectionare din header()
    ob_clean();
    
    // redirectionarea propriu-zisa
    header("location: ".$url);
    exit;
}

/*
 Converteste string-ul primit ca json de la Extjs intr-un array
 --> de modificat, daca $_POST devine mai complex
*/
function convert_json_to_array($data)
{
    $output = array();
    
    
    if (is_array($data))
    {
        foreach ($data as $key=>$value)
        {
            $decode = @json_decode($value, true);
            if ($decode != null)
            {
                $output[$key] = $decode;
            }
            else
            {
                $output[$key] = $value;
            }
        }
    }
    
    
    return $output;
}

# read the content of a file
function r ($x)
{
 	if (file_exists($x))
    {
		$file = @fopen($x, "r");
		$size = filesize($x);
		if ($size == 0)
        {
            $size = "32";
        }
		$data = @fread($file, $size);
		return $data;
 	}
    else
    {
        return false;
    }
}

# write to a file
function w ($x, $data, $type='w')
{
    // Create the path 
    @mkdir(dirname($x), 0777, true);
    
    // Write to file
   	$numefisier=@fopen($x,$type);
   	$return = true;
    if (@fwrite($numefisier, $data) === FALSE)
    {
        $return = false;
    }
    @fclose($numefisier);
    
    // change file permissions
    //@chmod($x, 777);
    
    return $return; 
}
?>