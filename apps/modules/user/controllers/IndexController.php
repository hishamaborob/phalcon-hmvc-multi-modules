<?php

namespace HA\Modules\User\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller {

	public function indexAction() {

		$userModuleResponse = '* User Module Response <br /><br />';
		$officeModuleResponseTest = $this->di->getShared('app')->module(
				'office', 'index', 'test', array('test_param_1' => 'this_is_user_module_passed_param')
		);
		if (is_array($officeModuleResponseTest)) {
			$this->view->setVar('officeIndex', $officeModuleResponseTest[0] . $userModuleResponse);
		} else {
			$this->view->setVar('officeIndex', $officeModuleResponseTest . $userModuleResponse);
		}

		$officeModuleResponseTestView = $this->di->getShared('app')->module(
				'office', 'index', 'testView', array('test_param_2' => 'this_is_user_module_passed_param')
		);
		if (is_array($officeModuleResponseTestView)) {
			$this->view->setVar('officeTestView', $officeModuleResponseTestView[0] . $userModuleResponse);
		} else {
			$this->view->setVar('officeTestView', $officeModuleResponseTestView . $userModuleResponse);
		}
	}

}
