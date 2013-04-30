<?php
/**
 * @version $Id: columns.php 7341 2010-03-15 19:57:34Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

$version_columns[] = array('name' => 'vr_creator',
			   'sql' => 'int NOT NULL default 0');

$version_columns[] = array('name' => 'vr_editor',
			   'sql' => 'int NOT NULL default 0');

$version_columns[] = array('name' => 'vr_create_date',
			   'sql' => 'int NOT NULL default 0');

$version_columns[] = array('name' => 'vr_edit_date',
			   'sql' => 'int NOT NULL default 0');

$version_columns[] = array('name' => 'vr_number',
			   'sql' => 'smallint NOT NULL default 1');

$version_columns[] = array('name' => 'vr_current',
			   'sql' => 'smallint NOT NULL default 0');

$version_columns[] = array('name' => 'vr_approved',
			   'sql' => 'smallint NOT NULL default 0');

$version_columns[] = array('name' => 'vr_locked',
			   'sql' => 'smallint NOT NULL default 0');

?>