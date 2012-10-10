<!--
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
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
    <title><?php echo conf::val('site_title'); ?></title>
    <link rel="shortcut icon" href="<?php echo conf::val('site_url'); ?>public/images/ico.png" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo conf::val('site_url'); ?>lib/ext-3.4.0/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo conf::val('site_url'); ?>lib/ext-3.4.0/resources/css/xtheme-access.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo conf::val('site_url'); ?>public/css/gis/mainmap.css" />

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo conf::val('site_url'); ?>public/css/normalize.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo conf::val('site_url'); ?>public/css/grids.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo conf::val('site_url'); ?>public/css/pagination.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo conf::val('site_url'); ?>public/css/common.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo conf::val('site_url'); ?>public/css/styles.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo conf::val('site_url'); ?>public/css/special.css" />
    
    <script type="text/javascript">
        var site_url = '<?php echo conf::val('site_url'); ?>';
        var proxy_url = '<?php echo conf::val('proxy_url'); ?>';
        
        var geoserver_url = '<?php echo conf::val('geoserver_url'); ?>';
        var wms_url = '<?php echo conf::val('wms_url'); ?>';
        var tilecache_url = '<?php echo conf::val('tilecache_url'); ?>';
    </script>
    <script type="text/javascript" src="<?php echo conf::val('site_url'); ?>public/scripts.js"></script>
</head>

<body>
    <div class="wrapper_site rounded-bottom">
    <div class="wrapper">
        <h1 class="treid_textd logo"><a href="<?php echo conf::val('site_url'); ?>">Political colours of Romania <span>interactively mapped</span></a></h1>
        
        <div class="menu">
            <ul class="horizontal">
                <li><a href="<?php echo conf::val('site_url'); ?>about.html"       class="<?php if ($_GET['p'] == 'despre') { echo 'active'; } ?>">About the project</a></li>
                <li><a href="<?php echo conf::val('site_url'); ?>integration.html"    class="<?php if ($_GET['p'] == 'integrare') { echo 'active'; } ?>">Integration</a></li>
                <li><a href="<?php echo conf::val('site_url'); ?>colab.html" class="<?php if ($_GET['p'] == 'colaboratori') { echo 'active'; } ?>">Collaborators and Data Sources</a></li>
                <li><a href="<?php echo conf::val('site_url'); ?>feedback.html"     class="<?php if ($_GET['p'] == 'feedback') { echo 'active'; } ?>">Feedback</a></li>
            </ul>
        </div>
    </div>
    
    <div class="wrapper clear">
        
        <div class="wrapper_header rounded-top">
                <div class="submenu rounded-top">
                    <ul class="horizontal rounded-top">
                        <li><span>Available maps:</span></li>
                        <li><a href="<?php echo conf::val('site_url'); ?>local.html"       class="<?php if (($_GET['p'] == 'harti' || $_GET['p'] == '') && ($_GET['mode'] == 'mainmap' || $_GET['mode'] == '')) { echo 'active treid_text'; } ?>">Local Administration</a></li>
                        <li><a href="<?php echo conf::val('site_url'); ?>deputies.html"      class="<?php if (($_GET['p'] == 'harti' || $_GET['p'] == '') && $_GET['mode'] == 'deputati') { echo 'active treid_text'; } ?>">Chamber of Deputies</a></li>
                        <li><a href="<?php echo conf::val('site_url'); ?>senate.html"         class="<?php if (($_GET['p'] == 'harti' || $_GET['p'] == '') && $_GET['mode'] == 'senat') { echo 'active treid_text'; } ?>">Senate</a></li>
                        <li><a href="<?php echo conf::val('site_url'); ?>statistics.html"    class="<?php if (($_GET['p'] == 'harti' || $_GET['p'] == '') && $_GET['mode'] == 'statistici') { echo 'active treid_text'; } ?>">Statistics</a></li>
                    </ul>
                </div>
                
                <div class="clear"></div>
        </div>