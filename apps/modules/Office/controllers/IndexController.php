<?php

namespace HA\Modules\Office\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller {

	public function testAction() {
		return array('Office Module Response with (' . $this->dispatcher->getParam('test_param_1') . ') <br />');
	}

	public function testViewAction() {

	}

}
