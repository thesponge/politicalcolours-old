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

if (inside_app != true) { die(); }

session_start();
ob_start();

include(root . 'config.php');
include(root . 'system/functions.php');
include(root . 'system/conf.php');
include(root . 'system/cache.php');
include(root . 'system/database.php');
include(root . 'system/json.php');

$conf   = conf::singleton();
$cache  = cache::singleton();
$db     = db::singleton();
$json   = json::singleton();

if (isset($_GET['params'])) 
{
    parse_get_params();
}

include(root . 'system/sanitize.php');
?>