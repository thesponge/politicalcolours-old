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

// Init the site
define(inside_app, true);
define(root, '');
include(root . 'system/core.php');

// Define the current page
$page = $_GET['p'];
if (!file_exists(root . 'system/application/' . $page . '.php') || $page == 'header' || $page == 'footer')
{
    $page = 'harti';
}

// Show the site
include(root . 'system/application/header.php');
include(root . 'system/application/' . $page . '.php');
include(root . 'system/application/footer.php');
?>