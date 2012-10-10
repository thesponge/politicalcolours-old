/**
 * Copyright (c) 2008-2009 The Open Source Geospatial Foundation
 *
 * Published under the BSD license.
 * See http://svn.geoext.org/core/trunk/geoext/license.txt for the full text
 * of the license.
 */

/** api: (define)
 *  module = GeoExt.ux
 *  class = GeoNamesSearchCombo
 *  base_link = `Ext.form.ComboBox <http://dev.sencha.com/deploy/dev/docs/?class=Ext.form.ComboBox>`_
 */

Ext.namespace("GeoExt.ux");

GeoExt.ux.GeoNamesSearchCombo = Ext.extend(Ext.form.ComboBox, {
    /** private: property[fieldLabel]
    */
    fieldLabel: '',
    hideLabel: false ,

    /** api: config[map]
     *  ``OpenLayers.Map or Object``  A configured map or a configuration object
     *  for the map constructor, required only if :attr:`zoom` is set to
     *  value greater than or equal to 0.
     */
    /** private: property[map]
     *  ``OpenLayers.Map``  The map object.
     */
    map: null,
    /** private: property[layer]
    *  ``OpenLayers.Layer``  The vector layer object.
    */
    layer: null,

    /** private: property[layer]
    *  ``X``  The vector layer object X.
    */
    x: null,
    /** private: property[layer]
    *  ``Y``  The vector layer object Y.
    */
    y: null,

    /** api: config[width]
     *  See http://www.dev.sencha.com/deploy/dev/docs/source/BoxComponent.html#cfg-Ext.BoxComponent-width,
     *  default value is 350.
     */
    width: 180,

    /** api: config[listWidth]
     *  See http://www.dev.sencha.com/deploy/dev/docs/source/Combo.html#cfg-Ext.form.ComboBox-listWidth,
     *  default value is 350.
     */
    listWidth: 180,

    /** api: config[loadingText]
     *  See http://www.dev.sencha.com/deploy/dev/docs/source/Combo.html#cfg-Ext.form.ComboBox-loadingText,
     *  default value is "Search in Geonames...".
     */
    loadingText: 'Searching...',

    /** api: config[emptyText]
     *  See http://www.dev.sencha.com/deploy/dev/docs/source/TextField.html#cfg-Ext.form.TextField-emptyText,
     *  default value is "Search location in Geonames".
     */
    emptyText: 'Search municipality...',

    /** api: config[zoom]
     *  ``Number`` Zoom level for recentering the map after search, if set to
     *  a negative number the map isn't recentered, defaults to 8.
     */
    /** private: property[zoom]
     *  ``Number``
     */
    zoom: 6,

    /** api: config[minChars]
     *  ``Number`` Minimum number of characters to be typed before
     *  search occurs, defaults to 1.
     */
    minChars: 3,

    /** api: config[queryDelay]
     *  ``Number`` Delay before the search occurs, defaults to 50 ms.
     */
    queryDelay: 50,

    /** api: config[maxRows]
     *  `String` The maximum number of rows in the responses, defaults to 20,
     *  maximum allowed value is 1000.
     *  See: http://www.geonames.org/export/geonames-search.html
     */
    /** private: property[maxRows]
     *  ``String``
     */
    maxRows: '10',

    /** api: config[tpl]
     *  ``Ext.XTemplate or String`` Template for presenting the result in the
     *  list (see http://www.dev.sencha.com/deploy/dev/docs/output/Ext.XTemplate.html),
     *  if not set a default value is provided.
     */
    tpl: '<tpl for=".">' + '<div ext:qtip=\'{out_uat_name} ({out_jud_name})\' class="x-combo-list-item">{out_uat_name} ({out_jud_name})</div></tpl>',


    /** api: config[charset]
     *  `String` Defines the encoding used for the document returned by
     *  the web service, defaults to 'UTF8'.
     *  See: http://www.geonames.org/export/geonames-search.html
     */
    /** private: property[charset]
     *  ``String``
     */
    charset: 'UTF8',

    /** private: property[hideTrigger]
     *  Hide trigger of the combo.
     */
    hideTrigger: true,

    /** private: property[displayField]
     *  Display field name
     */
    displayField: 'out_uat_name',

    /** private: property[forceSelection]
     *  Force selection.
     */
    forceSelection: true,

    /** private: property[queryParam]
     *  Query parameter.
     */
    queryParam: 'name_startsWith',

    /** private: property[url]
     *  Url of the GeoNames service: http://www.GeoNames.org/export/GeoNames-search.html
     */
    url: null,
    /** private: constructor
     */

        
    initComponent: function() {
        GeoExt.ux.GeoNamesSearchCombo.superclass.initComponent.apply(this, arguments);
        this.store = new Ext.data.Store({
            proxy: new Ext.data.ScriptTagProxy({
                url: this.url,
                method: 'GET',
                disableCaching:false
            }),
            baseParams: {
            },
            reader: new Ext.data.JsonReader({
                //idProperty: 'geonameId',
                root: "data",
                //totalProperty: "totalResultsCount",
                fields: [
                    {
                        name: 'out_uat_name'
                    },
                    {
                        name: 'out_jud_name'
                    },
                    {
                        name: 'out_x'
                    },
                    {
                        name: 'out_y'
                    }
                ]
            })
        });
        


        if(this.zoom > 0) {
            this.on("select", function(combo, record, index) {
                //for (var i=0; i< this.layer.features.length; i++) {
                //    feat = this.layer.features[i];
                //    if (feat.attributes['description'] == this.fieldLabel) {
                //    this.layer.removeFeatures([feat]);
                //    }
                //}

                var position = new OpenLayers.LonLat(
                    record.data.out_x, record.data.out_y
                );
                
                this.x = record.data.out_x;
                this.y = record.data.out_y;
                //var feature = new OpenLayers.Feature.Vector(
                //    new OpenLayers.Geometry.Point(record.data.x, record.data.y),
                //    {"description": this.fieldLabel});
                //this.layer.addFeatures(feature);
                //this.layer.setVisibility(true);
                this.map.setCenter(position, this.zoom);
            }, this);
        }
    }

});



/** api: xtype = gxux_geonamessearchcombo */
Ext.reg('gxux_geonamessearchcombo', GeoExt.ux.GeoNamesSearchCombo);