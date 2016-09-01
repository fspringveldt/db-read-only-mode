<?php
//	error_reporting(E_ALL);
//	ini_set('display_errors',1);
	date_default_timezone_set('Europe/Berlin');
	global $project;
	$project = 'db-read-only-mode';

	require_once('conf/ConfigureFromEnv.php');

	// Set the site locale
	i18n::set_locale('en_US');

