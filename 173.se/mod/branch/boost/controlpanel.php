<?php
/**
 * @version $Id: controlpanel.php 7334 2010-03-15 19:52:09Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$link[] = array('label'       => dgettext('branch', 'Branch'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=branch',
		'description' => dgettext('branch', 'Install and update branch sites.'),
		'image'       => 'branch.png',
		'tab'         => 'admin'
		);

		?>