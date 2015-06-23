<?php
namespace Intega3\Core\Tests\Functional\Controller\LoginController;

use TYPO3\Flow\Tests\FunctionalTestCase;

/**
 * Testcase for Login Controller
 */
class LoginController extends FunctionalTestCase {

    /**
     * @var boolean
     */
    protected $testableHttpEnabled = TRUE;

    /** 
     * @test
     */
    public function showLoginFormWhenUserIsLoggedOff() {
        $response = $this->browser->request('http://localhost/');
        $this->assertContains('Login form', $response->getContent());
    }

}