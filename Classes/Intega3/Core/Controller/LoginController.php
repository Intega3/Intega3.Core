<?php
namespace Intega3\Core\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Intega3.Core".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class LoginController extends AbstractController {

	/**
     * @var \TYPO3\Flow\Security\Authentication\AuthenticationManagerInterface
     * @Flow\Inject
     */
    protected $authenticationManager;
 
    /**
     * index action, does only display the form
     */
    public function indexAction() {
        // do nothing, action only required to show form        
    }
 
    /**
     * @throws \TYPO3\Flow\Security\Exception\AuthenticationRequiredException
     * @return void
     */
    public function authenticateAction() {
        try {
            $this->authenticationManager->authenticate();
            $this->redirect('index', 'Dashboard');
        } catch (\TYPO3\Flow\Security\Exception\AuthenticationRequiredException $exception) {
            $this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Error('Wrong username or password.'));
            $this->redirect('index', 'Login');
        }
    }
     
    public function logoutAction() {
        $this->authenticationManager->logout();
        $this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Error('Successfully logged out.'));
        $this->redirect('index', 'Login');
    }

}