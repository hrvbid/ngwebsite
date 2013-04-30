<?php
/**
 * @version $Id: controlpanel.php 7311 2010-03-10 13:21:15Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$link[] = array('label'       => dgettext('block', 'Block'),
                'restricted'  => TRUE,
                'url'         =>
                'index.php?module=block',
		'description' => dgettext('block', 'Create blocks of content.'),
		'image'       => 'block.png',
		'tab'         => 'content'
		);
		?>