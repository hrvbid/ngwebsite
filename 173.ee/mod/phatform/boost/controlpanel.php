<?php

/**
 * @version $Id: controlpanel.php 7341 2010-03-15 19:57:34Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$link[] = array ('label'       => 'Form Generator',
                 'restricted'  => TRUE,
		 'module'      => 'phatform',
		 'url'         => 'index.php?module=phatform&amp;PHAT_MAN_OP=List',
		 'image'       => 'phatform.png',
		 'description' => 'Creates online forms. Email, CSV reporting available.',
		 'tab'         => 'content');

?>