<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: controlpanel.php 7341 2010-03-15 19:57:34Z matt $
 */

$link[] = array('label'       => dgettext('menu', 'Menu'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=menu',
		'description' => dgettext('menu', 'Controls the layout and positioning of your menus.'),
		'image'       => 'menu.png',
		'tab'         => 'content'
		);
		?>