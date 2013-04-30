<?php
/**
 * @version $Id: controlpanel.php 7311 2010-03-10 13:21:15Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
$link[] = array('label'       => dgettext('access', 'Access'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=access',
		'description' => dgettext('access', 'Controls the .htaccess file for Apache and creates shortcuts.'),
		'image'       => 'access.png',
		'tab'         => 'admin'
		);

		?>