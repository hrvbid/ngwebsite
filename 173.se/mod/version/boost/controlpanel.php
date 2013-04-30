<?php
/**
 * @version $Id: controlpanel.php 7341 2010-03-15 19:57:34Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$link[] = array('label'       => dgettext('version', 'Version'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=version',
		'description' => dgettext('version', 'Controls the versioning settings.'),
		'image'       => 'version.png',
		'tab'         => 'admin'
		);
		?>