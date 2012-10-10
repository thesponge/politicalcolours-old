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

define('root', '');
include("system/core.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo conf::val('site_title'); ?></title>
	<style type="text/css">
	* { margin: 0; padding: 0; }
	</style>
</head>
<body>
	<div name="map_<?php echo $_GET['id']; ?>" id="map_<?php echo $_GET['id']; ?>"></div>
	<script type="text/javascript" src="integrate.js?id=<?php echo $_GET['id']; ?>&code=<?php echo $_GET['code']; ?>"></script>
</body>
</html>