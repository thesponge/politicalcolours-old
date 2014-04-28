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

function init()
{
    var control, action, toolbarItems = [],
        footerbarItems = [];
    var layerOne = '2010 Graduates';

    var map;

    OpenLayers.Number.thousandsSeparator = ' ';
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;

    OpenLayers.ProxyHost = proxyUrl;

	var lStat2010Abs = new OpenLayers.Layer.WMS(layerOne, wmsUrl, {
        layers: 'omc:ro_statistici_2010',
        transparent: true,
        format: 'image/png',
        width: 512,
        styles: 'ro_absolventi_2010',
        height: 512,
        tilesOrigin: "0,211289.80",
        visibility: true
    }, _layer_option0);

    var mapLayers = [lOpenStreetMap, lStat2010Abs, lAdminBorder, hover, lAdminBorderLabel];

    map = new OpenLayers.Map('map', {
        projection: _map_projection31700,
        units: "m",
        numZoomLevels: 10,
        maxExtent: _map_bounds,
        restrictedExtent: _map_bounds,
        resolutions: _server_resolutions
    });

    //map
    //var map = new OpenLayers.Map('map', mapOptions);
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

    var layerOneProtocol = OpenLayers.Protocol.WFS.fromWMSLayer(lStat2010Abs, {
        featurePrefix: "omc",
        featureNS: "http://www.opengeospatial.net/omc",
        featureType: "ro_statistici_2010",
        geometryName: "the_geom",
        version: "1.0.0",
        url: geoserver_url,
        PropertyName: "gid"
    });

    featureInfo.protocol = layerOneProtocol;

    var popup;

    featureInfo.events.register("featuresselected", this, function(e) {

        hover.addFeatures([e.features[0]]);
        var content = '<div class="info">';
        content += '<i><p style="font-size: 16px;">Census data</p></i>';
        content += '<b><p style="font-size: 16px;">' + e.features[0].attributes.uat_name + '</p></b>';
        content += '<i>County:</i> <b>' + e.features[0].attributes.jud_lbl + ' </b></br>';
        content += '<i>Municipality: </i><b>' + e.features[0].attributes.uat_lbl + ' </b></br>';
        content += '<i>2011 Population (preliminary data):</i> <b>' + e.features[0].attributes.total_locuitori + ' </b></br>';
        content += '<i>2011 Households (preliminary data):</i> <b>' + e.features[0].attributes.gospodarii + ' </b></br>';
		content += '<i>2010 Graduates:</i> <b>' + e.features[0].attributes.nr_absolventi + ' </b></br>';
		content += '<i>2010 Employees:</i> <b>' + e.features[0].attributes.nr_angajati + ' </b></br>';
        content += '</div>';

        document.getElementById('infobox').style.display = "block";
        document.getElementById('infobox').className = 'infobox';
        document.getElementById('infoboxbottom').innerHTML = content;
    });
    featureInfo.events.register("featureunselected", this, function(e) {
        hover.removeFeatures([e.feature]);
        document.getElementById('infobox').style.display = "none";
    });

    map.addControl(featureInfo);
    featureInfo.activate();

    if (!map.getCenter()) {
        map.zoomToMaxExtent();
    }
}