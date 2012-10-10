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

$config = array(
    'db_host'    => 'localhost',
    'db_port'    => '5432',
    'db_user'    => '---',
    'db_pass'    => '---',
    'db_db'      => '---',
    
    'site_url'      => 'http://'.$_SERVER['HTTP_HOST'].'/',
    'proxy_url'     => 'http://'.$_SERVER['HTTP_HOST'].'/',
    'geoserver_url' => 'http://192.168.10.123:8818/geoserver/omc/wms?',
    'wms_url'       => "http://89.120.31.156:8818/geoserver/omc/wms?",
    'tilecache_url' => "http://89.120.31.156:80/tilecache/cache/",
    
    'site_title'    => 'Political colours of Romania interactively mapped',
    'site_descr'    => 'Open Media Challenge',
    
    'site_cache'    => '0',
    'cache_time'    => '2', // in minutes
    'cache_root'    => 'cache/',
);
?>