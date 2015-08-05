<?php
namespace Intega3\Core\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Intega3.Core".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class AdministrationController extends AbstractController {

        /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Security\AccountRepository
     */
    protected $accountRepository;
    /**
     * @Flow\Inject
     * @var \TYPO3\Party\Domain\Repository\PartyRepository
     */
    protected $partyRepository;
        
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Security\AccountFactory
     */
    protected $accountFactory;
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Security\Cryptography\HashService
     */
    protected $hashService;
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Security\Policy\PolicyService
     */
    protected $policyService;
    /**
     * @var \TYPO3\Flow\Security\Context
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * @return void
     */
    protected function initializeAction() {
        parent::initializeAction();
        if ($this->arguments->hasArgument('account')) {
            
            $propertyMappingConfigurationForAccount = $this->arguments->getArgument('account')->getPropertyMappingConfiguration();
            $propertyMappingConfigurationForAccountParty = $propertyMappingConfigurationForAccount->forProperty('party');
            $propertyMappingConfigurationForAccountPartyName = $propertyMappingConfigurationForAccount->forProperty('party.name');
            foreach (array($propertyMappingConfigurationForAccountParty, $propertyMappingConfigurationForAccountPartyName) as $propertyMappingConfiguration) {
                $propertyMappingConfiguration->setTypeConverterOption(
                    'TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter',
                    \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
                    TRUE
                );
                $propertyMappingConfiguration->setTypeConverterOption(
                    'TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter',
                    \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED,
                    TRUE
                );
            }
        }
    }

    /**
     * @return void
     */
    public function configurationAction() {
        
    }

    /**
     * @return void
     */
    public function createUserAction() {
        
    }
    
    /**
     * @param \TYPO3\Flow\Security\Account $account
     * @return void
     */
    public function deleteUserAction(\TYPO3\Flow\Security\Account $account) {
        $this->accountRepository->remove($account);
        
        $this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Message('Account successfully deleted.'));
        $this->redirect('userList');
    }
    
    /**
     * @param \TYPO3\Flow\Security\Account $account
     * @return void
     */
    public function editUserAction(\TYPO3\Flow\Security\Account $account) {
        $this->view->assign('account', $account);
    }

	/**
	 * @return void
	 */
	public function indexAction() {
		// Overview Modules
	}
    
    /**
     * @param string $name
     * @param string $pass
     * @param string $pass2
     */
    public function doCreateUserAction($name, $pass, $pass2) {
        $defaultRole = 'Intega3.Core:User';
 
        if($name == '' || strlen($name) < 3) {
            $this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Error('Username too short or empty'));
            $this->redirect('createUser');
        } else if($pass == '' || $pass != $pass2) {
            $this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Error('Password too short or does not match'));
            $this->redirect('createUser');
        } else { 
            // create a account with password an add it to the accountRepository
            $account = $this->accountFactory->createAccountWithPassword($name, $pass, array($defaultRole), 'DefaultProvider');
            $this->accountRepository->add($account);
 
            $personName = new \TYPO3\Party\Domain\Model\PersonName;
            $personName->setOtherName($name);
 
            $person = new \TYPO3\Party\Domain\Model\Person;
            $person->addAccount($account);
            $person->setName($personName);
            
            $this->partyRepository->add($person);
             
            // add a message and redirect to the login form
            $this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Message('Account successfully created.'));
            $this->redirect('listUsers');
        }
 
        // redirect to the login form
        $this->redirect('listUsers');
    }
    
    /**
     * @return void
     */
    public function listUsersAction() {
        $this->view->assign('accounts', $this->accountRepository->findAll());
    }
}