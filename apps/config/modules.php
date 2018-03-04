<?php

/**
 * Register application modules
 */
$application->registerModules(array(
	'user' => array(
		'className' => 'HA\Modules\User\Module',
		'namespaceName' => 'HA\Modules\User\Controllers',
		'path' => __DIR__ . '/../modules/user/Module.php'
	),
	'office' => array(
		'className' => 'HA\Modules\Office\Module',
		'namespaceName' => 'HA\Modules\Office\Controllers',
		'path' => __DIR__ . '/../modules/office/Module.php'
	)
));
