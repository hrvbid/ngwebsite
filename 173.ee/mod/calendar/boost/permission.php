<?php
/**
 * Permissions file for users
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: permission.php 7311 2010-03-10 13:21:15Z matt $
 */

$use_permissions  = TRUE;
$item_permissions = TRUE;

$permissions['settings']            = dgettext('calendar', 'Change module settings (unrestricted only)');
$permissions['edit_public']         = dgettext('calendar', 'Create/Edit public schedule');

// Creation of private schedules handled by calendar settings
$permissions['edit_private']        = dgettext('calendar', 'Edit private schedule');
$permissions['delete_schedule']     = dgettext('calendar', 'Delete schedules (unrestricted only)');

?>