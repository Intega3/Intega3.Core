<?php
namespace Intega3\Core\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Intega3.Core".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class AbstractController extends \TYPO3\Flow\Mvc\Controller\ActionController {

    /**
     * @var \TYPO3\Flow\I18n\Locale
     */
    protected $lang;

	/**
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     * @Flow\Inject
     */
    protected $persistenceManager;
    
    /**
     * @var \TYPO3\Flow\Security\Context
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * Initialize view
     *
     * @param \TYPO3\Flow\Mvc\View\ViewInterface $view
     * @return void
     */
    public function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
        $detector   = new \TYPO3\Flow\I18n\Detector();
        $this->lang = $detector->detectLocaleFromHttpHeader($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        $view->assign('langDetector', $this->lang);
    }

    /**
     * @return boolean
     */
    protected function isLoggedIn() {
        return $this->securityContext->getAccount();
    }
}