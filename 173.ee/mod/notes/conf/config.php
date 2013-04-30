<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: config.php 7311 2010-03-10 13:21:15Z matt $
 */

// minutes to check for new notes
define('NOTE_CHECK_INTERVAL', 5);


/**
 * Set to allow the searching of users when sending notes
 * turning it off means the user must enter the username (actually searches
 * on the display name) exactly
 **/
define('NOTE_ALLOW_USERNAME_SEARCH', true);

?>