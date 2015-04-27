<?php
namespace Intega3\Core\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Intega3.Core".         *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class DashboardController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('foos', array(
			'bar', 'baz'
		));
	}

}