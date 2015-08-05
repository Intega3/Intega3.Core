<?php
namespace Intega3\Core\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Intega3.Core".         *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class DashboardController extends AbstractController {

	/**
	 * @return void
	 */
	public function indexAction() {
	    
        if($this->securityContext->hasRole($this->defaultUserRole) === FALSE) {
            $this->redirect('index', 'Login');
        }
	}

}