<?php /* Starfish Framework Template protection */ die(); ?>
<style type="text/css">* { margin: 0; padding: 0; } </style>
    
<script type="text/javascript">
    var site_url        = '<?php echo starfish::config('_starfish', 'site_url'); ?>';
    var proxy_url       = '<?php echo starfish::config('_starfish', 'proxy_url'); ?>';
    var geoserver_url   = '<?php echo starfish::config('_starfish', 'geoserver_url'); ?>';
    var wms_url         = '<?php echo starfish::config('_starfish', 'wms_url'); ?>';
    var wfs_url         = '<?php echo starfish::config('_starfish', 'wfs_url'); ?>';
    var tilecache_url   = '<?php echo starfish::config('_starfish', 'tilecache_url'); ?>';
    
    <?php
    echo "\n";
    if (is_array($_GET) && count($_GET) > 0)
    {
        foreach ($_GET as $key=>$value)
        {
            if ($key != 'unsanitized' && !is_array($value))
            {
                echo "\t\t".'var ' . $key . " = '".$value."';\n";
            }
        }
    }
    ?>
    
    if (typeof p1 == 'undefined') { var p1 = 'B'; }
    if (typeof p2 == 'undefined') { var p2 = '1'; }
    
    window.onload=function(){ init(); };
</script>

<script type="text/javascript" src="{/}libraries/OpenLayers-2.12/OpenLayers.js"></script>
<script type="text/javascript" src="{/}maps/javascript/embedded_globals.js"></script>
<script type="text/javascript" src="{/}maps/javascript/<?php echo $map; ?>"></script>
    
<div name="map" id="map" class="map">
    <div name="infobox" id="infobox" class="infobox">
        <div name="infoboxright" id="infoboxright" class="infoboxright"></div>
        <div name="infoboxtop" id="infoboxtop" class="infoboxtop"></div>
        <div name="infoboxbottom" id="infoboxbottom" class="infoboxbottom"></div>
    </div>
</div>