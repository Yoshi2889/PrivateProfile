<?php

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');

global $smcFunc, $user_info;

if((SMF == 'SSI') && !$user_info['is_admin'])
	die('Admin priveleges required.');

db_extend('packages');
	
$smcFunc['db_remove_column'](
	'{db_prefix}members',
	'profile_private'
);
$smcFunc['db_remove_column'](
	'{db_prefix}members',
	'pp_ignore'
);

$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}settings
	WHERE variable IN ({array_string:settings})',
	array(
		'settings' => array(
			'pp_default',
			'pp_allow_override',
			'pp_override_stats',
			'pp_override_posts',
		)
	));