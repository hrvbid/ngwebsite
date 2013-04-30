<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: controlpanel.php 7344 2010-03-16 17:56:56Z matt $
 */

$link[] = array('label'       => dgettext('filecabinet', 'File Cabinet'),
                'restricted'  => TRUE,
                'url'         => 'index.php?module=filecabinet&amp;aop=image',
                'description' => dgettext('filecabinet', 'Manages images and documents uploaded to your site.'),
                'image'       => 'cabinet.png',
                'tab'         => 'admin'
                );
                ?>