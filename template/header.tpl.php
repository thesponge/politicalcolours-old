<?php /* Starfish Framework Template protection */ die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{site_title} :: {site_description}</title>
    <meta name="description" content="{site_descr}" />
    
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
    <meta http-equiv="Pragma" content="no-cache" />
    
    <link rel="stylesheet" type="text/css" media="all" href="http://necolas.github.io/normalize.css/3.0.0/normalize.css" />
    <link rel="stylesheet" type="text/css" href="{/}public/style.css">
    
    
    <link rel="shortcut icon" href="{/}public/ico.png" />
</head>
    
<body>
    <?php if (!isset($mode) || $mode != 'simple'): ?>
    <div class="container">
        <header class="header site">
            <div class="title left">
                <h1><a href="{/}" class="<?php echo currentPage('/home'); ?>">{site_title} <span>{site_description}</span></a> </h1>
            </div>
            
            <div class="menu right">
                <ul class="horizontal none">
                    <li><a class="<?php echo currentPage('/about'); ?>" href="{/}about">About the project</a></li>
                    <li><a class="<?php echo currentPage('/integration'); ?>" href="{/}integration">Integration</a></li>
                    <li><a class="<?php echo currentPage('/colab'); ?>" href="{/}colab">Collaborators and Data Sources</a></li>
                    <li><a class="<?php echo currentPage('/feedback'); ?>" href="{/}feedback">Feedback</a></li>
                </ul>
            </div>
            
            <div class="clear"></div>
		</header>
	</div>
		
    <div class="container shadow">
        <div class="header site">    
            <div class="submenu">
                <ul class="horizontal none">
                    <li><a class="<?php echo currentPage('/maps/local'); ?>" href="{/}maps/local/">Local Administration</a></li>
                    <li><a class="<?php echo currentPage('/maps/deputies'); ?>" href="{/}maps/deputies/">Chamber of Deputies</a></li>
                    <li><a class="<?php echo currentPage('/maps/senate'); ?>" href="{/}maps/senate/">Senate</a></li>
                    <li><a class="<?php echo currentPage('/maps/statistics'); ?>" href="{/}maps/statistics/">Statistics</a></li>
                </ul>
            </div>
            
            <div class="clear"></div>
        </div>
        
        <div class="site content">
    <?php endif; ?>