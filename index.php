<?php
include('./libraries/starfish/starfish.php');
starfish::singleton();
starfish::config(array(
	// Basic configuration
    'site_url' => 'http://'.$_SERVER['HTTP_HOST'].'/politicalcolours/',
	'site_title' => 'Political colours of Romania',
	'site_description' => 'Interactively mapped',
	
    'proxy_url'     => 'http://'.$_SERVER['HTTP_HOST'].'/',
    'geoserver_url' => 'http://192.168.12.44:818/geo/politicalcolours/wms?',
    'wms_url'       => "http://192.168.12.44:818/geo/politicalcolours/wms?",
    'wfs_url'       => "http://192.168.12.44:818/geo/politicalcolours/wfs?",
    'tilecache_url' => "http://192.168.12.44:811/tile/",
    
    'friendly' => false,
    'router'   => '',
	'root'	   => './libraries/starfish/',
	'objects'  => './objects/',
    'aliases'  => array('s', 'reg'),
    'debug'    => true,
	'tpl'	   => './template/',
    
	'session'  => 'politicalcolours2'
));

// Init the framework
starfish::init();
function currentPage($var)
{
    if (starfish::regVar('currentPage') == $var) {
        return ' active';
    }
    
    return '';
}

// Default page
s::on('get', '*', function(){
    starfish::redirect('./maps/local');
    exit;
});

// Pages
s::on('get', '/about*', function(){
    starfish::regVar('currentPage', '/about');
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('about');
    echo s::obj('tpl')->view('copyright');
    echo s::obj('tpl')->view('footer');
});
s::on('get', '/colab*', function(){
    starfish::regVar('currentPage', '/colab');
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('colab');
    echo s::obj('tpl')->view('copyright');
    echo s::obj('tpl')->view('footer');
});
s::on('get', '/feedback*', function(){
    starfish::regVar('currentPage', '/feedback');
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('feedback');
    echo s::obj('tpl')->view('footer');
});

// Integration
function integration() {
    starfish::regVar('currentPage', '/integration');
    
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
        strlen( starfish::params('map') ) > 0 &&
        is_numeric( starfish::params('height') ) &&
        is_numeric( starfish::params('width') )
    )
    {
        $code = '&lt;iframe seamless="seamless" scrolling="no" frameboder="0" style="width: '.starfish::params('width').'px; height: '.starfish::params('height').'px;" src="'.starfish::config('site_url').'embed/'.starfish::params('map').'">&lt;/iframe&gt;';
    }
    else
    {
        $code = 'This is the area where the integration code will be shown.';
    }
    
    if (!is_numeric( starfish::params('height') )) { $height = 300; } else { $height = starfish::params('height'); }
    if (!is_numeric( starfish::params('width') )) { $width = 300; } else { $width = starfish::params('width'); }
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('integration', array(
        'list'      => $list,
        
        'current'   => starfish::params('map'),
        'width'     => $width,
        'height'    => $height,
        
        'code'      => $code
    ));
    echo s::obj('tpl')->view('copyright');
    echo s::obj('tpl')->view('footer');
}
s::on('get', '/integration*', 'integration');
s::on('post', '/integration*', 'integration');

// Maps
s::on('get', '/maps/::map', function($map) {
    
    switch ($map)
    {
        case 'statistics':
            starfish::regVar('currentPage', '/maps/statistics');
            break;
        case 'senate':
            starfish::regVar('currentPage', '/maps/senate');
            break;
        case 'deputies':
            starfish::regVar('currentPage', '/maps/deputies');
            break;
        
        default:
        case 'local':
            starfish::regVar('currentPage', '/maps/local');
            break;
    }
    
    
    echo s::obj('tpl')->view('header');
    echo s::obj('tpl')->view('iframe', array('mode'=>$map));
    echo s::obj('tpl')->view('footer');
});

s::on('get', '/loader', function() {
    echo s::obj('tpl')->view('header', array('mode'=>'simple'));
    echo s::obj('tpl')->view('maps', array('mode'=>'local'));
    echo s::obj('tpl')->view('footer', array('mode'=>'simple'));
});
s::on('get', '/loader/::map', function($map) {
    echo s::obj('tpl')->view('header', array('mode'=>'simple'));
    echo s::obj('tpl')->view('maps', array('mode'=>$map));
    echo s::obj('tpl')->view('footer', array('mode'=>'simple'));
});

// Run the embed code
s::on('get', '/embed', function() {
    exit;
});
s::on('get', '/embed/::map', function($map) {
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
s::exec();
?>