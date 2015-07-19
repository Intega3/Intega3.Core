<?php
namespace Intega3\Core\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Intega3.Core".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Abstract Controller for the FUGRM.Base package
 *
 * @Flow\Scope("singleton")
 */
class AbstractController extends \TYPO3\Flow\Mvc\Controller\ActionController {

    /**
     * @var \TYPO3\Flow\I18n\Locale
     */
    protected $lang;

    /**
     * @var \TYPO3\Flow\Package\PackageManagerInterface
     * @Flow\Inject
     */
    protected $packageManager;

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
        // Language detection
        $detector   = new \TYPO3\Flow\I18n\Detector();
        $this->lang = $detector->detectLocaleFromHttpHeader($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        $view->assign('langDetector', $this->lang);
        
        $packagePath = $this->packageManager->getPackage('Intega3.Template')->getPackagePath();
        $view->setTemplateRootPaths(array($packagePath . 'Resources/Private/Templates'));
        $view->setLayoutRootPath($packagePath .'Resources/Private/Layouts');
        $view->setPartialRootPath($packagePath . 'Resources/Private/Partials/');
    }

    /**
     * @return boolean
     */
    protected function isLoggedIn() {
        return $this->securityContext->getAccount();
    }
}