<?php /* Starfish Framework Template protection */ die(); ?>
<link rel="stylesheet" type="text/css" href="{/}libraries/ext-3.4.0/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="{/}libraries/ext-3.4.0/resources/css/xtheme-gray.css" />
<link rel="stylesheet" type="text/css" href="{/}maps/css/mainmap.css" />
<script type="text/javascript">
    var site_url = '<?php echo starfish::config('_starfish', 'site_url'); ?>';
    var proxy_url = '<?php echo starfish::config('_starfish', 'proxy_url'); ?>';
    
    var geoserver_url = '<?php echo starfish::config('_starfish', 'geoserver_url'); ?>';
    var wms_url = '<?php echo starfish::config('_starfish', 'wms_url'); ?>';
    var wfs_url = '<?php echo starfish::config('_starfish', 'wfs_url'); ?>';
    var tilecache_url = '<?php echo starfish::config('_starfish', 'tilecache_url'); ?>';
</script>
<script type="text/javascript" src="{/}maps/javascript/scripts.js"></script>

<script type="text/javascript" src="{/}libraries/ext-3.4.0/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="{/}libraries/ext-3.4.0/ext-all.js"></script>
<script type="text/javascript" src="{/}libraries/OpenLayers-2.12/OpenLayers.js"></script>
<script type="text/javascript" src="{/}libraries/GeoExt/script/GeoExt.js"></script>
<script type="text/javascript" src="{/}libraries/GeoNamesSearchCombo.js"></script>
<script type="text/javascript" src="{/}maps/javascript/map_globals.js"></script>

<?php switch ($mode): ?>

<?php default: ?>
<?php case 'local': ?>
<script type="text/javascript" src="{/}maps/javascript/map_local.js"></script>
<?php break; ?>

<?php case 'deputies': ?>
<script type="text/javascript" src="{/}maps/javascript/map_deputies.js"></script>
<?php break; ?>

<?php case 'senate': ?>
<script type="text/javascript" src="{/}maps/javascript/map_senate.js"></script>
<?php break; ?>

<?php case 'statistics': ?>
<script type="text/javascript" src="{/}maps/javascript/map_statistics.js"></script>
<?php break; ?>

<?php endswitch; ?>


<div class="wrapper_harta">
    <div class="harta" id="harta">
        <div id="infobox">
            <div id="infoboxright"></div>
            <div id="infoboxtop"></div>
            <div id="infoboxbottom"></div>
        </div>
    </div>
</div>