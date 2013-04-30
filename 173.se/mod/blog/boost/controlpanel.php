<?php

/**
 * @version $Id: controlpanel.php 7311 2010-03-10 13:21:15Z matt $
 * @author Matthew McNaney <mcnaney at appstate dot edu>
 */

$link[] = array('label'       => 'Blog',
		'restricted'  => TRUE,
		'url'         => 'index.php?module=blog&amp;action=admin',
		'description' => dgettext('blog', 'Post current thoughts, happenings, and discussions.'),
		'image'       => 'blog.png',
		'tab'         => 'content'
		);

		?>