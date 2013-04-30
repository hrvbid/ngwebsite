<?php
/**
 * @version $Id: controlpanel.php 7357 2010-03-16 20:45:17Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$tabs[] = array('id' => 'my_page',
                'title' => dgettext('users', 'My Page'),
		'link'  => 'index.php?module=users&amp;action=user',
);

$link[] = array('label'       => dgettext('users', 'User Administration'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=users&amp;action=admin',
		'description' => dgettext('users', 'Lets you create and edit users and groups.'),
		'image'       => 'users.png',
		'tab'         => 'admin'
		);
		?>