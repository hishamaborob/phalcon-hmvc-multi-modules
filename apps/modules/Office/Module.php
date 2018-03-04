<?php

namespace HA\Modules\Office;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface {

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders() {

		$loader = new Loader();

		$loader->registerNamespaces(array(
			'HA\Modules\Office\Controllers' => __DIR__ . '/controllers/',
		));

		$loader->register();
	}

	/**
	 * Registers the module-only services
	 *
	 * @param Phalcon\DI $di
	 */
	public function registerServices($di) {

		/**
		 * Setting up the view component
		 */
		$di['view'] = function () {
			$view = new View();
			$view->setViewsDir(__DIR__ . '/views/');

			return $view;
		};

	}

}
