<?php
/**
 * @version $Id: controlpanel.php 7311 2010-03-10 13:21:15Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */


$link[] = array('label'       => dgettext('calendar', 'Calendar'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=calendar&amp;aop=schedules',
		'description' => dgettext('calendar', 'Create events and schedules.'),
		'image'       => 'calendar.png',
		'tab'         => 'content'
		);


		?>