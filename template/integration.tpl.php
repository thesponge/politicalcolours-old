<?php /* Starfish Framework Template protection */ die(); ?>
<h2>Integration</h2>

<div class="integration">
    <p>Please select the map you want integrated in your website:</p>
    <form action="{/}integration" method="post">
        <select name="map">
            <?php foreach ($list as $key=>$value): ?>
            <option value="<?php echo $key; ?>" <?php if ($current == $key) { echo 'selected'; } ?>><?php echo $value; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" min="50" max="1200" maxlength="4" size="4" name="width" id="width" value="<?php echo $width; ?>"> <label for="width">px width</label>
        <input type="number" min="50" max="1200" maxlength="4" size="4" name="height" id="height" value="<?php echo $height; ?>"> <label for="height">px height</label>
        
        <input type="submit" value="Show code">
    </form>
    <small>Please remember to press "Show code", in order to see the updated code.</small>
    <br />
    <br />
        
    <div class="code">
        <?php echo $code; ?>
    </div>
</div>

<h3>Downloadable datasets</h3>
<p>
		The following datasets are used for rendering the following themes:
		<ul class="squares">
			<li>
				Local administration
				<ul>
					<li>2012 Municipality Mayor [<a href="{/}download/ro_uat_primari_2012.zip">ro_uat_primari_2012.zip</a>] [<a href="{/}download/ro_uat_primari_2012.csv">ro_uat_primari_2012.csv</a>]</li>
					<li>2012 Municipality Mayor (True Colours) [<a href="{/}download/ro_uat_primari_2012.zip">ro_uat_primari_2012.zip</a>] [<a href="{/}download/ro_uat_primari_2012.csv">ro_uat_primari_2012.csv</a>]</li>
					<li>2012 County Council President [<a href="{/}download/ro_judet_presedinti_cj_2012.zip">ro_judet_presedinti_cj_2012.zip</a>] [<a href="{/}download/ro_judet_presedinti_cj_2012.csv">ro_judet_presedinti_cj_2012.csv</a>]</li>
				</ul>
			</li>
			
			<li>
				Chamber of deputies
				<ul>
					<li>2008-2012 Chamber of deputies [<a href="{/}download/ro_deputati_2008.zip">ro_deputati_2008.zip</a>] [<a href="{/}download/ro_deputati_2008.csv">ro_deputati_2008.csv</a>]</li>
					<li>2008-20012 Chamber of deputies Presence [<a href="{/}download/ro_deputati_2008.zip">ro_deputati_2008.zip</a>] [<a href="{/}download/ro_deputati_2008.csv">ro_deputati_2008.csv</a>]</li>
					<li>200-2012 Chamber of deputies Rebel Vote [<a href="{/}download/ro_deputati_2008.zip">ro_deputati_2008.zip</a>] [<a href="{/}download/ro_deputati_2008.csv">ro_deputati_2008.csv</a>]</li>
				</ul>
			</li>
			
			<li>
				Senate
				<ul>
					<li>2008-2012 Senate [<a href="{/}download/ro_senatori_2008.zip">ro_senatori_2008.zip</a> <a href="{/}download/ro_senatori_2008.csv">ro_senatori_2008.csv</a>]</li>
					<li>2008-20012 Senate Presence [<a href="{/}download/ro_senatori_2008.zip">ro_senatori_2008.zip</a>] [<a href="{/}download/ro_senatori_2008.csv">ro_senatori_2008.csv</a>]</li>
					<li>2008-2012 Senate Rebel Vote [<a href="{/}download/ro_senatori_2008.zip">ro_senatori_2008.zip</a>] [<a href="{/}download/ro_senatori_2008.csv">ro_senatori_2008.csv</a>]</li>
				</ul>
			</li>
			
			<li>
				Statistics
				<ul>
					<li>2011 Population Census [<a href="{/}download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="{/}download/ro_statistici.csv">ro_statistici.csv</a>]</li>
					<li>2011 Household Census [<a href="{/}download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="{/}download/ro_statistici.csv">ro_statistici.csv</a>]</li>
					<li>2010 Graduates [<a href="{/}download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="{/}download/ro_statistici.csv">ro_statistici.csv</a>]</li>
					<li>2010 Emplyees [<a href="{/}download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="{/}download/ro_statistici.csv">ro_statistici.csv</a>]</li>
				</ul>
			</li>
		</ul>

<h3>Application</h3>
<p>The web application, built on <a href="http://www.php.net" target="_blank">PHP</a>, <a href="http://openlayers.org/">OpenLayers</a>, <a href="http://www.sencha.com" target="_blank">Exjs</a> and <a href="http://geoext.org/" target="_blank">GeoExt</a> can be downloaded from <a href="{/}download/politicalcolours.zip">here</a>. To install it just unzip the file into a web server with PHP Support (we recommend Apache, but you can use any web server with Php support) Using the MS4W distribution is recommended, even the map service will not be used. For identifying a proxy must be setup. If you don't have a proxy, just use <a href="{/}download/proxy.zip" target="_blank">this one</a>, which is build with Python. Just drop the file into a cgi-bin web directory (execute permission needed). To make it run install <a href="http://www.python.org/" target="_blank">Python</a> (2.7 recommended). The Exjs and Geoext distribution must be installed (unzipped) into the corresponding folders of the web application (search for drop.here.extjs and drop.here.geoext)</p>
<p>
    The final touches are
    <ol>
        <li>Install <a href="http://geoserver.org" target="_blank">Geoserver</a></li>
        <li>Upload data to <a href="http://www.postgresql.org/" target="_blank">PostreSql</a></li>
        <li>Configure Geoserver datastores and layers</li>
        <li>Edit embedded_globals.js, map_globals.js and config.php</li>
    </ol>
</p>