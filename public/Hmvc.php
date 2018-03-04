<?php

namespace HA\Library\Phalcon\Mvc\Application;

use Phalcon\Mvc\Application;
use \Phalcon\Http\ResponseInterface;
use \Phalcon\DI\FactoryDefault as PhDI;
use \Exception;

/**
 * HMVC Application
 * This Application extends the basic Phalcon MVC Application
 * to contain the HMVC structuring by enabling sub requests
 * between modules
 * 
 * @copyright (c) 2015, HA (Hisham Aburob)
 * @author Hisham Aburob <hisham.aborob@gmail.com>
 * @todo Ability to dispatch controller in the same module
 */
class Hmvc extends Application {

	/**
	 * Store modules that been requested
	 * 
	 * @var \Phalcon\Mvc\ModuleDefinitionInterface[]
	 */
	protected $aHmvcModules = array();

	/**
	 * Handling request between modules <br>
	 * 
	 * Example: <br>
	 * 
	  <code>
	  $this->di->getShared('app')->request(
	  'module_name',
	  'controller_name',
	  'action_name',
	  array('param1' => 'param1_value')
	  );
	  </code>
	 * 
	 * @param string $sModule Requested Module name
	 * @param string $sController Requested Controller name
	 * @param string $sAction Requested Action name
	 * @param array $aParams Parameters to be passed
	 * @return \Phalcon\Http\ResponseInterface|string|array|NULL
	 */
	public function module($sModule, $sController, $sAction, $aParams = array()) {
		$aModule = $this->getModule($sModule);
		$oDispatcher = $aModule['di']->get('dispatcher');
		$oView = $aModule['di']->get('view');
		$oDispatcher->setControllerName($sController);
		$oDispatcher->setActionName($sAction);
		$oDispatcher->setParams($aParams);
		$oView->start();
		$oDispatcher->dispatch();
		$oResponse = $oDispatcher->getReturnedValue();
		if ($oResponse instanceof ResponseInterface) {
			$sContent = $oResponse->getContent();
		} elseif (is_null($oResponse)) {
			$oView->render($sController, $sAction);
			$sContent = $oView->getContent();
		} else {
			$sContent = $oResponse;
		}
		$oView->finish();
		return $sContent;
	}

	/**
	 * Get module after check if it is registered
	 * then initiate it and seting up dispatcher for
	 * This function return singleton module
	 * 
	 * @param string $sModule
	 * @return array registered module info
	 */
	protected function getModule($sModule) {

		if (!isset($this->aHmvcModules[$sModule])) {
			$aRequestModuleNamespace = $this->getModuleNamespace($sModule);
			$this->aHmvcModules[$sModule]['module'] = new $aRequestModuleNamespace['className'];
			$this->aHmvcModules[$sModule]['module']->registerAutoloaders();
			$oHmvcDI = new PhDI();
			$this->aHmvcModules[$sModule]['module']->registerServices($oHmvcDI);
			$this->aHmvcModules[$sModule]['di'] = $oHmvcDI;
			$this->aHmvcModules[$sModule]['di']->get('dispatcher')->setNamespaceName(
					$aRequestModuleNamespace['namespaceName']
			);
			$this->aHmvcModules[$sModule]['di']->get('dispatcher')->setModuleName($sModule);
		}
		return $this->aHmvcModules[$sModule];
	}

	/**
	 * 
	 * @param type $sModule
	 * @return type
	 * @throws \Exception
	 */
	protected function getModuleNamespace($sModule) {

		$aModule = $this->getModules();
		if (isset($aModule[$sModule])) {
			return $aModule[$sModule];
		}
		throw new Exception($sModule . ' module is not registered');
	}

}
