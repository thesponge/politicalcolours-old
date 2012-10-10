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


function mm_init() {
    var control, action, toolbarItems = [],
        footerbarItems = [];
    var layerOne = '2012 - Municipality Mayor';
    
    var map;

    OpenLayers.Number.thousandsSeparator = ' ';
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;

    OpenLayers.ProxyHost = proxyUrl;

    var lPrimari2012 = new OpenLayers.Layer.WMS(layerOne, wmsUrl, {
        layers: 'omc:ro_uat_primari_2012',
        transparent: true,
        format: 'image/png',
        width: 512,
        styles: 'ro_uat_primari_2012',
        height: 512,
        tilesOrigin: "0,211289.80",
        visibility: true
    }, _layer_option0);

    var mapLayers = [lOpenStreetMap, lPrimari2012, hover, lAdminBorder, lAdminBorderLabel];
    map = new OpenLayers.Map( 'map_mm', {
            projection: _map_projection31700,
            units: "m",
            numZoomLevels: 10,
            maxExtent: _map_bounds,
            restrictedExtent: _map_bounds,
            resolutions: _server_resolutions});
    
    //map
    map.addLayers(mapLayers);
    map.addControl(new OpenLayers.Control.LayerSwitcher());



    //hoover and select	
    var featureInfo = new OpenLayers.Control.GetFeature({
        box: false,
        click: true,
        maxFeatures: 10,
        hover: false,
        clickout: true,
        multiple: false,
        single: true,
        clickTolerance: 20
    });

    var layerOneProtocol = OpenLayers.Protocol.WFS.fromWMSLayer(lPrimari2012, {
        featurePrefix: "omc",
        featureNS: "http://www.opengeospatial.net/omc",
        featureType: "ro_uat_primari_2012",
        geometryName: "the_geom",
        version: "1.0.0",
        url: geoserver_url,
        PropertyName: "id_primar"
    });

    featureInfo.protocol = layerOneProtocol;

    var popup;

    featureInfo.events.register("featuresselected", this, function(e) {

        hover.addFeatures([e.features[0]]);
        var content = '<div class="info">';
            content += '<i><p style="font-size: 16px;">Local Elections - 2012 - Municipality Mayor</p></i>';
            content += '<b><p style="font-size: 16px;">' + e.features[0].attributes.primar + '</p></b>';
            content += '<i>County: </i><b>' + e.features[0].attributes.jud_lbl + ' </b></br>';
            content += '<i>Municipality: </i><b>' + e.features[0].attributes.uat_lbl + ' </b></br>';
            content += '<i>Political Organisation: </i><b>' + e.features[0].attributes.partid + ' (' + e.features[0].attributes.abv_partid + ') </b></br>';
            content += '</div>';

        document.getElementById('infobox_mm').style.display = "block";
        document.getElementById('infobox_mm').className = 'infobox';
        document.getElementById('infoboxbottom_mm').innerHTML = content;
    });
    featureInfo.events.register("featureunselected", this, function(e) {
        hover.removeFeatures([e.feature]);
        document.getElementById('infobox_mm').style.display = "none";
    });

    map.addControl(featureInfo);
    featureInfo.activate();

    if (!map.getCenter()) {
        map.zoomToMaxExtent();
    }
};