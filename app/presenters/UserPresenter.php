<?php

namespace App\Presenters;

use App\Model\UserManager;
use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Form;

use Tracy\Debugger;

class UserPresenter extends BasePresenter {

    private $userManager;

    function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    protected function startup() {
        parent::startup();
        if (!$this->getUser()->isAllowed('Users')) {
            throw new ForbiddenRequestException();
        }
    }    
    
    public function actionCreate() {
//        if (!$this->getUser()->isLoggedIn()) $this->redirect('Sign:in');
        $data = array();
        $this['userForm']->setDefaults($data);
    }

    public function renderList() {
        $this->template->data = $this->userManager->getAll();
    }

    public function renderUpdate($id) {
        if (!$data = $this->userManager->getById($id)) throw new BadRequestException();                
        if ($data->id != $this->getUser()->getId() && !in_array('administrator',$this->getUser()->getRoles()))
            throw new ForbiddenRequestException();
        $this['userForm']->setDefaults($data);                
    }
    
    protected function createComponentUserForm() {
        $form = new Form();
        $form->addText('username', 'Uživatelské jméno')
             ->setAttribute('readonly')   
             ->setRequired('Uživatelské jméno musí být vyplněno');   
        $form->addText('name', 'Osobní jméno')
             ->setRequired('Osobní jméno musí být vyplněno');   
        $form->addEmail('email', 'E-mailová adresa')
             ->setRequired('Email musí být zadán');    
        /*
        $form->addPassword('oldPassword', 'Staré heslo:', 30)
                ->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
        $form->addPassword('newPassword', 'Nové heslo:', 30)
                ->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
        $form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
                ->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
                ->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);   
         */
        $roles = ["registrovaný"=>"Registrovaný uživatel",
                  "redaktor"=>"Redaktor",
                  "administrator"=>"Správce sytému"];
        $form->addSelect('role', 'Role uživatele', $roles)
             ->setDefaultValue('registrovaný');
        $form->addSubmit('submit', 'Potvrdit');
        $form->onSuccess[] = array($this, 'userFormSucceeded');
        return $form;
    }
        
    public function userFormSucceeded(Form $form, $values) {
        $id = $this->getParameter("id");
        if ($id) {
            $this->userManager->update($id, $values);
            $this->flashMessage("Záznam byl úspěšně upraven");            
        } else {            
            $this->userManager->insert($values);
            $this->flashMessage("Záznam byl úspěšně vložen");                        
        }
        $this->redirect("list");
    }
    
    /**
     * @return Nette\Application\UI\Form
     */
/*    protected function createComponentPasswordForm() {
        $form = new Form();
        $form->addPassword('oldPassword', 'Staré heslo:', 30)
                ->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
        $form->addPassword('newPassword', 'Nové heslo:', 30)
                ->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
        $form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
                ->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
                ->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);
        $form->addSubmit('set', 'Změnit heslo');
        $form->onSuccess[] = $this->passwordFormSubmitted;
        return $form;
    }

    public function passwordFormSubmitted(Form $form) {
        $values = $form->getValues();
        $user = $this->getUser();
        try {
            $this->authenticator->authenticate(array(
                $user->getIdentity()->username,
                $values->oldPassword
            ));
            $this->authenticator->setPassword($user->getId(), $values->newPassword);
            $this->flashMessage('Heslo bylo změněno.', 'success');
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Zadané heslo není správné.');
        }
    }*/

}
