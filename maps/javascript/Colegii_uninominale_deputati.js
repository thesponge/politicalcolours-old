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

var styleOMChp = new OpenLayers.StyleMap({
    "default": new OpenLayers.Style(null, {
        rules: [new OpenLayers.Rule({
            name: 'Hoover',
            symbolizer: {
                "Polygon": {
                    strokeWidth: 4,
                    strokeOpacity: 0.8,
                    strokeColor: "purple",
                    fillColor: "#383c4d",
                    fillOpacity: 0.3
                }
            }
        })]
    })
});

function init()
{
    var layerOne = 'Chamber of deputies';
    var map;
    
    OpenLayers.Number.thousandsSeparator = ' ';
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
    OpenLayers.ProxyHost = proxyUrl;
    

	lDep2008 = new OpenLayers.Layer.Vector(layerOne, {
        strategies: [new OpenLayers.Strategy.Fixed()],
        projection: _map_projection31700,
        protocol: new OpenLayers.Protocol.WFS({
            version: "1.0.0",
            url: wfsUrl,
            featureType: "ro_deputati_2008",
            featurePrefix: "omc",
            srsName: "EPSG:31700",
            geometryName: "the_geom"
        }),
		filter: new OpenLayers.Filter.Logical({
			type: OpenLayers.Filter.Logical.AND,
			filters: [
			new OpenLayers.Filter.Comparison({
				type: OpenLayers.Filter.Comparison.EQUAL_TO,
				property: "jud_code",
				value: p1
			}),
			new OpenLayers.Filter.Comparison({
				type: OpenLayers.Filter.Comparison.EQUAL_TO,
				property: "coldep",
				value: p2
			})
			]
		}),
        maxExtent: _map_bounds,
        styleMap: styleOMChp,
        extractAttributes: true,
        visibility: true
    	});

    var mapLayers = [lOpenStreetMap, lDep2008, lAdminBorderDep];
	map = new OpenLayers.Map('map', {
		controls: [],
        projection: _map_projection31700,
        units: "m",
        numZoomLevels: 10,
        maxExtent: _map_bounds,
        restrictedExtent: _map_bounds,
        resolutions: _server_resolutions
    });

    map.addLayers(mapLayers);

	if (!map.getCenter()) {
		map.zoomToMaxExtent();
	}


	lDep2008.events.register('loadend', lDep2008, function() {
		found_feature = lDep2008.features[0];
		if (found_feature===undefined) {
			map.zoomToMaxExtent();
		} else {
			map.setCenter(found_feature.geometry.bounds.getCenterLonLat());
			map.zoomToExtent(found_feature.geometry.bounds);
		}
	}
	);
}