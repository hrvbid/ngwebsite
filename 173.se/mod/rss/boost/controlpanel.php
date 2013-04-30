<?php
/**
 * @version $Id: controlpanel.php 7375 2010-03-23 16:27:19Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$link[] = array('label'       => dgettext('rss', 'RSS Feeds'),
		'restricted'  => TRUE,
		'url'         => 'index.php?module=rss&amp;tab=channels',
		'description' => dgettext('rss', 'Administrative panel for setting RSS feeds.'),
		'image'       => 'rss.png',
		'tab'         => 'admin'
		);
		?>