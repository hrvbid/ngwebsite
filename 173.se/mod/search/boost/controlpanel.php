<?php
/**
 * @version $Id: controlpanel.php 7311 2010-03-10 13:21:15Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$link[] = array('label'       => dgettext('search', 'Search'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=search&amp;tab=keyword',
		'description' => dgettext('search', 'Administrate and see information on searches.'),
		'image'       => 'search.png',
		'tab'         => 'admin'
		);
		?>