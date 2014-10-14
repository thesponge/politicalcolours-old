<?php /* Starfish Framework Template protection */ die(); ?>

<?php switch ($mode): ?>
    
<?php default: ?>
<?php case 'local': ?>
<iframe src="{/}loader/local" seamless="seamless" width="100%" height="610" frameBorder="0" scrolling="no" style="outline-width: 0;"></iframe>
<?php break; ?>

<?php case 'deputies': ?>
<iframe src="{/}loader/deputies" seamless="seamless" width="100%" height="610" frameBorder="0" scrolling="no" style="outline-width: 0;"></iframe>
<?php break; ?>

<?php case 'senate': ?>
<iframe src="{/}loader/senate" seamless="seamless" width="100%" height="610" frameBorder="0" scrolling="no" style="outline-width: 0;"></iframe>
<?php break; ?>

<?php case 'statistics': ?>
<iframe src="{/}loader/statistics" seamless="seamless" width="100%" height="610" frameBorder="0" scrolling="no" style="outline-width: 0;"></iframe>
<?php break; ?>

<?php endswitch; ?>