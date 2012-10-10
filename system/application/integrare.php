<!--
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
-->
<div class="wrapper_content">
	<div class="tabs white">
		<ul class="horizontal">
			<li><a href="<?php echo conf::val('site_url'); ?>integration.html" class="<?php if ($_GET['mode'] == 'integration') { echo 'active'; } ?>">Integration</a></li>
			<li><a href="<?php echo conf::val('site_url'); ?>integration-download.html" class="<?php if ($_GET['mode'] == 'download') { echo 'active'; } ?>">Downloadable datasets</a></li>
			<li><a href="<?php echo conf::val('site_url'); ?>integration-application.html" class="<?php if ($_GET['mode'] == 'application') { echo 'active'; } ?>">Application</a></li>
		</ul>
	</div>

	<div class="intpage <?php if ($_GET['mode'] == 'integration') { echo 'visible'; } ?>">
    <div class="clear">
        <form action="" method="post">
            <div class="row">
                <label class="go">Please select the map you want integrated:</label>
                
                <select name="map_id" style="width: 660px;">
                    <option value="1" <?php if ($_POST['map_id'] == 1) { echo 'selected'; } ?> >2012 - County Council President</option>
                    <option value="2" <?php if ($_POST['map_id'] == 2) { echo 'selected'; } ?> >2012 - Municipality Mayor</option>
                    <option value="3" <?php if ($_POST['map_id'] == 3) { echo 'selected'; } ?> >2012 - Municipality Mayor True Colours</option>
					
                    <option value="4" <?php if ($_POST['map_id'] == 4) { echo 'selected'; } ?> >2010 - Employees</option>
                    <option value="5" <?php if ($_POST['map_id'] == 5) { echo 'selected'; } ?> >2010 - Graduates</option>
                    <option value="6" <?php if ($_POST['map_id'] == 6) { echo 'selected'; } ?> >2011 - Households Census</option>
                    <option value="7" <?php if ($_POST['map_id'] == 7) { echo 'selected'; } ?> >2011 - Population Census</option>
					
                    <option value="8" <?php if ($_POST['map_id'] == 8) { echo 'selected'; } ?> >2008 - 2012 Chamber of Deputies</option>
                    <option value="9" <?php if ($_POST['map_id'] == 9) { echo 'selected'; } ?> >2008 - 2012 Chamber of Deputies Presence</option>
                    <option value="10" <?php if ($_POST['map_id'] == 10) { echo 'selected'; } ?> >2008 - 2012 Chamber of Deputies Rebel</option>
                    <option value="11" <?php if ($_POST['map_id'] == 11) { echo 'selected'; } ?> >2008 - 2012 Senate</option>
                    <option value="12" <?php if ($_POST['map_id'] == 12) { echo 'selected'; } ?> >2008 - 2012 Senate Elec. Voting Presence</option>
                    <option value="13" <?php if ($_POST['map_id'] == 13) { echo 'selected'; } ?> >2008 - 2012 Senate Rebel Voting</option>
                </select>
            </div>
            <div class="row">
                <label class="go">Please enter CSS only customization code:</label>
                <div class="small">It is important to keep <i>position: relative;</i> in the code.</div>
                
                <textarea name="code" id="code" rows="5" cols="100" class="margin-top-10"><?php
                    if (strlen($_POST['map_id']) == 0)
                    {
                        echo 'width: 560px; height: 415px; position: relative;';
                    }
                    else
                    {
                        echo $_POST['code'];
                    }
                ?></textarea>
            </div>
            
            <div class="row">
                <input type="submit" class="submit" value="Show code">
            </div>
        </form>
    </div>
    
	<h2>Generated code</h2>
	<?php
	if (is_numeric($_POST['map_id'])) { $id = $_POST['map_id']; } else { $id = 1; }
	
	if (strlen($_POST['code']) > 0)
	{
		$code = str_replace(array('<', '>'), '', $_POST['code']);
	}
	else
	{
		$code = 'width: 560px; height: 415px; position: relative;';
	}
	
	?>
    <textarea name="code" id="code" rows="5" cols="100" class="margin-top-10" readonly>
&lt;iframe seamless="seamless" scrolling="no" frameboder="0" style="<?php echo $code; ?>" src="<?php echo conf::val('site_url'); ?>integrate.html?id=<?php echo $id;?>&code=<?php echo base64_encode($code); ?>">&lt;/iframe&gt;
    </textarea>
	
	
    </div>
	
	<div class="intpage <?php if ($_GET['mode'] == 'download') { echo 'visible'; } ?>">
    <p>
		The following datasets are used for rendering the following themes:
		<ul class="squares">
			<li>
				Local administration
				<ul>
					<li>2012 Municipality Mayor [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_uat_primari_2012.zip">ro_uat_primari_2012.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_uat_primari_2012.csv">ro_uat_primari_2012.csv</a>]</li>
					<li>2012 Municipality Mayor (True Colours) [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_uat_primari_2012.zip">ro_uat_primari_2012.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_uat_primari_2012.csv">ro_uat_primari_2012.csv</a>]</li>
					<li>2012 County Council President [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_judet_presedinti_cj_2012.zip">ro_judet_presedinti_cj_2012.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_judet_presedinti_cj_2012.csv">ro_judet_presedinti_cj_2012.csv</a>]</li>
				</ul>
			</li>
			
			<li>
				Chamber of deputies
				<ul>
					<li>2008-2012 Chamber of deputies [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_deputati_2008.zip">ro_deputati_2008.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_deputati_2008.csv">ro_deputati_2008.csv</a>]</li>
					<li>2008-20012 Chamber of deputies Presence [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_deputati_2008.zip">ro_deputati_2008.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_deputati_2008.csv">ro_deputati_2008.csv</a>]</li>
					<li>200-2012 Chamber of deputies Rebel Vote [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_deputati_2008.zip">ro_deputati_2008.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_deputati_2008.csv">ro_deputati_2008.csv</a>]</li>
				</ul>
			</li>
			
			<li>
				Senate
				<ul>
					<li>2008-2012 Senate [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_senatori_2008.zip">ro_senatori_2008.zip</a> <a href="<?php echo conf::val('site_url'); ?>data/download/ro_senatori_2008.csv">ro_senatori_2008.csv</a>]</li>
					<li>2008-20012 Senate Presence [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_senatori_2008.zip">ro_senatori_2008.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_senatori_2008.csv">ro_senatori_2008.csv</a>]</li>
					<li>2008-2012 Senate Rebel Vote [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_senatori_2008.zip">ro_senatori_2008.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_senatori_2008.csv">ro_senatori_2008.csv</a>]</li>
				</ul>
			</li>
			
			<li>
				Statistics
				<ul>
					<li>2011 Population Census [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.csv">ro_statistici.csv</a>]</li>
					<li>2011 Household Census [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.csv">ro_statistici.csv</a>]</li>
					<li>2010 Graduates [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.csv">ro_statistici.csv</a>]</li>
					<li>2010 Emplyees [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.zip">ro_statistici.zip</a>] [<a href="<?php echo conf::val('site_url'); ?>data/download/ro_statistici.csv">ro_statistici.csv</a>]</li>
				</ul>
			</li>
		</ul>
    </p>
	
	
	<h2 class="margin-top-20">Copyright Notice</h2>
	<p>The current project has been developed by <a href="http://thesponge.eu">TheSponge</a>, a journalistic project in Romania owned by <a href="https://www.crji.org/">CRJI</a>.  All information presented are of public interest. </p>
	<p>
		Sources of the information are: 
		<ul>
			<li>The Central Bureau of Elections</li>
			<li>The National Institute of Statistics</li>
			<li>The National Agency for Cadastre and Land Registration</li>
			<li><a href="http://www.ancpi.ro/dwf/INDEX_1_2.dwf">http://www.ancpi.ro/dwf/INDEX_1_2.dwf</a> and derivative works of the above.</li>
		</ul>
	</p>
	<p>The origin (and not the source) of some information can't be disclosed due to the protection of journalistic sources. </p>
	<p>All the information and works in the current website are available in 
the public domain or are licenced via <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US" target="_blank">Creative Commons Attribution-ShareAlike 3.0 Unported License</a> (as applicable). The source code of the application is licenced under <a href="http://opensource.org/licenses/GPL-3.0" target="_blank">GPLv3</a>. All data and code source are available for download on the webpage <a href="http://www.politicalcolours.ro">www.politicalcolours.ro</a> for personal use.</p>

	<p>By our knowledge, for any re-use of the data in a public commercial or non-commercial project please note that  certain information may be protected  by the sui-generis database right of some Romanian public institutions. </p>
	<p>The contributors of this project would like to emphasize the public character of all the data used in this project and the necessity of availability of all these data in an open data  format and licence from all Romanian public bodies and as soon as possible.</p>
	
	<p>All images, maps, screenshots and text from the current site may be  reproduced freely on any other media, if the work is correctly  attributed to 'PoliticalColours.ro - Project of TheSponge.eu. Some  Rights Reserved'.</p>
	<p>Please <a href="mailto:contact@politicalcolours.ro">contact us</a> if you want any further details regarding the copyright status of various data present in the website.</p>
	
	
	
	</div>

	<div class="intpage <?php if ($_GET['mode'] == 'application') { echo 'visible'; } ?>">
	<p>The web application, built on <a href="http://www.php.net" target="_blank">PHP</a>, <a href="http://openlayers.org/">OpenLayers</a>, <a href="http://www.sencha.com" target="_blank">Exjs</a> and <a href="http://geoext.org/" target="_blank">GeoExt</a> can be downloaded from <a href="<?php echo conf::val('site_url'); ?>data/download/politicalcolours.zip">here</a>. To install it just unzip the file into a web server with PHP Support (we recommend Apache, but you can use any web server with Php support) Using the MS4W distribution is recommended, even the map service will not be used. For identifying a proxy must be setup. If you don't have a proxy, just use <a href="<?php echo conf::val('site_url'); ?>data/download/proxy.zip" target="_blank">this one</a>, which is build with Python. Just drop the file into a cgi-bin web directory (execute permission needed). To make it run install <a href="http://www.python.org/" target="_blank">Python</a> (2.7 recommended). The Exjs and Geoext distribution must be installed (unzipped) into the corresponding folders of the web application (search for drop.here.extjs and drop.here.geoext)</p>
	<p>
		The final touches are
		<ol>
			<li>Install <a href="http://geoserver.org" target="_blank">Geoserver</a></li>
			<li>Upload data to <a href="http://www.postgresql.org/" target="_blank">PostreSql</a></li>
			<li>Configure Geoserver datastores and layers</li>
			<li>Edit embedded_globals.js, map_globals.js and config.php</li>
		</ol>
	</p>
	</div>
</div>