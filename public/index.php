<?php

require 'Hmvc.php';

use Phalcon\Loader;

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
	$loader = new Loader();

	$loader->registerNamespaces(array(
		'HA\Modules' => __DIR__ . '/../apps/modules/',
	));

	$loader->register();

	/**
	 * Include services
	 */
	require __DIR__ . '/../apps/config/services.php';

	/**
	 * Handle the request
	 */
	$application = new HA\Library\Phalcon\Mvc\Application\Hmvc();

	$di['app'] = $application;

	/**
	 * Assign the DI
	 */
	$application->setDI($di);

	/**
	 * Include modules
	 */
	require __DIR__ . '/../apps/config/modules.php';

	echo $application->handle()->getContent();
} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e) {
	echo $e->getMessage();
}
