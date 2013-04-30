<?php
/**
 * @version $Id: permission.php 7341 2010-03-15 19:57:34Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$use_permissions = TRUE;

$permissions['edit_comments']   = dgettext('comments', 'Edit comments');
$permissions['delete_comments'] = dgettext('comments', 'Delete comments');
$permissions['punish_users']    = dgettext('comments', 'Punish users');
$permissions['settings']        = dgettext('comments', 'Change settings');

$item_permissions = FALSE;
?>