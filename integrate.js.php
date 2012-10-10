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
?>

<?php 
include("config.php"); 
header("Content-type: text/javascript"); 
?>
var site_url = '<?php echo $config['site_url']; ?>';
var proxy_url = '<?php echo $config['proxy_url']; ?>';
var geoserver_url = '<?php echo $config['geoserver_url']; ?>';
var wms_url = '<?php echo $config['wms_url']; ?>';
var tilecache_url = '<?php echo $config['tilecache_url']; ?>';

if (typeof loaded_scripts == 'undefined')   { var loaded_scripts = new Array(); }
if (typeof loaded_css == 'undefined')       { var loaded_css = new Array(); }

// Check if div exists
if (typeof existsDiv != 'function')
{
    function existsDiv(div)
	{
		var o = document.getElementById(div);
		if (o) 
        {
			return true;
		}
		
		return false;
	}
}
// Create a div
if (typeof createDiv != 'function')
{
    function createDiv(name, ref, sstyle, cssclass, callback)
    {
        if (existsDiv(name) == false)
        {
            var fileref=document.createElement('div');
            fileref.setAttribute("name", name);
            fileref.setAttribute("id", name);
            fileref.setAttribute("class", cssclass);
            if (typeof sstyle == 'string' && sstyle.length > 0)
            {
                fileref.style.cssText = sstyle;
            }
            
            if (ref == 'body')
            {
                document.body.appendChild(fileref)
            }
            else
            {
                document.getElementById(ref).appendChild(fileref);
            }
            
            callback();
        }
        else
        {
            alert("A map can only be integrated once on a page!");
        }
    }
}

// Load script file
if (typeof loadScript != 'function')
{
    function loadScript(src, name, callback)
    {
        if (typeof loaded_scripts[src] == 'undefined')
        {
            loaded_scripts[src] = false;
            
            var scriptFile = document.createElement("script");
            scriptFile.type = "text/javascript"; 
            scriptFile.name = name; 
            scriptFile.id   = name; 
            scriptFile.async = false;
            scriptFile.src = src;
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(scriptFile, s);
            
            if (scriptFile.addEventListener) { // normal browsers
                scriptFile.addEventListener('load', function(){
                    loaded_scripts[src] = true;
                    callback();
                }, false);
            } else {
                scriptFile.onreadystatechange = function() { // old IEs
                    if (scriptFile.readyState in {loaded: 1, complete: 1}) {
                        scriptFile.onreadystatechange = null;
                        loaded_scripts[src] = true;
                        callback();
                    }
                };
            }
        }
        else
        {
            if (loaded_scripts[src] == true)
            {
                callback();
            }
            else
            {
                var retry_callback = setInterval(function(){
                    if (loaded_scripts[src] == true)
                    {
                        clearInterval(retry_callback);
                        callback();
                    }
                }, 100);
            }
        }
    }
}

// Load CSS file
if (typeof loadCss != 'function')
{
    function loadCss(src, callback)
    {
        if (typeof loaded_css[src] == 'undefined')
        {
            loaded_css[src] = true;
            
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = src;
            document.getElementsByTagName('head')[0].appendChild(link);
            
            callback();
        }
    }
}

// Run the script
<?php $map_id = str_replace(array('<', '>'), '', $_GET['id']); ?>
<?php $mapstyle = str_replace(array('<', '>'), '', base64_decode($_GET['code'])); ?>

loadCss(site_url + "lib/OpenLayers-2.12/theme/default/style.css", function(){
    loadCss(site_url + "public/css/gis/embedded_map.css", function(){});
});

loadScript(site_url + "lib/OpenLayers-2.12/OpenLayers.js", 'openlayers',function(){
    loadScript(site_url + "gis/js/embedded_globals.js", 'embedded_globals', function(){
        switch (<?php echo $map_id; ?>)
        {
            case 1:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2012_County_Council_President.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 2:
                createDiv('map_mm', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_mm', 'map_mm', '', 'infobox', function(){
                        createDiv('infoboxright_mm', 'infobox_mm', '', '', function(){});
                        createDiv('infoboxtop_mm', 'infobox_mm', '', '', function(){});
                        createDiv('infoboxbottom_mm', 'infobox_mm', '', '', function(){
                            loadScript(site_url + 'gis/js/2012_Municipality_Mayor.js', 'mmap_url', function(){ mm_init(); });
                        });
                    });
                });
                break;
            case 3:
                createDiv('map_mmtc', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_mmtc', 'map_mmtc', '', 'infobox', function(){
                        createDiv('infoboxright_mmtc', 'infobox_mmtc', '', '', function(){});
                        createDiv('infoboxtop_mmtc', 'infobox_mmtc', '', '', function(){});
                        createDiv('infoboxbottom_mmtc', 'infobox_mmtc', '', '', function(){
                            loadScript(site_url + 'gis/js/2012_Municipality_Mayor_True_Colors.js', 'mmap_url', function(){ init(); });
                        });
                    });
                });
                break;
            case 4:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2010_employees.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
				
            case 5:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2010_graduates.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 6:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2011_households_census.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 7:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2011_population_census.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 8:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2008_2012_cd.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 9:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2008_2012_cd_presence.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 10:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2008_2012_cd_rebel.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 11:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2008_2012_sen.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 12:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2008_2012_sen_presence.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
            case 13:
                createDiv('map_ccp', 'map_<?php echo $map_id; ?>', '<?php echo $mapstyle; ?>', '', function(){
                    createDiv('infobox_ccp', 'map_ccp', '', 'infobox', function(){
                        createDiv('infoboxright_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxtop_ccp', 'infobox_ccp', '', '', function(){});
                        createDiv('infoboxbottom_ccp', 'infobox_ccp', '', '', function(){
                            loadScript(site_url + 'gis/js/2008_2012_sen_rebel.js', 'mmap_url', function(){ ccp_init(); });
                        });
                    });
                });
                break;
        }
    });
});