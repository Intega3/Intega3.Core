<?php
namespace Intega3\Core\Error;

use TYPO3\Flow\Error\ProductionExceptionHandler;

/**
 * Production Exception handler
 */
class ExceptionHandler extends ProductionExceptionHandler {
    
    /**
     * The response which will be returned by this action controller
     * @var \TYPO3\Flow\Http\Response
     */
    protected $response;
    
    /**
     * @var \TYPO3\Flow\Mvc\Routing\UriBuilder
     */
    protected $uriBuilder;
    
    /**
     * Initialize
     */
    protected function initialize() {
        $this->injectUriBuilder();
        $this->injectHttpResponse();
    }
    
    /**
     * Initialize UriBuilder
     */
    protected function injectUriBuilder() {
        $httpRequest = \TYPO3\Flow\Http\Request::createFromEnvironment();
        $request = new \TYPO3\Flow\Mvc\ActionRequest($httpRequest);
        $uriBuilder = new \TYPO3\Flow\Mvc\Routing\UriBuilder();
        $uriBuilder->setRequest($request);
        $this->uriBuilder = $uriBuilder;
        
        $this->response = new \TYPO3\Flow\Http\Response;
    }
    
    /**
     * Initialize Http Response
     */
    protected function injectHttpResponse() {
        $this->response = new \TYPO3\Flow\Http\Response;
    }
    
    /**
     * @param \Exception $exception
     * @return void
     */
    protected function echoExceptionWeb($exception) {
        $this->initialize();
        
        switch($exception->getStatusCode()) {
            case 403:
                $this->redirectToErrorAction('accessDenied');                
                break;
            default:
                parent::echoExceptionWeb($exception);
        }
    }
    
    /**
     * @param string $action
     */
    private function redirectToErrorAction($action) {
        $uri = $this->uriBuilder->setCreateAbsoluteUri(TRUE)->uriFor($action, array(), 'Error', 'Intega3.Core');
                
        $escapedUri = htmlentities($uri, ENT_QUOTES, 'utf-8');
        $this->response->setContent('<html><head><meta http-equiv="refresh" content="0;url=' . $escapedUri . '"/></head></html>');
        $this->response->setStatus(303);
        
        $this->response->setHeader('Location', (string)$uri);
        $this->response->send();
    }
}