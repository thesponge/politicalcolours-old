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

var webSiteURL = site_url;
var wmsUrl = wms_url;
var tilecacheUrl = tilecache_url;
var proxyUrl = proxy_url + "/cgi-bin/proxy.cgi?url=";

var pls_blank_image_url = webSiteURL + "public/css/gis/images/s.gif";


var hartaPoliticiiUrl = "http://hartapoliticii.ro/?name=";

var _server_resolutions = [1411.111111,1058.333333,705.5555556,352.7777778,264.5833333,176.3888889,88.19444444,35.27777778,17.63888889,8.819444444];
var _map_bounds = new OpenLayers.Bounds(96385.30,211289.80,908484.10,778129.20);
var _map_projection31700 = new OpenLayers.Projection('EPSG:31700');

var judeteJsonURL = webSiteURL + "objects/data.php?mode=judete";
var partide2012JsonURL = webSiteURL + "objects/data.php?mode=partide";
var partide2008SenatJsonURL = webSiteURL + "objects/data.php?mode=partide_senat_2008";
var partide2008CDepJsonURL = webSiteURL + "objects/data.php?mode=partide_deputati_2008";

var searchLocationURL = webSiteURL + "objects/data.php?mode=map_search_location";
var legendURL_1loc = webSiteURL + "/maps/html/legend_1loc.html";
var legendURL_2dep = webSiteURL + "/maps/html/legend_2dep.html";
var legendURL_3sen = webSiteURL + "/maps/html/legend_3sen.html";
var legendURL_4stat = webSiteURL + "/maps/html/legend_4stat.html";


// custom layer node UI class
var LayerNodeUI = Ext.extend(
GeoExt.tree.LayerNodeUI, new GeoExt.tree.TreeNodeUIEventMixin());

var toggleGroup = "map controls";
var control, action, toolbarItems = [],
    footerbarItems = [];
    
var global_coox = 502434.7;
var global_cooy = 494709.5;
var global_zoomLevelInit = 1;

var styleOMC = new OpenLayers.StyleMap({
    "default": new OpenLayers.Style(null, {
        rules: [new OpenLayers.Rule({
            name: 'Hoover',
            symbolizer: {
                "Polygon": {
                    strokeWidth: 8,
                    strokeOpacity: 0.9,
                    strokeColor: "purple",
                    fillColor: "#383c4d",
                    fillOpacity: 0.2
                }
            }
        })]
    })
});

var mapOptions = {
    allOverlays: true,
    projection: _map_projection31700,
    units: "m",
    numZoomLevels: 10,
    maxExtent: _map_bounds,
    restrictedExtent: _map_bounds,
    resolutions: _server_resolutions
};

var _layer_option0 = {
    projection: _map_projection31700,
    units: "m",
    maxExtent: _map_bounds,
    maxResolution: 1411.111111,
    buffer: 0,
    gutter: 0,
    ratio: 1,
    tileSize: new OpenLayers.Size(512, 512),
    singleTile: false
};


var _layer_option2 = {
    projection: _map_projection31700,
    units: "m",
    maxExtent: _map_bounds,
    maxResolution: 1411.111111,
    buffer: 0,
    gutter: 0,
    ratio: 1,
    singleTile: true
};


// global layers
var lOpenStreetMap = new OpenLayers.Layer.TileCache("OpenStreetMap", [tilecacheUrl], "omc_osm", {
    maxResolution: 1411.111111,
    buffer: 1,
    gutter: 0,
    transitionEffect: 'resize',
    tileSize: new OpenLayers.Size(512, 512),
    displayInLayerSwitcher: false,
    visibility: false,
    attribution: 'Map data &#169; OpenStreetMap contributors' //+ curDate.getFullYear() //2011'
});

var lAdminBorder = new OpenLayers.Layer.TileCache("Admin", [tilecacheUrl], "omc_admin", {
    maxResolution: 1411.111111,
    buffer: 1,
    gutter: 0,
    tileSize: new OpenLayers.Size(512, 512),
    displayInLayerSwitcher: false,
    visibility: true
});

var lAdminBorderSen = new OpenLayers.Layer.TileCache("AdminSen", [tilecacheUrl], "omc_admin_sen", {
    maxResolution: 1411.111111,
    buffer: 1,
    gutter: 0,
    tileSize: new OpenLayers.Size(512, 512),
    displayInLayerSwitcher: false,
    visibility: true
});

var lAdminBorderDep = new OpenLayers.Layer.TileCache("AdminDep", [tilecacheUrl], "omc_admin_dep", {
    maxResolution: 1411.111111,
    buffer: 1,
    gutter: 0,
    tileSize: new OpenLayers.Size(512, 512),
    displayInLayerSwitcher: false,
    visibility: true
});




var lAdminBorderLabel = new OpenLayers.Layer.WMS("Admin Label", wmsUrl, {
    layers: 'ro_admin_gr_label',
    transparent: true,
    format: 'image/png',
    displayInLayerSwitcher: false
}, _layer_option2);

var lAdminBorderLabelDep = new OpenLayers.Layer.WMS("Admin Label Dep", wmsUrl, {
    layers: 'ro_admin_gr_colegii_dep_label',
    transparent: true,
    format: 'image/png',
    displayInLayerSwitcher: false
}, _layer_option2);

var lAdminBorderLabelSen = new OpenLayers.Layer.WMS("Admin Label Sen", wmsUrl, {
    layers: 'ro_admin_gr_colegii_sen_label',
    transparent: true,
    format: 'image/png',
    displayInLayerSwitcher: false
}, _layer_option2);

var hover = new OpenLayers.Layer.Vector("Hover", {
    styleMap: styleOMC,
    displayInLayerSwitcher: false,
    attribution: '<a href="http://www.politicalcolours.ro/colab.html" style="color:#fff;"> Copyright Notice</a>' //+ curDate.getFullYear() //2011'
}, _layer_option2);

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
};