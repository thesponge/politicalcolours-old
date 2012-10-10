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
?><script type="text/javascript" src="<?php echo conf::val('site_url'); ?>lib/ext-3.4.0/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>lib/ext-3.4.0/ext-all.js"></script>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>lib/OpenLayers-2.12/OpenLayers.js"></script>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>lib/GeoExt/script/GeoExt.js"></script>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>lib/GeoNamesSearchCombo.js"></script>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>gis/js/map_globals.js"></script>

<div class="wrapper_harta">
    
<?php switch ($_GET['mode']): ?>
<?php case 'senat': ?>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>gis/js/map_senate.js"></script>
<?php break; ?>

<?php case 'deputati': ?>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>gis/js/map_deputies.js"></script>
<?php break; ?>

<?php case 'statistici': ?>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>gis/js/map_statistics.js"></script>
<?php break; ?>

<?php default: ?>
<?php case 'mainmap': ?>
<script type="text/javascript" src="<?php echo conf::val('site_url'); ?>gis/js/map_local.js"></script>
<?php break; ?>

<?php endswitch; ?>
<div class="harta" id="harta">
    <div id="infobox">
        <div id="infoboxright"></div>
        <div id="infoboxtop"></div>
        <div id="infoboxbottom"></div>
    </div>
</div>

</div>

<div class="wrapper_content rounded-bottom text-justify">
    <h2>About the project</h2>
    <p>
        The project offers open access in a friendly, interactive and visual way to public information regarding the spatial distribution of Romanian datasets referring to political preferences based on uninominal districts and 2011 national census data.
        [<a href="<?php echo conf::val('site_url'); ?>despre.html">...</a>]
    </p>
</div>