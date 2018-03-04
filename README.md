# Phalcon-HMVC-Multi-Modules
This Application extends the basic Phalcon MVC Application to contain the HMVC structuring by enabling sub requests between modules.

## How to use
### Register your modules with its namespaces names:
```php
<?php
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
```

### Do module request
```php
<?php
$this->di->getShared('app')->module(
	  'module_name',
	  'controller_name',
	  'action_name',
	  array('param1' => 'param1_value')
	  );
