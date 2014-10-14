<?php
/**
 * Starfish initial commands
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require the needed files
include('../starfish/starfish.php');

// The configuration
starfish::config('_starfish', 'base', array(
	// Basic configuration
    'site_url' => 'http://'.$_SERVER['HTTP_HOST'].'/politicalcolours/',
	'site_title' => 'Political colours of Romania',
	'site_description' => 'Interactively mapped',
	
    'proxy_url'     => 'http://'.$_SERVER['HTTP_HOST'].'/',
    'geoserver_url' => 'http://192.168.12.44:818/geo/politicalcolours/wms?',
    'wms_url'       => "http://192.168.12.44:818/geo/politicalcolours/wms?",
    'wfs_url'       => "http://192.168.12.44:818/geo/politicalcolours/wfs?",
    'tilecache_url' => "http://192.168.12.44:811/tile/",
    
    'debug'    => true,
	'template'	   => @realpath(__DIR__) . DIRECTORY_SEPARATOR . 'template/',
    
	'session'  => 'politicalcolours2'
));

// Init the framework
starfish::init();

function currentPage($var)
{
    if (getVar('currentPage') == $var) {
        return ' active';
    }
    
    return '';
}

// Default page
on('get', '*', function(){
    starfish::redirect('./maps/local');
    exit;
});

// Pages
on('get', '/about*', function(){
    setVar('currentPage', '/about');
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('about');
    echo s::obj('tpl')->view('copyright');
    echo s::obj('tpl')->view('footer');
});
on('get', '/colab*', function(){
    setVar('currentPage', '/colab');
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('colab');
    echo s::obj('tpl')->view('copyright');
    echo s::obj('tpl')->view('footer');
});
on('get', '/feedback*', function(){
    setVar('currentPage', '/feedback');
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('feedback');
    echo s::obj('tpl')->view('footer');
});

// Integration
function integration() {
    setVar('currentPage', '/integration');
    
    // The embed list
    $list = array();
    $files = starfish::obj('files')->all('./maps/javascript/');
    foreach ($files['files'] as $key=>$value)
    {
        $value = substr($value, strlen('./maps/javascript/'), -3);
        
        if (substr($value, 0, 6) == 'embed_')
        {
            $list[ base64_encode($value) ] = str_replace(array('embed_', '_'), array('', ' '), $value);
        }
    }
    
    // The code
    if (
        strlen( get('map') ) > 0 &&
        is_numeric( get('height') ) &&
        is_numeric( get('width') )
    )
    {
        $code = '&lt;iframe seamless="seamless" scrolling="no" frameboder="0" style="width: '.get('width').'px; height: '.get('height').'px;" src="'.starfish::config('site_url').'embed/'.get('map').'">&lt;/iframe&gt;';
    }
    else
    {
        $code = 'This is the area where the integration code will be shown.';
    }
    
    if (!is_numeric( get('height') )) { $height = 300; } else { $height = get('height'); }
    if (!is_numeric( get('width') )) { $width = 300; } else { $width = get('width'); }
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('integration', array(
        'list'      => $list,
        
        'current'   => get('map'),
        'width'     => $width,
        'height'    => $height,
        
        'code'      => $code
    ));
    echo s::obj('tpl')->view('copyright');
    echo s::obj('tpl')->view('footer');
}
on('get', '/integration*', 'integration');
on('post', '/integration*', 'integration');

// Maps
on('get', '/maps/:alpha', function($map) {
    switch ($map)
    {
        case 'statistics':
            setVar('currentPage', '/maps/statistics');
            break;
        case 'senate':
            setVar('currentPage', '/maps/senate');
            break;
        case 'deputies':
            setVar('currentPage', '/maps/deputies');
            break;
        
        default:
        case 'local':
            setVar('currentPage', '/maps/local');
            break;
    }
    
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('iframe', array('mode'=>$map));
    echo s::obj('tpl')->view('footer');
});

on('get', '/loader', function() {
    echo s::obj('tpl')->view('header', array('mode'=>'simple'));
    echo s::obj('tpl')->view('maps', array('mode'=>'local'));
    echo s::obj('tpl')->view('footer', array('mode'=>'simple'));
});
on('get', '/loader/::alpha', function($map) {
    echo s::obj('tpl')->view('header', array('mode'=>'simple'));
    echo s::obj('tpl')->view('maps', array('mode'=>$map));
    echo s::obj('tpl')->view('footer', array('mode'=>'simple'));
});

// Run the embed code
on('get', '/embed', function() {
    exit;
});
on('get', '/embed/::alpha', function($map) {
    $file = base64_decode($map);
    
    if (file_exists('maps/javascript/'.$file.'.js'))
    {
        echo s::obj('tpl')->view('header', array('mode'=>'simple'));
        echo s::obj('tpl')->view('embed', array('map'=>$file));
        echo s::obj('tpl')->view('footer', array('mode'=>'simple'));
    }
    else
    {
        exit;
    }
});

// Run the script
on();
?>