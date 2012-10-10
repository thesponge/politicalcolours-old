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

define(root, '../');
include(root . 'system/core.php');

switch ($_GET['mode'])
{
    case 'judete':
        $data = db::a("select jud.jud_code, initcap(jud_lbl) jud_lbl, minx, miny, maxx , maxy  from (select jud_code, jud_lbl,ST_XMin(the_geom) as minx, ST_YMin(the_geom) as miny, ST_XMax(the_geom)  As maxx,  ST_YMax(the_geom)  As maxy from ro_judete union select 'AA','All Counties', 0.0, 0.0, 0.0, 0.0) jud order by jud.jud_code asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'map_search_location':
        $data = db::a("select out_uat_name, out_jud_name,out_x, out_y from get_uat('".$_GET['name_startsWith']."') LIMIT 20");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'partide':
        $data = db::a("select par.id_partid, initcap(par.partid) partid  from (select id_partid, partid,count(partid) as nr_primari from ro_uat_primari_2012 group by id_partid,partid union select 0,' All Political Organisations',9999) par order by par.nr_primari desc, par.partid asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'partide_deputati_2008':
        $data = db::a("select par.id_partid, initcap(par.partid) partid  from (select id_partid, partid from ro_deputati_2008 group by id_partid,partid union select 0,' All Political Organisations') par order by par.partid asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'partide_senat_2008':
        $data = db::a("select par.id_partid, initcap(par.partid) partid  from (select id_partid, partid from ro_senatori_2008 group by id_partid,partid union select 0,' All Political Organisations') par order by par.partid asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
}


header("Content-type: application/json");
header("Content-type: text/json; charset=utf-8");
echo $output;

?>