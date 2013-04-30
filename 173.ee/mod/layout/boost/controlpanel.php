<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: controlpanel.php 8365 2012-10-25 16:46:40Z matt $
 */

$link[] = array('label'       => dgettext('layout', 'Layout'),
		 'restricted'  => TRUE,
		 'url'         => 'index.php?module=layout&amp;action=admin',
		 'description' => dgettext('layout', 'Control the layout of your site.'),
		 'image'       => 'layout.png',
		 'tab'         => 'admin'
		 );
		 ?>