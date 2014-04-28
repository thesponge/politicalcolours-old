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

/** 
 *  Main Map
 *  ------------
 */
var activeLayer = '2008 - 2012 Chamber<br/>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;  of Deputies';
var layerOne = '2008 - 2012 Chamber<br/>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;  of Deputies';
var layerTwo = '2008 - 2012 Chamber<br/>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;  of Deputies - Electronic voting<br/>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; presence';
var layerThree = '2008 - 2012 Chamber<br/>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;  of Deputies - Rebel voting';

var filterOne = '1 = 1';
var filterTwo = ' AND 1 = 1';

var cookie_coox = getCookie('map_coox');
var cookie_cooy = getCookie('map_cooy');
var cookie_zoomLevelInit = getCookie('map_zoomLevelInit');
var cookie_layerOpacity = getCookie('map_layerOpacity');

if (typeof cookie_coox == 'undefined') {
    var coox = global_coox;
} else {
    var coox = parseInt(cookie_coox);
}
if (typeof cookie_cooy == 'undefined') {
    var cooy = global_cooy;
} else {
    var cooy = parseInt(cookie_cooy);
}
if (typeof cookie_zoomLevelInit == 'undefined') {
    var zoomLevelInit = global_zoomLevelInit;
} else {
    var zoomLevelInit = parseInt(cookie_zoomLevelInit);
}
if (typeof cookie_layerOpacity == 'undefined') {
    var layerOpacity = 100;
} else {
    var layerOpacity = parseInt(cookie_layerOpacity);
}

    
Ext.onReady(function() {
    Ext.QuickTips.init();
    Ext.BLANK_IMAGE_URL = pls_blank_image_url;
    OpenLayers.Number.thousandsSeparator = ' ';
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;

    OpenLayers.ProxyHost = proxyUrl;

    var lCDep2008 = new OpenLayers.Layer.WMS(layerOne, wmsUrl, {
        layers: 'omc:ro_deputati_2008',
        transparent: true,
        format: 'image/png',
        width: 512,
        styles: 'ro_deputati_2008',
        height: 512,
        tilesOrigin: "0,211289.80",
        visibility: true
    }, _layer_option0);

    var lCDep2008Presence = new OpenLayers.Layer.WMS(layerTwo, wmsUrl, {
        layers: 'omc:ro_deputati_2008',
        transparent: true,
        format: 'image/png',
        width: 512,
        styles: 'ro_parlament_prezenta',
        height: 512,
        tilesOrigin: "0,211289.80",
        visibility: false
    }, _layer_option0);

    var lCDep2008Rebel = new OpenLayers.Layer.WMS(layerThree, wmsUrl, {
        layers: 'omc:ro_deputati_2008',
        transparent: true,
        format: 'image/png',
        width: 512,
        styles: 'ro_parlament_rebel',
        height: 512,
        tilesOrigin: "0,211289.80",
        visibility: false
    }, _layer_option0);



    var mapLayers = [lOpenStreetMap, lCDep2008Rebel, lCDep2008Presence, lCDep2008, hover, lAdminBorderDep, lAdminBorderLabelDep];

    //map
    var map = new OpenLayers.Map(mapOptions);
    map.addLayers(mapLayers);
    lCDep2008Presence.setVisibility(false);
    lCDep2008Rebel.setVisibility(false);




    //zoom in
    action = new GeoExt.Action({
        control: new OpenLayers.Control.ZoomBox({
            title: "Zoom in box",
            alwaysZoom: true
        }),
        map: map,
        toggleGroup: toggleGroup,
        tooltip: "Zoom in box",
        iconCls: 'zoom_in_action',
        itemId: 'myActionZoomIn',
        enableToggle: true,
        allowDepress: false,
        handlerOptions: {
            "click": {
                delay: 100
            }
        },
        pressed: false
    });
    toolbarItems.push(action);

    //zoom out
    action = new GeoExt.Action({
        control: new OpenLayers.Control.ZoomBox({
            title: "Zoom out box",
            out: true,
            displayClass: 'olControlZoomOut'
        }),
        map: map,
        toggleGroup: toggleGroup,
        tooltip: "Zoom out box",
        iconCls: 'zoom_out_action',
        itemId: 'myActionZoomOut',
        allowDepress: false,
        handlerOptions: {
            "click": {
                delay: 100
            }
        },
        pressed: false
    });
    toolbarItems.push(action);
    //pan
    action = new GeoExt.Action({
        control: new OpenLayers.Control.DragPan({
            title: "Drag map",
            displayClass: 'olDragDown'
        }),
        map: map,
        toggleGroup: toggleGroup,
        tooltip: "Pan",
        iconCls: 'pan_map_action',
        itemId: 'myActionDragMap',
        allowDepress: false,
        handlerOptions: {
            "click": {
                delay: 100
            }
        },
        pressed: false
    });
    toolbarItems.push(action);

    ////zoom all
    var zoom_extent_button = new Ext.Button({
        tooltip: "Zoom full extent",
        iconCls: 'zoom_extent_action',
        handler: function() {
            this.setDisabled(false);
            map.setCenter(new OpenLayers.LonLat(global_coox, global_cooy), global_zoomLevelInit);
        }
    });
    toolbarItems.push(zoom_extent_button);

    //Navigation controls
    var navHistory = new OpenLayers.Control.NavigationHistory();
    navHistory.previous.title = "View history backward";
    navHistory.next.title = "View history forward";
    map.addControl(navHistory);

    //Initially disabled
    var buttonPrevious = new Ext.Button({
        iconCls: 'prevoff',
        tooltip: 'View history backward',
        disabled: true,
        handler: navHistory.previous.trigger
    });
    var buttonNext = new Ext.Button({
        iconCls: 'nextoff',
        tooltip: 'View history forward',
        disabled: true,
        handler: navHistory.next.trigger
    });

    toolbarItems.push(buttonPrevious);
    toolbarItems.push(buttonNext);

    navHistory.previous.events.register("activate", buttonPrevious, function() {
        this.setDisabled(false);
        this.setIconClass('prevon'); // set the icon when activated
    });
    navHistory.next.events.register("activate", buttonNext, function() {
        this.setDisabled(false);
        this.setIconClass('nexton'); // set the icon when activated
    });

    navHistory.previous.events.register("deactivate", buttonPrevious, function() {
        this.setDisabled(true);
        this.setIconClass('prevoff'); // set the icon when deactivated
    });
    navHistory.next.events.register("deactivate", buttonNext, function() {
        this.setDisabled(true);
        this.setIconClass('nextoff'); // set the icon when deactivated
    });

    //hoover and select	
    var featureInfo = new OpenLayers.Control.GetFeature({
        box: false,
        click: true,
        maxFeatures: 10,
        hover: false,
        toggleGroup: toggleGroup,
        clickout: true,
        multiple: false,
        single: true,
        clickTolerance: 20
    });

    var layerOneProtocol = OpenLayers.Protocol.WFS.fromWMSLayer(lCDep2008, {
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
        //Eliminate confusion: don't select not visible features
        if (judeteCombo.getValue() != 'AA' && judeteCombo.getValue() != 'All Counties') {
            if (e.features[0].attributes.jud_code != judeteCombo.getValue()) {
                return;
            }
        }

        if (partideCombo.getValue() != 0 && partideCombo.getValue() != ' All Political Organisations') {
            if (e.features[0].attributes.id_partid != partideCombo.getValue()) {
                return;
            }
        }
        hover.addFeatures([e.features[0]]);

        var content = '<div id="info" style="padding:3px 5px 3px 5px; font-size: 12px; font-family: verdana, sans-serif;width:350px;word-wrap: break-word;">';
        content += '<i><p style="font-size: 16px;">2008 - 2012 Chamber of Deputies</p></i>';
        content += '<b><p style="font-size: 16px;">' + e.features[0].attributes.nume + '</p></b>';
        content += '<i>Uninominal college: </i><b>D' + e.features[0].attributes.coldep + ' - ' + e.features[0].attributes.jud_lbl + ' </b></br>';
        content += '<i>Political Organisation: </i><b> ' + e.features[0].attributes.partid + ' (' + e.features[0].attributes.abv_partid + ') </b></br>';
        content += '<i>Electronic voting presence: </i><b> ' + e.features[0].attributes.prezenta + '% </b></br>';
        content += '<i>Rebel voting (defying the party instructions): </i><b> ' + e.features[0].attributes.rebel + '% </b></br></br>';
        content += '<i>Read more <A HREF="' + hartaPoliticiiUrl + e.features[0].attributes.nume.split(" ").join("+") + '" TARGET="_blank">www.hartapoliticii.ro</A></i></br>';
        content += '</div>';

        document.getElementById('infobox').style.display = "block";
        document.getElementById('infoboxbottom').innerHTML = content;
    });
    featureInfo.events.register("featureunselected", this, function(e) {
        hover.removeFeatures([e.feature]);
        document.getElementById('infobox').style.display = "none";
    });

    map.addControl(featureInfo);
    //featureInfo.activate();

    action = new GeoExt.Action({
        control: featureInfo,
        map: map,
        toggleGroup: toggleGroup,
        tooltip: "Information",
        iconCls: 'query_map',
        itemId: 'myActionFeatureInfo',
        enableToggle: true,
        allowDepress: false,
        //handlerOptions: {	"click": {delay: 10}},
        pressed: true
    });
    toolbarItems.push(action);
    toolbarItems.push("-");





    //Filtru judete

    var judeteStore = new Ext.data.Store({
        proxy: new Ext.data.ScriptTagProxy({
            url: judeteJsonURL,
            method: 'GET',
            disableCaching: false
        }),
        baseParams: {},
        reader: new Ext.data.JsonReader({
            idProperty: 'jud_code',
            root: "data",
            fields: [{
                name: 'jud_code'
            }, {
                name: 'jud_lbl'
            }, {
                name: 'minx'
            }, {
                name: 'miny'
            }, {
                name: 'maxx'
            }, {
                name: 'maxy'
            }]
        }),
        remoteSort: false
    });

    judeteStore.load();


    var judeteCombo = new Ext.form.ComboBox({
        id: 'judeteComboId',
        width: 130,
        maxHeight: 180,
        anchor: '100%',
        listWidth: this.width,
        editable: false,
        store: judeteStore,
        valueField: 'jud_code',
        displayField: 'jud_lbl',
        value: 'All Counties',
        tpl: '<tpl for=".">' + '<div ext:qtip="{jud_lbl}" class="x-combo-list-item">{jud_lbl}</div></tpl>',
        typeAhead: false,
        mode: 'local',
        triggerAction: 'all',
        emptyText: '...',
        selectOnFocus: false,
        forceSelection: true,
        style: {
            marginLeft: '5px'
        }
    });

    judeteCombo.on('select', function(box, record, index) {

        if (record.data.jud_code == 'AA') {
            filterOne = '1 = 1';
        } else {
            filterOne = "jud_code = '" + record.data.jud_code + "'";
            hover.removeAllFeatures();
            document.getElementById('infobox').style.display = "none";
        }



        lCDep2008.mergeNewParams({
            'CQL_FILTER': filterOne + filterTwo
        });
        lCDep2008Presence.mergeNewParams({
            'CQL_FILTER': filterOne + filterTwo
        });
        lCDep2008Rebel.mergeNewParams({
            'CQL_FILTER': filterOne + filterTwo
        });
        
        if (record.data.jud_code == 'AA') {
            map.setCenter(new OpenLayers.LonLat(global_coox, global_cooy), global_zoomLevelInit);
        } else {
            map.zoomToExtent(
            new OpenLayers.Bounds(
            record.data.minx, record.data.miny, record.data.maxx, record.data.maxy));
        };
    });
    toolbarItems.push(new Ext.Toolbar.TextItem("County "));
    toolbarItems.push(judeteCombo);
    toolbarItems.push("-");

    //Filtru partide

    var partideStore = new Ext.data.Store({
        proxy: new Ext.data.ScriptTagProxy({
            url: partide2008CDepJsonURL,
            method: 'GET',
            disableCaching: false
        }),
        baseParams: {},
        reader: new Ext.data.JsonReader({
            idProperty: 'id_partid',
            root: "data",
            fields: [{
                name: 'id_partid',
                type: 'integer'
            }, {
                name: 'partid'
            }]
        }),
        remoteSort: false
    });

    partideStore.load();


    var partideCombo = new Ext.form.ComboBox({
        id: 'partideComboId',
        width: 220,
        maxHeight: 180,
        anchor: '100%',
        listWidth: this.width,
        editable: false,
        store: partideStore,
        valueField: 'id_partid',
        displayField: 'partid',
        value: ' All Political Organisations',
        tpl: '<tpl for=".">' + '<div ext:qtip="{partid}" class="x-combo-list-item">{partid}</div></tpl>',
        typeAhead: false,
        mode: 'local',
        triggerAction: 'all',
        emptyText: 'Please Select',
        selectOnFocus: false,
        style: {
            marginLeft: '5px'
        },
        forceSelection: false,
        lastQuery: ''
    });

    partideCombo.on('select', function(box, record, index) {
        if (record.data.id_partid == 0) {
            filterTwo = ' AND 1 = 1';
        } else {
            filterTwo = " AND id_partid = '" + record.data.id_partid + "'";
            hover.removeAllFeatures();
            document.getElementById('infobox').style.display = "none";
        }

        lCDep2008.mergeNewParams({
            'CQL_FILTER': filterOne + filterTwo
        });
        lCDep2008Presence.mergeNewParams({
            'CQL_FILTER': filterOne + filterTwo
        });
        lCDep2008Rebel.mergeNewParams({
            'CQL_FILTER': filterOne + filterTwo
        });
        
    });
    toolbarItems.push("-");
    toolbarItems.push(new Ext.Toolbar.TextItem("Political org."));
    toolbarItems.push(partideCombo);
    toolbarItems.push("-");

    //search
    // controls for positionig
    var geoNameSearchCombo = new GeoExt.ux.GeoNamesSearchCombo({
        map: map,
        url: searchLocationURL,
        zoom: 7,
        //layer: searchAddressLayer,
        toggleGroup: toggleGroup,
        enableToggle: true,
        triggerAction: 'all',
        selectOnFocus: true,
        typeAhead: false,
        maxHeight: 180,
        width: 180,
        fieldLabel: 'A',
        hideLabel: false,
        autoCreate: {
            tag: "input",
            type: "text",
            maxlength: 50
        }
    });

    toolbarItems.push("-");
    toolbarItems.push(geoNameSearchCombo);

    var searchClearBtn = new Ext.Button({
        xtype: 'tbbutton',
        iconCls: 'localPositionClear',
        tooltip: 'Clear search',
        itemId: 'myLocationClear',
        handler: function(btn) {
            geoNameSearchCombo.emptyText = 'Search municipality...';
            geoNameSearchCombo.clearValue();
            geoNameSearchCombo.store.removeAll();
            geoNameSearchCombo.lastQuery = null;
        }
    });
    toolbarItems.push(searchClearBtn);

    //filter transparency
    var opcSlider = {
        id: "opacity_slider",
        xtype: "gx_opacityslider",
        plugins: new GeoExt.LayerOpacitySliderTip(),
        layer: lCDep2008,
        aggressive: false,
        vertical: false,
        width: 100,
        style: {
            marginLeft: '5px',
            marginRight: '25px'
        },
		listeners:{
			'changecomplete': function(slider, newValue, thumb ){
				layerOpacity = newValue;
				setCookie('map_layerOpacity', layerOpacity, 1);
			}
		}
        //height: 100,
        //x: 12,
        //y: 10
    };
    toolbarItems.push("->");
    toolbarItems.push(new Ext.Toolbar.TextItem("Transparency "));
    toolbarItems.push(opcSlider);
	
	//global opacity
	lCDep2008.setOpacity(layerOpacity/100);
	
    //panels MAP
    mapPanel = new GeoExt.MapPanel({
        region: 'center',
        stateId: "mappanel",
        id: "mappanel",
        map: map,
        center: new OpenLayers.LonLat(coox, cooy),
        zoom: zoomLevelInit,
        //frame: true,
        border: true,
        fb: toolbarItems
    });

    map.events.register('changelayer', null, function(evt) {
        if (evt.property === "visibility") {
            if (evt.layer.visibility) {
                if (evt.layer.name == layerOne || evt.layer.name == layerTwo || evt.layer.name == layerThree) {
                    hover.removeAllFeatures();
                    activeLayer = evt.layer.name;
                    console.log(evt.layer.name);
                    Ext.getCmp('opacity_slider').setLayer(evt.layer);
					Ext.getCmp('opacity_slider').setValue( layerOpacity, true );
					evt.layer.setOpacity(layerOpacity/100);
                    document.getElementById('infobox').style.display = "none";
                }
            }

        }
    });

    map.events.register('moveend', null, function(evt) {
        setCookie('map_zoomLevelInit', map.getZoom(), 1);
        setCookie('map_coox', map.getCenter().lon, 1);
        setCookie('map_cooy', map.getCenter().lat, 1);
    });
    
    var treeConfig = ([{
        nodeType: "gx_overlaylayercontainer",
        loader: {
            baseAttrs: {
                radioGroup: "foo",
                uiProvider: "use_radio",
                checkedGroup: "overlays"
            },
            filter: function(record) {
                return [layerThree, layerTwo, layerOne].indexOf(record.get('layer').name) > -1
            }

        },
        expanded: true
    }, {
        text: "Basemaps",
        leaf: false,
        children: [{
            nodeType: "gx_layer",
            text: "Open Street Map",
            layer: lOpenStreetMap
        }],
        expanded: true

    }]);

    var layerTree = new Ext.tree.TreePanel({
        region: 'center',
        width: 260,
        height: 250,
        //title: 'Thematic maps',
        autoScroll: true,
        enableDD: true,
        plugins: [{
            ptype: "gx_treenodecomponent"
        }],
        loader: {
            applyLoader: false,
            uiProviders: {
                "use_radio": LayerNodeUI
            }
        },
        root: {
            nodeType: "async",
            children: treeConfig
        },
        collapsible: false,
        //collapseMode: "mini",
        rootVisible: false,
        lines: false,
        border: true,
        cls: 'x-tree-noicon'
    });

    legendPanel = new Ext.Panel({
        title: 'Legend',
        region: 'south',
        width: 260,
        height: 360,
        floating: false,
        centered: true,
        modal: true,
        draggable: false,
        collapsible: false,
        titleCollapse: false,
        animCollapse: false,
        autoScroll: true,
        collapseFirst: false,
        forceLayout: true,
        hideCollapseTool: false,
        split: false,
        border: false,
        cls: 'x-tree-noicon'
    });

    Ext.Ajax.request({
        url: legendURL_2dep,
        success: function(response, opts) {
            legendPanel.update(response.responseText);
        }
    });

    var accordion = new Ext.Panel({
        title: 'Thematic maps',
        region: 'east',
        margins: '0 0 0 0',
        split: false,
        frame: false,
        width: 260,
        minSize: 260,
        maxSize: 260,
        layout: 'border',
        items: [layerTree, legendPanel],
        border: true,
        collapsible: true,
        collapseMode: "mini"
    });


    var main_map = new Ext.Panel({
        renderTo: Ext.getBody(),
        height: 610,
        frame: false,
        border: false,
        hideBorders: true,
        autoShow: true,
        autoRender: true,
        layout: 'border',
        items: [{
            region: 'north',
            xtype: 'toolbar',
            items: toolbarItems,
            height: 28,
            border: false
        },
        mapPanel, accordion]
    });
});