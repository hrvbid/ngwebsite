<?php

/**
 * @version $Id: controlpanel.php 7322 2010-03-10 19:34:15Z matt $
 * @author Matthew McNaney <mcnaney at appstate dot edu>
 */

$link[] = array('label'       => 'Alert!',
		'restricted'  => true,
		'url'         => 'index.php?module=alert&amp;aop=main',
		'description' => dgettext('blog', 'Alert your community to important happenings.'),
		'image'       => 'alert.png',
		'tab'         => 'content'
		);
		?>