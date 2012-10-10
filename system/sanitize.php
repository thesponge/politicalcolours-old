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

if (!is_included) { die(); }

function addslashes_once($input){
    //These characters are single quote ('), double quote ("), backslash (\) and NUL (the NULL byte).
    $pattern = array("\\'", "\\\"", "\\\\", "\\0");
    $replace = array("", "", "", "");
    if(preg_match("/[\\\\'\"\\0]/", str_replace($pattern, $replace, $input))){
        return addslashes($input);
    }
    else{
        return $input;
    }
}
function sanitize_clean($str) 
{  
    $str = str_replace('%','',$str);
    $str  = @trim($str);
    //$str = htmlentities($str);
    
    if(version_compare(phpversion(),'4.3.0') >= 0) 
    {
    	if(get_magic_quotes_gpc()) 
        {
    	    $str = stripslashes($str);
    	}
    	if(@pg_ping()) 
        {
    	    $str = pg_escape_string($str);
    	}
    	else 
        {
    	    $str = addslashes_once($str);
    	}
    }
    else 
    {
    	if(!get_magic_quotes_gpc()) 
        {
    	    $str = addslashes_once($str);
    	}
    }
    return $str;
}
function sanitize_strips(&$el) 
{
    if (is_array($el))
    {
        foreach($el as $k=>$v) 
        {
            if ($k != 'unsanitized')
            {
                sanitize_strips($el[$k],$k);
            }
        }
    } 
    else 
    {
        $el = sanitize_clean($el);
    }
}

$_GET['unsanitized'] = $_GET;       sanitize_strips($_GET);
$_POST['unsanitized'] = $_POST;     sanitize_strips($_POST);
$_COOKIE['unsanitized'] = $_COOKIE; sanitize_strips($_COOKIE);
$_SERVER['unsanitized'] = $_SERVER; sanitize_strips($_SERVER);
 
//unset($_REQUEST);
?>
