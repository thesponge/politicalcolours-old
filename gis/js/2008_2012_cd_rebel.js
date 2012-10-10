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

function ccp_init() {
    var control, action, toolbarItems = [],
        footerbarItems = [];
    var layerOne = '2008 - 2012 Chamber<br/>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;  of Deputies - Rebel voting';

    var map;

    OpenLayers.Number.thousandsSeparator = ' ';
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;

    OpenLayers.ProxyHost = proxyUrl;

    var lCDep2008Rebel = new OpenLayers.Layer.WMS(layerOne, wmsUrl, {
        layers: 'omc:ro_deputati_2008',
        transparent: true,
        format: 'image/png',
        width: 512,
        styles: 'ro_parlament_rebel',
        height: 512,
        tilesOrigin: "0,211289.80",
        visibility: false
    }, _layer_option0);

    var mapLayers = [lOpenStreetMap, lCDep2008Rebel, hover, lAdminBorderDep, lAdminBorderLabelDep];

    map = new OpenLayers.Map('map_ccp', {
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

    var layerOneProtocol = OpenLayers.Protocol.WFS.fromWMSLayer(lCDep2008Rebel, {
        featurePrefix: "omc",
        featureNS: "http://www.opengeospatial.net/omc",
        featureType: "ro_deputati_2008",
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
        content += '<i><p style="font-size: 16px;">2008 - 2012 Chamber of Deputies</p></i>';
        content += '<b><p style="font-size: 16px;">' + e.features[0].attributes.nume + '</p></b>';
        content += '<i>Uninominal college: </i><b>D' + e.features[0].attributes.coldep + ' - ' + e.features[0].attributes.jud_lbl + ' </b></br>';
        content += '<i>Political Organisation: </i><b> ' + e.features[0].attributes.partid + ' (' + e.features[0].attributes.abv_partid + ') </b></br>';
        content += '<i>Electronic voting presence: </i><b> ' + e.features[0].attributes.prezenta + '% </b></br>';
        content += '<i>Rebel voting (defying the party instructions): </i><b> ' + e.features[0].attributes.rebel + '% </b></br></br>';
        content += '<i>Read more <A HREF="' + hartaPoliticiiUrl + e.features[0].attributes.nume.split(" ").join("+") + '" TARGET="_blank">www.hartapoliticii.ro</A></i></br>';
        content += '</div>';

        document.getElementById('infobox_ccp').style.display = "block";
        document.getElementById('infobox_ccp').className = 'infobox';
        document.getElementById('infoboxbottom_ccp').innerHTML = content;
    });
    featureInfo.events.register("featureunselected", this, function(e) {
        hover.removeFeatures([e.feature]);
        document.getElementById('infobox_ccp').style.display = "none";
    });

    map.addControl(featureInfo);
    featureInfo.activate();

    if (!map.getCenter()) {
        map.zoomToMaxExtent();
    }
};